<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Inventory;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        if ($user->role == 'owner') {
            $now = Carbon::now();
            $sales = Sale::query();

            $todaySales = (clone $sales)
                ->whereDate('created_at', $now->toDateString())
                ->sum('total_amount');
            $weekSales = (clone $sales)
                ->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])
                ->sum('total_amount');
            $monthSales = (clone $sales)
                ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
                ->sum('total_amount');
            $yearSales = (clone $sales)
                ->whereBetween('created_at', [$now->copy()->startOfYear(), $now->copy()->endOfYear()])
                ->sum('total_amount');

            $totalProducts = Product::count();
            $totalCustomers = Customer::count();
            $recentSales = Sale::with(['items.product', 'user'])
                ->latest()
                ->take(10)
                ->get();

            return view('owner.dashboard', compact(
                'user',
                'todaySales',
                'weekSales',
                'monthSales',
                'yearSales',
                'totalProducts',
                'totalCustomers',
                'recentSales'
            ));
        }

        
        $unitsInStock = Inventory::where('branch_id', $user->branch_id)
            ->sum('current_stock');
        $soldOutItems = Inventory::with('product')
            ->where('branch_id', $user->branch_id)
            ->where('current_stock', 0)
            ->latest()
            ->take(5)
            ->get();

        return view('staff.dashboard', compact('user', 'unitsInStock', 'soldOutItems'));
    }

    public function globalSearch(Request $request)
    {
        $search = trim((string) $request->input('search'));

        if ($search === '') {
            return redirect()->route('owner.dashboard');
        }

        $term = strtolower($search);

        if (preg_match('/\b(users?|staff|admin|administrator|account)\b/', $term)) {
            return redirect()->route('owner.user');
        }

        if (User::where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('role', 'like', "%{$search}%")
            ->exists()) {
            return redirect()->route('owner.user', ['search' => $search]);
        }

        if (Product::where('name', 'like', "%{$search}%")
            ->orWhere('sku', 'like', "%{$search}%")
            ->exists()) {
            return redirect()->route('owner.product', ['search' => $search]);
        }

        if (Customer::where('name', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->exists()) {
            return redirect()->route('owner.customers', ['search' => $search]);
        }

        if (Branch::where('branch_name', 'like', "%{$search}%")->exists()) {
            return redirect()->route('owner.branch');
        }

        if (preg_match('/\b(inventory|stock|stocks)\b/', $term)) {
            return redirect()->route('owner.stock');
        }

        if (preg_match('/\b(sales?|transactions?|reports?)\b/', $term)) {
            return redirect()->route('owner.reports.sales');
        }

        return redirect()->route('owner.product', ['search' => $search]);
    }
}