<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category') && $request->category != 'All Categories') {
            $query->where('category', $request->category);
        }

        if ($request->filled('branch') && $request->branch != 'All Branches') {
            $query->where('branch', $request->branch);
        }

        if ($request->filled('status') && $request->status != 'All Status') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(6)->withQueryString();
        $totalProducts = Product::count();

        return view('owner.product', compact('products', 'totalProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'category' => 'required|string',
            'branch' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'category' => $request->category,
            'branch' => $request->branch,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->stock > 0 ? 'In Stock' : 'Out of Stock',
        ]);

        return redirect()->route('owner.product')->with('success', 'Matagumpay na naidagdag ang produkto!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category' => 'required|string',
            'branch' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'category' => $request->category,
            'branch' => $request->branch,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->stock > 0 ? 'In Stock' : 'Out of Stock',
        ]);

        return redirect()->route('owner.product')->with('success', 'Matagumpay na na-update ang produkto!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('owner.product')->with('success', 'Matagumpay na nabura ang produkto!');
    }
}