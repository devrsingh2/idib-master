<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use OhMyBrew\ShopifyApp\Models\tool\Api;
use OhMyBrew\ShopifyApp\Models\tool\Products;
use OhMyBrew\ShopifyApp\Models\tool\ProductColor;
use OhMyBrew\ShopifyApp\Models\tool\ProductButton;
use OhMyBrew\ShopifyApp\Models\tool\ProductAccent;
use OhMyBrew\ShopifyApp\Models\tool\ProductThread;
use OhMyBrew\ShopifyApp\Models\tool\ProductLining;
use OhMyBrew\ShopifyApp\Models\tool\ProductPocketSquare;
use OhMyBrew\ShopifyApp\Models\tool\ProductType;
use OhMyBrew\ShopifyApp\Models\tool\ProductCategory;
use OhMyBrew\ShopifyApp\Models\tool\ProductStyle;
use OhMyBrew\ShopifyApp\Models\tool\ProductStyleParts;
use OhMyBrew\ShopifyApp\Models\tool\ProductStylePartsTypes;
use OhMyBrew\ShopifyApp\Models\tool\ProductPart;
use OhMyBrew\ShopifyApp\Models\tool\OrderLineItem;
use OhMyBrew\ShopifyApp\Models\tool\OrderDetails;
use OhMyBrew\ShopifyApp\Models\tool\OrderCustomerDetails;
use OhMyBrew\ShopifyApp\Models\tool\CartItem;
//use App\Helpers\GlowMaskImageGenerator;
use OhMyBrew\ShopifyApp\Helper\GlowMaskImageGenerator;
use OhMyBrew\ShopifyApp\Helper\GlowMaskShirtImageGenerator;
use OhMyBrew\ShopifyApp\Helper\GlowMaskThreadImageGenerator;
use OhMyBrew\ShopifyApp\Helper\GlowMaskLiningImageGenerator;
use OhMyBrew\ShopifyApp\Helper\GlowMaskPocketSquareImageGenerator;
use Brian2694\Toastr\Facades\Toastr;
use PDF;
use validate;
use DB;

//$getAPI = Api::get();
//$ngrok = $getAPI[0]['API_key'];

class ToolController extends Controller
{


    /*
       |--------------------------------------------------------------------------
       | IdesignIbuy orders  API Controller
       |--------------------------------------------------------------------------
       |
       |
      */

    public function orders()
    {

        //dd(base_path());
        $getProducts = Products::get(); //sidebar

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://10874ad00c4d819ca273b2b1c1b1cdc5:560d2469967f0b6c4632c06b36ba6eea@palmiro-style.myshopify.com/admin/api/2019-04/orders.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "Postman-Token: 5b7eea12-8880-4782-b390-51abcf1c2ab3",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $respo = json_decode($response);

        //dd($response);

        DB::table('idib_order_details')->truncate();
        DB::table('idib_order_item_details')->truncate();
        DB::table('idib_customer_details')->truncate();

        $order_arr = array();
        $item_arr = array();
        $order_list_arr = array();
        $customer_arr = array();

        foreach($respo as $key => $item)
        {
            foreach($item as $key => $value)
            {
                foreach ($value->line_items as $key => $line_item)
                {
                    //4439434461293
                    if($line_item->product_id == "4439434461293")
                    {

                        $mainOrderId = $value->order_number;

                        CartItem::where('variant_id', $line_item->variant_id)->update(['checkout_id' => $mainOrderId]);

                        $orderId = self::insertOrderDetails($value,$line_item, $mainOrderId);
                        $LineItem = self::insertOrderLineItems($value,$line_item, $mainOrderId);
                        $customerInfo = self::insertOrderCustomer($value,$line_item, $mainOrderId);

                    }
                }
            }
        }
        //$getOrderInfo = OrderDetails::get();
        $getOrderList = OrderDetails::groupBy('order_number')->orderBy('id','asc')->get()->toArray();
        return view('shopify-app::tool.order',compact('getProducts','getOrderList','getOrderInfo'));
    }


    /*
      |--------------------------------------------------------------------------
      | IdesignIbuy orders Details  API Controller
      |--------------------------------------------------------------------------
      |
      |
     */

    public function insertOrderDetails($value,$line_item, $mainOrderId)
    {
        //main order
        $order_list_arr['name'] =  $value->name;
        $order_list_arr['shpoify_order_id'] =  $value->id;
        $order_list_arr['line_item_id'] = $line_item->id;
        $order_list_arr['order_number'] =  $value->order_number;
        $order_list_arr['customer_name'] =  $value->billing_address->name;
        $order_list_arr['app_id'] =  $value->app_id;
        $order_list_arr['checkout_id'] =  $value->checkout_id;
        $order_list_arr['token'] =  $value->token;
        $order_list_arr['gateway'] =  $value->gateway;
        $order_list_arr['total_price'] =  $value->total_price;
        $order_list_arr['subtotal_price'] =  $value->subtotal_price;
        $order_list_arr['currency'] =  $value->currency;
        $order_list_arr['cart_token'] =  $value->cart_token;
        $order_list_arr['checkout_token'] =  $value->checkout_token;
        $order_list_arr['order_status_url'] =  $value->order_status_url;

        return OrderDetails::insertGetId($order_list_arr);

    }

    /*
      |--------------------------------------------------------------------------
      | IdesignIbuy orders Line Items  API Controller
      |--------------------------------------------------------------------------
      |
      |
     */

    public function insertOrderLineItems($value,$line_item, $mainOrderId)
    {
        //list of items
        $lineItem_arr['order_id'] = $mainOrderId;
        $lineItem_arr['line_item_id'] = $line_item->id;
        $lineItem_arr['variant_id'] = $line_item->variant_id;
        $lineItem_arr['title'] = $line_item->title;
        $lineItem_arr['quantity'] = $line_item->quantity;
        $lineItem_arr['sku'] = $line_item->sku;
        $lineItem_arr['variant_title'] = $line_item->variant_title;
        $lineItem_arr['vendor'] = $line_item->vendor;
        $lineItem_arr['fulfillment_service'] = $line_item->fulfillment_service;
        $lineItem_arr['product_id'] = $line_item->product_id;
        $lineItem_arr['price'] = $line_item->price;
        $lineItem_arr['requires_shipping'] = $line_item->requires_shipping;
        $lineItem_arr['taxable'] = $line_item->taxable;

        return OrderLineItem::insertGetId($lineItem_arr);

    }

    /*
      |--------------------------------------------------------------------------
      | IdesignIbuy orders Customer Information  API Controller
      |--------------------------------------------------------------------------
      |
      |
     */

    public function insertOrderCustomer($value,$line_item, $mainOrderId)
    {


        //customer info
        $customer_arr['order_id'] = $mainOrderId;
        $customer_arr['line_item_id'] = $line_item->id;
        $customer_arr['billing_address_name'] =$value->billing_address->name;
        $customer_arr['billing_address_first_name'] =$value->billing_address->first_name;
        $customer_arr['billing_address_last_name'] =$value->billing_address->last_name;
        $customer_arr['billing_address_address1'] =$value->billing_address->address1;
        $customer_arr['billing_address_address2'] =$value->billing_address->address2;
        $customer_arr['billing_address_phone'] =$value->billing_address->phone;
        $customer_arr['billing_address_city'] =$value->billing_address->city;
        $customer_arr['billing_address_zip'] =$value->billing_address->zip;
        $customer_arr['billing_address_province'] =$value->billing_address->province;
        $customer_arr['billing_address_country'] =$value->billing_address->country;
        $customer_arr['billing_address_company'] =$value->billing_address->company;
        $customer_arr['billing_address_latitude'] =$value->billing_address->latitude;
        $customer_arr['billing_address_longitude'] =$value->billing_address->longitude;
        $customer_arr['billing_address_province_code'] =$value->billing_address->province_code;
        $customer_arr['billing_address_country_code'] =$value->billing_address->country_code;
        $customer_arr['shipping_address_name'] = $value->shipping_address->name;
        $customer_arr['shipping_address_first_name'] = $value->shipping_address->first_name;
        $customer_arr['shipping_address_last_name'] = $value->shipping_address->last_name;
        $customer_arr['shipping_address_address1'] = $value->shipping_address->address1;
        $customer_arr['shipping_address_address2'] = $value->shipping_address->address2;
        $customer_arr['shipping_address_phone'] = $value->shipping_address->phone;
        $customer_arr['shipping_address_city'] = $value->shipping_address->city;
        $customer_arr['shipping_address_zip'] = $value->shipping_address->zip;
        $customer_arr['shipping_address_province'] = $value->shipping_address->province;
        $customer_arr['shipping_address_country'] = $value->shipping_address->country;
        $customer_arr['shipping_address_company'] = $value->shipping_address->company;
        $customer_arr['shipping_address_latitude'] = $value->shipping_address->latitude;
        $customer_arr['shipping_address_longitude'] = $value->shipping_address->longitude;
        $customer_arr['shipping_address_province_code'] = $value->shipping_address->province_code;
        $customer_arr['shipping_address_country_code'] = $value->shipping_address->country_code;
        $customer_arr['customer_id'] = $value->customer->id;
        $customer_arr['customer_email'] = $value->customer->email;
        $customer_arr['customer_first_name'] = $value->customer->first_name;
        $customer_arr['customer_last_name'] = $value->customer->last_name;
        $customer_arr['customer_total_spent'] = $value->customer->total_spent;
        $customer_arr['customer_last_order_id'] = $value->customer->last_order_id;
        $customer_arr['customer_phone'] = $value->customer->phone;
        $customer_arr['customer_tags'] = $value->customer->tags;
        $customer_arr['customer_last_order_name'] = $value->customer->last_order_name;
        $customer_arr['customer_currency'] = $value->customer->currency;
        $customer_arr['default_address_id'] = $value->customer->default_address->id;
        $customer_arr['default_address_customer_id'] = $value->customer->default_address->customer_id;
        $customer_arr['default_address_first_name'] = $value->customer->default_address->first_name;
        $customer_arr['default_address_last_name'] = $value->customer->default_address->last_name;
        $customer_arr['default_address_company'] = $value->customer->default_address->company;
        $customer_arr['default_address_address1'] = $value->customer->default_address->address1;
        $customer_arr['default_address_address2'] = $value->customer->default_address->address2;
        $customer_arr['default_address_city'] = $value->customer->default_address->city;
        $customer_arr['default_address_province'] = $value->customer->default_address->province;
        $customer_arr['default_address_country'] = $value->customer->default_address->country;
        $customer_arr['default_address_zip'] = $value->customer->default_address->zip;
        $customer_arr['default_address_phone'] = $value->customer->default_address->phone;
        $customer_arr['default_address_name'] = $value->customer->default_address->name;
        $customer_arr['default_address_province_code'] = $value->customer->default_address->province_code;
        $customer_arr['default_address_country_code'] = $value->customer->default_address->country_code;
        $customer_arr['default_address_country_name'] = $value->customer->default_address->country_name;


        return OrderCustomerDetails::insertGetId($customer_arr);

    }

    /*
      |--------------------------------------------------------------------------
      | IdesignIbuy Fetch orders Details  API Controller
      |--------------------------------------------------------------------------
      |
      |
     */

    public function orderDetails($id)
    {
        //dd($id);
        $orderId = $id;
        $getProducts = Products::get(); //sidebar
        $getLineItemInfo = OrderLineItem::where('order_id', $id)->get(); //sidebar
        $getCustomerInfo = OrderCustomerDetails::where('order_id', $id)->get(); //sidebar
        return view('shopify-app::tool.order-detail',compact('getProducts','getLineItemInfo','getCustomerInfo', 'orderId'));
    }


    /******Order******/

    /*public function order(){
        $getCategoryList = DB::table('product_category')
            ->where('product_category.product_id', 1)
            ->join('products', 'product_category.product_id', 'products.id')
            ->select('product_category.product_id', 'product_category.category_description', 'product_category.status', 'product_category.id', 'product_category.status', 'product_category.category', 'products.product_name')->get();

        return view('shopify-app::tool.order', compact('getCategoryList'));
    }

    public function orderDetails(){
        $getCategoryList = DB::table('product_category')
            ->where('product_category.product_id', 1)
            ->join('products', 'product_category.product_id', 'products.id')
            ->select('product_category.product_id', 'product_category.category_description', 'product_category.status', 'product_category.id', 'product_category.status', 'product_category.category', 'products.product_name')->get();

        return view('shopify-app::tool.order-detail', compact('getCategoryList'));
    }*/

    /****************************************************************************/

    /******Store New Product******/

    public function store(Request $request)
    {
        $product = new Products();

        if ($file = $request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/tool/images/products/';
            $file->move($destinationPath, $fileName);

            $product->status = false;
            if ($request->status) {
                $product->status = true;
            }

            $product->product_name = $request->product_name;
            $product->link_name = $request->product_link_name;
            $product->status = $product->status;
            $product->product_image = $fileName;
            /*$product->product_hover_image = $fileName_hover;*/
        }

        $product->save();
        \session()->put('success', 'product Added successfully!');
        Toastr::success('Product Added successfully', 'Success!');
        return redirect()->route('dashboard');
    }

    /******Edit New Product******/

    public function editProduct($id)
    {
        $getProducts = Products::where('id', $id)->get(); //sidebar
        $getProductColor = ProductColor::where('id', $id)->get();
        $getProductCategory = ProductCategory::get();

        return view('shopify-app::tool.edit-product', compact('getProductCategory', 'getProducts', 'getProductColor'));
    }

    /******Update New Product******/

    public function updateProduct(Request $request, $id)
    {
        $status = false;
        if ($request->status) {
            $status = true;
        }
        if ($file = $request->hasFile('product_image')) {
            $file = $request->file('product_image');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/tool/images/products/';
            $file->move($destinationPath, $fileName);
            $product = array(
                'product_name' => $request->product_name,
                'link_name' => $request->product_link_name,
                'status' => $status,
                'product_image' => $fileName,
            );
            DB::table('products')
                ->where('id', $id)
                ->update($product);
        } else {
            $product = array(
                'link_name' => $request->product_link_name,
                'product_name' => $request->product_name,
                'status' => $status,
            );
            DB::table('products')
                ->where('id', $id)
                ->update($product);
        }
        \session()->put('success', 'Product Updated successfully!');
        Toastr::success('Product Updated successfully', 'Success!');
        return redirect()->route('dashboard');
    }

    /******Delete New Product******/

    public function deleteProduct($id)
    {
        $deleteProduct = Products::where('id', $id)->delete();
        $deleteProductParts = ProductPart::where('product_id', $id)->delete();
        \session()->put('success', 'Product Deleted successfully!');
        Toastr::success('Product Deleted successfully', 'Success!');
        return redirect()->route('dashboard');
    }

    /****************************************************************************/

    /******Manage Product******/

    public function manageProduct($id)
    {
        $getProductInfo = Products::where('id', $id)->get();
        $getCategoryList = DB::table('product_category')
            ->join('products', 'product_category.product_id', 'products.id')
            ->join('static_category', 'product_category.static_category_id', 'static_category.id')
            ->select('product_category.category_icon_class','product_category.product_id','static_category.static_category_name', 'product_category.category_description', 'product_category.status', 'product_category.id', 'product_category.status', 'product_category.category', 'products.product_name')
            ->where('product_category.product_id', $id)
            ->get();
        $getStyleList = DB::table('product_style')
            ->join('products', 'product_style.product_id', 'products.id')
            ->select('product_style.product_id', 'product_style.icon_class', 'product_style.style_description', 'product_style.status', 'product_style.id', 'product_style.status', 'product_style.style', 'products.product_name')
            ->where('product_style.product_id', $id)->get();
        $getProductColor = DB::table('product_colors')
            //->join('product_category', 'product_colors.category_id', 'product_category.id')
            //->join('product_types','product_types.id','product_colors.type_id')
            ->select('product_colors.product_id','product_colors.display_image','product_colors.id','product_colors.color_name','product_colors.color_description','product_colors.fabric_price','product_colors.large_image','product_colors.fabric_image','product_colors.status','product_colors.category_id')
            ->where('product_colors.product_id', $id)->get();
        $getProductButton = DB::table('product_button')
            ->join('products', 'product_button.product_id', 'products.id')
            ->select('product_button.product_id', 'product_button.icon_class', 'product_button.button_description', 'product_button.status', 'product_button.id', 'product_button.status', 'product_button.button','products.id as prod_id','products.product_name','product_button.button_image','product_button.icon_class')
            ->where('product_button.product_id', $id)->get();
        $getProductThread = DB::table('product_thread')
            ->join('products', 'product_thread.product_id', 'products.id')
            ->select('product_thread.product_id', 'product_thread.price','product_thread.icon_class', 'product_thread.thread_description', 'product_thread.status', 'product_thread.id', 'product_thread.status', 'product_thread.thread','products.id as prod_id','products.product_name','product_thread.thread_image','product_thread.icon_class')
            ->where('product_thread.product_id', $id)->get();

        $getProductPocketSquare = DB::table('product_pocket_square')
            ->join('products', 'product_pocket_square.product_id', 'products.id')
            ->select('product_pocket_square.product_id', 'product_pocket_square.price','product_pocket_square.icon_class', 'product_pocket_square.pocket_square_description', 'product_pocket_square.status', 'product_pocket_square.id', 'product_pocket_square.status', 'product_pocket_square.pocket_square','products.id as prod_id','products.product_name','product_pocket_square.pocket_square_image','product_pocket_square.icon_class')
            ->where('product_pocket_square.product_id', $id)->get();
        $getProductLining = DB::table('product_lining')
            ->join('products', 'product_lining.product_id', 'products.id')
            ->select('product_lining.product_id', 'product_lining.price','product_lining.icon_class', 'product_lining.lining_description', 'product_lining.status', 'product_lining.id', 'product_lining.status', 'product_lining.lining','products.id as prod_id','products.product_name','product_lining.lining_image','product_lining.icon_class')
            ->where('product_lining.product_id', $id)->get();
        $getProductAccent = DB::table('product_accent')
            ->join('products', 'product_accent.product_id', 'products.id')
            ->select('product_accent.product_id', 'product_accent.price','product_accent.icon_class', 'product_accent.accent_description', 'product_accent.status', 'product_accent.id', 'product_accent.status', 'product_accent.accent','products.id as prod_id','products.product_name','product_accent.accent_image','product_accent.icon_class')
            ->where('product_accent.product_id', $id)->get();

        return view('shopify-app::tool.manage-product', compact('getProductColor','getProductInfo', 'getColorList', 'getCategoryList','getStyleList','getProductButton','getProductThread','getProductPocketSquare','getProductLining','getProductAccent'));

    }


    /****************************************************************************/

    /******List Category******/

    public function listCategory($id)
    {
        $getProducts = Products::get(); //sidebar
        $getProductInfo = Products::where('id', $id)->get();
        $getCategoryList = DB::table('product_category')
            ->join('static_category', 'product_category.static_category_id', 'static_category.id')
            ->join('products', 'product_category.product_id', 'products.id')
            ->select('product_category.category_icon_class','product_category.product_id', 'static_category.static_category_name','product_category.category_description', 'product_category.status', 'product_category.id', 'product_category.category', 'products.product_name')->get();
        return view('shopify-app::tool.manage-product', compact('getProductInfo', 'getProducts', 'getCategoryList'));
    }

    /******Add New Category******/

    public function addNewCategory($id)
    {
        $getProducts = Products::where('id', $id)->get(); //sidebar
        $getProductsList = Products::get(); //sidebar
        $getTypeList = ProductType::where('product_id', $id)->get();
        $getStaticCategory = DB::table('static_category')->get();

        return view('shopify-app::tool.add-category', compact('getStaticCategory','getProducts', 'getProductsList', 'getTypeList'));
    }

    /******Store New Category******/

    public function storeNewCategory(Request $request, $id)
    {
        $productCategory = new ProductCategory();
        $productCategory->product_id = $id;
        $productCategory->category = $request->category_name;
        $productCategory->category_description = $request->category_description;
        $productCategory->static_category_id = $request->static_category;
        $productCategory->category_icon_class = $request->category_icon_class;
        //$productCategory->type_id = $request->type_id;
        $productCategory->status = false;
        if ($request->status) {
            $productCategory->status = true;
        }
        $productCategory->save();

        $getProducts = Products::get(); //sidebar
        $getProductColor = ProductColor::where('id', $id)->get();
        \session()->put('success', 'New Category Added successfully!');
        Toastr::success('New Category Added successfully', 'Success!');
        return redirect()->route('manage-product', $id);
    }

    /******Edit New Category******/

    public function editNewCategory($id)
    {
        $ProdId = $id;
        $getProducts = Products::get(); //sidebar
        $getTypeList = ProductType::get();
        $getCategoryEdit = ProductCategory::where('id', $id)->get();
        $getStaticCategory = DB::table('static_category')->get();
        return view('shopify-app::tool.edit-category', compact('getStaticCategory','ProdId', 'getProducts', 'getTypeList', 'getCategoryEdit'));
    }

    /******Update New Category******/

    public function updateNewCategory(Request $request, $id)
    {
        //dd($request);
        $status = false;
        if ($request->status) {
            $status = true;
        }

        $ProductCategory = array(
            'category' => $request->category_name,
            'category_description' => $request->category_description,
            'product_id' => $request->product_id,
            'static_category_id' => $request->static_category,
            'category_icon_class' => $request->category_icon_class,
            //  'type_id' => $request->product_id,
            'status' => $status,
        );

        DB::table('product_category')
            ->where('id', $id)
            ->update($ProductCategory);

        \session()->put('success', 'Category Updated successfully!');
        Toastr::success('Category Updated successfully', 'Success!');
        return redirect()->route('list-category', $request->product_id);
    }

    /******Delete New Category******/

    public function deleteNewCategory(Request $request, $id, $prodId)
    {
        $deletecategory = ProductCategory::where('id', $id)->delete();
        \session()->put('success', 'Category Deleted successfully!');
        Toastr::success('Category Deleted successfully', 'Success!');
        return redirect()->route('list-category', $prodId);
    }

    /****************************************************************************/

    /******List Color *****/

    public function listColor($id)
    {
        //dd($id);
        $getProducts = Products::get(); //sidebar
        /*$getProductColor = ProductColor::where('product_id', $id)->get(); */
        /*$getProductColor = DB::table('product_colors')
            ->join('product_category', 'product_colors.category_id', 'product_category.id')
            //->join('product_types','product_types.id','product_colors.type_id')
            ->select('product_category.category as category_name','product_colors.product_id','product_colors.display_image','product_colors.id','product_colors.color_name','product_colors.color_description','product_colors.large_image','product_colors.fabric_image','product_colors.status','product_colors.category_id')
            ->where('product_colors.product_id', $id)
            ->where('product_category.product_id', $id)
            ->where('product_category.status', 1)
            ->where('product_colors.status', 1)->get();*/

        $getProductColor = DB::table('product_colors')
            ->select('product_colors.product_id','product_colors.display_image','product_colors.id','product_colors.color_name','product_colors.color_description','product_colors.fabric_price','product_colors.large_image','product_colors.fabric_image','product_colors.status','product_colors.category_id')
            ->where('product_colors.product_id', $id)
//            ->where('product_colors.status', 1)
            ->get();
        $prodId = $id;
        $getProductInfo = Products::where('id', $id)->get();

        return view('shopify-app::tool.list-fabric',compact('prodId','getProducts','getProductInfo','getProductColor'));
    }

    /******Add New Color *****/

    public function addNewColor($id)
    {
        $getProducts = Products::get(); //sidebar
        $getProductInfo = Products::where('id', $id)->get();
        $getTypeList = ProductType::where('product_id', $id)->get();
        $getCategoryList = ProductCategory::where('product_id', $id)->where('status', '1')->get();
        $getMaterialParentList = DB::table('product_category')
            ->select('id','category')
            ->where('static_category_id', 1)
            ->where('product_category.product_id', $id)
            ->get();
        $getPatternParentList = DB::table('product_category')
            ->select('id','category')
            ->where('static_category_id', 2)
            ->where('product_category.product_id', $id)
            ->get();
        $getSeasonParentList = DB::table('product_category')
            ->select('id','category')
            ->where('static_category_id', 3)
            ->where('product_category.product_id', $id)
            ->get();
        $getColorParentList = DB::table('product_category')
            ->select('id','category')
            ->where('static_category_id', 4)
            ->where('product_category.product_id', $id)
            ->get();
        $getCategoryParentList = DB::table('product_category')
            ->select('id','category')
            ->where('static_category_id', 5)
            ->where('product_category.product_id', $id)
            ->get();

        return view('shopify-app::tool.add-color', compact('getMaterialParentList','getPatternParentList','getSeasonParentList','getColorParentList','getCategoryParentList','getProducts', 'getProductInfo', 'getTypeList', 'getCategoryList'));
    }

    /******store New Color *****/

    public function storeNewColor(Request $request, $id)
    {
        if(($file = $request->hasFile('fabric_thumb')) && ($file = $request->hasFile('display_image')) && ($file = $request->hasFile('large_image')))
        {
            $file = $request->file('fabric_thumb');
            $file_thumb = $request->file('display_image');
            $file_thumb_large = $request->file('large_image');

            $fileName = $file->getClientOriginalName() ;
            $fileName_thumb = $file_thumb->getClientOriginalName() ;
            $fileName_large_thumb = $file_thumb_large->getClientOriginalName() ;

            if($id == 1)
            {
                $destinationPath = public_path().'/tool/images/fabric/shirt/' ;
                $destinationPath_thumb = public_path().'/tool/images/display/shirt/' ;
                $destinationPath_large_thumb = public_path().'/tool/images/large/shirt/' ;
            }else{
                $destinationPath = public_path().'/tool/images/fabric/suit/' ;
                $destinationPath_thumb = public_path().'/tool/images/display/suit/' ;
                $destinationPath_large_thumb = public_path().'/tool/images/large/suit/' ;
            }

            $file->move($destinationPath,$fileName);
            $file_thumb->move($destinationPath_thumb,$fileName_thumb);
            $file_thumb_large->move($destinationPath_large_thumb,$fileName_large_thumb);

            $productColor = new ProductColor();
            $productColor->product_id = $id;
            //$productColor->type_id = $request->type_id;
            $productColor->category_id = $request->category_id;
            $productColor->color_name = $request->color_name;
            $productColor->color_description = $request->color_description;
            $productColor->fabric_image = $fileName;
            $productColor->display_image = $fileName_thumb;
            $productColor->large_image = $fileName_large_thumb;
            $productColor->fabric_price = $request->fabric_price;
            $productColor->material_parent = $request->material_category_get;
            $productColor->pattern_parent = $request->pattern_category_get;
            $productColor->season_parent = $request->season_category_get;
            $productColor->color_parent = $request->color_category_get;
            $productColor->category_parent = $request->category_category_get;

            $productColor->status = false;
            if ($request->status) {
                $productColor->status = true;
            }

            $productColor->save();
            //shirt image genration helper
            if ($id == 1) {
                GlowMaskShirtImageGenerator::ShirtImageGenerator($productColor->id, $fileName_thumb, $destinationPath_thumb);
            }
            //suit image genration helper
            if ($id == 2) {
                GlowMaskImageGenerator::ImageGenerator($productColor->id, $fileName_thumb, $destinationPath_thumb);
            }

            \session()->put('success', 'New color Added successfully!');
            Toastr::success('New color Added successfully', 'Success!');
            return redirect()->route('manage-product', $id);
        }
    }

    /******Edit New Color *****/

    public function editNewColor($id)
    {
        $getProducts = Products::get(); //sidebar
        $getProductColor = ProductColor::where('id', $id)->get();
        if (isset($getProductColor)) {
            $getProductCategory = ProductCategory::get();
            $productId = $getProductColor[0]->product_id;
            $getMaterialParentList =
                DB::table('product_category')
                    ->select('id', 'category')
                    ->where('static_category_id', 1)
                    ->where('product_id', $productId)
                    ->get();
            $getPatternParentList =
                DB::table('product_category')
                    ->select('id', 'category')
                    ->where('static_category_id', 2)
                    ->where('product_id', $productId)
                    ->get();
            $getSeasonParentList =
                DB::table('product_category')
                    ->select('id', 'category')
                    ->where('static_category_id', 3)
                    ->where('product_id', $productId)
                    ->get();
            $getColorParentList =
                DB::table('product_category')
                    ->select('id', 'category')
                    ->where('static_category_id', 4)
                    ->where('product_id', $productId)
                    ->get();
            $getCategoryParentList =
                DB::table('product_category')
                    ->select('id', 'category')
                    ->where('static_category_id', 5)
                    ->where('product_id', $productId)
                    ->get();

            return view('shopify-app::tool.edit-color', compact('getMaterialParentList', 'getPatternParentList', 'getSeasonParentList', 'getColorParentList', 'getCategoryParentList', 'getProductCategory', 'getProducts', 'getProductColor'));
        }
        else {
            \session()->put('error','Requested Color not found!');
            Toastr::error('Requested Color not found', 'Error!');
            return redirect()->route('list-color',[$getProductColor[0]->product_id]);
        }
    }

    /******Update New Color *****/

    public function updateNewColor(Request $request, $id)
    {
        if (($request->hasFile('fabric_image')) && ($request->hasFile('display_image')) && ($request->hasFile('large_image'))) {
            $file = $request->file('fabric_image');
            $file_thumb = $request->file('display_image');
            $file_thumb_large = $request->file('large_image');

            $fileName = $file->getClientOriginalName() ;
            $fileName_thumb = $file_thumb->getClientOriginalName() ;
            $fileName_thumb_large = $file_thumb_large->getClientOriginalName() ;

            if ($request->product_id == 1) {
                $destinationPath = public_path().'/tool/images/fabric/shirt/' ;
                $destinationPath_thumb = public_path().'/tool/images/display/shirt/' ;
                $destinationPath_large_thumb = public_path().'/tool/images/large/shirt/' ;
            } else {
                $destinationPath = public_path().'/tool/images/fabric/suit/' ;
                $destinationPath_thumb = public_path().'/tool/images/display/suit/' ;
                $destinationPath_large_thumb = public_path().'/tool/images/large/suit/' ;
            }
            $file->move($destinationPath,$fileName);
            $file_thumb->move($destinationPath_thumb,$fileName_thumb);
            $file_thumb_large->move($destinationPath_large_thumb,$fileName_thumb_large);

            $status = false;
            if ($request->status) {
                $status = true;
            }
            $productColor = ProductColor::find($id);
//            $productColor->product_id = $id;
//            $productColor->type_id = $request->type_id;
            $productColor->category_id = $request->category_id;
            $productColor->color_name = $request->color_name;
            $productColor->color_description = $request->color_description;
            $productColor->fabric_image = $fileName;
            $productColor->display_image = $fileName_thumb;
            $productColor->large_image = $fileName_thumb_large;
            $productColor->fabric_price = $request->fabric_price;
            $productColor->material_parent = $request->material_category_get;
            $productColor->pattern_parent = $request->pattern_category_get;
            $productColor->season_parent = $request->season_category_get;
            $productColor->color_parent = $request->color_category_get;
            $productColor->category_parent = $request->category_category_get;
            $productColor->status = $status;
            $productColor->save();

            //shirt image genration helper
            if ($request->product_id == 1) {
                GlowMaskShirtImageGenerator::ShirtImageGenerator($id, $fileName_thumb, $destinationPath_thumb);
            }
            //suit image genration helper
            if ($request->product_id == 2) {
                GlowMaskImageGenerator::ImageGenerator($id, $fileName_thumb, $destinationPath_thumb);
            }

        } else {
            $status = false;
            if($request->status)
            {
                $status = true;
            }
            $productColor = ProductColor::find($id);
//            $productColor->product_id = $id;
//            $productColor->type_id = $request->type_id;
            $productColor->category_id = $request->category_id;
            $productColor->color_name = $request->color_name;
            $productColor->color_description = $request->color_description;
            $productColor->fabric_image = $request->fabric_image_hidden;
            $productColor->display_image = $request->display_thumb_image_hidden;
            $productColor->large_image = $request->large_thumb_image_hidden;
            $productColor->fabric_price = $request->fabric_price;
            $productColor->material_parent = $request->material_category_get;
            $productColor->pattern_parent = $request->pattern_category_get;
            $productColor->season_parent = $request->season_category_get;
            $productColor->color_parent = $request->color_category_get;
            $productColor->category_parent = $request->category_category_get;
            $productColor->status = $status;
            $productColor->save();

        }

        \session()->put('success','Color Updated successfully!');
        Toastr::success('Color Updated successfully', 'Success!');
        return redirect()->route('list-color',[$request->product_id]);
//        return redirect()->route('manage-product',[$request->product_id]);

    }

    /******Delete Color *****/

    public function deleteNewColor(Request $request, $id)
    {
        //dd($id);
        $deleteColor = ProductColor::where('id', $id)->delete();
        \session()->put('success','Color Deleted successfully!');
        Toastr::success('Color Deleted successfully', 'Success!');
        return redirect()->route('list-color',[1]);
//        return redirect()->route('manage-product', 1);
    }


    /****************************************************************************/

    /******List Style******/

    public function listStyle($id)
    {
        $getProducts = Products::get(); //sidebar
        $getProductInfo = Products::where('id', $id)->get();
        $getStyleList = DB::table('product_style')
            ->join('products', 'product_style.product_id', 'products.id')
            ->select('product_style.product_id', 'product_style.style_description', 'product_style.status', 'product_style.id', 'product_style.style', 'products.product_name')
            ->where('product_style.product_id', $id)->get();

        return view('shopify-app::tool.list-style', compact('getProductInfo', 'getProducts', 'getStyleList'));
    }

    /******Add New Style******/

    public function addNewStyle($id)
    {
        $getProducts = Products::where('id', $id)->get(); //sidebar
        $getProductsList = Products::get(); //sidebar
        $getTypeList = ProductType::where('product_id', $id)->get();

        return view('shopify-app::tool.add-style', compact('getProducts', 'getProductsList', 'getTypeList'));
    }

    /******Store New Style******/

    public function storeNewStyle(Request $request, $id)
    {
        $productStyle = new ProductStyle();
        $productStyle->product_id = $id;
        $productStyle->style = $request->style_name;
        $productStyle->style_description = $request->style_description;
        $productStyle->icon_class = $request->icon_class;
        //$productStyle->type_id = $request->type_id;
        $productStyle->status = false;
        if ($request->status) {
            $productStyle->status = true;
        }
        $productStyle->save();

        $getProducts = Products::get(); //sidebar
        $getProductColor = ProductColor::where('id', $id)->get();
        \session()->put('success', 'New Style Added successfully!');
        Toastr::success('New Style Added successfully', 'Success!');
        return redirect()->route('manage-product', [$id]);
    }

    /******Edit New Style******/

    public function editNewStyle($id)
    {
        $ProdId = $id;
        $getProducts = Products::get(); //sidebar
        $getTypeList = ProductType::get();
        $getStyleEdit = ProductStyle::where('id', $id)->get();
        return view('shopify-app::tool.edit-style', compact('ProdId', 'getProducts', 'getTypeList', 'getStyleEdit'));
    }

    /******Update New Style******/

    public function updateNewStyle(Request $request, $id)
    {
        //dd($request);
        $status = false;
        if ($request->status) {
            $status = true;
        }

        $ProductStyle = array(
            'style' => $request->style_name,
            'style_description' => $request->style_description,
            'product_id' => $request->product_id,
            'icon_class' => $request->icon_class,
            //  'type_id' => $request->product_id,
            'status' => $status,
        );

        DB::table('product_style')
            ->where('id', $id)
            ->update($ProductStyle);

        \session()->put('success', 'Style Updated successfully!');
        Toastr::success('Style Updated successfully', 'Success!');
        return redirect()->route('manage-product', [$request->product_id]);
    }

    /******Delete New Style******/

    public function deleteNewStyle(Request $request, $id, $prodId)
    {
        $deletestyle = ProductStyle::where('id', $id)->delete();
        \session()->put('success', 'Style Deleted successfully!');
        Toastr::success('Style Deleted successfully', 'Success!');
        return redirect()->route('list-style', [$id,$prodId]);
    }

    /****************************************************************************/

    /******List Style Parts******/

    public function listStyleParts($id, $prodId)
    {
        //dd($prodId);
        $getProducts = Products::get(); //sidebar
        $getProductInfo = Products::where('id', $id)->get();
        $geStylePartsList = DB::table('product_style_parts')
            ->join('products', 'product_style_parts.product_id', 'products.id')
            ->join('product_style', 'product_style_parts.style_id', 'product_style.id')
            ->select('product_style.style','product_style_parts.product_id','product_style_parts.icon_class','product_style_parts.price', 'product_style_parts.style_parts_description', 'product_style_parts.status', 'product_style_parts.id', 'product_style_parts.style_parts', 'products.product_name')->where('style_id', $id)->get();
        $style_id = $id;

        return view('shopify-app::tool.list-style-parts', compact('prodId','style_id','getProductsList', 'getProductInfo', 'getProducts', 'geStylePartsList'));
    }

    /******Add New StyleParts******/

    public function addNewStyleParts($id, $prodId)
    {
        $getProducts = Products::where('id', $id)->get(); //sidebar
        $getProductsList = Products::get(); //sidebar
        $getTypeList = ProductType::where('product_id', $id)->get();
        $style_id = $id;

        return view('shopify-app::tool.add-style-parts', compact('prodId', 'style_id','getProducts', 'getProductsList', 'getTypeList'));
    }

    /******Store New StyleParts******/

    public function storeNewStyleParts(Request $request, $id)
    {

        $chk_id = ProductStyleParts::where('product_id',$id)->where('style_id', $request->style_id)->value('alt_id');
        $cnt_chk_id = (count($chk_id) + 1);

        $productStyleParts = new ProductStyleParts();
        $productStyleParts->product_id = $id;
        $productStyleParts->style_parts = $request->style_parts_name;
        $productStyleParts->style_parts_description = $request->style_parts_description;
        $productStyleParts->alt_id = $cnt_chk_id;
        $productStyleParts->style_id = $request->style_id;
        $productStyleParts->icon_class = $request->icon_class;
        $productStyleParts->price = $request->price;
        //$productStyleParts->type_id = $request->type_id;
        $productStyleParts->status = false;
        if ($request->status) {
            $productStyleParts->status = true;
        }
        $productStyleParts->save();

        $getProductsList = Products::get(); //sidebar
        $getProductColor = ProductColor::where('id', $id)->get();
        \session()->put('success', 'New Style Parts Added successfully!');
        Toastr::success('New Style Parts Added successfully', 'Success!');
        $style_id = $request->style_id;
        $prodId = $id;
        return redirect()->route('list-style-parts', [$request->style_id, $prodId]);
    }

    /******Edit New StyleParts******/

    public function editNewStyleParts($id)
    {
        //dd($id);
        $ProdId = $id;
        $getProducts = Products::get(); //sidebar
        $getTypeList = ProductType::get();
        $getStylePartsEdit = ProductStyleParts::where('id', $id)->get();
        $style_id = (object)['style_id'=>$id];

        return view('shopify-app::tool.edit-new-style-parts', compact('style_id','ProdId', 'getProducts', 'getTypeList', 'getStylePartsEdit'));
    }

    /******Update New StyleParts******/

    public function updateNewStyleParts(Request $request, $id)
    {
        //dd($request);
        $status = false;
        if ($request->status) {
            $status = true;
        }

        $ProductStyleParts = array(
            'style_parts' => $request->style_parts,
            'style_parts_description' => $request->style_parts_description,
            'product_id' => $request->product_id,
            'style_id' => $request->style_id,
            'icon_class' => $request->icon_class,
            'price' => $request->price,
            //  'type_id' => $request->product_id,
            'status' => $status,
        );

        DB::table('product_style_parts')
            ->where('id', $id)
            ->update($ProductStyleParts);

        \session()->put('success', 'Style Parts Updated successfully!');
        Toastr::success('Style Parts Updated successfully', 'Success!');
        return redirect()->route('list-style-parts', [$request->style_id,$request->product_id]);
    }

    /******Delete New StyleParts******/

    public function deleteNewStyleParts(Request $request, $id, $prodId, $styleId)
    {
        $deletestyle = ProductStyleParts::where('id', $id)->delete();
        \session()->put('success', 'Style Parts Deleted successfully!');
        Toastr::success('Style Parts Deleted successfully', 'Success!');
        $style_id = $styleId;
        $prodId = $prodId;
        return redirect()->route('list-style-parts', [$styleId, $prodId]);
    }

    /****************************************************************************/

    /******List Style Parts Types******/

    public function listStylePartsTypes($id, $prodId)
    {
        //dd($prodId);
        $getProducts = Products::get(); //sidebar
        $getProductInfo = Products::where('id', $id)->get();
        $geStylePartsTypesList = DB::table('product_style_parts_types')
            ->join('products', 'product_style_parts_types.product_id', 'products.id')
            ->join('product_style_parts', 'product_style_parts_types.style_parts_id', 'product_style_parts.id')
            ->select('product_style_parts_types.id as type_id','product_style_parts.style_parts as style_name','product_style_parts_types.product_id','product_style_parts_types.icon_class','product_style_parts_types.price', 'product_style_parts_types.style_parts_description', 'product_style_parts_types.status', 'product_style_parts_types.id', 'product_style_parts_types.style_parts', 'products.product_name')
            ->where('product_style_parts_types.style_parts_id', $id)
//            ->where('product_style_parts_types.status', 1)
            ->get();

        $style_id = (object)['style_id'=>$id];

        return view('shopify-app::tool.list-style-parts-types', compact('prodId','style_id','getProductsList', 'getProductInfo', 'getProducts', 'geStylePartsTypesList'));
    }

    /******Add New StylePartsTypes******/

    public function addNewStylePartsTypes($id, $prodId)
    {
        //dd($prodId);
        $getProducts = Products::where('id', $prodId)->get(); //sidebar
        $getProductsList = Products::get(); //sidebar
        $getTypeList = ProductType::where('product_id', $id)->get();
        $getLapelCategory = DB::table('lapel_category')->get();
        $getStaticType = DB::table('static_type')->get();
        $style_id = $id;

        return view('shopify-app::tool.add-style-parts-types', compact('prodId','style_id','getProducts', 'getProductsList', 'getTypeList','getLapelCategory','getStaticType'));
    }

    /******Store New StylePartsTypes******/

    public function storeNewStylePartsTypes(Request $request, $id)
    {

        $chk_id = ProductStylePartsTypes::where('product_id',$id)->where('style_parts_id',$request->style_id)->select('alt_id')->get();
        $cnt_chk_id = (count($chk_id) + 1);

        //dd($request->lapel_category);
        if($request->style_parts_id == '44')
        {
            if($request->lapel_category == null)
            {
                $lapel_category = "Lapel";
            }else{
                $lapel_category = "Lapel Size";
            }
        }else{
            $lapel_category = null;
        }

        if($request->style_parts_id == '43')
        {
            $static_type = $request->static_type;
        }else{
            $static_type = null;
        }

        $productStylePartsTypes = new ProductStylePartsTypes();
        $productStylePartsTypes->product_id = $id;
        $productStylePartsTypes->alt_id = $cnt_chk_id;
        $productStylePartsTypes->static_type_id = $static_type;
        $productStylePartsTypes->style_parts = $request->style_parts_name;
        $productStylePartsTypes->style_parts_description = $request->style_parts_description;
        $productStylePartsTypes->style_parts_id = $request->style_id;
        $productStylePartsTypes->icon_class = $request->icon_class;
        $productStylePartsTypes->lapel_category = $lapel_category;
        $productStylePartsTypes->price = $request->price;
        //$productStylePartsTypes->type_id = $request->type_id;
        $productStylePartsTypes->status = false;
        if ($request->status) {
            $productStylePartsTypes->status = true;
        }
        $productStylePartsTypes->save();

        $getProductsList = Products::get(); //sidebar
        $getProductColor = ProductColor::where('id', $id)->get();
        \session()->put('success', 'New Style Parts Types Added successfully!');
        Toastr::success('New Style Parts Types Added successfully', 'Success!');

        $style_id = $request->style_id;
        $prodId = $id;
        return redirect()->route('list-style-parts-types', [$request->style_id, $id]);
    }

    /******Edit New StylePartsTypes******/

    public function editNewStylePartsTypes($id)
    {
        //dd($id);
        $ProdId = $id;
        $getProducts = Products::get(); //sidebar
        $getTypeList = ProductType::get();
        $getStylePartsTypesEdit = ProductStylePartsTypes::where('id', $id)->get();
        $getStaticType = DB::table('static_type')->get();
        $style_id = $id;

        return view('shopify-app::tool.edit-new-style-parts-types', compact('style_id','ProdId', 'getProducts', 'getTypeList', 'getStylePartsTypesEdit','getStaticType'));
    }

    /******Update New StylePartsTypes******/

    public function updateNewStylePartsTypes(Request $request, $id)
    {
        //dd($request);
        $status = false;
        if ($request->status) {
            $status = true;
        }

        if(($request->style_id == '43' || $request->style_id == '54'))
        {
            $static_type = $request->static_type;
        }else{
            $static_type = null;
        }

        $ProductStylePartsTypes = array(
            'style_parts' => $request->style_parts,
            'style_parts_description' => $request->style_parts_description,
            'static_type_id' => $static_type,
            'alt_id' => $request->cnt_chk_id,
            'product_id' => $request->product_id,
            'style_parts_id' => $request->style_id,
            'icon_class' => $request->icon_class,
            'price' => $request->price,
            //  'type_id' => $request->product_id,
            'status' => $status,
        );

        DB::table('product_style_parts_types')
            ->where('id', $id)
            ->update($ProductStylePartsTypes);

        \session()->put('success', 'Style Parts Types Updated successfully!');
        Toastr::success('Style Parts Types Updated successfully', 'Success!');
        return redirect()->route('list-style-parts-types', [$request->style_id,$request->product_id]);
    }

    /******Delete New StylePartsTypes******/

    public function deleteNewStylePartsTypes(Request $request, $id, $prodId, $styleId)
    {
        $deletestyle = ProductStylePartsTypes::where('id', $id)->delete();
        \session()->put('success', 'Style Parts Types Deleted successfully!');
        Toastr::success('Style Parts Types Deleted successfully', 'Success!');
        return redirect()->route('list-style-parts-types', [$styleId,$prodId]);
    }

    /****************************************************************************/

    /******List Brass Button *****/

    public function listBrassButton($accent_id, $id)
    {
        $prodID = $id;
        $accentId = $accent_id;
        $getProducts = Products::get(); //sidebar
        /*$getProductColor = ProductColor::where('product_id', $id)->get(); */
        $getProductButton = DB::table('product_button')
            ->join('products', 'product_button.product_id', 'products.id')
            ->join('product_accent', 'product_button.accent_id', 'product_accent.id')
            ->select('product_accent.accent as accent_name','product_button.product_id', 'product_button.price','product_button.icon_class','product_button.accent_id', 'product_button.button_description', 'product_button.status', 'product_button.id', 'product_button.status', 'product_button.button','products.id as prod_id','products.product_name','product_button.button_image','product_button.icon_class')
            ->where('product_button.product_id', $id)
            ->where('product_button.accent_id', $accent_id)->get()->toArray();
        $getProductInfo = Products::where('id', $id)->get();
        return view('shopify-app::tool.list-accent',compact('prodID', 'accentId', 'getProducts','getProductInfo','getProductButton'));
    }

    /******Add New Brass Button *****/

    public function addNewBrassButton($id, $accent_id)
    {
        $accent_id = $accent_id;
        //dd($accent_id);
        $getProducts = Products::get(); //sidebar
        $getProductInfo = Products::where('id', $id)->get();
        $getTypeList = ProductType::where('product_id', $id)->get();
        $getProductButton = ProductButton::where('product_id', $id)->get();

        return view('shopify-app::tool.add-brass-button', compact('accent_id','getProducts', 'getProductInfo'));
    }

    /******store New Brass Button *****/

    public function storeNewBrassButton(Request $request, $id)
    {
        $chk_id = ProductButton::where('product_id',$id)->where('accent_id', $request->accent_id)->select('alt_id')->get();
        $cnt_chk_id = (count($chk_id) + 1);

        if(($file = $request->hasFile('brass_button_thumb')))
        {
            $file = $request->file('brass_button_thumb');

            $fileName = $file->getClientOriginalName() ;

            if($id == 1)
            {
                $destinationPath = public_path().'/tool/images/display/shirt/' ;
            }else{
                $destinationPath = public_path().'/tool/images/display/suit/';
            }

            $file->move($destinationPath,$fileName);

            if($id == 1)
            {
                $img_path = 'shirt';
            }else{
                $img_path = 'suit';
            }

            $productButton = new ProductButton();
            $productButton->product_id = $id;
            //$productButton->type_id = $request->type_id;
            $productButton->button = $request->brass_button_name;
            $productButton->accent_id = $request->accent_id;
            $productButton->icon_class = $request->brass_button_icon_class;
            $productButton->alt_id = $cnt_chk_id;
            $productButton->button_description = $request->brass_button_description;
            $productButton->button_image = url('/').'/public/tool/images/display/'.$img_path.'/'.$fileName;
            $productButton->price = $request->brass_button_price;

            $productButton->status = false;
            if ($request->status) {
                $productButton->status = true;
            }

            if($request->accent_id == 2)
            {

                GlowMaskThreadImageGenerator::ThreadImageGenerator($cnt_chk_id, $fileName, $destinationPath);
            }
            if($request->accent_id == 4)
            {
                GlowMaskLiningImageGenerator::LiningImageGenerator($cnt_chk_id, $fileName, $destinationPath);
            }
            $productButton->save();
            \session()->put('success', 'New Brass Button Added successfully!');
            Toastr::success('New Brass Button Added successfully', 'Success!');
            return redirect()->route('manage-product', $id);
        }
    }

    /******Edit Brass Button *****/

    public function editNewBrassButton($id)
    {
        $getProducts = Products::get(); //sidebar
        $getProductButton = ProductButton::where('id', $id)->get();

        return view('shopify-app::tool.edit-brass-button',compact('getProducts','getProductButton'));
    }

    /******Update Brass Button *****/

    public function updateNewBrassButton(Request $request, $id)
    {
        if(($file = $request->hasFile('brass_button_thumb')) )
        {
            $file = $request->file('brass_button_thumb');

            $fileName = $file->getClientOriginalName() ;

            if($request->product_id == 1)
            {
                $destinationPath = public_path().'/tool/images/display/shirt/' ;
            }else{
                $destinationPath = public_path().'/tool/images/display/suit/';
            }

            $file->move($destinationPath,$fileName);

            $status = false;
            if($request->status)
            {
                $status = true;
            }

            $productButton = array(
                //$productButton->product_id = $id;
                //$productButton->type_id = $request->type_id;
                //'category_id' => $request->category_id,
                'product_id' => $request->product_id,
                'button' => $request->brass_button_name,
                'icon_class' => $request->brass_button_icon_class,
                'accent_id' => $request->accent_id,
                'button_description' => $request->brass_button_description,
                'button_image' => $fileName,
                'price' => $request->brass_button_price,
                'status' => $status,
            );
        }else{
            $status = false;
            if($request->status)
            {
                $status = true;
            }

            $productButton = array(
                //$productButton->product_id = $id;
                //$productButton->type_id = $request->type_id;
                //'category_id' => $request->category_id,
                'product_id' => $request->product_id,
                'button' => $request->brass_button_name,
                'accent_id' => $request->accent_id,
                'icon_class' => $request->brass_button_icon_class,
                'button_description' => $request->brass_button_description,
                'button_image' => $request->hidden_brass_button_thumb,
                'price' => $request->brass_button_price,
                'status' => $status,
            );
        }

        DB::table('product_button')
            ->where('id', $id)
            ->update($productButton);

        \session()->put('success','Brass Button Updated successfully!');
        Toastr::success('Brass Button Updated successfully', 'Success!');
        return redirect()->route('manage-product',[$request->product_id]);
    }

    /******Delete Brass Button  *****/

    public function deleteNewBrassButton($id, $prodId)
    {
        $deleteColor = ProductButton::where('id', $id)->delete();
        \session()->put('success','Brass Button Deleted successfully!');
        Toastr::success('Brass Button Deleted successfully', 'Success!');
        return redirect()->route('manage-product', [$prodId]);
    }

    /**
     * @param $productId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addNewThread($productId)
    {
        $getProductInfo = Products::where('id', $productId)->get();
        return view('shopify-app::tool.add-thread', compact('getProductInfo'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeNewThread(Request $request, $id)
    {
        $chk_id = ProductButton::where('product_id',$id)->where('accent_id', $request->accent_id)->select('alt_id')->get();
        $cnt_chk_id = (count($chk_id) + 1);

        if(($file = $request->hasFile('thread_thumb')))
        {
            $file = $request->file('thread_thumb');
            $fileName = $file->getClientOriginalName() ;
            if ($id == 1) {
                $img_path = 'shirt';
                $destinationPath = public_path().'/tool/images/display/shirt/' ;
            } else {
                $img_path = 'suit/thread';
                $destinationPath = public_path().'/tool/images/display/suit/thread/';
            }

            $file->move($destinationPath, $fileName);

            $productButton = new ProductButton();
            $productButton->product_id = $id;
            //$productButton->type_id = $request->type_id;
            $productButton->button = $request->thread_name;
            $productButton->accent_id = $request->accent_id;
//            $productButton->icon_class = $request->thread_icon_class;
            $productButton->icon_class = '';
            $productButton->alt_id = $cnt_chk_id;
            $productButton->button_description = $request->thread_description;
            $productButton->button_image = url('/').'/public/tool/images/display/'.$img_path.'/'.$fileName;
            $productButton->price = $request->thread_price;

            $productButton->status = false;
            if ($request->status) {
                $productButton->status = true;
            }

            GlowMaskThreadImageGenerator::ThreadImageGenerator($cnt_chk_id, $fileName, $destinationPath);

            $productButton->save();
            \session()->put('success', 'New Thread Added successfully!');
            Toastr::success('New Thread Added successfully', 'Success!');
            return redirect()->route('list-brass_button', [$request->accent_id, $id]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editAccentThread($id)
    {
        $getProductThread = ProductButton::find($id);
        return view('shopify-app::tool.edit-thread',compact('getProductThread'));
    }

    /***
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function updateAccentThread(Request $request, $id)
    {
        if (($file = $request->hasFile('thread_thumb'))) {

            $file = $request->file('thread_thumb');
            $fileName = $file->getClientOriginalName();

            if ($request->product_id == 1) {
                $img_path = 'shirt';
                $destinationPath = public_path().'/tool/images/display/shirt/';
            } else {
                $img_path = 'suit/thread';
                $destinationPath = public_path().'/tool/images/display/suit/thread/';
            }

            $file->move($destinationPath, $fileName);

            $status = false;
            if ($request->status) {
                $status = true;
            }
            $productButton = ProductButton::find($id);
//            $productButton->product_id = $request->product_id;
            $productButton->button = $request->thread_name;
            $productButton->button_description = $request->thread_description;
//            $productButton->button_image = $fileName;
            $productButton->button_image = url('/').'/public/tool/images/display/'.$img_path.'/'.$fileName;
            $productButton->price = $request->thread_price;
            $productButton->status = $status;
            $productButton->save();
            GlowMaskThreadImageGenerator::ThreadImageGenerator($productButton->alt_id, $fileName, $destinationPath);
        } else {
            $status = false;
            if($request->status)
            {
                $status = true;
            }

            $productButton = ProductButton::find($id);
//            $productButton->product_id = $request->product_id;
            $productButton->button = $request->thread_name;
            $productButton->button_description = $request->thread_description;
            $productButton->price = $request->thread_price;
            $productButton->status = $status;
            $productButton->save();
        }

        \session()->put('success','Thread Updated successfully!');
        Toastr::success('Thread Updated successfully', 'Success!');
        return redirect()->route('list-brass_button', [2, $request->product_id]);
    }

    /**
     * @param $productId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addNewLining($productId)
    {
        $getProductInfo = Products::where('id', $productId)->get();
        return view('shopify-app::tool.add-lining', compact('getProductInfo'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeNewLining(Request $request, $id)
    {
        $chk_id = ProductButton::where('product_id',$id)->where('accent_id', $request->accent_id)->select('alt_id')->get();
        $cnt_chk_id = (count($chk_id) + 1);

        if(($file = $request->hasFile('lining_thumb')))
        {
            $file = $request->file('lining_thumb');
            $fileName = $file->getClientOriginalName() ;
            if ($id == 1) {
                $img_path = 'shirt';
                $destinationPath = public_path().'/tool/images/display/shirt/' ;
            } else {
                $img_path = 'suit/lining';
                $destinationPath = public_path().'/tool/images/display/suit/lining/';
            }

            $file->move($destinationPath, $fileName);

            $productButton = new ProductButton();
            $productButton->product_id = $id;
            //$productButton->type_id = $request->type_id;
            $productButton->button = $request->lining_name;
            $productButton->accent_id = $request->accent_id;
//            $productButton->icon_class = $request->thread_icon_class;
            $productButton->icon_class = '';
            $productButton->alt_id = $cnt_chk_id;
            $productButton->button_description = $request->lining_description;
            $productButton->button_image = url('/').'/public/tool/images/display/'.$img_path.'/'.$fileName;
            $productButton->price = $request->lining_price;

            $productButton->status = false;
            if ($request->status) {
                $productButton->status = true;
            }

            GlowMaskLiningImageGenerator::LiningImageGenerator($cnt_chk_id, $fileName, $destinationPath);

            $productButton->save();
            \session()->put('success', 'Lining Added successfully!');
            Toastr::success('Lining Added successfully', 'Success!');
            return redirect()->route('list-brass_button', [$request->accent_id, $id]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editNewLining($id)
    {
        $getProductLining = ProductButton::find($id);
        return view('shopify-app::tool.edit-lining',compact('getProductLining'));
    }

    /***
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function updateNewLining(Request $request, $id)
    {
        if (($file = $request->hasFile('lining_thumb'))) {

            $file = $request->file('lining_thumb');
            $fileName = $file->getClientOriginalName();

            if ($request->product_id == 1) {
                $img_path = 'shirt';
                $destinationPath = public_path().'/tool/images/display/shirt/';
            } else {
                $img_path = 'suit/lining';
                $destinationPath = public_path().'/tool/images/display/suit/lining/';
            }

            $file->move($destinationPath, $fileName);

            $status = false;
            if ($request->status) {
                $status = true;
            }
            $productButton = ProductButton::find($id);
//            $productButton->product_id = $request->product_id;
            $productButton->button = $request->lining_name;
            $productButton->button_description = $request->lining_description;
//            $productButton->button_image = $fileName;
            $productButton->button_image = url('/').'/public/tool/images/display/'.$img_path.'/'.$fileName;
            $productButton->price = $request->lining_price;
            $productButton->status = $status;
            $productButton->save();

            GlowMaskLiningImageGenerator::LiningImageGenerator($productButton->alt_id, $fileName, $destinationPath);
        } else {
            $status = false;
            if($request->status)
            {
                $status = true;
            }

            $productButton = ProductButton::find($id);
//            $productButton->product_id = $request->product_id;
            $productButton->button = $request->lining_name;
            $productButton->button_description = $request->lining_description;
            $productButton->price = $request->lining_price;
            $productButton->status = $status;
            $productButton->save();
        }

        \session()->put('success','Lining Updated successfully!');
        Toastr::success('Lining Updated successfully', 'Success!');
        return redirect()->route('list-brass_button', [4, $request->product_id]);
    }

    /**
     * @param $productId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addNewPocketSquare($productId)
    {
        $getProductInfo = Products::where('id', $productId)->get();
        return view('shopify-app::tool.add-pocket-square', compact('getProductInfo'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeNewPocketSquare(Request $request, $id)
    {
        $chk_id = ProductButton::where('product_id',$id)->where('accent_id', $request->accent_id)->select('alt_id')->get();
        $cnt_chk_id = (count($chk_id) + 1);

        if(($file = $request->hasFile('pocket_square_thumb')))
        {
            $file = $request->file('pocket_square_thumb');
            $fileName = $file->getClientOriginalName() ;
            if ($id == 1) {
                $img_path = 'shirt';
                $destinationPath = public_path().'/tool/images/display/shirt/' ;
            } else {
                $img_path = 'suit/pocketsquare';
                $destinationPath = public_path().'/tool/images/display/suit/pocketsquare/';
            }

            $file->move($destinationPath, $fileName);

            $productButton = new ProductButton();
            $productButton->product_id = $id;
            //$productButton->type_id = $request->type_id;
            $productButton->button = $request->pocket_square_name;
            $productButton->accent_id = $request->accent_id;
//            $productButton->icon_class = $request->thread_icon_class;
            $productButton->icon_class = '';
            $productButton->alt_id = $cnt_chk_id;
            $productButton->button_description = $request->pocket_square_description;
            $productButton->button_image = url('/').'/public/tool/images/display/'.$img_path.'/'.$fileName;
            $productButton->price = $request->pocket_square_price;

            $productButton->status = false;
            if ($request->status) {
                $productButton->status = true;
            }

            GlowMaskPocketSquareImageGenerator::PocketSquareImageGenerator($cnt_chk_id, $fileName, $destinationPath);

            $productButton->save();
            \session()->put('success', 'Pocket Square Added successfully!');
            Toastr::success('Pocket Square Added successfully', 'Success!');
            return redirect()->route('list-brass_button', [$request->accent_id, $id]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editNewPocketSquare($id)
    {
        $getProductPs = ProductButton::find($id);
        return view('shopify-app::tool.edit-pocket-square',compact('getProductPs'));
    }

    /***
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function updateNewPocketSquare(Request $request, $id)
    {
        if (($file = $request->hasFile('pocket_square_thumb'))) {

            $file = $request->file('pocket_square_thumb');
            $fileName = $file->getClientOriginalName();

            if ($request->product_id == 1) {
                $img_path = 'shirt';
                $destinationPath = public_path().'/tool/images/display/shirt/';
            } else {
                $img_path = 'suit/pocketsquare';
                $destinationPath = public_path().'/tool/images/display/suit/pocketsquare/';
            }

            $file->move($destinationPath, $fileName);

            $status = false;
            if ($request->status) {
                $status = true;
            }
            $productButton = ProductButton::find($id);
//            $productButton->product_id = $request->product_id;
            $productButton->button = $request->pocket_square_name;
            $productButton->button_description = $request->pocket_square_description;
//            $productButton->button_image = $fileName;
            $productButton->button_image = url('/').'/public/tool/images/display/'.$img_path.'/'.$fileName;
            $productButton->price = $request->pocket_square_price;
            $productButton->status = $status;
            $productButton->save();

            GlowMaskPocketSquareImageGenerator::PocketSquareImageGenerator($productButton->alt_id, $fileName, $destinationPath);
        } else {
            $status = false;
            if($request->status)
            {
                $status = true;
            }

            $productButton = ProductButton::find($id);
//            $productButton->product_id = $request->product_id;
            $productButton->button = $request->pocket_square_name;
            $productButton->button_description = $request->pocket_square_description;
            $productButton->price = $request->pocket_square_price;
            $productButton->status = $status;
            $productButton->save();
        }

        \session()->put('success','Pocket Square Updated successfully!');
        Toastr::success('Pocket Square Updated successfully', 'Success!');
        return redirect()->route('list-brass_button', [3, $request->product_id]);
    }
    /****************************************************************************/


    /****************************************************************************/

    /******List Accent *****/

    public function listAccent($id)
    {
        //dd($id);
        $getProducts = Products::get(); //sidebar
        /*$getProductColor = ProductColor::where('product_id', $id)->get(); */
        $getProductAccent = DB::table('product_accent')
            ->join('products', 'product_accent.product_id', 'products.id')
            ->select('product_accent.product_id', 'product_accent.icon_class', 'product_accent.accent_description', 'product_accent.status', 'product_accent.id', 'product_accent.status', 'product_accent.accent','products.id as prod_id','products.product_name','product_accent.accent_image','product_accent.icon_class')
            ->where('product_accent.product_id', $id)->get();
        $getProductInfo = Products::where('id', $id)->get();
        $prodId = $id;
        return view('shopify-app::tool.list-accent-style',compact('prodId','getProducts','getProductInfo','getProductAccent'));
    }

    /******Add New Accent *****/

    public function addNewAccent($id)
    {
        $getProducts = Products::get(); //sidebar
        $getProductInfo = Products::where('id', $id)->get();
        $getTypeList = ProductType::where('product_id', $id)->get();
        $getProductAccent = ProductAccent::where('product_id', $id)->get();

        return view('shopify-app::tool.add-accent', compact('getProductAccent','getProducts', 'getProductInfo'));
    }

    /******store New Lining *****/

    public function storeNewAccent(Request $request, $id)
    {
        $chk_id = ProductAccent::where('product_id',$id)->select('alt_id')->get();
        $cnt_chk_id = (count($chk_id) + 1);

        $productThread = new ProductAccent();
        $productThread->product_id = $id;
        //$productThread->type_id = $request->type_id;
        $productThread->accent = $request->accent_name;
        $productThread->price = $request->price;
        $productThread->icon_class = $request->accent_icon_class;
        $productThread->alt_id = $cnt_chk_id;
        $productThread->accent_description = $request->accent_description;

        $productThread->status = false;
        if ($request->status) {
            $productThread->status = true;
        }

        $productThread->save();
        \session()->put('success', 'New Accent Added successfully!');
        Toastr::success('New Accent Added successfully', 'Success!');
        return redirect()->route('manage-product', $id);
    }



    /****************************************************************************/



    /****************************************************************************/

    /******List Accent Types******/

    public function listAccentTypes($id, $prodId)
    {
        //dd($prodId);
        $getProducts = Products::get(); //sidebar
        $getProductInfo = Products::where('id', $id)->get();
        $getAccentPartList = DB::table('product_accent_types')
            ->join('products', 'product_accent_types.product_id', 'products.id')
            ->select('product_accent_types.id as type_id','product_accent_types.product_id','product_accent_types.icon_class','product_accent_types.price', 'product_accent_types.accent_parts_description', 'product_accent_types.status', 'product_accent_types.id', 'product_accent_types.accent_parts', 'products.product_name')->where('product_accent_types.style_parts_id', $id)->get();

        $style_id = (object)['style_id'=>$id];

        return view('shopify-app::tool.list-accent-types', compact('prodId','style_id','getProductsList', 'getProductInfo', 'getProducts', 'getAccentPartList'));
    }

    /******Add New Accent Types******/

    public function addNewAccentTypes($id, $prodId)
    {
        //dd($prodId);
        $getProducts = Products::where('id', $prodId)->get(); //sidebar
        $getProductsList = Products::get(); //sidebar
        $getTypeList = ProductType::where('product_id', $id)->get();
        $getLapelCategory = DB::table('lapel_category')->get();
        $getStaticType = DB::table('static_type')->get();
        $style_id = $id;

        return view('shopify-app::tool.add-accent-types', compact('prodId','style_id','getProducts', 'getProductsList', 'getTypeList','getLapelCategory','getStaticType'));
    }

    /******Store New StylePartsTypes******/

    public function storeNewAccentTypes(Request $request, $id)
    {

        $chk_id = ProductStylePartsTypes::where('product_id',$id)->where('style_parts_id',$request->style_id)->select('alt_id')->get();
        $cnt_chk_id = (count($chk_id) + 1);


        $productStylePartsTypes = new ProductStylePartsTypes();
        $productStylePartsTypes->product_id = $id;
        $productStylePartsTypes->alt_id = $cnt_chk_id;
        $productStylePartsTypes->static_type_id = $static_type;
        $productStylePartsTypes->style_parts = $request->style_parts_name;
        $productStylePartsTypes->style_parts_description = $request->style_parts_description;
        $productStylePartsTypes->style_parts_id = $request->style_id;
        $productStylePartsTypes->icon_class = $request->icon_class;
        $productStylePartsTypes->lapel_category = $lapel_category;
        $productStylePartsTypes->price = $request->price;
        //$productStylePartsTypes->type_id = $request->type_id;
        $productStylePartsTypes->status = false;
        if ($request->status) {
            $productStylePartsTypes->status = true;
        }
        $productStylePartsTypes->save();

        $getProductsList = Products::get(); //sidebar
        $getProductColor = ProductColor::where('id', $id)->get();
        \session()->put('success', 'New Accent Types Added successfully!');
        Toastr::success('New Style Parts Types Added successfully', 'Success!');

        $style_id = $request->style_id;
        $prodId = $id;
        return redirect()->route('list-style-parts-types', [$request->style_id, $id]);
    }




    /****************************************************************************************************/
    /****************************************************************************************************/
    /****************************************************************************************************/




    /****************************************************************************************************/

    /***********************
     * export CSV
     **********************/

    public function export(Request $request)
    {
        foreach($request->exportVariant as $key => $expVar)
        {
            $data[] = DB::table('idib_order_item_details')
                ->join('idib_order_details', 'idib_order_item_details.line_item_id', 'idib_order_details.line_item_id')
                ->join('idib_customer_details', 'idib_order_item_details.line_item_id', 'idib_customer_details.line_item_id')
                ->where('idib_order_item_details.variant_id', $expVar)
                //->where('idib_order_item_details.line_item_id', $lineItem)
                ->where('idib_order_item_details.order_id', $request->orderID[0])
                ->select('idib_order_item_details.order_id', 'idib_order_item_details.variant_id', 'idib_order_item_details.title','idib_order_item_details.variant_title', 'idib_order_item_details.quantity', 'idib_order_item_details.price',
                    'idib_order_details.customer_name', 'idib_order_details.gateway', 'idib_order_details.order_status_url',
                    'idib_customer_details.customer_first_name', 'idib_customer_details.customer_last_name', 'idib_customer_details.customer_id', 'idib_customer_details.customer_email',
                    'idib_customer_details.default_address_first_name', 'idib_customer_details.default_address_last_name', 'idib_customer_details.default_address_company', 'idib_customer_details.default_address_address1', 'idib_customer_details.default_address_address2', 'idib_customer_details.default_address_city',
                    'idib_customer_details.default_address_province', 'idib_customer_details.default_address_country', 'idib_customer_details.default_address_zip', 'idib_customer_details.default_address_phone',
                    'idib_customer_details.billing_address_name', 'idib_customer_details.billing_address_address1', 'idib_customer_details.billing_address_address2', 'idib_customer_details.billing_address_phone', 'idib_customer_details.billing_address_zip', 'idib_customer_details.billing_address_province', 'idib_customer_details.billing_address_country',
                    'idib_customer_details.shipping_address_name', 'idib_customer_details.shipping_address_address1', 'idib_customer_details.shipping_address_address2', 'idib_customer_details.shipping_address_phone', 'idib_customer_details.shipping_address_zip', 'idib_customer_details.shipping_address_province', 'idib_customer_details.shipping_address_country'
                )
                ->first();
        }
        //Open file pointer.
        $fp = fopen('export_order/order_'.$request->orderID[0].'.csv', 'w');

        fputcsv($fp, array('Order Id','Variant Id','title', 'Variant Options', 'Quantity', 'Price',
            'Customer Name', 'Payment Gateway', 'Order Status Url',
            'Customer First Name','customer Last Name', 'Customer Id', 'Customer Email',
            'Default First name', 'Default Last Name', 'Default Company','Default Address 1', 'Default Address 2','Default City', 'Default Province', 'Default Country','Default Zip', 'Default Phone',
            'Billing Name', 'Billing Address 1','Billing Address 2', 'Billing Phone', 'Billing Zip', 'Billing Province', 'Billing Country',
            'Shipping Name', 'Shipping Address 1','Shipping Address 2', 'Shipping Phone', 'Shipping Zip', 'Shipping Province', 'Shipping Country'
        ));
        //Loop through the associative array.
        $data_temp = array();
        $data = collect($data);
        $data_temp = $data->toArray();
        foreach ($data_temp as $data_main){
            fputcsv($fp, (array) $data_main);
        }
        //Finally, close the file pointer.
        fclose($fp);
        return 'export_order/order_'.$request->orderID[0].'.csv';
    }

    public function exportAll(Request $request)
    {
        //dd($request->all());

        $time = time();
        foreach($request->exportVariant as $key => $expVar) {
            $data[] = DB::table('idib_order_item_details')
                ->join('idib_order_details', 'idib_order_item_details.line_item_id', 'idib_order_details.line_item_id')
                ->join('idib_customer_details', 'idib_order_item_details.line_item_id', 'idib_customer_details.line_item_id')
                ->where('idib_customer_details.order_id', $expVar)
                ->where('idib_order_item_details.order_id', $expVar)
                ->where('idib_order_details.order_number', $expVar)
                ->select('idib_order_item_details.order_id', 'idib_order_item_details.variant_id', 'idib_order_item_details.title','idib_order_item_details.variant_title', 'idib_order_item_details.quantity', 'idib_order_item_details.price',
                    'idib_order_details.customer_name', 'idib_order_details.gateway', 'idib_order_details.order_status_url',
                    'idib_customer_details.customer_first_name', 'idib_customer_details.customer_last_name', 'idib_customer_details.customer_id', 'idib_customer_details.customer_email',
                    'idib_customer_details.default_address_first_name', 'idib_customer_details.default_address_last_name', 'idib_customer_details.default_address_company', 'idib_customer_details.default_address_address1', 'idib_customer_details.default_address_address2', 'idib_customer_details.default_address_city',
                    'idib_customer_details.default_address_province', 'idib_customer_details.default_address_country', 'idib_customer_details.default_address_zip', 'idib_customer_details.default_address_phone',
                    'idib_customer_details.billing_address_name', 'idib_customer_details.billing_address_address1', 'idib_customer_details.billing_address_address2', 'idib_customer_details.billing_address_phone', 'idib_customer_details.billing_address_zip', 'idib_customer_details.billing_address_province', 'idib_customer_details.billing_address_country',
                    'idib_customer_details.shipping_address_name', 'idib_customer_details.shipping_address_address1', 'idib_customer_details.shipping_address_address2', 'idib_customer_details.shipping_address_phone', 'idib_customer_details.shipping_address_zip', 'idib_customer_details.shipping_address_province', 'idib_customer_details.shipping_address_country'
                )
                ->get()->toArray();
        }

        //Open file pointer.
        $fp = fopen('export_order/all/order_all_'.$time.'.csv', 'w');

        fputcsv($fp, array('Order Id','Variant Id','title', 'Variant Options', 'Quantity', 'Price',
            'Customer Name', 'Payment Gateway', 'Order Status Url',
            'Customer First Name','customer Last Name', 'Customer Id', 'Customer Email',
            'Default First name', 'Default Last Name', 'Default Company','Default Address 1', 'Default Address 2','Default City', 'Default Province', 'Default Country','Default Zip', 'Default Phone',
            'Billing Name', 'Billing Address 1','Billing Address 2', 'Billing Phone', 'Billing Zip', 'Billing Province', 'Billing Country',
            'Shipping Name', 'Shipping Address 1','Shipping Address 2', 'Shipping Phone', 'Shipping Zip', 'Shipping Province', 'Shipping Country'
        ));
        //Loop through the associative array.
        $data_temp = array();
        $data = collect($data);
        $data_temp = $data;
        foreach ($data_temp as $data_main){
            foreach($data_main as $item) {
                fputcsv($fp, (array)$item);
            }
        }
        //Finally, close the file pointer.
        fclose($fp);
        return 'export_order/all/order_all_'.$time.'.csv';
    }


    /***********************
     * Generate PDF
     **********************/
    public function generatePDF($orderId)
    {
        //$data = ['title' => 'Welcome to HDTuto.com', 'order' => $orderId];
        $getProducts = Products::get(); //sidebar
        $getLineItemInfo = OrderLineItem::where('order_id', $orderId)->get(); //sidebar
        $getOrderDetails = OrderDetails::where('order_number', $orderId)->get(); //sidebar
        $getCustomerInfo = OrderCustomerDetails::where('order_id', $orderId)->get(); //sidebar
        $getproductDetails = DB::table('shopify_order')->where('shopify_order_id', $orderId)->get(); //sidebar
        /*$pdf = PDF::loadView('shopify-app::tool.orderPdf', compact('getproductDetails','getOrderDetails','getProducts','getLineItemInfo','getCustomerInfo', 'orderId'));
        sleep(5);*/
        //return $pdf->download('Invoice_'.$orderId.'.pdf');
        return view('shopify-app::tool.orderPdf',compact('getproductDetails','getOrderDetails','getProducts','getLineItemInfo','getCustomerInfo', 'orderId'));
    }


    /*
      |--------------------------------------------------------------------------
      | IdesignIbuy Get JSON data to product  API Controller
      |--------------------------------------------------------------------------
      |
      |
     */

//$custom_path = "https://dev.mpbazaar.com/public/Idesignibuy3d";
//$custom_obj_path = "https://dev.mpbazaar.com/idesignibuy-cap/";
//dd(_path());


    /***************************Shirt Style Json**************************/


    public function getToolStyleJson($prodId)
    {
        $getProduct = Products::where('id',$prodId)->where('status', 1)->get();
        $getProductStyle = ProductStyle::join('products','product_style.product_id', 'products.id')
            ->select('products.product_description','products.product_name','product_style.id','product_style.style','product_style.icon_class')
            ->where('product_style.product_id',$prodId)
            ->where('product_style.status',1)
            ->get();

        /* $getProductStylePart = DB::table('product_style_parts')
                             ->join('products','product_style_parts.product_id', 'products.id')
                             ->select('products.product_name','product_style_parts.style_parts','product_style_parts.icon_class as style_icon','product_style_parts.id as style_id')
                             ->where('product_style_parts.product_id',$prodId)
                             ->where('product_style_parts.status',1)
                             ->get();*/

        if(isset($getProductStyle))
        {
            if($prodId == 1)
            {
                foreach ($getProductStyle as $key => $prod_value)
                {
                    $getProductStyleData = ProductStyleParts::join('product_style','product_style_parts.style_id','product_style.id')
                        ->join('products','product_style.product_id', 'products.id')
                        ->select('product_style_parts.alt_id as id','product_style_parts.icon_class as class','product_style.style as parent','products.product_description as designType','product_style_parts.style_parts as name','product_style_parts.price as price')
                        ->where('product_style_parts.product_id',$prodId)
                        ->where('product_style_parts.style_id',$prod_value->id)
                        ->where('product_style_parts.status', 1)
                        ->get();

                    $productStyle['id'] = "".$prod_value->id;
                    $productStyle['name'] = $prod_value->style;
                    $productStyle['designType'] = $prod_value->product_description;
                    $productStyle['class'] = $prod_value->icon_class;
                    $productStyle['style'] = $getProductStyleData;
                    $AllProductStyle[] = $productStyle;
                }
            }else{
                $productStyle['Data'] = "Data not available for this product!";
                $AllProductStyle[] = $productStyle;
            }
        }

        $data = array();
        $data = (object)$AllProductStyle;

        return json_encode($data);
    }

    /**********************Shirt/Suit Fabric Json*************************/


    public function getToolFabricJson($prodId)
    {
        $local_fabric_path = url('/')."/public/tool/images/fabric";
        if($prodId == 1){
            $product = "shirt";
        }else{
            $product = "suit";
        }
        $local_display_path = url('/')."/public/tool/images/display/".$product;
        $local_large_path = url('/')."/public/tool/images/large/".$product;

        $getFabric = DB::table('product_colors')->where('product_id', $prodId)->get();
        if(isset($getFabric))
        {
            foreach ($getFabric as $key => $value)
            {

                $getCategoryName = DB::table('product_category')
                    //->where('product_id', $prodId)
                    ->whereIn('id', [$value->material_parent, $value->pattern_parent, $value->season_parent, $value->color_parent, $value->category_parent])
                    ->get()->toArray();


                $fabric['id'] = $value->id;
                $fabric['name'] = $value->color_name;
                //$fabric['fabric_thumb'] = $local_fabric_path.'/'.$value->fabric_image;
                $fabric['img'] = $local_display_path.'/'.$value->display_image;
                $fabric['large_thumb'] = $local_large_path.'/'.$value->large_image;
                $fabric['price'] = $value->fabric_price;
                $fabric['material_parent'] = $getCategoryName[0]->category;
                $fabric['pattern_parent'] = $getCategoryName[1]->category;
                $fabric['season_parent'] = $getCategoryName[2]->category;
                $fabric['color_parent'] = $getCategoryName[3]->category;
                $fabric['category_parent'] = $getCategoryName[4]->category;
                $fabric['type'] = $getCategoryName[0]->category;
                $AllFabric[] = $fabric;
            }
        }
        else
        {
            $fabric['Data'] = "Data not available for this product!";
            $AllFabric[] = $fabric;
        }

        $getStaticCategory = DB::table('static_category')->get();
        if(isset($getStaticCategory))
        {
            foreach ($getStaticCategory as $key => $value)
            {
                $getCategory[] = DB::table('product_category')
                    ->join('static_category', 'product_category.static_category_id', 'static_category.id')
                    ->select('product_category.id as id', 'product_category.category as name', 'static_category.static_category_name as parent')
                    ->where('product_category.status', 1)
                    ->where('product_category.product_id', $prodId)
                    ->where('product_category.static_category_id',$value->id)
                    ->get();
                $AllCategory = $getCategory;
            }
        }


        $Fabric_data = array();
        if($prodId == 1)
        {
            $Fabric_data = ["fabric" => $AllFabric, "category" => $AllCategory];
        }else{
            $Fabric_data = ["fabric" => (object)$AllFabric, "category" => (object)$AllCategory];
        }
        return json_encode($Fabric_data);

    }

    /***********************Suit Style Json*******************************/

    public function getJacketJson($prodId, $styleId)
    {
        $getJacketJson = DB::table('product_style')
            ->join('product_style_parts', 'product_style.id', 'product_style_parts.style_id')
            ->select('product_style.id as id','product_style.product_id','product_style.style as designType','product_style_parts.style_parts_description as name','product_style_parts.icon_class as class','product_style_parts.id as style_part_id')
            ->where('product_style.product_id', $prodId)
            ->where('product_style.id', $styleId)
            ->where('product_style.status', 1)
            ->get();


        $i = 1;
        foreach($getJacketJson as $key => $val)
        {

            if($val->style_part_id == "44")
            {
                $getLapel = DB::table('product_style')
                    ->join('product_style_parts','product_style.id', 'product_style_parts.style_id')
                    ->join('product_style_parts_types', 'product_style_parts.id', 'product_style_parts_types.style_parts_id')
                    ->select('product_style_parts_types.alt_id as id','product_style_parts_types.style_parts as name', 'product_style_parts_types.icon_class as class','product_style_parts_types.price  as price','product_style_parts_types.lapel_category as parent','product_style.style as designType')
                    ->where('lapel_category','Lapel')
                    ->where('product_style_parts_types.status', 1)
                    ->where('product_style_parts_types.style_parts_id', $val->style_part_id)
                    ->get();


                $getLapelSize = DB::table('product_style')
                    ->join('product_style_parts','product_style.id', 'product_style_parts.style_id')
                    ->join('product_style_parts_types', 'product_style_parts.id', 'product_style_parts_types.style_parts_id')
                    ->select('product_style_parts_types.alt_id as id','product_style_parts_types.style_parts as name', 'product_style_parts_types.icon_class as class','product_style_parts_types.price  as price','product_style_parts_types.lapel_category as parent','product_style.style as designType')
                    ->where('lapel_category','LapelSize')
                    ->where('product_style_parts_types.status', 1)
                    ->where('product_style_parts_types.style_parts_id', $val->style_part_id)
                    ->get();

            }else{
                $getSuitStyle = DB::table('product_style')
                    ->join('product_style_parts','product_style.id', 'product_style_parts.style_id')
                    ->join('product_style_parts_types', 'product_style_parts.id','product_style_parts_types.style_parts_id')
                    ->select('product_style_parts_types.static_type_id as type','product_style_parts_types.alt_id as id','product_style_parts_types.style_parts as name', 'product_style_parts_types.icon_class as class','product_style_parts_types.price  as price','product_style_parts.style_parts as parent','product_style.style as designType')
                    ->where('product_style_parts_types.status', 1)
                    ->where('product_style_parts_types.style_parts_id', $val->style_part_id)
                    ->get();
            }


            $suit['id'] = $i;
            $suit['designType'] = $val->designType;
            $suit['name'] = $val->name;
            $suit['class'] = $val->class;
            if($val->style_part_id == "44"){
                $suit['style'] = $getLapel;
                $suit['size'] = $getLapelSize;
            }
            else{
                $suit['style'] = $getSuitStyle;
            }
            $AllSuit[] = $suit;
            $i++;
        }

        $Suit_data = array();
        $Suit_data = $AllSuit;
//        dd($Suit_data);
        return json_encode($Suit_data);
    }

    /*********************Suit-vest Style Json****************************/

    public function getVestJson($prodId, $styleId){
        $getVestJson = DB::table('product_style')
            ->join('product_style_parts', 'product_style.id', 'product_style_parts.style_id')
            ->select('product_style.product_id','product_style.style as designType','product_style_parts.style_parts_description as name','product_style_parts.icon_class as class','product_style_parts.id as style_part_id')
            ->where('product_style.product_id', $prodId)
            ->where('product_style.id', $styleId)
            ->where('product_style.status', 1)
            ->get();

        $vest_id = 1;
        foreach($getVestJson as $key => $val)
        {
            $getVestStyle = DB::table('product_style')
                ->join('product_style_parts','product_style.id', 'product_style_parts.style_id')
                ->join('product_style_parts_types', 'product_style_parts.id', 'product_style_parts_types.style_parts_id')
                ->select('product_style_parts_types.static_type_id as type','product_style_parts_types.alt_id as id','product_style_parts_types.style_parts as name', 'product_style_parts_types.icon_class as class','product_style_parts_types.price  as price','product_style_parts.style_parts as parent','product_style.style as designType')
                ->where('product_style_parts_types.style_parts_id', $val->style_part_id)
                ->where('product_style_parts_types.status', 1)
                ->get();

            $vest['id'] = $vest_id;
            $vest['designType'] = $val->designType;
            $vest['name'] = $val->name;
            $vest['class'] = $val->class;
            $vest['style'] = $getVestStyle;
            $AllVest[] = $vest;
            $vest_id++;
        }

        $Vest_data = array();
        $Vest_data = $AllVest;
        return json_encode($Vest_data);
    }

    /**********************Suit-pant Style Json***************************/

    public function getPantJson($prodId, $styleId){
        $getPantJson = DB::table('product_style')
            ->join('product_style_parts', 'product_style.id', 'product_style_parts.style_id')
            ->select('product_style.id','product_style.product_id','product_style.style as designType','product_style_parts.style_parts_description as name','product_style_parts.icon_class as class','product_style_parts.id as style_part_id')
            ->where('product_style.product_id', $prodId)
            ->where('product_style.id', $styleId)
            ->where('product_style.status', 1)
            ->get();

        $pant_id = 1;
        foreach($getPantJson as $key => $val)
        {
            $getPantStyle = DB::table('product_style')
                ->join('product_style_parts','product_style.id', 'product_style_parts.style_id')
                ->join('product_style_parts_types', 'product_style_parts.id', 'product_style_parts_types.style_parts_id')
                ->select('product_style_parts_types.alt_id as id','product_style_parts_types.style_parts as name', 'product_style_parts_types.icon_class as class','product_style_parts_types.price  as price','product_style_parts.style_parts as parent','product_style.style as designType')
                ->where('product_style_parts_types.style_parts_id', $val->style_part_id)
                ->where('product_style_parts_types.status', 1)
                ->get();

            $pant['id'] = $pant_id;
            $pant['designType'] = $val->designType;
            $pant['name'] = $val->name;
            $pant['class'] = $val->class;
            $pant['style'] = $getPantStyle;
            $AllPant[] = $pant;
            $pant_id++;
        }

        $Pant_data = array();
        $Pant_data = $AllPant;
        return json_encode($Pant_data);
    }

    /***********************Jacket Accent Json*******************************/

    public function getAccentJson($prodId)
    {

        $getAccentJson = DB::table('product_accent')
            ->join('products', 'product_accent.product_id', 'products.id')
            ->select('product_accent.price','products.product_description','product_accent.accent_description','products.product_name','product_accent.id as accent_id','product_accent.accent as accent_name','product_accent.icon_class as accent_icon')
            ->where('product_accent.product_id', $prodId)
            ->where('product_accent.status', 1)
            ->where('products.status', 1)
            ->get()->toArray();

        $accentID = 1;
        foreach($getAccentJson as $key => $value)
        {
            $getAccentTypeJson = DB::table('product_button')
                ->join('products', 'product_button.product_id', 'products.id')
                ->join('product_accent', 'product_button.accent_id', 'product_accent.id')
                ->select('product_button.alt_id as id','product_accent.accent as parent','product_accent.accent_description as designType', 'product_accent.accent as designRel','product_button.button as name','product_button.price as price', 'product_button.icon_class as class', 'product_button.button_image as img')
                ->where('product_button.product_id', $prodId)
                ->where('product_accent.id', $value->accent_id)
                ->where('product_button.status', 1)
                ->where('products.status', 1)
                ->where('product_accent.status', 1)
                ->get()
                ->toArray();

            $accent['id'] = $accentID;
            $accent['name'] = $value->accent_name;
            $accent['class'] = $value->accent_icon;
            if($prodId == 1)
            {
                $accent['designType'] = $value->product_description;
            }else{
                $accent['designType'] = $value->accent_description;
            }
            $accent['price'] = $value->price;
            $accent['img'] = '';
            $accent['style'] = $getAccentTypeJson;
            $AllAccent[] = $accent;
            $accentID++;
        }

        $accent_data = array();
        $accent_data = $AllAccent;
        return json_encode($accent_data);
    }

}
