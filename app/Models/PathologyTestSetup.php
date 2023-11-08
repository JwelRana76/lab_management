<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyTestSetup extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'category', 'data' => 'category'],
        ['name' => 'test', 'data' => 'test'],
        ['name' => 'result_name', 'data' => 'result_name'],
        ['name' => 'normal_value', 'data' => 'normal_value'],
        ['name' => 'action', 'data' => 'action'],
    ];

    function test()
    {
        return $this->belongsTo(PathologyTest::class, 'test_id', 'id');
    }
    function resutlName()
    {
        return $this->hasMany(PathologyTestSetupResult::class, 'pathology_test_setup_id', 'id');
    }
}
