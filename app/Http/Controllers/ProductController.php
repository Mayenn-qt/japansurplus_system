<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'owner'){
            $products = Product::all();
            return view('owner.product', compact('products', 'user'));
        }
    }

    // Idagdag ang function na ito para sa Stock Management page
    public function stockManagement()
    {
        $user = Auth::user();

        if ($user->role == 'owner'){
            $products = Product::all();
            return view('owner.stock', compact('products', 'user'));
        }
    }
}