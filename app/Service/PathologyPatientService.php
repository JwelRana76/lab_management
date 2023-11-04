<?php

namespace App\Service;

use App\Models\PathologyPatient;
use App\Models\PatientTest;
use App\Models\PatientTube;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PathologyPatientService extends Service
{
  protected $model = PathologyPatient::class;

  function unique_id()
  {
    $patient = PathologyPatient::orderBy('id', 'desc')->first();
    if ($patient) {
      $unique_id = $patient->unique_id;
      $ext = explode('-', $unique_id)[1];
      if ($ext < 10) {
        $unique_id = setting()->invoice_prefix . '-000' . $ext + 1;
      } elseif ($ext < 100) {
        $unique_id = setting()->invoice_prefix . '-00' . $ext + 1;
      } elseif ($ext < 1000) {
        $unique_id = setting()->invoice_prefix . '-0' . $ext + 1;
      } else {
        $unique_id = setting()->invoice_prefix . '-' . $ext + 1;
      }
    } else {
      $unique_id = setting()->invoice_prefix . '-0001';
    }
    return $unique_id;
  }
  function index()
  {
    $patinets = $this->model::orderBy('id', 'desc')->get();
    return DataTables::of($patinets)
      ->addColumn('age', function ($item) {
        return $item->age . $item->age_type == 1 ? 'Days' : ($item->age_type == 2 ? 'Months' : 'Years');
      })
      ->addColumn('test', function ($item) {
        $badges = '';
        foreach ($item->tests as $test) {
          $badges .= '<span class="badge badge-primary">' . ($test->test->name ?? 'N/A') . '</span> ';
        }
        return $badges;
      })
      ->addColumn('tube', function ($item) {
        $badges = '';
        foreach ($item->tubes as $tube) {
          $badges .= '<span class="badge badge-primary">' . ($tube->tube->name ?? 'N/A') . '</span> ';
        }
        return $badges;
      })
      ->addColumn('due', function ($item) {
        return $item->due;
      })
      ->addColumn('action', fn ($item) => view('pages.pathology.patient.action', compact('item'))->render())
      ->rawColumns(['test', 'action', 'tube'])
      ->make(true);
  }
  function store($data)
  {
    DB::beginTransaction();
    try {
      $patient_data['name'] = $data['name'];
      $patient_data['age'] = $data['age'];
      $patient_data['contact'] = $data['contact'];
      $patient_data['unique_id'] = $this->unique_id();;
      $patient_data['age_type'] = $data['age_type'];
      $patient_data['doctor_id'] = $data['doctor_id'];
      $patient_data['referral_id'] = $data['referral_id'];
      $patient_data['gender_id'] = $data['gender_id'];
      $patient_data['total'] = $data['sub_total'];
      $patient_data['discount_amount'] = $data['discount_amount'];
      $patient_data['discount_percent'] = $data['discount_percent'];
      $patient_data['grand_total'] = $data['total_payable'];
      $patient_data['paid'] = $data['paid'];
      $patient = PathologyPatient::create($patient_data);

      $tests = $data['test_id'];

      foreach ($tests as $key => $test) {
        $patient_test['test_id'] = $test;
        $patient_test['patient_id'] = $patient->id;
        PatientTest::create($patient_test);
      }

      if ($data['tube_id']) {
        foreach ($data['tube_id'] as $key => $tube) {
          $patient_tube['tube_id'] = $tube;
          $patient_tube['patient_id'] = $patient->id;
          $patient_tube['qty'] = $data['tube_qty'][$key];
          PatientTube::create($patient_tube);
        }
      }
      $payment = new Payment([
        'amount' => $patient->paid,
      ]);

      $patient->payment()->save($payment);

      DB::commit();
      return $patient;
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }

  
}