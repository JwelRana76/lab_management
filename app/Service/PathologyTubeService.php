<?php

namespace App\Service;

use App\Models\PathologyTube;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PathologyTubeService
{
  protected $model = PathologyTube::class;

  function index()
  {
    $tubes = $this->model::all();
    return DataTables::of($tubes)
      ->addColumn('action', fn ($item) => view('pages.pathology.tube.action', compact('item'))->render())
      ->rawColumns(['action'])
      ->make(true);
  }
  function store($data)
  {
    DB::beginTransaction();
    try {
      $find = $this->model::where('code', $data['code'])->first();
      if ($find) {
        return ['warning' => 'This Code already provide other tube'];
      }
      $this->model::create($data);
      DB::commit();
    } catch (Exception $th) {
      DB::rollBack();
      dd($th->getMessage());
    }
    return ['success' => 'Pathology Tube Created Successfully'];
  }

  function update($data)
  {
    $find = $this->model::where('code', $data['code'])->first();
    if ($find && $find->id != $data['tube_id']) {
      return ['warning' => 'This Code already provide other tube'];
    }
    $this->model::findOrFail($data['tube_id'])->update($data);
    return ['success' => 'Pathology Tube Updated Successfully'];
  }
  function delete($id)
  {
    $this->model::findOrFail($id)->update(['is_active' => false]);
    return ['success' => 'Pathology Tube Deleted Successfully'];
  }

  function Import($data)
  {
    if (!empty($data['result_file'])) {
      $file = $data['result_file'];

      if ($file->getClientOriginalExtension() === 'csv') {
        $csvData = file_get_contents($file);
        $csvArray = array_map("str_getcsv", explode("\n", $csvData));
        $headers = array_shift($csvArray);
        array_pop($csvArray);

        foreach ($csvArray as $row) {
          $find = $this->model::where('name', $row[0])->first();
          if (!$find) {
            $tubes = new $this->model();
            $tubesData = array_combine($headers, $row);
            foreach ($tubesData as $key => $value) {
              $tubes->$key = $value;
              $tubes->$key = $value;
              $tubes->$key = $value;
            }

            $tubes->save();
          }
        }

        return ['success' => 'Pathology Result Name imported successfully'];
      } else {
        return ['error' => 'Invalid file format. Please upload a CSV file.'];
      }
    }
    return ['error' => 'Invalid file Please upload a CSV file.'];
  }
}
