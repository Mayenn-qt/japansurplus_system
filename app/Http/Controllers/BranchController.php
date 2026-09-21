<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Sale;
use Carbon\Carbon;

class BranchController extends Controller
{
    public function branch()
    {
        $branches = Branch::with(['users' => function ($query) {
            $query->where('role', 'staff')->orderBy('name');
        }])->withSum('sales', 'total_amount')->orderBy('branch_name')->get();

        return view('owner.branch', compact('branches'));
    }

    public function operations(Branch $branch)
    {
        $now = Carbon::now();
        $salesQuery = Sale::where('branch_id', $branch->id);

        $todaysSales = (clone $salesQuery)
            ->whereDate('created_at', $now->toDateString())
            ->sum('total_amount');
        $thisWeeksSales = (clone $salesQuery)
            ->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])
            ->sum('total_amount');
        $thisMonthsSales = (clone $salesQuery)
            ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->sum('total_amount');

        $recentSales = (clone $salesQuery)
            ->with(['items.product', 'user'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $branch->load(['users' => function ($query) {
            $query->where('role', 'staff')->orderBy('name');
        }]);

        return view('owner.branch_operations', compact(
            'branch',
            'todaysSales',
            'thisWeeksSales',
            'thisMonthsSales',
            'recentSales'
        ));
    }
}
