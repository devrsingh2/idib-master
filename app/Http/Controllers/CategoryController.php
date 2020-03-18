<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        $product_id = $id;
        $items = Category::get();
        return view('admin.categories.index', compact('product_id', 'items'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCategory($id)
    {
        $product_id = $id;
        return view('admin.categories.create', compact('product_id'));
    }

    /**
     * @param $productId
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCategory($productId, $id)
    {
        $product_id = $productId;
        $item = Category::find($id);
//        dd($item);
        return view('admin.categories.edit', compact('product_id', 'item'));
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
        $item = Category::find($id);
        $item->name = $request->category_name;
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
    public function subCategories($pId, $id)
    {
        $product_id = $pId;
        $items = Category::find($id);
        return view('admin.categories.sub-categories', compact('product_id', 'items'));
    }

    /**
     * @param $pId
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addSubCategory($pId, $id)
    {
        $product_id = $pId;
        $item = Category::find($id);
        return view('admin.categories.add-sub-category', compact('product_id', 'item'));
    }

    /**
     * @param Request $request
     * @param $pId
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSubCategory(Request $request, $pId, $id)
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
        $item = new SubCategory;
        $item->product_id = $request->product_id;
        $item->category_id = $request->category_id;
        $item->name = $request->category_name;
        $item->description = $request->category_description;
        $item->status = $status;
        $item->save();
        $item->order = $item->id;
        $item->save();

        toastr()->success('Sub Category Added successfully!');
        return redirect()->route('admin.categories.sub-categories', [$pId, $request->category_id]);
    }

    public function editSubCategory($productId, $cId, $id)
    {
        $product_id = $productId;
//        $item = SubCategory::FilterCategory($cId)->find($id);
        $item = SubCategory::find($id);
        dd($item);
        return view('admin.categories.edit-sub-category', compact('product_id', 'item'));
    }

    /**
     * @param Request $request
     * @param $pId
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSubCategory(Request $request, $pId, $id)
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
        $item = Category::find($id);
        $item->name = $request->category_name;
        $item->description = $request->category_description;
        $item->status = $status;
        $item->save();

        toastr()->success('Category Updated successfully!');
        return redirect()->route('admin.categories', [$pId]);
    }

}
