<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class Referral extends Model
{
    use HasFactory;

    protected $table = 'referrals';

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'gender', 'data' => 'gender'],
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
    function patients()
    {
        return $this->hasMany(PathologyPatient::class, 'referral_id', 'id');
    }
    function getReferamountAttribute()
    {
        $patients = PathologyPatient::join('patient_tests', 'patient_tests.patient_id', '=', 'pathology_patients.id')
        ->join('pathology_tests', 'pathology_tests.id', '=', 'patient_tests.test_id')
        ->where('pathology_patients.referral_id', $this->id)
            ->whereRaw('pathology_tests.referral_fee_amount - pathology_patients.discount_amount > 0')
            ->select('pathology_patients.*', 'pathology_tests.referral_fee_amount as refer')
            ->get();
        $total = 0;
        foreach ($patients as $key => $item) {
            if ($item->grand_total - $item->payment()->sum('amount') == 0) {
                $total += $item->refer;
            }
        }
        return $total;
    }
    function payment()
    {
        return $this->hasMany(ReferralPayment::class, 'referral_id', 'id');
    }
    function getDueAttribute()
    {
        return $this->getReferamountAttribute() - $this->payment()->sum('amount');;
    }
}
