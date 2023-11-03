<?php

namespace App\Http\Controllers;

use App\Models\PathologyTube;
use App\Service\PathologyTubeService;
use Illuminate\Http\Request;

class PathologyTubeController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyTubeService;
    }
    function index()
    {
        if (!userHasPermission('pathology_test-index'))
            return view('not_permitted');
        $tubes = $this->baseService->index();
        $columns = PathologyTube::$columns;
        if (request()->ajax()) {
            return $tubes;
        }
        return view('pages.pathology.tube.index', compact('columns'));
    }

    function store(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->store($data);
        return redirect()->route('tube.index')->with($message);
    }

    function edit($id)
    {
        return PathologyTube::findOrFail($id);
    }

    function update(Request $request)
    {
        $data = $request->all();
        $message = $this->baseService->update($data);
        return redirect()->route('tube.index')->with($message);
    }

    function delete($id)
    {
        $message = $this->baseService->delete($id);
        return redirect()->route('tube.index')->with($message);
    }
}
