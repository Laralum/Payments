<?php

namespace Laralum\Payments;

use Laralum\Payments\Model\Settings;
use Stripe\Stripe;

class Payments
{
    public function __construct()
    {
        Stripe::setApiKey(Settings::first()->stripe_secret);
    }
}
