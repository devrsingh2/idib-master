<?php

namespace Idib\Shopify\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Idib\Shopify\Facades\ShopifyApp;
use Idib\Shopify\Models\Charge;
use Idib\Shopify\Models\Plan;
use Idib\Shopify\Scopes\NamespaceScope;
use Idib\Shopify\Services\ShopSession;

/**
 * Responsible for reprecenting a shop record.
 */
trait ShopModelTrait
{
    use SoftDeletes;

    /**
     * The API instance.
     *
     * @var \Idib\Shopify\BasicShopifyAPI
     */
    protected $api;

    /**
     * The session instance.
     *
     * @var \Idib\Shopify\Services\ShopSession
     */
    protected $session;

    /**
     * Constructor for the model.
     *
     * @param array $attributes The model attribues to pass in.
     *
     * @return self
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new NamespaceScope());
    }

    /**
     * Creates or returns an instance of session for the shop.
     *
     * @return \Idib\Shopify\Services\ShopSession
     */
    public function session()
    {
        if (!$this->session) {
            // Create new session instance
            $this->session = new ShopSession($this);
        }

        // Return existing instance
        return $this->session;
    }

    /**
     * Creates or returns an instance of API for the shop.
     *
     * @return \Idib\Shopify\BasicShopifyAPI
     */
    public function api()
    {
        if (!$this->api) {
            // Get the domain and token
            $shopDomain = $this->shopify_domain;
            $token = $this->session()->getToken();

            // Create new API instance
            $this->api = ShopifyApp::api();
            $this->api->setSession($shopDomain, $token);
        }

        // Return existing instance
        return $this->api;
    }

    /**
     * Checks is shop is grandfathered in.
     *
     * @return bool
     */
    public function isGrandfathered()
    {
        return ((bool) $this->grandfathered) === true;
    }

    /**
     * Get charges.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function charges()
    {
        return $this->hasMany(Charge::class);
    }

    /**
     * Checks if charges have been applied to the shop.
     *
     * @return bool
     */
    public function hasCharges()
    {
        return $this->charges->isNotEmpty();
    }

    /**
     * Gets the plan.
     *
     * @return \Idib\Shopify\Models\Plan
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Checks if the shop is freemium.
     *
     * @return bool
     */
    public function isFreemium()
    {
        return ((bool) $this->freemium) === true;
    }

    /**
     * Gets the last single or recurring charge for the shop.
     *
     * @param int|null $planID The plan ID to check with.
     *
     * @return null|\Idib\Shopify\Models\Charge
     */
    public function planCharge(int $planID = null)
    {
        return $this
            ->charges()
            ->withTrashed()
            ->whereIn('type', [Charge::CHARGE_RECURRING, Charge::CHARGE_ONETIME])
            ->where('plan_id', $planID ?? $this->plan_id)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Checks if the access token is filled.
     *
     * @return bool
     */
    public function hasOfflineAccess()
    {
        return !empty($this->shopify_token);
    }
}
