<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyPatientReportValue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function result()
    {
        return $this->belongsTo(PathologyResultName::class, 'result_id', 'id');
    }
}
