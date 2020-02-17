<?php

namespace Idib\Shopify\Controllers;

use Illuminate\Routing\Controller;
use Idib\Shopify\Traits\BillingControllerTrait;

/**
 * Responsible for billing a shop for plans and usage charges.
 */
class BillingController extends Controller
{
    use BillingControllerTrait;
}
