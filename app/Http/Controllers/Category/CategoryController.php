<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all active categories (system-wide, not user-specific)
        $categories = Category::active()->paginate(15);

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        // Show category details with medications
        $category->load('medications');
        
        return view('categories.show', compact('category'));
    }

    /**
     * Display the specified category for editing (read-only for users).
     * This method is kept for compatibility but redirects to show.
     */
    public function edit(Category $category)
    {
        // Redirect to show view since categories are system-defined
        return redirect()->route('categories.show', $category)
            ->with('info', 'Les catégories sont prédéfinies par le système et ne peuvent pas être modifiées.');
    }

    /**
     * Update method disabled - categories are system-defined
     */
    public function update(Request $request, Category $category)
    {
        return redirect()->route('categories.index')
            ->with('error', 'Les catégories sont prédéfinies par le système et ne peuvent pas être modifiées.');
    }

    /**
     * Destroy method disabled - categories are system-defined
     */
    public function destroy(Category $category)
    {
        return redirect()->route('categories.index')
            ->with('error', 'Les catégories sont prédéfinies par le système et ne peuvent pas être supprimées.');
    }

    /**
     * Store method disabled - categories are system-defined
     */
    public function store(Request $request)
    {
        return redirect()->route('categories.index')
            ->with('error', 'Les catégories sont prédéfinies par le système et ne peuvent pas être créées.');
    }
}
