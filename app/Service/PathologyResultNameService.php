<?php

namespace App\Service;

use App\Models\PathologyResultName;
use Illuminate\Support\Facades\Response;
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
  function Import($data)
  {
    if (!empty($data['result_file'])) {
      $file = $data['result_file'];

      // Check if the file is a valid CSV file
      if ($file->getClientOriginalExtension() === 'csv') {
        $csvData = file_get_contents($file);
        $csvArray = array_map("str_getcsv", explode("\n", $csvData));
        // Assuming the first row contains headers, so skip it
        $headers = array_shift($csvArray);
        array_pop($csvArray);

        foreach ($csvArray as $row) {
          $find = PathologyResultName::where('name', $row[0])->first();
          if (!$find) {
            $result = new PathologyResultName();
            $resultData = array_combine($headers, $row);
            // Assuming your model has fields like 'column1', 'column2', 'column3', etc.
            foreach ($resultData as $key => $value) {
              if ($value) {
                $result->$key = $value;
              }
            }

            $result->save();
          }
        }

        return ['success' => 'Pathology Result Name imported successfully'];
      } else {
        return ['error' => 'Invalid file format. Please upload a CSV file.'];
      }
    }
    return ['error' => 'Invalid file Please upload a CSV file.'];
  }
  public function downloadCSV()
  {
    // Create or fetch your CSV data
    $csvData = [
      ['Name', 'Age'],
      ['John', 30],
      ['Alice', 25],
      ['Bob', 35],
    ];

    $fileName = 'sample.csv';

    // Create a CSV file and write the data to it
    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
    ];

    $handle = fopen('php://output', 'w');
    foreach ($csvData as $row) {
      fputcsv($handle, $row);
    }
    fclose($handle);

    // Return the CSV file as a response
    return Response::stream(
      function () use ($handle) {
        fclose($handle);
      },
      200,
      $headers
    );
  }
}
