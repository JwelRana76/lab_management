<?php

namespace App\Http\Controllers;

use App\Models\PathologyPatient;
use App\Models\PathologyTest;
use App\Models\PatientTest;
use App\Service\PathologyPatientReportSetupService;
use Illuminate\Http\Request;

class PathologyReportSetupController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyPatientReportSetupService;
    }
    function index()
    {
        if (!userHasPermission('pathology_test-index'))
            return view('not_permitted');
        $patinets = $this->baseService->index();
        $columns = [
            ['name' => 'unique_id', 'data' => 'unique_id'],
            ['name' => 'name', 'data' => 'name'],
            ['name' => 'contact', 'data' => 'contact'],
            ['name' => 'test', 'data' => 'test'],
            ['name' => 'action', 'data' => 'action'],
        ];
        if (request()->ajax()) {
            return $patinets;
        }
        return view('pages.pathology.report_set.index', compact('columns'));
    }

    function store(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->store($data);
        return redirect()->route('report_set.index')->with($message);
    }

    function view()
    {
        if (!userHasPermission('pathology_test-index'))
        return view('not_permitted');
        $patinets = $this->baseService->view();
        $columns = [
            ['name' => 'unique_id', 'data' => 'unique_id'],
            ['name' => 'name', 'data' => 'name'],
            ['name' => 'contact', 'data' => 'contact'],
            ['name' => 'test', 'data' => 'test'],
            ['name' => 'action', 'data' => 'action'],
        ];
        if (request()->ajax()) {
            return $patinets;
        }
        return view('pages.pathology.report_set.view', compact('columns'));
    }

    function update(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->update($data);
        return redirect()->route('report_set.view')->with($message);
    }

    function delete($id)
    {
        $message = $this->baseService->delete($id);
        return redirect()->route('pathology.result_heading.index')->with($message);
    }
    function reportPrint(Request $request)
    {
        $tests = $request->test_id;
        $pathology_test = [];
        foreach ($tests as $key => $test) {
            $find_test = PathologyTest::find($test);
            if (in_array($find_test->pathology_test_category_id, $pathology_test)) {
            } else {
                array_push($pathology_test, $find_test->pathology_test_category_id);
            }
        }
        $patient = PathologyPatient::findOrFail($request->patient_id);
        return view('pages.pathology.report_set.print2', compact('patient', 'pathology_test', 'tests'));
    }
    function findtest($id)
    {
        $pathology_test = PatientTest::where('patient_id', $id)
            ->join('pathology_tests', 'pathology_tests.id', 'patient_tests.test_id')->get();
        return $pathology_test;
    }
}
