<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Kunin ang branch_id ng naka-login na staff
        $branchId = $user->branch_id ?? null;

        $query = Product::with(['category', 'inventories' => function($q) use ($branchId) {
            if ($branchId) {
                $q->where('branch_id', $branchId);
            }
        }]);

        // Search filter para sa pangalan o SKU ng produkto
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Category filter galing sa database
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Gamitin ang subquery o branch filter direkta sa inventories para sigurado
        if ($branchId) {
            $query->whereHas('inventories', function($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->where('current_stock', '>', 0); // Opsyonal: kung gusto mong itago ang out-of-stock
            });
        }

        $products = $query->orderBy('sku', 'asc')->paginate(12)->appends($request->query());
        $categories = Category::all();

        return view('staff.sales.pos', compact('products', 'categories', 'user'));
    }
}