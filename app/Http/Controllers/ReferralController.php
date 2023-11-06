<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\Gender;
use App\Models\Referral;
use App\Models\ReferralPayment;
use App\Models\Religion;
use App\Service\ReferralService;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->baseService = new ReferralService;
    }

    function index()
    {
        $referrals = $this->baseService->Index();
        $columns = Referral::$columns;
        if (request()->ajax()) {
            return $referrals;
        }
        return view('pages.referral.index', compact('columns'));
    }
    function create()
    {
        $religion = Religion::select('id', 'name')->get();
        $gender = Gender::select('id', 'name')->get();
        return view('pages.referral.create', compact('gender', 'religion'));
    }
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required|unique:referrals',
            'gender_id' => 'required',
            'religion_id' => 'required',
        ]);
        $data = $request->all();
        $message = $this->baseService->create($data);
        return redirect()->route('referral.index')->with($message);
    }
    function edit($id)
    {
        $religion = Religion::select('id', 'name')->get();
        $gender = Gender::select('id', 'name')->get();
        $referral = Referral::findOrFail($id);
        return view('pages.referral.edit', compact('gender', 'religion', 'referral'));
    }
    function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required',
            'gender_id' => 'required',
            'religion_id' => 'required',
        ]);
        $data = $request->all();
        $message = $this->baseService->update($data, $id);
        return redirect()->route('referral.index')->with($message);
    }
    function delete($id)
    {
        $message = $this->baseService->delete($id);
        return redirect()->route('referral.index')->with($message);
    }

    function referralDue($id)
    {
        return Referral::findOrFail($id)->due;
    }
    function paymentDetailStore(Request $request)
    {
        $message = $this->baseService->paymentStore($request->all());
        return redirect()->route('referral.index')->with($message);
    }
    function paymentDetail($id)
    {
        return Referral::join('referral_payments', 'referral_payments.referral_id', 'referrals.id')
        ->join('users', 'users.id', 'referral_payments.user_id')
        ->where('referrals.id', $id)
            ->select('referral_payments.created_at as date', 'referral_payments.amount', 'users.name as username', 'referral_payments.id as id')
            ->get();
    }
    function paymentEdit($id)
    {
        return ReferralPayment::findOrFail($id);
    }
    function ReferralPaymentUpdate(Request $request)
    {
        $message = $this->baseService->paymentUpdate($request->all());
        return redirect()->route('referral.index')->with($message);
    }
    function paymentDelete($id)
    {
        ReferralPayment::findOrFail($id)->delete();
        return redirect()->route('referral.index')->with('success', 'Referral Payment Deleted Successfully');
    }
}
