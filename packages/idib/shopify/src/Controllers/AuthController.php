<?php

namespace Idib\Shopify\Controllers;

use Illuminate\Routing\Controller;
use Idib\Shopify\Traits\AuthControllerTrait;

/**
 * Responsible for authenticating the shop.
 */
class AuthController extends Controller
{
    use AuthControllerTrait;
}
