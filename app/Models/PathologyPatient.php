<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyPatient extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'unique_id', 'data' => 'unique_id'],
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'age', 'data' => 'age'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'test', 'data' => 'test'],
        ['name' => 'tube', 'data' => 'tube'],
        ['name' => 'total', 'data' => 'total'],
        ['name' => 'discount', 'data' => 'discount'],
        ['name' => 'grand_total', 'data' => 'grand_total'],
        ['name' => 'paid', 'data' => 'paid'],
        ['name' => 'due', 'data' => 'due'],
        ['name' => 'action', 'data' => 'action'],
    ];

    function tests()
    {
        return $this->hasMany(PatientTest::class, 'patient_id', 'id');
    }
    function tubes()
    {
        return $this->hasMany(PatientTube::class, 'patient_id', 'id');
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    function referral()
    {
        return $this->belongsTo(Referral::class);
    }
    function payment()
    {
        return $this->hasMany(Payment::class, 'patient_id', 'id');
    }
    function getDueAttribute()
    {
        return $this->grand_total - $this->payment()->sum('amount');
    }

    function scopeDuepatient($q)
    {
        return $q->where(function ($query) {
            $query->whereRaw('grand_total - (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE payments.patient_id = pathology_patients.id) > 0');
        });
    }
    function getMaxdiscountAttribute()
    {
        $data = $this->tests()->get();
        $max = 0;
        foreach ($data as $key => $item) {
            $max += $item->test()->sum('referral_fee_amount');
        }
        return $max;
    }
}
