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
        $query = Product::with(['category', 'inventories', 'images']);

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

        $branchId = $request->filled('branch_id') ? $request->branch_id : null;

        if ($branchId) {
            $query->whereHas('inventories', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });

            $query->withSum(['inventories as total_stock' => function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            }], 'current_stock');
        } else {
            $query->withSum('inventories as total_stock', 'current_stock');
        }

        $products = $query->oldest()->paginate(10)->appends($request->query());
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

        $sortDirection = $request->input('sort') === 'oldest' ? 'asc' : 'desc';
        $stocks = $query
            ->join('products', 'inventories.product_id', '=', 'products.id')
            ->select('inventories.*')
            ->orderBy('products.created_at', $sortDirection)
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

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status == 'in_stock') {
                $query->where('current_stock', '>', 5);
            } elseif ($status == 'low_stock') {
                $query->where('current_stock', '>', 0)->where('current_stock', '<=', 5);
            } elseif ($status == 'out_of_stock') {
                $query->where('current_stock', '<=', 0);
            }
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
        'stock_main' => 'required|integer|min:0',
        'stock_juban' => 'required|integer|min:0',
        'stock_magallanes' => 'required|integer|min:0',
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

        // 3. I-save ang Product (Siguraduhing 'image' lang ang kasama sa fillable, huwag ang stock_main/etc. kung wala sa products table)
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


        // 4. I-save ang stocks sa Inventory table para lumabas sa search, filters, at branches
        // Branch IDs: 1 = Main, 2 = Juban, 3 = Masbate.
        $branchesData = [
            1 => $request->stock_main,       // Main Branch ID
            2 => $request->stock_juban,      // Juban Branch ID
            3 => $request->stock_magallanes, // Masbate Branch ID
        ];

        foreach ($branchesData as $branchId => $stockValue) {
            if ($stockValue !== null) {
                Inventory::create([
                    'product_id' => $product->id,
                    'branch_id' => $branchId,
                    'current_stock' => $stockValue,
                ]);
            }
        }

        DB::commit();

        return redirect()->route('owner.product')->with('success', 'Product added successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Error saving product: ' . $e->getMessage()])->withInput();
    }
}
    public function storeStockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch_id' => 'required|exists:branches,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $inventory = Inventory::firstOrCreate(
                [
                    'product_id' => $request->product_id,
                    'branch_id' => $request->branch_id,
                ],
                ['current_stock' => 0]
            );

            $inventory->increment('current_stock', $request->quantity);

            DB::commit();

            return redirect()->back()->with('success', 'Stock added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error in stock-in: ' . $e->getMessage()])->withInput();
        }
    }

    public function storeStockOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch_id' => 'required|exists:branches,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $inventory = Inventory::where('product_id', $request->product_id)
                                    ->where('branch_id', $request->branch_id)
                                    ->first();

            if (!$inventory || $inventory->current_stock < $request->quantity) {
                return redirect()->back()->withErrors(['error' => 'Insufficient stock for this branch!'])->withInput();
            }

            $inventory->decrement('current_stock', $request->quantity);

            DB::commit();

            return redirect()->back()->with('success', 'Stock deducted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error in stock-out: ' . $e->getMessage()])->withInput();
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
            'stock_main' => 'required|integer|min:0',
            'stock_juban' => 'required|integer|min:0',
            'stock_magallanes' => 'required|integer|min:0',
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

            foreach ([
                1 => $request->stock_main,
                2 => $request->stock_juban,
                3 => $request->stock_magallanes,
            ] as $branchId => $stock) {
                Inventory::updateOrCreate(
                    ['product_id' => $product->id, 'branch_id' => $branchId],
                    ['current_stock' => $stock]
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