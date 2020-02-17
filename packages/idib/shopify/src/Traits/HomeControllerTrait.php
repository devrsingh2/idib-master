<?php

namespace Idib\Shopify\Traits;

use Idib\Shopify\Models\Shop;
use Illuminate\Support\Facades\View;

/**
 * Responsible for showing the main homescreen for the app.
 */
trait HomeControllerTrait
{
    /**
     * Index route which displays the home page of the app.
     *
     * @return \Illuminate\View\View
     */
    /*public function index()
    {
        return View::make('shopify-app::home.index');
    }*/

    public function index()
    {
        $shop = Shop::first();
        if (isset($shop) && $shop->shopify_domain !== '') {
            toastr()->error('Application already installed');
            return redirect()->route('login');
        } else {
            return View::make('shopify-app::install.index');
        }
    }
}
