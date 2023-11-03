<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyTube extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'code', 'data' => 'code'],
        ['name' => 'rate', 'data' => 'rate'],
        ['name' => 'action', 'data' => 'action'],
    ];

    function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }
}
