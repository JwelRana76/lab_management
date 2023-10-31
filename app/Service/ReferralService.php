<?php

namespace App\Service;

use App\Models\Referral;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReferralService {
  protected $model = Referral::class;

  public function index()
  {
    $doctors = $this->model::active();
    return DataTables::of($doctors)
      ->addColumn('gender', function ($item) {
        return $item->gender->name ?? 'N/A';
      })
      ->addColumn('action', fn ($item) => view('pages.referral.action', compact('item'))->render())
      ->make(true);
  }
  public function create($data)
  {
    DB::beginTransaction();
    try {
      Referral::create($data);
      DB::commit();
      return ['success' => "Referral Created Successfully"];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }
  public function update($data, $id)
  {
    $referral = $this->model::findOrFail($id);
    DB::beginTransaction();
    try {
      $referral->update($data);

      DB::commit();
      return ['success' => "Referral Update Successfully"];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }
  public function delete($id)
  {
    $this->model::findOrFail($id)->update([
      'is_active' => false,
    ]);
    return ['success' => "Referral Deleted Successfully"];
  }
}