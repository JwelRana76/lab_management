<?php

namespace App\Service;

use App\Models\PathologyPatient;
use App\Models\PathologyPatientReport;
use App\Models\PathologyPatientReportValue;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PathologyPatientReportSetupService extends Service
{
  protected $reportModel = PathologyPatientReport::class;
  protected $reportValueModel = PathologyPatientReportValue::class;
  protected $patientModel = PathologyPatient::class;

  function index()
  {
    $patients = $this->patientModel::where('is_reported', 0)->get();
    return DataTables::of($patients)
      ->addColumn('test', function ($item) {
        $badges = '';
        foreach ($item->tests as $test) {
          $badges .= '<span class="badge badge-primary">' . ($test->test->name ?? 'N/A') . '</span> ';
        }
        return $badges;
      })
      ->addColumn('action', function ($item) {
        $action = '';
        $action .= '<form method="get" action="' . route("report_set.index") . '">
            <button type="submit" class="btn btn-sm btn-primary" name="patient_id" value="' . $item->id . '">Add Report</button>
          </form>';
        return $action;
      })
      ->rawColumns(['test', 'action'])
      ->make(true);
  }
  function view()
  {
    $patients = $this->patientModel::where('is_reported', 1)->get();
    return DataTables::of($patients)
      ->addColumn('test', function ($item) {
        $badges = '';
        foreach ($item->tests as $test) {
          $badges .= '<span class="badge badge-primary">' . ($test->test->name ?? 'N/A') . '</span> ';
        }
        return $badges;
      })
      ->addColumn('action', function ($item) {
        $action = '';
        $action .= '<form method="get" action="' . route("report_set.view") . '">
          <input name="view" type="hidden">
          <button type="submit" class="btn btn-sm btn-primary" name="patient_id" value="' . $item->id . '">View</button>
          </form>';
        $action .= '<form method="get" action="' . route("report_set.view") . '">
          <input name="edit" type="hidden">
          <button type="submit" class="btn btn-sm btn-primary" name="patient_id" value="' . $item->id . '">Edit</button>
          </form>';
      $action .= '<button type="button" onclick="print_report(' . $item->id . ')" class="btn btn-sm btn-primary" name="patient_id">Print</button>';
        return '<div class="editViewPrint">' . $action . '</div>';
      })
      ->rawColumns(['test', 'action'])
      ->make(true);
  }
  function store($data)
  {
    DB::beginTransaction();
    try {
      foreach ($data['result_value'] as $key => $result) {
        $report_data['patient_id'] = $data['patient_id'];
        $report_data['test_id'] = $key;

        $report = $this->reportModel::create($report_data);

        foreach ($result as $key => $value) {
          $report_value['report_id'] = $report->id;
          $report_value['result_id'] = $key;
          $report_value['result_value'] = $value;

          $test_setup_result = \App\Models\PathologyTestSetupResult::where('result_id', $key)->first();

          if ($test_setup_result->is_converted == true) {
            if ($value == 'N/A') {
              $report_value['convert_value'] = $value;
            } else {
              $convert_value = $this->convert_result($test_setup_result->calculation_operator, $value, $test_setup_result->calculation_value);
              $report_value['convert_value'] = $convert_value;
            }
          }
          $this->reportValueModel::create($report_value);
        }
        $patient = \App\Models\PathologyPatient::findOrFail($data['patient_id'])->update([
          'is_reported' => true,
        ]);
      }

      DB::commit();
      return ['success' => 'Report Value inserted Successfully'];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }
  function update($data)
  {
    DB::beginTransaction();
    try {
      foreach ($data['result_value'] as $key => $result) {
        $report_data['patient_id'] = $data['patient_id'];
        $report_data['test_id'] = $key;
        $report = $this->reportModel::where('patient_id', $data['patient_id'])->where('test_id', $key)->first();

        $this->reportValueModel::where('report_id', $report->id)->delete();
        foreach ($result as $key => $value) {
          $report_value['report_id'] = $report->id;
          $report_value['result_id'] = $key;
          $report_value['result_value'] = $value;

          $test_setup_result = \App\Models\PathologyTestSetupResult::where('result_id', $key)->first();

          if ($test_setup_result->is_converted == true) {
            if ($value == 'N/A') {
              $report_value['convert_value'] = $value;
            } else {
              $convert_value = $this->convert_result($test_setup_result->calculation_operator, $value, $test_setup_result->calculation_value);
              $report_value['convert_value'] = $convert_value;
            }
          } else {
            $report_value['convert_value'] = null;
          }
          $this->reportValueModel::create($report_value);
        }
        $patient = \App\Models\PathologyPatient::findOrFail($data['patient_id'])->update([
          'is_reported' => true,
        ]);
      }

      DB::commit();
      return ['success' => 'Report Value Updated Successfully'];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }

  function convert_result($operator, $operand1, $operand2)
  {
    switch ($operator) {
      case '*':
        $result = $operand1 * $operand2;
        break;

      case '/':
        $result = $operand1 / $operand2;
        break;

      case '+':
        $result = $operand1 + $operand2;
        break;

      case '-':
        $result = $operand1 - $operand2;
        break;

      default:
        $result = 0;
        break;
    }
    return $result;
  }
}
