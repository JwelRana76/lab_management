<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PathologyTest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static $columns = [
        ['name' => 'name', 'data' => 'name'],
        ['name' => 'code', 'data' => 'code'],
        ['name' => 'category', 'data' => 'category'],
        ['name' => 'rate', 'data' => 'rate'],
        ['name' => 'referral_persent', 'data' => 'referral_persent'],
        ['name' => 'referral_amount', 'data' => 'referral_amount'],
        ['name' => 'action', 'data' => 'action'],
    ];

    public function category()
    {
        return $this->belongsTo(PathologyTestCategory::class, 'pathology_test_category_id', 'id');
    }

    function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }
}
