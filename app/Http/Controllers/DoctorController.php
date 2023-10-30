<?php

namespace App\Http\Controllers;

use App\Models\BloodGroup;
use App\Models\Doctor;
use App\Models\Gender;
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
        $doctors = $this->baseService->Index();
        $columns = Doctor::$columns;
        if (request()->ajax()) {
            return $doctors;
        }
        return view('pages.doctor.index', compact('columns'));
    }
    function create()
    {
        $blood_group = BloodGroup::select('id', 'name')->get();
        $religion = Religion::select('id', 'name')->get();
        $gender = Gender::select('id', 'name')->get();
        return view('pages.doctor.create', compact('blood_group', 'gender', 'religion'));
    }
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required|unique:doctors',
            'designation' => 'required',
            'contact' => 'required',
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
        $blood_group = BloodGroup::select('id', 'name')->get();
        $religion = Religion::select('id', 'name')->get();
        $gender = Gender::select('id', 'name')->get();
        $doctor = Doctor::findOrFail($id);
        return view('pages.doctor.edit', compact('blood_group', 'gender', 'religion', 'doctor'));
    }
    function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required',
            'designation' => 'required',
            'contact' => 'required',
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
        $message = $this->baseService->delete($id);
        return redirect()->route('doctor.index')->with($message);
    }
}
