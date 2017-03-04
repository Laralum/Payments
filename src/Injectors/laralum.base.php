<?php

$payments_settings = \Laralum\Payments\Models\Settings::first();

if ($payments_settings->stripe_key and $payments_settings->stripe_secret) {
    config([
        'services.stripe.model' => \Laralum\Payments\Models\User::class,
        'services.stripe.key' => $payments_settings->stripe_key,
        'services.stripe.secret' => $payments_settings->stripe_secret,
    ]);
}
