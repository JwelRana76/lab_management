<?php

namespace App\Http\Controllers;

use App\Models\PathologyTest;
use App\Models\PathologyTestCategory;
use App\Service\PathologyTestService;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class PathologyTestController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyTestService;
    }
    function index()
    {
        if (!userHasPermission('pathology_test-index'))
            return view('not_permitted');
        $tests = $this->baseService->testIndex();
        $columns = PathologyTest::$columns;
        if (request()->ajax()) {
            return $tests;
        }
        $categories = PathologyTestCategory::where('is_active', 1)->get();
        return view('pages.pathology.test.index', compact('columns', 'categories'));
    }

    function create()
    {
        $category = PathologyTestCategory::where('is_active', 1)->get();
        return view('pages.pathology.test.create', compact('category'));
    }

    function store(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->testStore($data);
        return redirect()->route('test.index')->with($message);
    }

    function edit($id)
    {
        $test = PathologyTest::findOrFail($id);
        $category = PathologyTestCategory::where('is_active', 1)->get();
        return view('pages.pathology.test.edit', compact('test', 'category'));
    }

    function update(Request $request, $id)
    {
        $data = $request->all();
        $message = $this->baseService->testUpdate($data, $id);
        return redirect()->route('test.index')->with($message);
    }

    function delete($id)
    {
        $message = $this->baseService->testDelete($id);
        return redirect()->route('test.index')->with($message);
    }

    function Import(Request $request)
    {
        $request->validate([
            'result_file' => 'required|file|mimes:csv,txt',
        ]);
        $message = $this->baseService->Import($request->all());
        return redirect()->route('test.index')->with($message);
    }
}
