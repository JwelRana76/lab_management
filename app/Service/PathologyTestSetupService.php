<?php

namespace App\Service;

use App\Models\PathologyTestSetup;
use App\Models\PathologyTestSetupResult;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PathologyTestSetupService
{
  protected $setupmode = PathologyTestSetup::class;
  protected $setupmodeResult = PathologyTestSetupResult::class;

  function Index()
  {
    $setups = $this->setupmode::all();
    return DataTables::of($setups)
      ->addColumn('category', function ($item) {
        return '<span class="badge badge-primary">' . $item->test->category->name ?? 'N/A' . '</span>';
      })
      ->addColumn('test', function ($item) {
        return $item->test->name;
      })
      ->addColumn('result_name', function ($item) {
        $badges = '';
        foreach ($item->resutlName as $result) {
          $badges .= '<span class="badge badge-primary">' . ($result->result->name ?? 'N/A') . '</span> ';
        }
        return $badges;
      })
      ->addColumn('normal_value', function ($item) {
        $badges = '';
        foreach ($item->resutlName as $result) {
          $badges .= '<span class="badge badge-primary">' . ($result->normal_value) . '</span> ';
        }
        return $badges;
      })
      ->addColumn('action', fn ($item) => view('pages.pathology.test_setup.action', compact('item'))->render())
      ->rawColumns(['category', 'action', 'result_name', 'normal_value'])
      ->make(true);
  }
  
  function Store($data)
  {
    DB::beginTransaction();
    try {
      $find = $this->setupmode::where('test_id', $data['test_id'])->first();
      if ($find) {
        return ["warning" => "This Test Already Setuped before"];
      }
      $setup_data['test_id'] = $data['test_id'];
      $setup_data['result_no'] = count($data['result_id']);

      $setup = $this->setupmode::create($setup_data);

      // pathology setup result create 

      $results = $data['result_id'];
      foreach ($results as $key => $result) {
        $setup_result['pathology_test_setup_id'] = $setup->id;
        $setup_result['result_id'] = $result;
        $setup_result['result_type'] = $data['type'][$key] == 0 ? 0 : 1;
        $setup_result['heading_id'] = $data['heading_id'][$key] ?? null;
        $setup_result['pathology_unit_id'] = $data['unit'][$key] == 0 ? null : $data['unit'][$key];
        $setup_result['pathology_convert_unit_id'] = $data['convert_unit'][$key] == 0 ? null : $data['convert_unit'][$key];
        $setup_result['calculation_value'] = $data['cal_value'][$key] ?? null;
        $setup_result['calculation_operator'] = $data['cal_type'][$key] ?? null;
        $setup_result['normal_value'] = $data['normal_value'][$key] ?? null;
        $setup_result['default_value'] = $data['default_value'][$key] ?? null;
        $setup_result['is_converted'] = $setup_result['pathology_convert_unit_id'] == null ? 0 : 1;

        $this->setupmodeResult::create($setup_result);

        if ($data['normal_value'][$key]) {
          $setup->is_normal_value = true;
        }
      }
      $setup->save();

      DB::commit();
      return ['success' => "Pathology Test Setup Inserted Successfully"];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }

  function Update($data, $id)
  {
    $setup = $this->setupmode::findOrFail($id);
    DB::beginTransaction();
    try {
      $setup_data['test_id'] = $data['test_id'];
      $setup_data['result_no'] = count($data['result_id']);

      $setup->update($setup_data);

      // pathology setup result create 
      $this->setupmodeResult::where('pathology_test_setup_id', $setup->id)->delete();

      $results = $data['result_id'];
      foreach ($results as $key => $result) {
        $setup_result['pathology_test_setup_id'] = $setup->id;
        $setup_result['result_id'] = $result;
        $setup_result['result_type'] = $data['type'][$key] == 0 ? 0 : 1;
        $setup_result['heading_id'] = $data['heading_id'][$key] ?? null;
        $setup_result['pathology_unit_id'] = $data['unit'][$key] == 0 ? null : $data['unit'][$key];
        $setup_result['pathology_convert_unit_id'] = $data['convert_unit'][$key] == 0 ? null : $data['convert_unit'][$key];
        $setup_result['calculation_value'] = $data['cal_value'][$key] ?? null;
        $setup_result['calculation_operator'] = $data['cal_type'][$key] ?? null;
        $setup_result['normal_value'] = $data['normal_value'][$key] ?? null;
        $setup_result['default_value'] = $data['default_value'][$key] ?? null;
        $setup_result['is_converted'] = $setup_result['pathology_convert_unit_id'] == null ? 0 : 1;

        $this->setupmodeResult::create($setup_result);
      }

      DB::commit();
      return ['success' => "Pathology Test Setup Updated Successfully"];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }

  function delete($id)
  {
    $this->setupmode::findOrFail($id)->delete();
    return ['success' => 'Pathology Test Setup Deleted Successfully'];
  }
}
