<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
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

        
        return view('staff.dashboard', compact('user'));
    }
}