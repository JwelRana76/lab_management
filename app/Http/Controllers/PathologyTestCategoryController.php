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
    function categorystore(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string',
            'category_code' => 'required|string|unique:patholoty_test_categories',
        ]);

        // Create a new category using the validated data
        $category = PathologyTestCategory::create([
            'name' => $validatedData['category_name'],
            'code' => $validatedData['category_code'],
        ]);
        return redirect()->route('test.index')->with('success', 'Pathology Test Category Created Successfully');
    }
    function edit($id)
    {
        return PathologyTestCategory::findOrFail($id);
    }
    function update(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string',
            'category_code' => 'required|string',
        ]);

        PathologyTestCategory::findOrFail($request->category_id)->update([
            'name' => $validatedData['category_name'],
            'code' => $validatedData['category_code'],
        ]);
        return redirect()->route('test.index')->with('success', 'Pathology Test Category Updated Successfully');
    }
    function delete($id)
    {
        PathologyTestCategory::findOrFail($id)->delete();
        return redirect()->route('test.index')->with('success', 'Pathology Test Category Deleted Successfully');
    }
}
