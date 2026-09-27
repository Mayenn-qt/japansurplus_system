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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart_data' => 'required|json',
            'money_received' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'is_suki' => 'nullable|boolean',
        ]);

        $cart = json_decode($validated['cart_data'], true);
        if (!is_array($cart) || empty($cart)) {
            return back()->withErrors(['cart_data' => 'The cart is empty.']);
        }

        $normalizedCart = collect($cart)->map(function ($item) {
            if (!is_array($item)) {
                return null;
            }

            $productId = filter_var($item['id'] ?? null, FILTER_VALIDATE_INT);
            $quantity = filter_var($item['quantity'] ?? null, FILTER_VALIDATE_INT);
            if ($productId === false || $productId < 1 || $quantity === false || $quantity < 1 || $quantity > 999) {
                return null;
            }

            return [
                'id' => $productId,
                'quantity' => $quantity,
                'is_free' => filter_var($item['is_free'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ];
        });

        if ($normalizedCart->contains(null)) {
            return back()->withErrors(['cart_data' => 'The cart contains an invalid product quantity.']);
        }

        $cart = $normalizedCart
            ->groupBy(fn ($item) => $item['id'] . ':' . (int) $item['is_free'])
            ->map(function ($group) {
                $item = $group->first();
                $item['quantity'] = $group->sum('quantity');

                return $item;
            })
            ->values();

        $productIds = collect($cart)->pluck('id')->filter()->unique();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        if ($products->count() !== $productIds->count()) {
            return back()->withErrors(['cart_data' => 'One or more products no longer exist.']);
        }

        $branchId = Auth::user()->branch_id ?? null;

        $items = collect($cart)->map(function ($item) use ($products, $branchId) {
            $productId = (int) ($item['id'] ?? 0);
            $quantity = (int) ($item['quantity'] ?? 0);

            if ($quantity < 1 || !$products->has($productId)) {
                return null;
            }

            $isFree = filter_var($item['is_free'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $price = $isFree ? 0 : (float) $products[$productId]->price;
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

        $requestedQuantities = $items
            ->groupBy('product_id')
            ->map(fn ($productItems) => $productItems->sum('quantity'));

        $subtotal = $items->sum('total');
        $isSuki = $request->boolean('is_suki');
        $discount = (float) ($validated['discount'] ?? 0);
        if ($isSuki && $discount === 0.0) {
            $discount = $subtotal * 0.10;
        }
        $discount = min($discount, $subtotal);
        $totalAmount = $subtotal - $discount;
        $moneyReceived = (float) $validated['money_received'];
        
        if ($moneyReceived < $totalAmount) {
            return back()->withErrors(['money_received' => 'Insufficient cash amount provided.']);
        }

        $change = $moneyReceived - $totalAmount;

        try {
            $sale = DB::transaction(function () use ($items, $subtotal, $discount, $totalAmount, $moneyReceived, $change, $isSuki, $branchId, $productIds, $products, $requestedQuantities) {
                $inventories = collect();
                if ($branchId) {
                    $inventories = Inventory::whereIn('product_id', $productIds)
                        ->where('branch_id', $branchId)
                        ->lockForUpdate()
                        ->get()
                        ->keyBy('product_id');

                    foreach ($productIds as $productId) {
                        $inventory = $inventories->get($productId);
                        $requestedQuantity = $requestedQuantities->get($productId, 0);
                        if (!$inventory || $inventory->current_stock < $requestedQuantity) {
                            throw new \Exception("Insufficient stock for {$products[$productId]->name}. Current stock: " . ($inventory?->current_stock ?? 0));
                        }
                    }
                }

                $sale = Sale::create([
                    'user_id' => Auth::id(),
                    'branch_id' => $branchId,
                    'order_type' => 'walk-in',
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
                }

                foreach ($inventories as $productId => $inventory) {
                    $inventory->update([
                        'current_stock' => $inventory->current_stock - $requestedQuantities->get($productId, 0),
                    ]);
                }

                return $sale;
            });
        } catch (\Exception $e) {
            return back()->withErrors(['cart_data' => $e->getMessage()]);
        }

        return redirect()->route('staff.sales.pos', ['clear_cart' => 'true'])
            ->with('success', 'Sale completed successfully.');
    }
}