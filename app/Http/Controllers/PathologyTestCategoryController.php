<?php

namespace App\Http\Controllers;

use App\Models\PathologyTestCategory;
use App\Service\PathologyTestService;
use Illuminate\Http\Request;

class PathologyTestCategoryController extends Controller
{
    public function __construct()
    {
        $this->baseService = new PathologyTestService;
    }

    function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string',
            'category_code' => 'required|string',
        ]);

        // Create a new category using the validated data
        $category = PathologyTestCategory::create([
            'name' => $validatedData['category_name'],
            'code' => $validatedData['category_code'],
        ]);
        $categories = PathologyTestCategory::all();
        return $categories;
    }
}
