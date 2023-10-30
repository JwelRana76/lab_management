<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'contact', 'data' => 'contact'],
        ['name' => 'gender', 'data' => 'gender'],
        ['name' => 'action', 'data' => 'action'],
    ];
}
