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
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
        ]);
        $user = Auth::user();
        
        // Kunin ang branch_id ng naka-login na staff
        $branchId = $user->branch_id ?? null;

        $query = Product::with(['category', 'inventories' => function($q) use ($branchId) {
            if ($branchId) {
                $q->where('branch_id', $branchId);
            }
        }]);

        // Search by product name, SKU, or location.
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            if ($search !== '') {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }
        }

        // Category filter galing sa database
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Gamitin ang subquery o branch filter direkta sa inventories para sigurado
        if ($branchId) {
            $query->whereHas('inventories', function($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                ->where('current_stock', '>', 0);
            });
        }

        $products = $query->orderBy('sku', 'asc')->paginate(12)->appends($request->query());
        $categories = Category::all();

        return view('staff.sales.pos', compact('products', 'categories', 'user'));
    }
}