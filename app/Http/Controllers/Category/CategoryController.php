<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = Category::whereRelation('pharmacy', 'user_id', auth()->user()->id)->paginate(PAGINATE);

        return view('categories.index', compact('categories'));
    }
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('categories')->where('pharmacy_id', auth()->user()->pharmacy->id),
            ],

        ]);

        // Create a new category
        Category::create([
            'name' => $request->name,
            'pharmacy_id' => auth()->user()->pharmacy->id, // Assuming the user has a pharmacy
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
