<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class StaffSalesController extends Controller
{
    // ... iba pang methods tulad ng sales, cart, checkout, history ...

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