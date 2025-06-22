<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of active categories.
     */
    public function index()
    {
        $categories = Category::active()
            ->withCount('medications')
            ->orderBy('name')
            ->get();

        return response()->json([
            'categories' => CategoryResource::collection($categories)
        ]);
    }

    /**
     * Display the specified category with its medications.
     */
    public function show(Category $category)
    {
        if (!$category->is_active) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $category->load(['medications' => function ($query) {
            $query->where('quantity', '>', 0);
        }]);

        return response()->json([
            'category' => new CategoryResource($category)
        ]);
    }

    /**
     * Get categories with medications count for a specific pharmacy.
     */
    public function pharmacyCategories($pharmacyId)
    {
        $categories = Category::active()
            ->withCount(['medications' => function ($query) use ($pharmacyId) {
                $query->where('pharmacy_id', $pharmacyId)
                      ->where('quantity', '>', 0);
            }])
            ->orderBy('name')
            ->get();

        return response()->json([
            'categories' => CategoryResource::collection($categories)
        ]);
    }
} 