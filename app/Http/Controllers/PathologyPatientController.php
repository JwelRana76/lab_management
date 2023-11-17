<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Gender;
use App\Models\PathologyPatient;
use App\Models\PathologyTest;
use App\Models\PathologyTube;
use App\Models\Referral;
use App\Models\RoleHasPermission;
use App\Service\PathologyPatientService;
use Illuminate\Http\Request;

use function PHPUnit\Framework\directoryExists;

class PathologyPatientController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyPatientService;
    }
    function index()
    {
        if (!userHasPermission('patient-index'))
        return view('404');
        $patients = $this->baseService->index();
        $columns = PathologyPatient::$columns;
        if (request()->ajax()) {
            return $patients;
        }
        return view('pages.pathology.patient.index', compact('columns'));
    }

    function create()
    {
        if (!userHasPermission('patient-store'))
        return view('404');
        $genders = Gender::all();
        $doctors = Doctor::where('is_active', 1)->get();
        $referrals = Referral::where('is_active', 1)->get();
        $tests = PathologyTest::where('is_active', 1)->get();
        $tubes = PathologyTube::where('is_active', 1)->get();
        return view('pages.pathology.patient.create', compact('doctors', 'referrals', 'tests', 'tubes', 'genders'));
    }
    function testFind($id)
    {
        return PathologyTest::where('code', $id)->first();
    }
    function tubeFind($id)
    {
        return PathologyTube::findOrFail($id);
    }
    function store(Request $request)
    {
        $data = $request->all();
        $patient = $this->baseService->store($data);
        return $patient;
    }
    function invoice($id)
    {
        $patient = PathologyPatient::findOrFail($id);
        return view('pages.pathology.patient.invoice', compact('patient'));
    }
    function edit($id)
    {
        if (!userHasPermission('patient-update'))
        return view('404');
        $genders = Gender::all();
        $doctors = Doctor::where('is_active', 1)->get();
        $referrals = Referral::where('is_active', 1)->get();
        $tests = PathologyTest::where('is_active', 1)->get();
        $tubes = PathologyTube::where('is_active', 1)->get();
        $patient = PathologyPatient::findOrFail($id);
        return view('pages.pathology.patient.edit', compact('patient', 'doctors', 'referrals', 'tests', 'tubes', 'genders'));
    }
    function update(Request $request)
    {
        $data = $request->all();
        $patient = $this->baseService->update($data);
        return $patient;
    }
    function delete($id)
    {
        if (!userHasPermission('patient-delete'))
        return view('404');
        $message = $this->baseService->delete($id);
        return redirect()->route('pathology.patient.index')->with($message);
    }
}
