<?php

namespace App\Service;

use App\Models\PathologyResultName;
use Yajra\DataTables\Facades\DataTables;

class PathologyResultNameService
{
  protected $modal = PathologyResultName::class;

  function index()
  {
    $resultnames = $this->modal::active();
    return DataTables::of($resultnames)
      ->addColumn('action', fn ($item) => view('pages.pathology.result_name.action', compact('item'))->render())
      ->rawColumns(['action'])
      ->make(true);
  }
  function store($data)
  {
    $this->modal::create($data);
    return ['success' => 'Pathology Result Name Created Successfully'];
  }

  function update($data)
  {
    $this->modal::findOrFail($data['result_name_id'])->update($data);
    return ['success' => 'Pathology Result Name Updated Successfully'];
  }
  function delete($id)
  {
    $this->modal::findOrFail($id)->update(['is_active' => false]);
    return ['success' => 'Pathology Result Name Deleted Successfully'];
  }
}
