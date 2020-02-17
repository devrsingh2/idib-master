<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FabricController extends Controller
{
    public function index($id)
    {
        $product_id = $id;
        return view('admin.fabrics.index', compact('product_id'));
    }

    public function addFabric($id)
    {
        $product_id = $id;
        return view('admin.fabrics.create', compact('product_id'));
    }

}
