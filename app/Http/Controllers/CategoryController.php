<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Validation\Rule; // pre validáciu

class CategoryController extends Controller
{
    /**
     * GET /api/categories
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json(['categories' => $categories], 200);
    }

    /**
     * POST /api/categories
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:64|unique:categories,name'
        ]); // validácia
        $category = Category::create($validated);

        return response()->json(['category' => $category], 201);
    }

    /**
     * GET /api/categories/{id}
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json(['category' => $category], 200);
    }

    /**
     * PUT/PATCH /api/categories/{id}
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:64',
                Rule::unique('categories')->ignore($category->id) //pri úprave musí byť možné ponechať pôvodný name
            ]
        ]); // validácia
        $category->update($validated);
        return response()->json(['category' => $category], 200);
    }

    /**
     * DELETE /api/categories/{id}
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted'], 200);
    }
}
