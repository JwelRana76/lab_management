<?php

namespace App\Service;

use App\Models\PathologyTest;
use App\Models\PathologyTestCategory;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PathologyTestService extends Service
{
  protected $model = PathologyTest::class;

  function testIndex()
  {
    $tests = $this->model::all();
    return DataTables::of($tests)
      ->addColumn('category', function ($item) {
        return '<span class="badge badge-primary">' . $item->category->name . '</span>';
      })
      ->addColumn('rate', function ($item) {
        return $item->test_rate;
      })
      ->addColumn('referral_persent', function ($item) {
        return $item->referral_fee_percent . '%';
      })
      ->addColumn('referral_amount', function ($item) {
        return $item->referral_fee_amount;
      })
      ->addColumn('action', fn ($item) => view('pages.pathology.test.action', compact('item'))->render())
      ->rawColumns(['category', 'action'])
      ->make(true);
  }
  function testStore($data)
  {
    DB::beginTransaction();
    try {
      $find = $this->model::where('code', $data['code'])->first();
      if ($find) {
        return ['warning' => 'This Code already provide other Test'];
      }
      $data['pathology_test_category_id'] = $data['category_id'];
      $data['referral_fee_amount'] = $data['test_rate'] * $data['referral_fee_percent'] / 100;
      $this->model::create($data);
      DB::commit();
      return ['success' => 'Pathology Test Created Successfully'];
    } catch (Exception $th) {
      DB::rollBack();
      dd($th->getMessage());
    }
    
  }

  function testUpdate($data, $id)
  {
    DB::beginTransaction();
    try {
      $find = $this->model::where('code', $data['code'])->first();
      if ($find && $find->id != $id) {
        return ['warning' => 'This Code already provide other Test'];
      }
      $data['pathology_test_category_id'] = $data['category_id'];
      $data['referral_fee_amount'] = $data['test_rate'] * $data['referral_fee_percent'] / 100;
      $this->model::findOrFail($id)->update($data);
      DB::commit();
      return ['success' => 'Pathology Test Updated Successfully'];
    } catch (Exception $th) {
      DB::rollBack();
      dd($th->getMessage());
    }
    
  }
  function testDelete($id)
  {
    $this->model::findOrFail($id)->delete();
    return ['success' => 'Pathology Test Deleted Successfully'];
  }

  function Import($data)
  {
    if (!empty($data['result_file'])) {
      $file = $data['result_file'];

      if ($file->getClientOriginalExtension() === 'csv') {
        $csvData = file_get_contents($file);
        $csvArray = array_map("str_getcsv", explode("\n", $csvData));
        array_shift($csvArray);
        array_pop($csvArray);
        $headers = ['pathology_test_category_id', 'name', 'code', 'test_rate', 'referral_fee_percent', 'referral_fee_amount', 'specimen'];

        foreach ($csvArray as $row) {
          $category = PathologyTestCategory::where('name', $row[0])->first();
          if (empty($category)) {
            $category = PathologyTestCategory::create([
              'name' => $row[0],
              'code' => rand(100, 1000),
            ]);
          }
          $row[0] = $category->id;
          $amount = $row[4] * $row[3] / 100;
          array_splice($row, 5, 0, $amount);
          $find = $this->model::where('name', $row[1])->orWhere('code', $row[2])->first();
          if (!$find) {
            $tests = new $this->model();
            $testsData = array_combine($headers, $row);
            foreach ($testsData as $key => $value) {
              $tests->$key = $value;
            }

            $tests->save();
          }
        }

        return ['success' => 'Pathology Test imported successfully'];
      } else {
        return ['error' => 'Invalid file format. Please upload a CSV file.'];
      }
    }
    return ['error' => 'Invalid file Please upload a CSV file.'];
  }
}
