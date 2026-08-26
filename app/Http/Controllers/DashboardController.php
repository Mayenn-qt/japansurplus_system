<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        if ($user->role == 'owner') {
            return view('owner.dashboard', compact('user'));
        }

        
        return view('staff.dashboard', compact('user'));
    }
}