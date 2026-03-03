<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function home(Request $request)
    {
        $query = Product::with('category');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by product name
        if ($request->filled('search')) {
            $query->where('productName', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }


    public function createProduct()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'productName' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'warranty' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',  // validate category exists
        ]);

        // Insert into database using query builder
        DB::table('products')->insert([
            'productName' => $validated['productName'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'warranty' => $validated['warranty'],
            'description' => $validated['description'],
            'created_at' => now(),
            'updated_at' => now(),
            'category_id' => $request->category_id,
        ]);

        // Redirect or return message
        return redirect('/')->with('success', 'Product added successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.show', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'productName' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'warranty' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        // Update all fields including category_id
        $product->update([
            'productName' => $validated['productName'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'warranty' => $validated['warranty'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
