<?php
namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // Handle search and filtering
        $query = Stock::with('product');

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
            if ($request->stock_level == 'low') {
                $query->whereColumn('quantity', '<=', 'minimum_threshold');
            } elseif ($request->stock_level == 'out') {
                $query->where('quantity', 0);
            }
        }

        $stocks = $query->paginate(10)->withQueryString();
        $activities = StockLog::latest()->take(10)->get();

        // Pass data to your Blade view (change 'stocks.index' to your view's path)
        return view('stocks.index', compact('stocks', 'activities'));
    }

    public function storeStockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'reference_no' => 'nullable|string',
        ]);

        // Find or create stock for this product in the branch
        $stock = Stock::firstOrCreate(
            [
                'product_id' => $request->product_id, 
                'branch' => $request->branch
            ],
            ['quantity' => 0]
        );

        $stock->increment('quantity', $request->quantity);

        // Log the activity
        StockLog::create([
            'product_id' => $request->product_id,
            'branch' => $request->branch,
            'type' => 'IN',
            'quantity' => $request->quantity,
            'reference_no' => $request->reference_no,
            'processed_by' => auth()->user()->name ?? 'Admin',
        ]);

        return back()->with('success', 'Stock added successfully!');
    }

    public function storeStockOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'reference_no' => 'nullable|string',
        ]);

        $stock = Stock::where('product_id', $request->product_id)
                      ->where('branch', $request->branch)
                      ->first();

        if (!$stock || $stock->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available for this transaction.');
        }

        $stock->decrement('quantity', $request->quantity);

        StockLog::create([
            'product_id' => $request->product_id,
            'branch' => $request->branch,
            'type' => 'OUT',
            'quantity' => $request->quantity,
            'reference_no' => $request->reference_no,
            'processed_by' => auth()->user()->name ?? 'Admin',
        ]);

        return back()->with('success', 'Stock deducted successfully!');
    }
}