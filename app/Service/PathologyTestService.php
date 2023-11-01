<?php

namespace App\Service;

use App\Models\PathologyTest;
use Yajra\DataTables\Facades\DataTables;

class PathologyTestService
{
  protected $testModel = PathologyTest::class;

  function testIndex()
  {
    $tests = $this->testModel::all();
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
    $data['pathology_test_category_id'] = $data['category_id'];
    $data['referral_fee_amount'] = $data['test_rate'] * $data['referral_fee_percent'] / 100;
    $this->testModel::create($data);
    return ['success' => 'Pathology Test Created Successfully'];
  }

  function testUpdate($data, $id)
  {
    $data['pathology_test_category_id'] = $data['category_id'];
    $data['referral_fee_amount'] = $data['test_rate'] * $data['referral_fee_percent'] / 100;
    $this->testModel::findOrFail($id)->update($data);
    return ['success' => 'Pathology Test Updated Successfully'];
  }
  function testDelete($id)
  {
    $this->testModel::findOrFail($id)->delete();
    return ['success' => 'Pathology Test Deleted Successfully'];
  }
}
