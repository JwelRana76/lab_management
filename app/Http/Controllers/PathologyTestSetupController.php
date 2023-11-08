<?php

namespace App\Http\Controllers;

use App\Models\PathologyResultHeading;
use App\Models\PathologyResultName;
use App\Models\PathologyTest;
use App\Models\PathologyTestCategory;
use App\Models\PathologyTestSetup;
use App\Models\PathologyUnit;
use App\Service\PathologyTestSetupService;
use Illuminate\Http\Request;

class PathologyTestSetupController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyTestSetupService;
    }
    function index()
    {
        if (!userHasPermission('pathology_test-index'))
            return view('not_permitted');
        $tests = $this->baseService->Index();
        $columns = PathologyTestSetup::$columns;
        if (request()->ajax()) {
            return $tests;
        }
        $categories = PathologyTestCategory::where('is_active', 1)->get();
        return view('pages.pathology.test_setup.index', compact('columns', 'categories'));
    }

    function create()
    {
        $tests = PathologyTest::where('is_active', 1)->get();
        $category = PathologyTestCategory::where('is_active', 1)->get();
        $test_result_name = PathologyResultName::where('is_active', 1)->get();
        return view('pages.pathology.test_setup.create', compact('category', 'test_result_name', 'tests'));
    }

    function store(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->Store($data);
        return redirect()->route('pathology.test_setup.index')->with($message);
    }

    function edit($id)
    {
        $units = PathologyUnit::where('is_active', 1)->get();
        $tests = PathologyTest::where('is_active', 1)->get();
        $category = PathologyTestCategory::where('is_active', 1)->get();
        $test_result_name = PathologyResultName::where('is_active', 1)->get();
        $test_result_heading = PathologyResultHeading::where('is_active', 1)->get();
        $setup = PathologyTestSetup::findOrFail($id);
        return view('pages.pathology.test_setup.edit', compact('tests', 'category', 'test_result_name', 'setup', 'test_result_heading', 'units'));
    }

    function update(Request $request, $id)
    {
        $data = $request->all();
        $message = $this->baseService->Update($data, $id);
        return redirect()->route('pathology.test_setup.index')->with($message);
    }

    function delete($id)
    {
        $message = $this->baseService->delete($id);
        return redirect()->route('pathology.test_setup.index')->with($message);
    }
}
