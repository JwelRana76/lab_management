<?php

namespace App\Http\Controllers;

use App\Models\PathologyUnit;
use App\Service\PathologyUnitService;
use Illuminate\Http\Request;

class PathologyUnitController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyUnitService;
    }
    function index()
    {
        if (!userHasPermission('pathology_test-index'))
            return view('not_permitted');
        $units = $this->baseService->index();
        $columns = PathologyUnit::$columns;
        if (request()->ajax()) {
            return $units;
        }
        return view('pages.pathology.unit.index', compact('columns'));
    }

    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:pathology_units',
        ]);
        $data = $request->all();
        $message = $this->baseService->store($data);
        return redirect()->route('pathology.unit.index')->with($message);
    }

    function edit($id)
    {
        return PathologyUnit::findOrFail($id);
    }

    function update(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->update($data);
        return redirect()->route('pathology.unit.index')->with($message);
    }

    function delete($id)
    {
        $message = $this->baseService->delete($id);
        return redirect()->route('pathology.unit.index')->with($message);
    }
    function Import(Request $request)
    {
        $request->validate([
            'result_file' => 'required|file|mimes:csv,txt',
        ]);
        $message = $this->baseService->Import($request->all());
        return redirect()->route('pathology.unit.index')->with($message);
    }
}
