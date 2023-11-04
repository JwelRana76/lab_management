<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTube extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function tube()
    {
        return $this->belongsTo(PathologyTube::class);
    }
}
