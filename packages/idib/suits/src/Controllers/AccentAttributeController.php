<?php

namespace Idib\Suits\Controllers;

use App\Helpers\GlowMaskImageGenerator;
use Idib\Suits\Models\SuitAccent;
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
            ->paginate(1);
        return view('Suits::accent.index', compact('accent_id', 'items'));
    }

    public function addAccent()
    {
        return view('Suits::accent.create');
    }

    public function storeAccent(Request $request)
    {
        $request->validate(
            [
                'accent_name' => 'required',
                'accent_description' => 'required',
                'accent_price' => 'required',
            ],
            [
                'accent_name.required' => 'Please enter accent name',
                'accent_description.required' => 'Please enter accent description',
                'accent_price.required' => 'Please enter accent price',
            ]
        );

        $accent = new SuitAccent();
        $accent->name = $request->accent_name;
        $accent->description = isset($request->accent_description) ? $request->accent_description : '';
        $accent->price = $request->accent_price;
        $accent->status = false;
        if ($request->status) {
            $accent->status = true;
        }
        $accent->save();
        $accent->order_id = $accent->id;
        $accent->save();

        toastr()->success('Accent added successfully!');
        return redirect()->route('admin.suits.accents');
    }

    public function editAccent($id)
    {
        $item = SuitAccent::find($id);
        return view('Suits::accent.edit', compact('item'));
    }

    public function updateAccent(Request $request, $id)
    {
        $request->validate(
            [
                'accent_name' => 'required',
                'accent_description' => 'required',
                'accent_price' => 'required',
            ],
            [
                'accent_name.required' => 'Please enter accent name',
                'accent_description.required' => 'Please enter accent description',
                'accent_price.required' => 'Please enter accent price',
            ]
        );

        $accent = SuitAccent::find($id);
        $accent->name = $request->accent_name;
        $accent->description = isset($request->accent_description) ? $request->accent_description : '';
        $accent->price = $request->accent_price;
        $accent->status = false;
        if ($request->status) {
            $accent->status = true;
        }
        $accent->save();

        toastr()->success('Accent updated successfully!');
        return redirect()->route('admin.suits.accents');
    }

}
