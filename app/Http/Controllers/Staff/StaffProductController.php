<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffProductController extends Controller
{
    // Ipinapakita ang Product Inventory List
    public function index(Request $request)
    {
        return view('staff.products.index');
    }

    // Ipinapakita ang Product Details page
    public function show($id)
    {
        return view('staff.products.show');
    }
}   