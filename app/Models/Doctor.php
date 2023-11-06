<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Doctor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'photo', 'data' => 'photo'],
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'designation', 'data' => 'designation'],
        ['name' => 'refer_amount', 'data' => 'refer_amount'],
        ['name' => 'paid', 'data' => 'paid'],
        ['name' => 'due', 'data' => 'due'],
        ['name' => 'action', 'data' => 'action'],
    ];

    function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }

    function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    function religion()
    {
        return $this->belongsTo(Religion::class);
    }
    function blood_group()
    {
        return $this->belongsTo(BloodGroup::class);
    }
    function getReferamountAttribute()
    {
        $total = PathologyPatient::join('patient_tests', 'patient_tests.patient_id', '=', 'pathology_patients.id')
        ->join('pathology_tests', 'pathology_tests.id', '=', 'patient_tests.test_id')
        ->where('pathology_patients.doctor_id', $this->id)
            ->sum(DB::raw('pathology_tests.referral_fee_amount - pathology_patients.discount_amount'));
        return $total;
    }
    function payment()
    {
        return $this->hasMany(ReferralPayment::class, 'doctor_id', 'id');
    }
    function getDueAttribute()
    {
        return $this->getReferamountAttribute() - $this->payment()->sum('amount');;
    }
}
