<?php

namespace Idib\Shopify\Traits;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Idib\Shopify\Facades\ShopifyApp;
use Idib\Shopify\Models\Charge;
use Idib\Shopify\Models\Plan;
use Idib\Shopify\Models\Shop;
use Idib\Shopify\Requests\StoreUsageCharge;
use Idib\Shopify\Services\BillingPlan;
use Idib\Shopify\Services\UsageCharge;

/**
 * Responsible for billing a shop for plans and usage charges.
 */
trait BillingControllerTrait
{
    /**
     * Redirects to billing screen for Shopify.
     *
     * @param \Idib\Shopify\Models\Plan $plan The plan.
     *
     * @return \Illuminate\View\View
     */
    public function index(Plan $plan)
    {
        // If the plan is null, get a plan
        if (is_null($plan) || ($plan && !$plan->exists)) {
            $plan = Plan::where('on_install', true)->first();
        }

        // Get the confirmation URL
        $bp = new BillingPlan(ShopifyApp::shop(), $plan);
        $url = $bp->confirmationUrl();

        // Do a fullpage redirect
        return View::make('shopify-app::billing.fullpage_redirect', compact('url'));
    }

    /**
     * Processes the response from the customer.
     *
     * @param \Idib\Shopify\Models\Plan $plan The plan.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Plan $plan)
    {
        // Activate the plan and save
        $shop = ShopifyApp::shop();
        $bp = new BillingPlan($shop, $plan);
        $bp->setChargeId(Request::query('charge_id'));
        $bp->activate();
        $save = $bp->save();

        // Go to homepage of app
        return Redirect::route('home')->with(
            $save ? 'success' : 'failure',
            'billing'
        );
    }

    /**
     * Allows for setting a usage charge.
     *
     * @param \Idib\Shopify\Requests\StoreUsageCharge $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function usageCharge(StoreUsageCharge $request)
    {
        // Activate and save the usage charge
        $validated = $request->validated();
        $uc = new UsageCharge(ShopifyApp::shop(), $validated);
        $uc->activate();
        $uc->save();

        // All done, return with success
        return isset($validated['redirect']) ?
            Redirect::to($validated['redirect'])->with('success', 'usage_charge') :
            Redirect::back()->with('success', 'usage_charge');
    }
}
