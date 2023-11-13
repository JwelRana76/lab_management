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
          $find = $this->modal::where('name', $row[0])->first();
          if (!$find) {
            $units = new $this->modal();
            $unitsData = array_combine($headers, $row);
            foreach ($unitsData as $key => $value) {
              if ($value) {
                $units->$key = $value;
              }
            }

            $units->save();
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
