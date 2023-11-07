<?php

namespace App\Service;

use App\Models\PathologyResultHeading;
use Yajra\DataTables\Facades\DataTables;

class PathologyResultHeadingService
{
  protected $modal = PathologyResultHeading::class;

  function index()
  {
    $resultheading = $this->modal::active();
    return DataTables::of($resultheading)
      ->addColumn('action', fn ($item) => view('pages.pathology.result_heading.action', compact('item'))->render())
      ->rawColumns(['action'])
      ->make(true);
  }
  function store($data)
  {
    $this->modal::create($data);
    return ['success' => 'Pathology Result Heading Created Successfully'];
  }

  function update($data)
  {
    $this->modal::findOrFail($data['result_heading_id'])->update($data);
    return ['success' => 'Pathology Result Heading Updated Successfully'];
  }
  function delete($id)
  {
    $this->modal::findOrFail($id)->update(['is_active' => false]);
    return ['success' => 'Pathology Result Heading Deleted Successfully'];
  }
}
