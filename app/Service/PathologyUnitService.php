<?php

namespace App\Service;

use App\Models\PathologyUnit;
use Yajra\DataTables\Facades\DataTables;

class PathologyUnitService extends Service
{
  protected $modal = PathologyUnit::class;

  function index()
  {
    $units = $this->modal::active();
    return DataTables::of($units)
      ->addColumn('action', fn ($item) => view('pages.pathology.unit.action', compact('item'))->render())
      ->rawColumns(['action'])
      ->make(true);
  }
  function store($data)
  {
    $this->modal::create($data);
    return ['success' => 'Pathology Unit Created Successfully'];
  }

  function update($data)
  {
    $this->modal::findOrFail($data['unit_id'])->update($data);
    return ['success' => 'Pathology Unit Updated Successfully'];
  }
  function delete($id)
  {
    $this->modal::findOrFail($id)->update(['is_active' => false]);
    return ['success' => 'Pathology Unit Deleted Successfully'];
  }
}
