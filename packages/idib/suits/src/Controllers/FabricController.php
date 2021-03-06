<?php

namespace Idib\Suits\Controllers;

use Idib\Suits\Helpers\GlowMaskImageGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Idib\Suits\Models\SuitCategory;
use Idib\Suits\Models\SuitFabric;
use Illuminate\Support\Facades\DB;

class FabricController extends Controller
{
    public function index($id = '')
    {
        $product_id = $id;
        $items = SuitFabric::all();
        return view('Suits::fabrics.index', compact('product_id', 'items'));
    }

    public function addFabric()
    {
        $categories = SuitCategory::with('parent')
            ->where('parent_id', '!=', 0)
            ->get();
        $cat_arr = [];
        if (isset($categories)) {
            foreach ($categories as $k => $item) {
                if ($item->parent->id === $item->parent_id) {
                    $cat_arr[$item->parent->seo_url][$k] = $item;
                }
            }
        }
        return view('Suits::fabrics.create', compact('product_id', 'cat_arr'));
    }

    public function storeFabric(Request $request)
    {
        $request->validate(
            [
                'fabric_name' => 'required',
                'fabric_type' => 'required',
                'fabric_price' => 'required',
                'fabric_weight' => 'required',
                'fabric_thumb' => 'required|dimensions:width=100,height=100',
                'medium_thumb' => 'required|dimensions:width=360,height=360',
                'large_thumb_image' => 'required|dimensions:width=1000,height=1000',
                /*'fabric_thumb' => 'required',
                'medium_thumb' => 'required',
                'large_thumb_image' => 'required',*/
                'composition' => 'required',
                'material_parent' => 'required',
                'pattern_parent' => 'required',
                'color_parent' => 'required',
                'collection_parent' => 'required',
                /*'season_parent' => 'required',
                'category_parent' => 'required',*/
            ],
            [
                'fabric_name.required' => 'Please enter fabric name',
                'fabric_type.required' => 'Please enter fabric type',
                'fabric_price.required' => 'Please enter fabric price',
                'fabric_weight.required' => 'Please enter fabric weight',
                'fabric_thumb.required' => 'Please select fabric thumb image',
                'medium_thumb.required' => 'Please select medium thumb image',
                'large_thumb_image.required' => 'Please select large thumb image',
                'composition.required' => 'Please enter composition',
            ]
        );
        if(($file = $request->hasFile('fabric_thumb')) && ($file = $request->hasFile('medium_thumb')) && ($file = $request->hasFile('large_thumb_image'))) {
            $file = $request->file('fabric_thumb');
            $file_thumb = $request->file('medium_thumb');
            $file_thumb_large = $request->file('large_thumb_image');

            $fileName = $file->getClientOriginalName();
            $fileName_thumb = $file_thumb->getClientOriginalName();
            $fileName_large_thumb = $file_thumb_large->getClientOriginalName();

            $destinationPath = public_path() . '/tool/images/fabric/suit/';
            $destinationPath_thumb = public_path() . '/tool/images/display/suit/';
            $destinationPath_large_thumb = public_path() . '/tool/images/large/suit/';

            $file->move($destinationPath, $fileName);
            $file_thumb->move($destinationPath_thumb, $fileName_thumb);
            $file_thumb_large->move($destinationPath_large_thumb, $fileName_large_thumb);
        }
        $fabric = new SuitFabric();
        $fabric->product_id = 1;
        $fabric->article_number = 'IDIB-'.$request->fabric_name;
        $fabric->name = $request->fabric_name;
        $fabric->fabric_type = $request->fabric_type;
//        $fabric->description = isset($request->description) ? $request->description : '';
        $fabric->fabric_image = $fileName;
        $fabric->display_image = $fileName_thumb;
        $fabric->large_image = $fileName_large_thumb;
        $fabric->price = $request->fabric_price;
        $fabric->weight = $request->fabric_weight;
        $fabric->composition = $request->composition;
        $fabric->material_parent = $request->material_parent;
        $fabric->pattern_parent = $request->pattern_parent;
//        $fabric->season_parent = $request->season_parent;
        $fabric->color_parent = $request->color_parent;
        $fabric->collection_parent = $request->collection_parent;
//        $fabric->category_parent = $request->category_parent;
        $fabric->status = false;
        if ($request->status) {
            $fabric->status = true;
        }
        $fabric->save();
        if (isset($fileName) && isset($destinationPath)) {
            GlowMaskImageGenerator::ImageGenerator($fabric->id, $fileName, $destinationPath);
        }
        toastr()->success('Fabric added successfully!');
        return redirect()->route('admin.suits.fabrics');
    }

    public function editFabric($id)
    {
        $categories = SuitCategory::with('parent')
            ->where('parent_id', '!=', 0)
            ->get();
        $cat_arr = [];
        if (isset($categories)) {
            foreach ($categories as $k => $item) {
                if ($item->parent->id === $item->parent_id) {
                    $cat_arr[$item->parent->seo_url][$k] = $item;
                }
            }
        }
        $item = SuitFabric::find($id);
        return view('Suits::fabrics.edit', compact('item', 'cat_arr'));
    }

    public function updateFabric(Request $request, $id)
    {
        $request->validate(
            [
                'fabric_name' => 'required',
                'fabric_price' => 'required',
                'fabric_thumb' => 'dimensions:width=100,height=100',
                'medium_thumb' => 'dimensions:width=360,height=360',
                'large_thumb_image' => 'dimensions:width=1000,height=1000',
                'material_parent' => 'required',
                'pattern_parent' => 'required',
//                'season_parent' => 'required',
                'color_parent' => 'required',
                'collection_parent' => 'required',
//                'category_parent' => 'required',
            ],
            [
                'fabric_name.required' => 'Please enter fabric name',
                'fabric_price.required' => 'Please enter fabric price',
            ]
        );
        if($file = $request->hasFile('fabric_thumb')) {
            $file = $request->file('fabric_thumb');

            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path() . '/tool/images/fabric/suit/';

            $file->move($destinationPath, $fileName);
        }
        if($file = $request->hasFile('medium_thumb')) {
            $file_thumb = $request->file('medium_thumb');

            $fileName_thumb = $file_thumb->getClientOriginalName();

            $destinationPath_thumb = public_path() . '/tool/images/display/suit/';

            $file_thumb->move($destinationPath_thumb, $fileName_thumb);
        }
        if($file = $request->hasFile('large_thumb_image')) {
            $file_thumb_large = $request->file('large_thumb_image');

            $fileName_large_thumb = $file_thumb_large->getClientOriginalName();

            $destinationPath_large_thumb = public_path() . '/tool/images/large/suit/';

            $file_thumb_large->move($destinationPath_large_thumb, $fileName_large_thumb);
        }

        $fabric = SuitFabric::find($id);
        $fabric->name = $request->fabric_name;
        $fabric->fabric_type = $request->fabric_type;
//        $fabric->description = isset($request->description) ? $request->description : '';
        $fabric->fabric_image = isset($fileName) ? $fileName : $fabric->fabric_image;
        $fabric->display_image = isset($fileName_thumb) ? $fileName_thumb : $fabric->display_image;
        $fabric->large_image = isset($fileName_large_thumb) ? $fileName_large_thumb : $fabric->large_image;
        $fabric->price = $request->fabric_price;
        $fabric->weight = $request->fabric_weight;
        $fabric->composition = $request->composition;
        $fabric->material_parent = $request->material_parent;
        $fabric->pattern_parent = $request->pattern_parent;
//        $fabric->season_parent = $request->season_parent;
        $fabric->color_parent = $request->color_parent;
        $fabric->collection_parent = $request->collection_parent;
//        $fabric->category_parent = $request->category_parent;
        $fabric->status = false;
        if ($request->status) {
            $fabric->status = true;
        }
        $fabric->save();

        if (isset($fileName) && isset($destinationPath)) {
            GlowMaskImageGenerator::ImageGenerator($fabric->id, $fileName, $destinationPath);
        }

        toastr()->success('Fabric updated successfully!');
        return redirect()->route('admin.suits.fabrics');
    }

}
