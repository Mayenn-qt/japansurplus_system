<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Branch;

class BranchReportController extends Controller
{
    public function branchReport()
    {
        $branches = Branch::withCount('sales')->withSum('sales', 'total_amount')->orderBy('branch_name')->get();
        $topBranch = $branches->sortByDesc('sales_sum_total_amount')->first();

        return view('owner.reports.branchreport', compact('branches', 'topBranch'));
    }
}
