<?php

namespace Idib\Suits\Controllers;

use App\Http\Controllers\Controller;
use Idib\Suits\Helpers\CommonHelper;
use Idib\Suits\Models\SuitCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $items = SuitCategory::get();
        return view('Suits::categories.index', compact('product_id', 'items'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCategory($id)
    {
        $product_id = $id;
        return view('Suits::categories.create', compact('product_id'));
    }

    /**
     * @param $productId
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCategory($productId, $id)
    {
        $product_id = $productId;
        $item = SuitCategory::find($id);
//        dd($item);
        return view('Suits::categories.edit', compact('product_id', 'item'));
    }

    /**
     * @param Request $request
     * @param $pId
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCategory(Request $request, $pId, $id)
    {
        $request->validate(
            [
                'category_name' => 'required',
                'category_description' => 'required',
            ],
            [
                'category_name.required' => 'Please enter category name',
                'category_description.required' => 'Please enter category description'
            ]
        );
        $status = false;
        if ($request->status) {
            $status = true;
        }
        $item = SuitCategory::find($id);
        $item->name = $request->category_name;
        $item->seo_url = CommonHelper::seoUrl($request->category_name);
        $item->description = $request->category_description;
        $item->status = $status;
        $item->save();

        toastr()->success('Category Updated successfully!');
        return redirect()->route('admin.categories', [$pId]);
    }

    /**
     * @param $pId
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subCategories($id)
    {
        $items = SuitCategory::where('parent_id', $id)
            ->with('parent')
            ->get();
        return view('Suits::categories.sub-categories', compact('id','items'));
    }

    /**
     * @param $pId
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addSubCategory($id)
    {
        $item = SuitCategory::find($id);
        return view('Suits::categories.add-sub-category', compact('item'));
    }

    /**
     * @param Request $request
     * @param $pId
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSubCategory(Request $request, $id)
    {
        $request->validate(
            [
//                'category_id' => 'required',
                'category_name' => 'required',
                'category_description' => 'required',
            ],
            [
//                'category_id.required' => 'Please enter category name',
                'category_name.required' => 'Please enter sub category name',
                'category_description.required' => 'Please enter sub category description'
            ]
        );
        $status = false;
        if ($request->status) {
            $status = true;
        }
        $item = new SuitCategory();
        $item->parent_id = $request->parent_id;
//        $item->category_id = $request->category_id;
        $item->name = $request->category_name;
        $item->seo_url = CommonHelper::seoUrl($request->category_name);
        $item->description = $request->category_description;
        $item->status = $status;
        $item->save();
        $item->order = $item->id;
        $item->save();

        toastr()->success('Sub Category Added successfully!');
        return redirect()->route('admin.suits.categories.sub-categories', [$request->category_id]);
    }

    public function editSubCategory($cId, $id)
    {
        $item = SuitCategory::with('parent')
            ->find($id);
        return view('Suits::categories.edit-sub-category', compact('item'));
    }

    /**
     * @param Request $request
     * @param $pId
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSubCategory(Request $request, $cId, $id)
    {
        $request->validate(
            [
                'category_name' => 'required',
                'category_description' => 'required',
            ],
            [
                'category_name.required' => 'Please enter category name',
                'category_description.required' => 'Please enter category description'
            ]
        );
        $status = false;
        if ($request->status) {
            $status = true;
        }
        $item = SuitCategory::find($id);
        $item->name = $request->category_name;
        $item->seo_url = CommonHelper::seoUrl($request->category_name);
        $item->description = $request->category_description;
        $item->status = $status;
        $item->save();

        toastr()->success('Category Updated successfully!');
        return redirect()->route('admin.suits.categories.sub-categories', [$cId]);
    }

}
