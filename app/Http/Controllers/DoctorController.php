<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\Doctor;
use App\Models\Gender;
use App\Models\ReferralPayment;
use App\Models\Religion;
use App\Service\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->baseService = new DoctorService;
    }

    function index()
    {
        if (!userHasPermission('doctor-index'))
        return view('404');

        $doctors = $this->baseService->Index();
        $columns = Doctor::$columns;
        if (request()->ajax()) {
            return $doctors;
        }
        return view('pages.doctor.index', compact('columns'));
    }
    function create()
    {
        if (!userHasPermission('doctor-store'))
        return view('404');
        $blood_group = BloodGroup::select('id', 'name')->get();
        $religion = Religion::select('id', 'name')->get();
        $gender = Gender::select('id', 'name')->get();
        return view('pages.doctor.create', compact('blood_group', 'gender', 'religion'));
    }
    function store(Request $request)
    {
        if (!userHasPermission('doctor-store'))
        return view('404');
        $request->validate([
            'name' => 'required',
            'contact' => 'required|unique:doctors',
            'designation' => 'required',
            'gender_id' => 'required',
            'religion_id' => 'required',
            'institute' => 'required',
        ]);
        $data = $request->all();
        $message = $this->baseService->create($data);
        return redirect()->route('doctor.index')->with($message);
    }
    function edit($id)
    {
        if (!userHasPermission('doctor-update'))
        return view('404');
        $blood_group = BloodGroup::select('id', 'name')->get();
        $religion = Religion::select('id', 'name')->get();
        $gender = Gender::select('id', 'name')->get();
        $doctor = Doctor::findOrFail($id);
        return view('pages.doctor.edit', compact('blood_group', 'gender', 'religion', 'doctor'));
    }
    function update(Request $request, $id)
    {
        if (!userHasPermission('doctor-update'))
        return view('404');
        $request->validate([
            'name' => 'required',
            'contact' => 'required',
            'designation' => 'required',
            'gender_id' => 'required',
            'religion_id' => 'required',
            'institute' => 'required',
        ]);
        $data = $request->all();
        $message = $this->baseService->update($data, $id);
        return redirect()->route('doctor.index')->with($message);
    }
    function delete($id)
    {
        if (!userHasPermission('doctor-delete'))
        return view('404');
        $message = $this->baseService->delete($id);
        return redirect()->route('doctor.index')->with($message);
    }

    function referralDue($id)
    {
        return Doctor::findOrFail($id)->due;
    }
    function paymentDetailStore(Request $request)
    {
        $message = $this->baseService->paymentStore($request->all());
        return redirect()->route('doctor.index')->with($message);
    }
    function paymentDetail($id)
    {
        return Doctor::join('referral_payments', 'referral_payments.doctor_id', 'doctors.id')
        ->join('users', 'users.id', 'referral_payments.user_id')
        ->where('doctors.id', $id)
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
        return redirect()->route('doctor.index')->with($message);
    }
    function paymentDelete($id)
    {
        ReferralPayment::findOrFail($id)->delete();
        return redirect()->route('doctor.index')->with('success', 'Doctor Refer Payment Deleted Successfully');
    }
}
