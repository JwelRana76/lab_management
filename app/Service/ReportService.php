<?php

namespace App\Service;

use App\Models\PathologyPatient;
use Psy\Command\WhereamiCommand;
use Yajra\DataTables\Facades\DataTables;

class ReportService
{

  function patientReport($start_date, $end_date)
  {
    $patients = PathologyPatient::when($start_date, function ($query) use ($start_date) {
      return $query->where('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
        return $query->where('created_at', '>=', $end_date);
      })
      ->get();
    return DataTables::of($patients)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
        return $item->grand_tota;
      })
      ->addColumn('paid', function ($item) {
        return $item->payment()->sum('amount');
      })
      ->addColumn('due', function ($item) {
        return $item->due;
      })
      ->make(true);
  }
  function referralReport($referral_id, $start_date, $end_date)
  {
    $patients = PathologyPatient::when($start_date, function ($query) use ($start_date) {
      return $query->where('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
        return $query->where('created_at', '>=', $end_date);
      })
      ->where('referral_id', $referral_id)
      ->get();

    return DataTables::of($patients)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
        return $item->grand_tota;
      })
      ->addColumn('discoutn', function ($item) {
        return $item->discount_amount;
      })
      ->addColumn('refer_amount', function ($item) {
        return $item->maxdiscount - $item->discount_amount;
      })
      ->make(true);
  }
  function doctorReport($doctor_id, $start_date, $end_date)
  {
    $patients = PathologyPatient::when($start_date, function ($query) use ($start_date) {
      return $query->where('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
        return $query->where('created_at', '>=', $end_date);
      })
      ->where('doctor_id', $doctor_id)
      ->get();

    return DataTables::of($patients)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
        return $item->grand_tota;
      })
      ->addColumn('discoutn', function ($item) {
        return $item->discount_amount;
      })
      ->addColumn('refer_amount', function ($item) {
        return $item->maxdiscount - $item->discount_amount;
      })
      ->make(true);
  }
  function doctorPaymentReport($doctor_id, $start_date, $end_date)
  {
    $patients = PathologyPatient::when($start_date, function ($query) use ($start_date) {
      return $query->where('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
        return $query->where('created_at', '>=', $end_date);
      })
      ->where('doctor_id', $doctor_id)
      ->get();

    return DataTables::of($patients)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
        return $item->grand_tota;
      })
      ->make(true);
  }
  function referralPaymentReport($referral_id, $start_date, $end_date)
  {
    $patients = PathologyPatient::when($start_date, function ($query) use ($start_date) {
      return $query->where('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
        return $query->where('created_at', '>=', $end_date);
      })
      ->where('referral_id', $referral_id)
      ->get();

    return DataTables::of($patients)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
        return $item->grand_tota;
      })
      ->make(true);
  }
}
