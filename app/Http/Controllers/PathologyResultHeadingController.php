<?php

namespace App\Http\Controllers;

use App\Models\PathologyResultHeading;
use App\Service\PathologyResultHeadingService;
use Illuminate\Http\Request;

class PathologyResultHeadingController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyResultHeadingService;
    }
    function index()
    {
        if (!userHasPermission('pathology_test-index'))
            return view('not_permitted');
        $heading = $this->baseService->index();
        $columns = PathologyResultHeading::$columns;
        if (request()->ajax()) {
            return $heading;
        }
        return view('pages.pathology.result_heading.index', compact('columns'));
    }

    function store(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->store($data);
        return redirect()->route('pathology.result_heading.index')->with($message);
    }

    function edit($id)
    {
        return PathologyResultHeading::findOrFail($id);
    }

    function update(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->update($data);
        return redirect()->route('pathology.result_heading.index')->with($message);
    }

    function delete($id)
    {
        $message = $this->baseService->delete($id);
        return redirect()->route('pathology.result_heading.index')->with($message);
    }
}
