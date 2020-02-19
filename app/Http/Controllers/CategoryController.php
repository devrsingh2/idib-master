<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index($id)
    {
        $product_id = $id;
        $items = Category::where('status', 1)
            ->get();
        return view('admin.categories.index', compact('product_id', 'items'));
    }

    public function addCategory($id)
    {
        $product_id = $id;
        return view('admin.categories.create', compact('product_id'));
    }
}
