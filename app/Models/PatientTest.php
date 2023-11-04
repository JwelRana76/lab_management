<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function test()
    {
        return $this->belongsTo(PathologyTest::class);
    }
}
