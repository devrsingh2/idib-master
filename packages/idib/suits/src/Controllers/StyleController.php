<?php

namespace Idib\Suits\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\GlowMaskImageGenerator;
use Idib\Suits\Models\SuitAccent;
use Idib\Suits\Models\SuitStyle;
use Idib\Suits\Models\SuitStyleAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fabric;

class StyleController extends Controller
{
    public function listJacketStyles()
    {
        $items = SuitStyle::where('designType', 'jacket')
            ->get();
        return view('Suits::styles.index', compact('items'));
    }

    public function listJacketStyleAttributes($id)
    {
        $items = SuitStyleAttribute::where('designType', 'jacket')
            ->where('style_id', $id)
            ->get();
        return view('Suits::styles.attribute-index', compact('id', 'items'));
    }

    public function addJacketStyle($id)
    {
        return view('Suits::styles.create-attribute', compact('id', 'items'));
    }

    public function editJacketStyle($sid, $id)
    {
        return view('Suits::styles.edit-attribute', compact('sid', 'items'));
    }

    public function listPantStyles()
    {
        $items = SuitStyle::where('designType', 'pant')
            ->get();
        return view('Suits::pant.index', compact('items'));
    }

    public function listPantStyleAttributes($id)
    {
        $items = SuitStyleAttribute::where('designType', 'pant')
            ->where('style_id', $id)
            ->get();
        return view('Suits::pant.attribute-index', compact('items'));
    }

    public function listVestStyles()
    {
        $items = SuitStyle::where('designType', 'vest')
            ->get();
        return view('Suits::vest.index', compact('items'));
    }

    public function listVestStyleAttributes($id)
    {
        $items = SuitStyleAttribute::where('designType', 'vest')
            ->where('style_id', $id)
            ->get();
        return view('Suits::vest.attribute-index', compact('items'));
    }

}
