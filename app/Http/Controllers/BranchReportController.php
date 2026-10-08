<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchReportController extends Controller
{
    public function branchReport(Request $request)
    {
        $filters = $this->validateReportFilters($request);
        $branches = $this->filteredBranches($filters)
            ->orderByDesc('sales_sum_total_amount')
            ->orderBy('branch_name')
            ->get();
        $allBranches = Branch::orderBy('branch_name')->get();
        $topBranch = $branches->sortByDesc('sales_sum_total_amount')->first();

        return view('owner.reports.branchreport', compact('branches', 'allBranches', 'topBranch', 'filters'));
    }

    public function exportBranchReport(Request $request)
    {
        $filters = $this->validateReportFilters($request);

        return response()->streamDownload(function () use ($filters) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Branch', 'Address', 'Transactions', 'Revenue']);

            $this->filteredBranches($filters)
                ->orderBy('branch_name')
                ->chunk(250, function ($branches) use ($output) {
                    foreach ($branches as $branch) {
                        fputcsv($output, [
                            $branch->branch_name,
                            $branch->address,
                            $branch->sales_count,
                            $branch->sales_sum_total_amount ?? 0,
                        ]);
                    }
                });

            fclose($output);
        }, 'branch-report-' . now()->format('Ymd-His') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function validateReportFilters(Request $request): array
    {
        return $request->validate([
            'start_date' => ['nullable', 'date_format:Y-m-d', 'before_or_equal:today'],
            'end_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:start_date', 'before_or_equal:today'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
        ]);
    }

    private function filteredBranches(array $filters)
    {
        $salesFilter = function ($query) use ($filters) {
            if (!empty($filters['start_date'])) {
                $query->whereDate('created_at', '>=', $filters['start_date']);
            }
            if (!empty($filters['end_date'])) {
                $query->whereDate('created_at', '<=', $filters['end_date']);
            }
        };

        $query = Branch::withCount(['sales' => $salesFilter])
            ->withSum(['sales' => $salesFilter], 'total_amount');

        if (!empty($filters['branch_id'])) {
            $query->whereKey($filters['branch_id']);
        }

        return $query;
    }
}
