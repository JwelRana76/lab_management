<?php

namespace App\Http\Controllers;

use App\Models\PathologyResultName;
use App\Service\PathologyResultNameService;
use Illuminate\Http\Request;

class PathologyResultNameController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyResultNameService;
    }
    function index()
    {
        if (!userHasPermission('pathology_test-index'))
            return view('not_permitted');
        $resultnames = $this->baseService->index();
        $columns = PathologyResultName::$columns;
        if (request()->ajax()) {
            return $resultnames;
        }
        return view('pages.pathology.result_name.index', compact('columns'));
    }

    function store(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->store($data);
        return redirect()->route('pathology.result_name.index')->with($message);
    }

    function edit($id)
    {
        return PathologyResultName::findOrFail($id);
    }

    function update(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->update($data);
        return redirect()->route('pathology.result_name.index')->with($message);
    }

    function delete($id)
    {
        $message = $this->baseService->delete($id);
        return redirect()->route('pathology.result_name.index')->with($message);
    }
}
