<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Categories;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories');
    }
}