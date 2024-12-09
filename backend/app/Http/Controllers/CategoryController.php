<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showAllCategory()
    {
        $category = Category::all();
        return response()->json($category, 200);
    }
    public function addCategory(Request $request)
    {
        try {
            $validator = $request->validate([
                'category_name' => 'required',
                'category_description' => 'required'
            ]);

            $category = Category::create([
                'category_name' => $request->category_name,
                'category_description' => $request->category_description
            ]);

            // Return the created supplier or a success message
            return response()->json(['success' => true, 'category' => $category], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function updatecategory(Request $request, $id)
    {
        try {
            $validator = $request->validate([
                'name' => 'required',
                'description' => 'required'

            ]);
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['message' => 'category not found'], 404);
            }

            $category->update([
                'category_name' => $request->name,
                'category_description' => $request->description

            ]);

            // Return the created supplier or a success message
            return response()->json(['success' => true, 'category' => $category], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function deleteCategory($id)
    {
        $category = Category::find($id);

        // Check if the customer exists
        if ($category) {
            $category->delete(); // Delete the category
            return response()->json(['message' => 'category deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'category not found.'], 404);
        }
    }
}
