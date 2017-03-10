<?php

namespace Laralum\Payments;

use Stripe\Stripe;
use Laralum\Payments\Model\Settings;

class Payments
{
    public function __construct()
    {
        Stripe::setApiKey(Settings::first()->stripe_secret);
    }
}
