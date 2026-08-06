<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    publivc function index()
    {
        return view('owner.stock');
    }
}
