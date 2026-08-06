<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BranchReportController extends Controller
{
    public function branchReport()
    {
        return view('owner.reports.branchreport'); 
    }
}
