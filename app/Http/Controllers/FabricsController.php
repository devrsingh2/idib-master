<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fabric;
use Illuminate\Http\Request;

class FabricsController extends Controller
{
    public function index($id)
    {
        $product_id = $id;
        $items = Fabric::all();
        return view('admin.fabrics.index', compact('product_id', 'items'));
    }

    public function addFabric($id)
    {
        $product_id = $id;
        $categories = Category::with('trans')
            ->get();
        $cat_arr = [];
        if (isset($categories)) {
            foreach ($categories as $k => $item) {
                if ($item->seo_url === 'material') {
                    $cat_arr['material'] = $item;
                }
                if ($item->seo_url === 'pattern') {
                    $cat_arr['pattern'] = $item;
                }
                if ($item->seo_url === 'season') {
                    $cat_arr['season'] = $item;
                }
                if ($item->seo_url === 'color') {
                    $cat_arr['color'] = $item;
                }
                if ($item->seo_url === 'category') {
                    $cat_arr['category'] = $item;
                }
            }
        }
        return view('admin.fabrics.create', compact('product_id', 'cat_arr'));
    }

    public function storeFabric(Request $request, $id)
    {
        $request->validate(
            [
                'fabric_name' => 'required',
                'fabric_price' => 'required',
                'fabric_thumb' => 'required',
                'medium_thumb' => 'required',
                'large_thumb_image' => 'required',
                'material_parent' => 'required',
                'pattern_parent' => 'required',
                'season_parent' => 'required',
                'color_parent' => 'required',
                'category_parent' => 'required',
            ],
            [
                'fabric_name.required' => 'Please enter fabric name',
                'fabric_price.required' => 'Please enter fabric price',
                'fabric_thumb.required' => 'Please select fabric thumb image',
                'medium_thumb.required' => 'Please select medium thumb image',
                'large_thumb_image.required' => 'Please select large thumb image'
            ]
        );
        if(($file = $request->hasFile('fabric_thumb')) && ($file = $request->hasFile('medium_thumb')) && ($file = $request->hasFile('large_thumb_image'))) {
            $file = $request->file('fabric_thumb');
            $file_thumb = $request->file('medium_thumb');
            $file_thumb_large = $request->file('large_thumb_image');

            $fileName = $file->getClientOriginalName();
            $fileName_thumb = $file_thumb->getClientOriginalName();
            $fileName_large_thumb = $file_thumb_large->getClientOriginalName();

            if ($id == 1) {
                $destinationPath = public_path() . '/tool/images/fabric/suit/';
                $destinationPath_thumb = public_path() . '/tool/images/display/suit/';
                $destinationPath_large_thumb = public_path() . '/tool/images/large/suit/';
            } else {
                $destinationPath = public_path() . '/tool/images/fabric/shirt/';
                $destinationPath_thumb = public_path() . '/tool/images/display/shirt/';
                $destinationPath_large_thumb = public_path() . '/tool/images/large/shirt/';
            }

            $file->move($destinationPath, $fileName);
            $file_thumb->move($destinationPath_thumb, $fileName_thumb);
            $file_thumb_large->move($destinationPath_large_thumb, $fileName_large_thumb);
        }
        $fabric = new Fabric();
        $fabric->product_id = $id;
        $fabric->name = $request->fabric_name;
        $fabric->description = isset($request->description) ? $request->description : '';
        $fabric->fabric_image = $fileName;
        $fabric->display_image = $fileName_thumb;
        $fabric->large_image = $fileName_large_thumb;
        $fabric->price = $request->fabric_price;
        $fabric->material_parent = $request->material_parent;
        $fabric->pattern_parent = $request->pattern_parent;
        $fabric->season_parent = $request->season_parent;
        $fabric->color_parent = $request->color_parent;
        $fabric->category_parent = $request->category_parent;
        $fabric->status = false;
        if ($request->status) {
            $fabric->status = true;
        }
        $fabric->save();
        toastr()->success('Fabric added successfully!');
        return redirect()->route('admin.fabrics', [$id]);
        /*$status = false;
        if ($request->status) {
            $status = true;
        }
        $item = new SubCategory;
        $item->product_id = $request->product_id;
        $item->category_id = $request->category_id;
        $item->name = $request->category_name;
        $item->description = $request->category_description;
        $item->status = $status;
        $item->save();
        $item->order = $item->id;
        $item->save();*/
    }

    public function editFabric($pId, $id)
    {
        $product_id = $pId;
        $categories = Category::with('trans')
            ->get();
//        dd($item);
        $cat_arr = [];
        if (isset($categories)) {
            foreach ($categories as $k => $item) {
                if ($item->seo_url === 'material') {
                    $cat_arr['material'] = $item;
                }
                if ($item->seo_url === 'pattern') {
                    $cat_arr['pattern'] = $item;
                }
                if ($item->seo_url === 'season') {
                    $cat_arr['season'] = $item;
                }
                if ($item->seo_url === 'color') {
                    $cat_arr['color'] = $item;
                }
                if ($item->seo_url === 'category') {
                    $cat_arr['category'] = $item;
                }
            }
        }
        $item = Fabric::find($id);
        return view('admin.fabrics.edit', compact('product_id', 'item', 'cat_arr'));
    }

    public function updateFabric(Request $request, $id)
    {
        $request->validate(
            [
                'fabric_name' => 'required',
                'fabric_price' => 'required',
                'fabric_thumb' => 'required',
                'medium_thumb' => 'required',
                'large_thumb_image' => 'required',
                'material_parent' => 'required',
                'pattern_parent' => 'required',
                'season_parent' => 'required',
                'color_parent' => 'required',
                'category_parent' => 'required',
            ],
            [
                'fabric_name.required' => 'Please enter fabric name',
                'fabric_price.required' => 'Please enter fabric price',
                'fabric_thumb.required' => 'Please select fabric thumb image',
                'medium_thumb.required' => 'Please select medium thumb image',
                'large_thumb_image.required' => 'Please select large thumb image'
            ]
        );
        if(($file = $request->hasFile('fabric_thumb')) && ($file = $request->hasFile('medium_thumb')) && ($file = $request->hasFile('large_thumb_image'))) {
            $file = $request->file('fabric_thumb');
            $file_thumb = $request->file('medium_thumb');
            $file_thumb_large = $request->file('large_thumb_image');

            $fileName = $file->getClientOriginalName();
            $fileName_thumb = $file_thumb->getClientOriginalName();
            $fileName_large_thumb = $file_thumb_large->getClientOriginalName();

            if ($id == 1) {
                $destinationPath = public_path() . '/tool/images/fabric/suit/';
                $destinationPath_thumb = public_path() . '/tool/images/display/suit/';
                $destinationPath_large_thumb = public_path() . '/tool/images/large/suit/';
            } else {
                $destinationPath = public_path() . '/tool/images/fabric/shirt/';
                $destinationPath_thumb = public_path() . '/tool/images/display/shirt/';
                $destinationPath_large_thumb = public_path() . '/tool/images/large/shirt/';
            }

            $file->move($destinationPath, $fileName);
            $file_thumb->move($destinationPath_thumb, $fileName_thumb);
            $file_thumb_large->move($destinationPath_large_thumb, $fileName_large_thumb);
        }
        $fabric = new Fabric();
        $fabric->product_id = $id;
        $fabric->name = $request->fabric_name;
        $fabric->description = isset($request->description) ? $request->description : '';
        $fabric->fabric_image = $fileName;
        $fabric->display_image = $fileName_thumb;
        $fabric->large_image = $fileName_large_thumb;
        $fabric->price = $request->fabric_price;
        $fabric->material_parent = $request->material_parent;
        $fabric->pattern_parent = $request->pattern_parent;
        $fabric->season_parent = $request->season_parent;
        $fabric->color_parent = $request->color_parent;
        $fabric->category_parent = $request->category_parent;
        $fabric->status = false;
        if ($request->status) {
            $fabric->status = true;
        }
        $fabric->save();
        toastr()->success('Fabric added successfully!');
        return redirect()->route('admin.fabrics', [$id]);
    }

}
