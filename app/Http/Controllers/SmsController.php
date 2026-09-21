<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Customer;

class SmsController extends Controller
{
    public function smsIndex(Request $request)
    {
        $customers = Customer::with('branch')->latest('name')->get();
        $branches = Branch::orderBy('branch_name')->get();

        return view('owner.sms', compact('customers', 'branches'));
    }
}
