<?php

namespace Idib\Suits\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\GlowMaskImageGenerator;
use Idib\Suits\Models\SuitAccent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fabric;
use Illuminate\Support\Facades\DB;

class SuitApiController extends Controller
{
    public function getSuitFabrics()
    {
        $fabrics = DB::table('suit_fabrics')
            ->where('status', 1)
            ->get();
        /*$fabrics = DB::table('suit_fabrics')
            ->where('status', 1)
            ->get();*/

        return response()->json($fabrics);

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
        $accent->accent_url = GeneralHelper::seoUrl($request->accent_name);
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
