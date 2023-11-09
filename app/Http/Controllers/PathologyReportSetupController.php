<?php

namespace App\Http\Controllers;

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
}
