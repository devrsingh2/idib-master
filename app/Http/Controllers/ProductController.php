<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $items = Product::where('status', 1)
            ->get();
        return view('admin.products.index', compact('items'));
    }
}
