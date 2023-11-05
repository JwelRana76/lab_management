<?php

namespace App\Service;

use App\Models\PathologyPatient;
use App\Models\Payment;
use Yajra\DataTables\Facades\DataTables;

class FinanceService extends Service
{
  function dueCollection()
  {
    $patients = PathologyPatient::duepatient()->get();
    return DataTables::of($patients)
      ->addColumn('due', function ($item) {
        return $item->due;
      })
      ->addColumn('action', 'action')
      ->rawColumns(['action'])
      ->make(true);
  }

  function dueCollectionStore($data, $id)
  {
    if ($data['discount'] > 0 || $data['amount'] > 0) {
      $patient = PathologyPatient::findOrFail($id);
      if ($data['discount']) {
        $patient['discount_amount'] += $data['discount'];
        $patient['grand_total'] -= $data['discount'];
      }
      if ($data['amount']) {
        Payment::create([
          'patient_id' => $id,
          'amount' => $data['amount'],
        ]);
      }
      $patient->save();
      return ['success' => 'Due Collection inserted Successfully'];
    } else {
      return ['warning' => 'Both of discount and amount is 0'];
    }
  }
}
