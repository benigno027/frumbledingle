<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Location;

class ReportController extends Controller
{
    public function index()
    {
        return view('report');
    }
}