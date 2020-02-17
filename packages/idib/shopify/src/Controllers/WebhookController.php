<?php

namespace Idib\Shopify\Controllers;

use Illuminate\Routing\Controller;
use Idib\Shopify\Traits\WebhookControllerTrait;

/**
 * Responsible for handling incoming webhook requests.
 */
class WebhookController extends Controller
{
    use WebhookControllerTrait;
}
