<?php

namespace App\Service;

use App\Models\Doctor;
use App\Models\ReferralPayment;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DoctorService extends Service
{

  protected $model = Doctor::class;

  public function index()
  {
    $doctors = $this->model::active();
    return DataTables::of($doctors)
      ->addColumn('photo', function ($item) {
        if ($item->photo) {
          $img = '<img src="/upload/doctor/' . $item->photo . '" alt="logo" width="80px">';
        } else {
        $img = '<img src="/upload/doctor/user.jpg" alt="logo" width="80px">';
        }
        return $img;
      })
      ->addColumn('refer_amount', function ($item) {
        return $item->referamount;
      })
      ->addColumn('paid', function ($item) {
        return $item->payment()->sum('amount');
      })
      ->addColumn('due', function ($item) {
        return $item->due;
      })
      ->addColumn('gender', function ($item) {
        return $item->gender->name ?? "N/A";
      })
      ->addColumn('action', fn ($item) => view('pages.doctor.action', compact('item'))->render())
      ->rawColumns(['photo', 'action'])
      ->make(true);
  }
  public function create($data)
  {
    DB::beginTransaction();
    try {
      if (!empty($data['photo'])) {
        $file = $data['photo'];
        $name = time() . '.' . $file->getClientOriginalExtension();
        $des = 'upload/doctor/';
        $file->move($des, $name);
        $data['photo'] = $name;
      }
      Doctor::create($data);

      DB::commit();
      return ['success' => "Doctor Created Successfully"];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }
  public function update($data, $id)
  {
    $doctor = $this->model::findOrFail($id);
    DB::beginTransaction();
    try {
      if (!empty($data['photo'])) {
        $file = $data['photo'];
        $name = time() . '.' . $file->getClientOriginalExtension();
        $des = 'upload/doctor/';
        $file->move($des, $name);
        $data['photo'] = $name;
      }
      $doctor->update($data);

      DB::commit();
      return ['success' => "Doctor Updated Successfully"];
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
    return ['success' => "Doctor Deleted Successfully"];
  }

  function paymentStore($data)
  {
    DB::beginTransaction();
    try {
      ReferralPayment::create([
        'doctor_id' => $data['doctor_id'],
        'amount' => $data['amount'],
        'user_id' => auth()->user()->id,
      ]);
      DB::commit();
      return ['success' => 'Doctor Refer Payment Inserted Successfully'];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage(), __LINE__);
    }
  }
  function paymentUpdate($data)
  {
    DB::beginTransaction();
    try {
      ReferralPayment::findOrFail($data['payment_id'])->update([
        'amount' => $data['amount'],
        'user_id' => auth()->user()->id,
      ]);
      DB::commit();
      return ['success' => 'Doctor Refer Payment Updated Successfully'];
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage(), __LINE__);
    }
  }
}
