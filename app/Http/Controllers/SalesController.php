<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function salesReport()
    {
        return view('owner.reports.sales'); 
        }
}