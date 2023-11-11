<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyReportChecker extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'degree', 'data' => 'degree'],
        ['name' => 'designation', 'data' => 'designation'],
        ['name' => 'institute', 'data' => 'institute'],
        ['name' => 'address', 'data' => 'address'],
    ];
}
