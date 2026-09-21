<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Branch;

class InventoryController extends Controller
{
    public function inventoryReport()
    {
        $inventory = Inventory::with(['product.category', 'branch'])
            ->whereHas('product')
            ->where('current_stock', '<=', 5)
            ->latest()
            ->get();

        return view('owner.reports.inventory', [
            'totalProducts' => Product::count(),
            'inStockItems' => Inventory::where('current_stock', '>', 0)->count(),
            'lowStockItems' => Inventory::where('current_stock', '>', 0)->where('current_stock', '<=', 5)->count(),
            'outOfStockItems' => Inventory::where('current_stock', '<=', 0)->count(),
            'inventory' => $inventory,
        ]);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $userBranchId = $user->branch_id;

        $query = Inventory::with(['product', 'branch'])
            ->whereHas('product');

        if ($userBranchId) {
            $query->where('branch_id', $userBranchId);
        }

        if ($request->filled('search')) {
            $search = trim($request->string('search')->toString());
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if (!$userBranchId && $request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('stock_level')) {
            match ($request->stock_level) {
                'in' => $query->where('current_stock', '>', 5),
                'low' => $query->where('current_stock', '>', 0)
                    ->where('current_stock', '<=', 5),
                'out' => $query->where('current_stock', '<=', 0),
                default => null,
            };
        }

        $sortDirection = $request->input('sort') === 'oldest' ? 'asc' : 'desc';
        $stocks = $query
            ->join('products', 'inventories.product_id', '=', 'products.id')
            ->select('inventories.*')
            ->orderBy('products.created_at', $sortDirection)
            ->orderBy('inventories.id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $baseCountQuery = Inventory::whereHas('product');
        if ($userBranchId) {
            $baseCountQuery->where('branch_id', $userBranchId);
        }

        $totalItems = (clone $baseCountQuery)->sum('current_stock');
        $lowStockCount = (clone $baseCountQuery)
            ->where('current_stock', '>', 0)
            ->where('current_stock', '<=', 5)
            ->count();
        $outOfStockCount = (clone $baseCountQuery)
            ->where('current_stock', '<=', 0)
            ->count();

        $branches = $userBranchId
            ? Branch::whereKey($userBranchId)->get()
            : Branch::orderBy('branch_name')->get();

        $productsQuery = Product::query()
            ->whereHas('inventories', function ($q) use ($userBranchId) {
                if ($userBranchId) {
                    $q->where('branch_id', $userBranchId);
                }
            })
            ->orderBy('name');
        $products = $productsQuery->get();
        $activities = collect();

        return view('staff.inventory.index', compact(
            'stocks',
            'activities',
            'totalItems',
            'lowStockCount',
            'outOfStockCount',
            'branches',
            'products'
        ));
    }

    public function lowStock(Request $request)
    {
        $request->merge(['stock_level' => 'low']);

        return $this->index($request);
    }
}