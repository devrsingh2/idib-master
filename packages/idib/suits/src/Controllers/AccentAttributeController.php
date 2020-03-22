<?php

namespace Idib\Suits\Controllers;

use Idib\Suits\Helpers\GlowMaskLiningImageGenerator;
use Idib\Suits\Helpers\GlowMaskPocketSquareImageGenerator;
use Idib\Suits\Helpers\GlowMaskThreadImageGenerator;
use Idib\Suits\Models\SuitAccent;
use Idib\Suits\Models\SuitAccentAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fabric;

class AccentAttributeController extends Controller
{
    public function index($id)
    {
        $accent_id = $id;
        $items = SuitAccent::with('trans')
            ->find($id);
        return view('Suits::accent-attribute.index', compact('accent_id', 'items'));
    }

    public function addAccent($id)
    {
        $accent_id = $id;
        $accent = SuitAccent::find($id);
        return view('Suits::accent-attribute.create', compact('accent_id', 'accent'));
    }

    public function storeAccent(Request $request, $id)
    {
        $request->validate(
            [
                'accent_name' => 'required',
                'attribute_name' => 'required',
                'attribute_description' => 'required',
                'attribute_price' => 'required',
                'attribute_image' => 'required',
            ],
            [
                'accent_name.required' => 'Please enter accent name',
                'attribute_name.required' => 'Please enter attribute name',
                'attribute_description.required' => 'Please enter attribute description',
                'attribute_price.required' => 'Please enter attribute price',
                'attribute_image.required' => 'Please select attribute image',
            ]
        );
        $accentData = SuitAccent::find($id);
        if($file = $request->hasFile('attribute_image')) {
            $file = $request->file('attribute_image');

            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path().'/tool/images/display/suit/'.$accentData->accent_url.'/';

            $file->move($destinationPath, $fileName);
        }

        $accent = new SuitAccentAttribute();
        $accent->accent_id = $request->accent_id;
        $accent->name = $request->attribute_name;
        $accent->description = isset($request->attribute_description) ? $request->attribute_description : '';
        $accent->price = $request->attribute_price;
        $accent->image = url('/').'/tool/images/display/suit/'.$accentData->accent_url.'/'.$fileName;
        $accent->status = false;
        if ($request->status) {
            $accent->status = true;
        }
        $accent->save();
        $accent->order_id = $accent->id;
        $accent->save();

        if (isset($fileName)) {
            if ($accentData->accent_url == 'thread') {
                GlowMaskThreadImageGenerator::ThreadImageGenerator($accent->id, $fileName, $destinationPath);
            }
            if ($accentData->accent_url == 'pocketsquare') {
                GlowMaskPocketSquareImageGenerator::PocketSquareImageGenerator($accent->id, $fileName, $destinationPath);
            }
            if ($accentData->accent_url == 'lining') {
                GlowMaskLiningImageGenerator::LiningImageGenerator($accent->id, $fileName, $destinationPath);
            }
        }

        toastr()->success('Attribute added successfully!');
        return redirect()->route('admin.suits.accent-attributes', [$id]);
    }

    public function editAccent($accent_id, $id)
    {
        $accent = SuitAccent::find($accent_id);
        $item = SuitAccentAttribute::find($id);
        return view('Suits::accent-attribute.edit', compact('accent', 'item'));
    }

    public function updateAccent(Request $request, $accent_id, $id)
    {
        $request->validate(
            [
                'accent_name' => 'required',
                'attribute_name' => 'required',
                'attribute_description' => 'required',
                'attribute_price' => 'required',
            ],
            [
                'accent_name.required' => 'Please enter accent name',
                'attribute_name.required' => 'Please enter attribute name',
                'attribute_description.required' => 'Please enter attribute description',
                'attribute_price.required' => 'Please enter attribute price',
            ]
        );
        $accentData = SuitAccent::find($accent_id);
        if($file = $request->hasFile('attribute_image')) {
            $file = $request->file('attribute_image');

            $fileName = $file->getClientOriginalName();

            $destinationPath = public_path().'/tool/images/display/suit/'.$accentData->accent_url.'/';

            $file->move($destinationPath, $fileName);
        }
        $accent = SuitAccentAttribute::find($id);
        $accent->name = $request->attribute_name;
        $accent->description = isset($request->attribute_description) ? $request->attribute_description : '';
        $accent->price = $request->attribute_price;
        $accent->image = isset($fileName) ? url('/').'/tool/images/display/suit/'.$accentData->accent_url.'/'.$fileName : $accent->image;
        $accent->status = false;
        if ($request->status) {
            $accent->status = true;
        }
        $accent->save();

        if (isset($fileName)) {
            if ($accentData->accent_url == 'thread') {
                GlowMaskThreadImageGenerator::ThreadImageGenerator($accent->id, $fileName, $destinationPath);
            }
            if ($accentData->accent_url == 'pocketsquare') {
                GlowMaskPocketSquareImageGenerator::PocketSquareImageGenerator($accent->id, $fileName, $destinationPath);
            }
            if ($accentData->accent_url == 'lining') {
                GlowMaskLiningImageGenerator::LiningImageGenerator($accent->id, $fileName, $destinationPath);
            }
        }

        toastr()->success('Attribute updated successfully!');
        return redirect()->route('admin.suits.accent-attributes', [$accent_id]);
    }

}
