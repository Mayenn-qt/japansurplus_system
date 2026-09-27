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
            ->where('current_stock', 0)
            ->latest()
            ->get();

        return view('owner.reports.inventory', [
            'totalProducts' => Product::count(),
            'inStockItems' => Inventory::sum('current_stock'),
            'outOfStockItems' => Inventory::where('current_stock', 0)->count(),
            'totalInventoryRecords' => Inventory::count(),
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
                'in_stock' => $query->where('current_stock', '>', 0),
                'out_of_stock' => $query->where('current_stock', 0),
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

        $unitsInStock = (clone $baseCountQuery)->sum('current_stock');
        $soldOutCount = (clone $baseCountQuery)->where('current_stock', 0)->count();
        $trackedProducts = (clone $baseCountQuery)->count();

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
            'unitsInStock',
            'soldOutCount',
            'trackedProducts',
            'branches',
            'products'
        ));
    }

    public function outOfStock(Request $request)
    {
        $request->merge(['stock_level' => 'out_of_stock']);

        return $this->index($request);
    }

    public function updateStock(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'current_stock' => 'required|integer|min:0',
        ]);

        $user = $request->user();
        if ($user->role === 'staff' && (int) $user->branch_id !== (int) $inventory->branch_id) {
            abort(403);
        }

        $inventory->update($validated);

        return back()->with('success', 'Stock quantity updated.');
    }
}