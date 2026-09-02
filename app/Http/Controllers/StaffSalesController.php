<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\SaleItem;

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
        // Validation para sa Suki discount, order type at Cash payment
        $validated = $request->validate([
            'money_received' => 'required|numeric|min:0',
            'is_suki' => 'nullable|boolean',
            'order_type' => 'nullable|string',
        ]);

        // Pansamantalang subtotal (Maaari mong baguhin depende sa iyong cart session implementation)
        $subtotal = 2650.00; 
        $isSuki = $request->has('is_suki') ? true : false;
        $discount = $isSuki ? $subtotal * 0.10 : 0;
        $totalAmount = $subtotal - $discount;
        $moneyReceived = $request->money_received;
        
        if ($moneyReceived < $totalAmount) {
            return back()->withErrors(['money_received' => 'Insufficient cash amount provided.']);
        }

        $change = $moneyReceived - $totalAmount;

        // Pag-save ng transaction sa database
        Sale::create([
            'user_id' => Auth::id(),
            'branch_id' => Auth::user()->branch_id ?? null,
            'order_type' => $request->order_type ?? 'walk-in',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total_amount' => $totalAmount,
            'money_received' => $moneyReceived,
            'change' => $change,
            'is_suki' => $isSuki,
        ]);

        // Pagkatapos ma-save, direktang dadalhin sa sales history page na may success message
        return redirect()->route('staff.sales.history')->with('success', 'Transaction successfully recorded!');
    }
}