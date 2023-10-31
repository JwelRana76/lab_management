<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $table = 'referrals';

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'gender', 'data' => 'gender'],
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
}
