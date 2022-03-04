<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Routing\Controller;
use App\Http\Requests\Category\AddCategoryFormRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::get());
    }

    public function store(AddCategoryFormRequest $request)
    {
        try {

            $data = $request->getData();
            $category = Category::create($data);

            return response()->json($category, 201);
        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Category $category)
    {
        try {

            $category_count = Category::where('parent_id', $category->id)->get()->count();

            if ($category_count > 0) {
                return response()->json(['message' => 'Cannot delete category with subcategories'], 422);
            }

            $category->delete();

            return response()->json(null, 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
