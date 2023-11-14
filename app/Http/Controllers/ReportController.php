<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Service\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->baseService = new ReportService;
    }

    function patient(Request $request)
    {
        $columns = [
            ['name' => 'date', 'data' => 'date'],
            ['name' => 'unique_id', 'data' => 'unique_id'],
            ['name' => 'name', 'data' => 'name'],
            ['name' => 'amount', 'data' => 'amount'],
            ['name' => 'paid', 'data' => 'paid'],
            ['name' => 'due', 'data' => 'due'],
        ];
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');
        $patinets = $this->baseService->patientReport($start_date, $end_date);
        if ($request->ajax()) {
            return $patinets;
        }
        return view('pages.report.patient', compact('columns'));
    }
    function referral(Request $request)
    {
        $columns = [
            ['name' => 'date', 'data' => 'date'],
            ['name' => 'unique_id', 'data' => 'unique_id'],
            ['name' => 'name', 'data' => 'name'],
            ['name' => 'amount', 'data' => 'amount'],
            ['name' => 'discount', 'data' => 'discount'],
            ['name' => 'refer_amount', 'data' => 'refer_amount'],
        ];
        $referrals = Referral::active()->get();
        $referral = $request->referral_id ?? null;
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');
        $patinets = $this->baseService->referralReport($referral, $start_date, $end_date);
        if ($request->ajax()) {
            return $patinets;
        }
        return view('pages.report.referral', compact('columns', 'referrals'));
    }
    function doctor(Request $request)
    {
        $columns = [
            ['name' => 'date', 'data' => 'date'],
            ['name' => 'unique_id', 'data' => 'unique_id'],
            ['name' => 'name', 'data' => 'name'],
            ['name' => 'amount', 'data' => 'amount'],
            ['name' => 'discount', 'data' => 'discount'],
            ['name' => 'refer_amount', 'data' => 'refer_amount'],
        ];
        $doctors = Referral::active()->get();
        $doctor = $request->doctor_id ?? null;
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');
        $patinets = $this->baseService->doctorReport($doctor, $start_date, $end_date);
        if ($request->ajax()) {
            return $patinets;
        }
        return view('pages.report.doctor', compact('columns', 'doctors'));
    }
    function doctorPayment(Request $request)
    {
        $columns = [
            ['name' => 'date', 'data' => 'date'],
            ['name' => 'amount', 'data' => 'amount'],
        ];
        $doctors = Referral::active()->get();
        $doctor = $request->doctor_id ?? null;
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');
        $patinets = $this->baseService->doctorPaymentReport($doctor, $start_date, $end_date);
        if ($request->ajax()) {
            return $patinets;
        }
        return view('pages.report.doctor_payment', compact('columns', 'doctors'));
    }
    function referralPayment(Request $request)
    {
        $columns = [
            ['name' => 'date', 'data' => 'date'],
            ['name' => 'amount', 'data' => 'amount'],
        ];
        $referrals = Referral::active()->get();
        $referral = $request->referral_id ?? null;
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');
        $patinets = $this->baseService->referralPaymentReport($referral, $start_date, $end_date);
        if ($request->ajax()) {
            return $patinets;
        }
        return view('pages.report.referral_payment', compact('columns', 'referrals'));
    }
}
