<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffSalesController extends Controller
{
    // Main POS Screen (Ipinapakita ang produkto at ang cart sa kanan)
    public function sales()
    {
        return view('staff.sales.pos'); // O kung pos.blade.php ang gamit mo: staff.sales.pos
    }

    // Para sa Cart Route kung kailangan (hal. AJAX request o hiwalay na tawag)
    public function cart()
    {
        return view('staff.sales.cart');
    }

    // Checkout Screen
    public function checkout()
    {
        return view('staff.sales.checkout');
    }
}