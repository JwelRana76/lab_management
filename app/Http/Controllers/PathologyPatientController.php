<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Gender;
use App\Models\PathologyTest;
use App\Models\PathologyTube;
use App\Models\Referral;
use App\Service\PathologyPatientService;
use Illuminate\Http\Request;

class PathologyPatientController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyPatientService;
    }
    function index()
    {
    }

    function create()
    {
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
}
