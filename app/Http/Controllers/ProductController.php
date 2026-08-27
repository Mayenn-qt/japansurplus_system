<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Branch;
use App\Models\Inventory;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Product::with(['category', 'inventories']);

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
            $query->whereHas('inventories', function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });

            $query->withSum(['inventories as total_stock' => function($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            }], 'current_stock');
        } else {
            $query->withSum('inventories as total_stock', 'current_stock');
        }

        if ($request->filled('status')) {
            $status = $request->status;

            if ($status == 'in_stock') {
                $query->where(function ($subQuery) use ($branchId) {
                    $subQuery->select(DB::raw('COALESCE(SUM(current_stock), 0)'))
                             ->from('inventories')
                             ->whereColumn('inventories.product_id', 'products.id');
                    
                    if ($branchId) {
                        $subQuery->where('branch_id', $branchId);
                    }
                }, '>', 5);

            } elseif ($status == 'low_stock') {
                $query->where(function ($subQuery) use ($branchId) {
                    $subQuery->select(DB::raw('COALESCE(SUM(current_stock), 0)'))
                             ->from('inventories')
                             ->whereColumn('inventories.product_id', 'products.id');
                           
                    if ($branchId) {
                        $subQuery->where('branch_id', $branchId);
                    }
                }, '>', 0)
                ->where(function ($subQuery) use ($branchId) {
                    $subQuery->select(DB::raw('COALESCE(SUM(current_stock), 0)'))
                             ->from('inventories')
                             ->whereColumn('inventories.product_id', 'products.id');
                           
                    if ($branchId) {
                        $subQuery->where('branch_id', $branchId);
                    }
                }, '<=', 5);

            } elseif ($status == 'out_of_stock') {
                $query->where(function ($subQuery) use ($branchId) {
                    $subQuery->select(DB::raw('COALESCE(SUM(current_stock), 0)'))
                             ->from('inventories')
                             ->whereColumn('inventories.product_id', 'products.id');
                           
                    if ($branchId) {
                        $subQuery->where('branch_id', $branchId);
                    }
                }, '<=', 0);
            }
        }

        $products = $query->oldest()->paginate(10)->appends($request->query());
        $categories = Category::all();
        $branches = Branch::all();

        return view('owner.product', compact('products', 'user', 'categories', 'branches'));
    }

    public function stockManagement(Request $request)
    {
        $user = Auth::user();
        $query = Inventory::with(['product', 'branch']);

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

        $stocks = $query->orderBy('branch_id')->latest()->take(10)->get();
        
        $allInventories = Inventory::all();
        $totalItems = $allInventories->sum('current_stock');
        $lowStockCount = $allInventories->where('current_stock', '>', 0)->where('current_stock', '<=', 5)->count();
        $outOfStockCount = $allInventories->where('current_stock', '<=', 0)->count();

        $categories = Category::all();
        $branches = Branch::all();
        $activities = []; 

        return view('owner.stock', compact('stocks', 'activities', 'user', 'categories', 'branches', 'totalItems', 'lowStockCount', 'outOfStockCount'));
    }

    public function allStocks(Request $request)
    {
        $user = Auth::user();
        $query = Inventory::with(['product', 'branch']);

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
        'sku' => 'required|string|max:255|unique:products,sku',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric',
        'stock_main' => 'required|integer|min:0',
        'stock_juban' => 'required|integer|min:0',
        'stock_magallanes' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        DB::beginTransaction();

        $imageName = null;
        // 2. Handle ang image upload kung meron
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
        }

        // 3. I-save ang Product (Siguraduhing 'image' lang ang kasama sa fillable, huwag ang stock_main/etc. kung wala sa products table)
        $product = Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'image' => $imageName,
        ]);

        // 4. I-save ang stocks sa Inventory table para lumabas sa search, filters, at branches
        // (Palitan mo ang branch_id kung magkaiba ang ID sa database mo, e.g. 1 = Main, 2 = Juban, 3 = Magallanes)
        $branchesData = [
            1 => $request->stock_main,       // Main Branch ID
            2 => $request->stock_juban,      // Juban Branch ID
            3 => $request->stock_magallanes, // Magallanes Branch ID
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
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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

            // Product details lang ang iu-update
            $product->update([
                'name' => $request->name,
                'sku' => $request->sku,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'image' => $imageName,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Product details updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'May nangyaring mali sa pag-update: ' . $e->getMessage()])->withInput();
        }
    }
}