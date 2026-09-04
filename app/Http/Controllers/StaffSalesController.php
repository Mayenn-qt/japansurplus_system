<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class StaffSalesController extends Controller
{
    public function sales(Request $request)
    {
        $user = Auth::user();
        
        // Kunin ang branch_id ng naka-login na staff
        $branchId = $user->branch_id ?? null;

        $query = Product::with(['category', 'inventories' => function($q) use ($branchId) {
            if ($branchId) {
                $q->where('branch_id', $branchId);
            }
        }]);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('sku', 'asc')->paginate(12)->appends($request->query());
        $categories = Category::all();

        return view('staff.sales.pos', compact('products', 'categories', 'user'));
    }

    public function cart()
    {
        return view('staff.sales.cart');
    }

    public function checkout(Request $request)
    {
        return view('staff.sales.checkout');
    }

    public function history(Request $request)
    {
        $user = Auth::user();
        $branchId = $user->branch_id ?? null;

        $query = Sale::with(['items.product', 'user'])
            ->orderBy('created_at', 'desc');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $sales = $query->paginate(10);

        return view('staff.sales.history', compact('sales'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart_data' => 'required|json',
            'money_received' => 'required|numeric|min:0',
            'is_suki' => 'nullable|boolean',
            'order_type' => 'nullable|string|in:walk-in,pickup,delivery',
        ]);

        $cart = json_decode($validated['cart_data'], true);
        if (!is_array($cart) || empty($cart)) {
            return back()->withErrors(['cart_data' => 'The cart is empty.']);
        }

        $productIds = collect($cart)->pluck('id')->filter()->unique();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        if ($products->count() !== $productIds->count()) {
            return back()->withErrors(['cart_data' => 'One or more products are no longer available.']);
        }

        $branchId = Auth::user()->branch_id ?? null;

        $items = collect($cart)->map(function ($item) use ($products, $branchId) {
            $productId = (int) ($item['id'] ?? 0);
            $quantity = (int) ($item['quantity'] ?? 0);

            if ($quantity < 1 || !$products->has($productId)) {
                return null;
            }

            // I-check kung sapat ang stock bago ituloy ang checkout
            if ($branchId) {
                $inventory = Inventory::where('product_id', $productId)
                    ->where('branch_id', $branchId)
                    ->first();

                if (!$inventory || $inventory->current_stock < $quantity) {
                    throw new \Exception("Insufficient stock for product: " . $products[$productId]->name);
                }
            }

            $price = (float) $products[$productId]->price;
            return [
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $price * $quantity,
            ];
        })->filter()->values();

        if ($items->isEmpty()) {
            return back()->withErrors(['cart_data' => 'The cart contains no valid products.']);
        }

        $subtotal = $items->sum('total');
        $isSuki = $request->boolean('is_suki');
        $discount = $isSuki ? $subtotal * 0.10 : 0;
        $totalAmount = $subtotal - $discount;
        $moneyReceived = (float) $validated['money_received'];
        
        if ($moneyReceived < $totalAmount) {
            return back()->withErrors(['money_received' => 'Insufficient cash amount provided.']);
        }

        $change = $moneyReceived - $totalAmount;

        try {
            $sale = DB::transaction(function () use ($items, $subtotal, $discount, $totalAmount, $moneyReceived, $change, $isSuki, $request, $branchId) {
                $sale = Sale::create([
                    'user_id' => Auth::id(),
                    'branch_id' => $branchId,
                    'order_type' => $request->input('order_type', 'walk-in'),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'total_amount' => $totalAmount,
                    'money_received' => $moneyReceived,
                    'change' => $change,
                    'is_suki' => $isSuki,
                ]);

                // I-save ang sale items at bawasan ang stock sa inventory
                foreach ($items as $item) {
                    $sale->items()->create($item);

                    if ($branchId) {
                        $inventory = Inventory::where('product_id', $item['product_id'])
                            ->where('branch_id', $branchId)
                            ->first();

                        if ($inventory) {
                            $inventory->current_stock = max(0, $inventory->current_stock - $item['quantity']);
                            $inventory->save();
                        }
                    }
                }

                return $sale;
            });
        } catch (\Exception $e) {
            return back()->withErrors(['cart_data' => $e->getMessage()]);
        }

        return redirect()->route('staff.sales.history')
            ->with('success', 'Transaction #' . $sale->id . ' successfully recorded and stocks updated!');
    }
}