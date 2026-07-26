<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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