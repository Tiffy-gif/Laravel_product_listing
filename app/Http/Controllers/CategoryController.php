<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // get all categories

        return view('category.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'description'  => 'nullable|string',
        ]);
    
        Category::create([
            'categoryName' => $request->categoryName,
            'description'  => $request->description,
        ]);
    
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'description'  => 'nullable|string',
        ]);
    
        $category = Category::findOrFail($id);
        $category->categoryName = $request->categoryName;
        $category->description = $request->description;
        $category->save();
    
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    
        // Check if category has related products
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category because it has associated products.');
        }
    
        $category->delete();
    
        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully!');
    }    
}