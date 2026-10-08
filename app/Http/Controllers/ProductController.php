<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Branch;
use App\Models\Inventory;
use App\Models\SaleItem;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Kinukuha natin ang total stock ng product sa lahat ng branches (o base sa napiling branch)
        $validated = $request->validate([
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
        ]);
        $branchId = $validated['branch_id'] ?? null;

        $query = Product::with(['category', 'inventories', 'images'])
            ->addSelect([
                'last_sold_at' => SaleItem::query()
                    ->select('sales.created_at')
                    ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
                    ->whereColumn('sale_items.product_id', 'products.id')
                    ->orderByDesc('sales.created_at')
                    ->orderByDesc('sale_items.id')
                    ->limit(1),
            ])
            // Idinaragdag natin ito para ma-compute ang total stock ng product
            ->withSum(['inventories' => function($q) use ($branchId) {
                if ($branchId) {
                    $q->where('branch_id', $branchId);
                }
            }], 'current_stock');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($branchId) {
            $query->whereHas('inventories', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        // Pagsasaayos ng pag-sort: Mauuna ang may stock (> 0), at mapupunta sa dulo ang sold out (0 stock)
        if ($branchId !== null) {
            $query->orderByRaw(
                '(SELECT COALESCE(SUM(current_stock), 0) FROM inventories WHERE inventories.product_id = products.id AND branch_id = ?) DESC',
                [$branchId]
            );
        } else {
            $query->orderByRaw(
                '(SELECT COALESCE(SUM(current_stock), 0) FROM inventories WHERE inventories.product_id = products.id) DESC'
            );
        }

        $products = $query
            ->latest('created_at')
            ->paginate(10)
            ->appends($request->query());

        $categories = Category::all();
        $branches = Branch::all();

        return view('owner.product', compact('products', 'user', 'categories', 'branches'));
    }

    public function stockManagement(Request $request)
    {
        $user = Auth::user();
        $branchId = $request->input('branch_id', 1);
        $query = Inventory::with(['product.category', 'product.images', 'branch'])
                          ->whereHas('product');

        if ($branchId !== '') {
            $query->where('branch_id', $branchId);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->filled('condition')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->where('condition', $request->condition);
            });
        }

        $stocks = $query
            ->join('products', 'inventories.product_id', '=', 'products.id')
            ->select('inventories.*')
            ->orderBy('products.created_at', 'desc')
            ->orderBy('inventories.id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();
        $branches = Branch::orderBy('branch_name')->get();
        $conditions = Product::whereNotNull('condition')
            ->where('condition', '!=', '')
            ->select('condition')
            ->distinct()
            ->orderBy('condition')
            ->pluck('condition');
        $totalProductsQuery = Product::whereHas('inventories');
        if ($branchId !== '') {
            $totalProductsQuery->whereHas('inventories', function ($inventoryQuery) use ($branchId) {
                $inventoryQuery->where('branch_id', $branchId);
            });
        }
        $totalProducts = $totalProductsQuery->count();

        return view('owner.stock', compact('stocks', 'user', 'categories', 'branches', 'conditions', 'totalProducts'));
    }

    public function allStocks(Request $request)
    {
        $user = Auth::user();
        $query = Inventory::with(['product.category', 'branch'])
                          ->whereHas('product');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('stock_level')) {
            match ($request->stock_level) {
                'in_stock' => $query->where('current_stock', '>', 0),
                'out_of_stock' => $query->where('current_stock', 0),
                default => null,
            };
        }

        $stocks = $query->orderBy('branch_id')->latest()->paginate(15)->appends($request->query());
        $branches = Branch::all();

        return view('owner.stock_all', compact('stocks', 'user', 'branches'));
    }

    public function store(Request $request)
{
    // 1. Validate ang mga input
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'supplier_price' => 'required|numeric|min:0',
        'sale_price' => 'required|numeric|min:0',
        'condition' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'remarks' => 'nullable|string',
        'stock' => 'required|array',
        'stock.*' => 'required|integer|min:0',
        'images' => 'nullable|array|max:10',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    try {
        DB::beginTransaction();

        $imageName = null;
        $uploadedImages = $request->file('images', []);
        if ($uploadedImages) {
            $imageName = Str::uuid() . '.' . $uploadedImages[0]->getClientOriginalExtension();
            $uploadedImages[0]->move(public_path('images/products'), $imageName);
        }

        $product = Product::create([
            'name' => $request->name,
            'sku' => 'PRD-' . Str::upper(Str::random(10)),
            'category_id' => $request->category_id,
            'price' => $request->sale_price,
            'supplier_price' => $request->supplier_price,
            'sale_price' => $request->sale_price,
            'image' => $imageName,
            'condition' => $request->condition,
            'location' => $request->location,
            'remarks' => $request->remarks,
        ]);

        foreach ($uploadedImages as $index => $image) {
            if ($index === 0) {
                continue;
            }

            $additionalImageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $additionalImageName);
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $additionalImageName,
            ]);
        }


        foreach ($request->input('stock', []) as $branchId => $currentStock) {
            Inventory::create([
                'product_id' => $product->id,
                'branch_id' => $branchId,
                'current_stock' => $currentStock,
            ]);
        }

        DB::commit();

        return redirect()->route('owner.product')->with('success', 'Product added successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Error saving product: ' . $e->getMessage()])->withInput();
    }
}
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'supplier_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'condition' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'stock' => 'required|array',
            'stock.*' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $imageName = $product->image;
            if ($request->hasFile('image')) {
                if ($imageName && file_exists(public_path('images/products/' . $imageName))) {
                    @unlink(public_path('images/products/' . $imageName));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $imageName);
            }

            foreach ($request->file('images', []) as $image) {
                $additionalImageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/products'), $additionalImageName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $additionalImageName,
                ]);
            }

            // Product details lang ang iu-update
            $product->update([
                'name' => $request->name,
                'sku' => $request->sku,
                'category_id' => $request->category_id,
                'price' => $request->sale_price,
                'supplier_price' => $request->supplier_price,
                'sale_price' => $request->sale_price,
                'image' => $imageName,
                'condition' => $request->condition,
                'location' => $request->location,
                'remarks' => $request->remarks,
            ]);

            foreach ($request->input('stock', []) as $branchId => $currentStock) {
                Inventory::updateOrCreate(
                    ['product_id' => $product->id, 'branch_id' => $branchId],
                    ['current_stock' => $currentStock]
                );
            }

            DB::commit();

            return redirect()->back()->with('success', 'Product details updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'May nangyaring mali sa pag-update: ' . $e->getMessage()])->withInput();
        }
    }
}