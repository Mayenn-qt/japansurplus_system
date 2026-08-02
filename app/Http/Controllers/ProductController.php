<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('owner.product'); // Siguraduhing ito ang tamang path ng blade file mo
    }
}