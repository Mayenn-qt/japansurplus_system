<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class SalesController extends Controller
{
    // ... iba pang methods tulad ng sales, cart, checkout, history ...
    public function salesReport(Request $request)
    {
        $filters = $this->validateReportFilters($request);
        $sales = $this->filteredSalesQuery($filters);
        $totalSales = (clone $sales)->sum('total_amount');
        $transactionCount = (clone $sales)->count();
        $unitsSold = SaleItem::query()
            ->whereHas('sale', fn (Builder $query) => $this->applySalesFilters($query, $filters))
            ->sum('quantity');
        $bestSellingProducts = SaleItem::with('product')
            ->whereHas('sale', fn (Builder $query) => $this->applySalesFilters($query, $filters))
            ->select('product_id')
            ->selectRaw('SUM(quantity) as quantity_sold, SUM(total) as revenue')
            ->groupBy('product_id')
            ->orderByDesc('quantity_sold')
            ->take(10)
            ->get();
        $recentSales = (clone $sales)
            ->with(['branch', 'user'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $trendEnd = isset($filters['end_date'])
            ? Carbon::parse($filters['end_date'])
            : Carbon::today();
        $trendStart = isset($filters['start_date'])
            ? Carbon::parse($filters['start_date'])
            : $trendEnd->copy()->subDays(13);
        if ($trendStart->diffInDays($trendEnd) > 29) {
            $trendStart = $trendEnd->copy()->subDays(29);
        }
        $trendValues = (clone $sales)
            ->whereDate('created_at', '>=', $trendStart->toDateString())
            ->whereDate('created_at', '<=', $trendEnd->toDateString())
            ->selectRaw('DATE(created_at) as sale_date, SUM(total_amount) as revenue')
            ->groupBy('sale_date')
            ->pluck('revenue', 'sale_date');
        $trendLabels = [];
        $trendData = [];
        for ($date = $trendStart->copy(); $date->lte($trendEnd); $date->addDay()) {
            $key = $date->toDateString();
            $trendLabels[] = $date->format('M j');
            $trendData[] = (float) ($trendValues[$key] ?? 0);
        }
        $branches = Branch::orderBy('branch_name')->get();

        return view('owner.reports.sales', compact(
            'totalSales', 'transactionCount', 'unitsSold', 'bestSellingProducts',
            'recentSales', 'branches', 'filters', 'trendLabels', 'trendData'
        ));
    }

    public function exportSalesReport(Request $request)
    {
        $filters = $this->validateReportFilters($request);

        return response()->streamDownload(function () use ($filters) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Transaction', 'Date', 'Branch', 'Staff', 'Order type', 'Subtotal', 'Discount', 'Total']);

            $this->filteredSalesQuery($filters)
                ->with(['branch', 'user'])
                ->chunkById(500, function ($sales) use ($output) {
                    foreach ($sales as $sale) {
                        fputcsv($output, [
                            $sale->id,
                            $sale->created_at?->format('Y-m-d H:i:s'),
                            $sale->branch?->branch_name ?? 'Unassigned',
                            $sale->user?->name ?? 'Unassigned',
                            $sale->order_type,
                            $sale->subtotal,
                            $sale->discount,
                            $sale->total_amount,
                        ]);
                    }
                });

            fclose($output);
        }, 'sales-report-' . now()->format('Ymd-His') . '.csv', [
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

    private function filteredSalesQuery(array $filters): Builder
    {
        return $this->applySalesFilters(Sale::query(), $filters);
    }

    private function applySalesFilters(Builder $query, array $filters): Builder
    {
        if (!empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }
        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        return $query;
    }

    public function history()
    {
        $sales = Sale::latest()->paginate(10);
        return view('staff.sales.history', compact('sales'));
    }

    public function store(Request $request)
    {
        // 1. Kunin at i-decode ang cart items galing sa hidden input
        $cart = json_decode($request->input('cart_data'), true);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Walang produkto sa cart.');
        }

        // 2. Kalkulahin ang subtotal at discount
        $subtotal = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        $isSuki = $request->has('is_suki') ? 1 : 0;
        $discount = $isSuki ? $subtotal * 0.10 : 0;
        $totalAmount = $subtotal - $discount;
        $moneyReceived = $request->input('money_received');
        $change = $moneyReceived - $totalAmount;

        if ($moneyReceived < $totalAmount) {
            return redirect()->back()->with('error', 'Kulang ang ibinigay na bayad.');
        }

        // 3. I-save sa Database
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'order_type'     => 'Walk-in',
                'is_suki'        => $isSuki,
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'total_amount'   => $totalAmount,
                'money_received' => $moneyReceived,
                'change'         => $change,
            ]);

            DB::commit();

            return redirect()->route('staff.sales.history')->with('success', 'Tagumpay na naitala ang transaksyon (#POS-' . $sale->id . ')!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'May nangyaring mali: ' . $e->getMessage());
        }
    }
}