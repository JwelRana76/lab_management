<?php

namespace App\Service;

use App\Models\PathologyPatient;
use App\Models\ReferralPayment;
use Psy\Command\WhereamiCommand;
use Yajra\DataTables\Facades\DataTables;

class ReportService
{

  function patientReport($start_date, $end_date)
  {
    $patients = PathologyPatient::when($start_date, function ($query) use ($start_date) {
      return $query->whereDate('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
      return $query->whereDate('created_at', '<=', $end_date);
      })
      ->get();
    return DataTables::of($patients)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
      return $item->grand_total;
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
      return $query->whereDate('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
      return $query->whereDate('created_at', '<=', $end_date);
      })
      ->where('referral_id', $referral_id)
      ->get();

    return DataTables::of($patients)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
      return $item->grand_total;
      })
      ->addColumn('discount', function ($item) {
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
      return $query->whereDate('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
      return $query->whereDate('created_at', '<=', $end_date);
      })
      ->where('doctor_id', $doctor_id)
      ->get();

    return DataTables::of($patients)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
      return $item->grand_total;
      })
      ->addColumn('discount', function ($item) {
        return $item->discount_amount;
      })
      ->addColumn('refer_amount', function ($item) {
        return $item->maxdiscount - $item->discount_amount;
      })
      ->make(true);
  }
  function doctorPaymentReport($doctor_id, $start_date, $end_date)
  {
    $payments = ReferralPayment::when($start_date, function ($query) use ($start_date) {
      return $query->whereDate('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
      return $query->whereDate('created_at', '<=', $end_date);
      })
      ->when($doctor_id, function ($query) use ($doctor_id) {
        return $query->where('doctor_id', $doctor_id);
      })
      ->where('doctor_id', '!=', null)
      ->get();

    return DataTables::of($payments)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
      return $item->amount;
      })
      ->make(true);
  }
  function referralPaymentReport($referral_id, $start_date, $end_date)
  {
    $payments = ReferralPayment::when($start_date, function ($query) use ($start_date) {
      return $query->whereDate('created_at', '>=', $start_date);
    })
      ->when($end_date, function ($query) use ($end_date) {
      return $query->whereDate('created_at', '<=', $end_date);
      })
      ->when($referral_id, function ($query) use ($referral_id) {
        return $query->where('referral_id', $referral_id);
      })
      ->where('referral_id', '!=', null)
      ->get();

    return DataTables::of($payments)
      ->addColumn('date', function ($item) {
        return $item->created_at->format('d-M-Y');
      })
      ->addColumn('amount', function ($item) {
      return $item->amount;
      })
      ->make(true);
  }
}
