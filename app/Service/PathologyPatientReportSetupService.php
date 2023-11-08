<?php

namespace App\Service;

use App\Models\PathologyPatient;
use App\Models\PathologyPatientReport;
use App\Models\PathologyPatientReportValue;
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
  function store($data)
  {
    dd($data);
  }
}
