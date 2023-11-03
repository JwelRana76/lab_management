<?php

namespace App\Service;

use App\Models\PathologyTube;
use Yajra\DataTables\Facades\DataTables;

class PathologyTubeService
{
  protected $testModel = PathologyTube::class;

  function index()
  {
    $tubes = $this->testModel::all();
    return DataTables::of($tubes)
      ->addColumn('action', fn ($item) => view('pages.pathology.tube.action', compact('item'))->render())
      ->rawColumns(['action'])
      ->make(true);
  }
  function store($data)
  {
    $this->testModel::create($data);
    return ['success' => 'Pathology Tube Created Successfully'];
  }

  function update($data)
  {
    $this->testModel::findOrFail($data['tube_id'])->update($data);
    return ['success' => 'Pathology Tube Updated Successfully'];
  }
  function delete($id)
  {
    $this->testModel::findOrFail($id)->update(['is_active' => false]);
    return ['success' => 'Pathology Tube Deleted Successfully'];
  }
}
