<?php

namespace Idib\Suits\Controllers;

use App\Helpers\GeneralHelper;
use App\Helpers\GlowMaskImageGenerator;
use Idib\Suits\Models\SuitAccent;
use Idib\Suits\Models\SuitCategory;
use Idib\Suits\Models\SuitStyle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Fabric;
use Illuminate\Support\Facades\DB;

class SuitApiController extends Controller
{
    public function getSuitFabrics()
    {
        $getFabric = DB::table('suit_fabrics')
            ->where('status', 1)
            ->get();

        $local_display_path = url('/')."/tool/images/display/suit";
        $local_large_path = url('/')."/tool/images/large/suit";
        if (isset($getFabric)) {
            foreach ($getFabric as $key => $value) {
                $getCategoryName = DB::table('suit_categories')
                    ->whereIn('id', [$value->material_parent, $value->pattern_parent, $value->season_parent, $value->color_parent, $value->category_parent])
                    ->get()->toArray();
                $materialParent = DB::table('suit_categories')
                    ->where('id', $value->material_parent)
                    ->first();
                $patternParent = DB::table('suit_categories')
                    ->where('id', $value->pattern_parent)
                    ->first();
                $seasonParent = DB::table('suit_categories')
                    ->where('id', $value->season_parent)
                    ->first();
                $colorParent = DB::table('suit_categories')
                    ->where('id', $value->color_parent)
                    ->first();
                $categoryParent = DB::table('suit_categories')
                    ->where('id', $value->category_parent)
                    ->first();
                $fabric['id'] = $value->id;
                $fabric['name'] = $value->name;
                //$fabric['fabric_thumb'] = $local_fabric_path.'/'.$value->fabric_image;
                $fabric['img'] = $local_display_path.'/'.$value->display_image;
                $fabric['large_thumb'] = $local_large_path.'/'.$value->large_image;
                $fabric['price'] = $value->price;
                $fabric['material_parent'] = isset($materialParent) ? $materialParent->name : '';
                $fabric['pattern_parent'] = isset($patternParent) ? $patternParent->name : '';
                $fabric['season_parent'] = isset($seasonParent) ? $seasonParent->name : '';
                $fabric['color_parent'] = isset($colorParent) ? $colorParent->name : '';
                $fabric['category_parent'] = isset($categoryParent) ? $categoryParent->name : '';
                $fabric['type'] = isset($getCategoryName[0]) ? $getCategoryName[0]->name : '';
                $AllFabric[] = $fabric;
            }
        } else {
            $fabric['Data'] = "Data not available for this product!";
            $AllFabric[] = $fabric;
        }

        $getStaticCategory = DB::table('suit_categories')
            ->where('parent_id', 0)
            ->get();
        if (isset($getStaticCategory)) {
            foreach ($getStaticCategory as $key => $value) {
                $getCategory[] = SuitCategory::with('parent')
                    ->where('status', 1)
                    ->where('parent_id', $value->id)
                    ->get();
//                $AllCategory = $getCategory;
            }
        }

        $allCategory = [];
        if (isset($getCategory)) {
            foreach ($getCategory as $k => $item) {
                if (isset($item)) {
                    foreach ($item as $key => $sc) {
                        $allCategory[$k][$key] = [
                            'id' => $sc['id'],
                            'name' => $sc['name'],
                            'parent' => $sc['parent']->seo_url,
                        ];
                    }
                }
            }
        }
        $fabric_data = array();
        $fabric_data = ["fabric" => $AllFabric, "category" => $allCategory];

        return response()->json($fabric_data);

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuitAccent()
    {
        $tool_accents = SuitAccent::with('trans')
            ->where('status', 1)
            ->get();
        //suit tool path
        $tool_path = config('suits.suit_path');

        if (isset($tool_accents)) {
            foreach ($tool_accents as $key => $item) {
                $getAccentTypeJson = [];
                if (isset($item->trans)) {
                    foreach ($item->trans as $k => $attr) {
                        $getAccentTypeJson[$k] = [
                          'id' => $k+1,
                          'parent' => $item->name,
                          'category' => 'metal',
                          'designType' => 'jacket',
                          'designRel' => $item->name,
                          'name' => $attr->name,
                          'price' => $attr->price,
                          'class' => '',
                          'status' => $attr->status,
                          'fabric_360' => $attr->image,
                        ];
                    }
                }
//                $getAccentTypeJson =
                $accent['id'] = $key+1;
                $accent['name'] = $item->name;
                $accent['class'] = $item->class_name;
                $accent['designType'] = 'jacket';
                $accent['price'] = $item->price;
                $accent['img'] = '';
                $accent['style'] = $getAccentTypeJson;
                $AllAccent[] = $accent;
            }
        }

        $accent_data = array();
        $accent_data = $AllAccent;
        return response()->json($accent_data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuitStyle()
    {
        $tool_styles = SuitStyle::with('trans')
            ->where('designType', 'jacket')
            ->where('status', 1)
            ->get();

        if (isset($tool_styles)) {
            foreach ($tool_styles as $key => $item) {
                $getStyleTypeJson = [];
                if (isset($item->trans)) {
                    foreach ($item->trans as $k => $attr) {
                        $getStyleTypeJson[$k] = [
                            'id' => $k+1,
                            'parent' => $item->name,
                            'designType' => $item->designType,
                            'name' => $attr->name,
                            'price' => $attr->price,
                            'class' => $attr->class_name,
                            'status' => $attr->status,
                        ];
                    }
                }
//                $getStyleTypeJson =
                $style['id'] = $key+1;
                $style['name'] = $item->name;
                $style['class'] = $item->class_name;
                $style['designType'] = 'jacket';
                $style['price'] = $item->price;
                $style['style'] = $getStyleTypeJson;
                $all_styles[] = $style;
            }
        }

        $style_data = array();
        $style_data = $all_styles;
        return response()->json($style_data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuitPant()
    {
        $tool_pant_styles = SuitStyle::with('trans')
            ->where('designType', 'pant')
            ->where('status', 1)
            ->get();

        if (isset($tool_pant_styles)) {
            foreach ($tool_pant_styles as $key => $item) {
                $getStyleTypeJson = [];
                if (isset($item->trans)) {
                    foreach ($item->trans as $k => $attr) {
                        $getStyleTypeJson[$k] = [
                            'id' => $k+1,
                            'parent' => $item->name,
                            'designType' => $item->designType,
                            'name' => $attr->name,
                            'price' => $attr->price,
                            'class' => $attr->class_name,
                            'status' => $attr->status,
                        ];
                    }
                }
//                $getStyleTypeJson =
                $style['id'] = $key+1;
                $style['name'] = $item->name;
                $style['class'] = $item->class_name;
                $style['designType'] = $item->designType;
                $style['price'] = $item->price;
                $style['style'] = $getStyleTypeJson;
                $all_styles[] = $style;
            }
        }

        $style_data = array();
        $style_data = $all_styles;
        return response()->json($style_data);
    }

    public function getSuitVest()
    {
        $tool_vest_styles = SuitStyle::with('trans')
            ->where('designType', 'vest')
            ->where('status', 1)
            ->get();

        if (isset($tool_vest_styles)) {
            foreach ($tool_vest_styles as $key => $item) {
                $getStyleTypeJson = [];
                if (isset($item->trans)) {
                    foreach ($item->trans as $k => $attr) {
                        $getStyleTypeJson[$k] = [
                            'id' => $k+1,
                            'parent' => $item->name,
                            'designType' => $item->designType,
                            'name' => $attr->name,
                            'price' => $attr->price,
                            'class' => $attr->class_name,
                            'status' => $attr->status,
                        ];
                    }
                }
//                $getStyleTypeJson =
                $style['id'] = $key+1;
                $style['name'] = $item->name;
                $style['class'] = $item->class_name;
                $style['designType'] = $item->designType;
                $style['price'] = $item->price;
                $style['style'] = $getStyleTypeJson;
                $all_styles[] = $style;
            }
        }

        $style_data = array();
        $style_data = $all_styles;
        return response()->json($style_data);
    }

}
