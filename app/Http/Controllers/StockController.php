<?php
namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockLog;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // Kunin ang lahat ng valid at existing product IDs para salain ang orphaned records
        $validProductIds = Product::pluck('id');

        $query = Stock::with(['product'])
                    ->whereIn('product_id', $validProductIds);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('branch')) {
            $query->where('branch', $request->branch);
        }

        if ($request->filled('stock_level')) {
            $level = $request->stock_level;
            if ($level == 'low') {
                $query->where('quantity', '>', 0)
                      ->whereColumn('quantity', '<=', 'minimum_threshold');
            } elseif ($level == 'out') {
                $query->where('quantity', '<=', 0);
            } elseif ($level == 'in') {
                $query->whereColumn('quantity', '>', 'minimum_threshold');
            }
        }

        $stocks = $query->paginate(10)->withQueryString();

        // Salain din ang activities gamit ang valid product IDs
        $activities = StockLog::with('product')
                        ->whereIn('product_id', $validProductIds)
                        ->latest()
                        ->take(10)
                        ->get();

        // Mga counts para sa summary cards
        $totalItems = Stock::whereIn('product_id', $validProductIds)->count();

        $lowStockCount = Stock::whereIn('product_id', $validProductIds)
                            ->where('quantity', '>', 0)
                            ->whereColumn('quantity', '<=', 'minimum_threshold')
                            ->count();

        $outOfStockCount = Stock::whereIn('product_id', $validProductIds)
                            ->where('quantity', '<=', 0)
                            ->count();

        // Para sa Restock Checklist Modal
        $criticalStocks = Stock::with(['product'])
            ->whereIn('product_id', $validProductIds)
            ->whereColumn('quantity', '<=', 'minimum_threshold')
            ->get();

        $branchesList = Stock::whereIn('product_id', $validProductIds)
                   ->select('branch')
                   ->distinct()
                   ->pluck('branch');

        // I-pasa ang products at branches para sa modals
        $products = Product::all();
        $branches = Branch::all();

        return view('owner.stock.all', compact(
            'stocks', 'activities', 'totalItems',
            'lowStockCount', 'outOfStockCount', 'criticalStocks', 'branchesList', 'products', 'branches'
        ));
    }

    public function storeStockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch_id'  => 'required',
            'quantity'   => 'required|integer|min:1',
            'supplier'   => 'nullable|string',
            'reference_no' => 'nullable|string',
            'remarks'    => 'nullable|string',
        ]);

        // Kunin ang tamang pangalan ng branch kung ID ang ipinasa ng form
        $branchInput = $request->branch_id;
        $branchRecord = Branch::find($branchInput);
        $branchName = $branchRecord ? ($branchRecord->branch_name ?? $branchRecord->name) : $branchInput;

        $refNo = $request->supplier ?? $request->reference_no;

        $stock = Stock::firstOrCreate(
            [
                'product_id' => $request->product_id, 
                'branch'     => $branchName
            ],
            ['quantity' => 0, 'minimum_threshold' => 5]
        );

        $stock->increment('quantity', $request->quantity);

        StockLog::create([
            'product_id'   => $request->product_id,
            'branch'       => $branchName,
            'type'         => 'IN',
            'quantity'     => $request->quantity,
            'reference_no' => $refNo,
            'remarks'      => $request->remarks ?? null,
            'processed_by' => auth()->user()->name ?? 'Admin',
        ]);

        return back()->with('success', 'Stock added successfully and updated in UI!');
    }

    public function storeStockOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch_id'  => 'required',
            'quantity'   => 'required|integer|min:1',
            'reason'     => 'nullable|string',
            'reference_no' => 'nullable|string',
            'remarks'    => 'nullable|string',
        ]);

        $branchInput = $request->branch_id;
        $branchRecord = Branch::find($branchInput);
        $branchName = $branchRecord ? ($branchRecord->branch_name ?? $branchRecord->name) : $branchInput;

        $refNo = $request->reason ?? $request->reference_no;

        $validProductIds = Product::pluck('id');

        $stock = Stock::whereIn('product_id', $validProductIds)
                     ->where('product_id', $request->product_id)
                     ->where('branch', $branchName)
                     ->first();

        if (!$stock || $stock->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available for this transaction.');
        }

        $stock->decrement('quantity', $request->quantity);

        StockLog::create([
            'product_id'   => $request->product_id,
            'branch'       => $branchName,
            'type'         => 'OUT',
            'quantity'     => $request->quantity,
            'reference_no' => $refNo,
            'remarks'      => $request->remarks ?? null,
            'processed_by' => auth()->user()->name ?? 'Admin',
        ]);

        return back()->with('success', 'Stock deducted successfully and updated in UI!');
    }
}