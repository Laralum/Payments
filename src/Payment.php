<?php

namespace Laralum\Payments;

use Laralum\Payments\Models\Settings;
use Stripe\Charge;
use Stripe\Stripe;

class Payment
{
    public $amount = 0;
    public $currency = 'EUR';
    public $source;
    public $description = 'Payment';
    public $error = null;

    /**
     * Payment constructor to setup the API key.
     */
    public function __construct()
    {
        if (Settings::first()->ready()) {
            Stripe::setApiKey(decrypt(Settings::first()->stripe_secret));
        }
    }

    /**
     * Setup the payment ammount.
     *
     * @param int $ammount
     *
     * @return \Laralum\Payments\Payment
     */
    public function ammount($ammount)
    {
        $this->ammount = $ammount;

        return $this;
    }

    /**
     * Setup the payment currency.
     *
     * @param string $currency
     *
     * @return \Laralum\Payments\Payment
     */
    public function currency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Setup the payment source token.
     *
     * @param string $source
     *
     * @return \Laralum\Payments\Payment
     */
    public function source($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Setup the payment description.
     *
     * @param string $description
     *
     * @return \Laralum\Payments\Payment
     */
    public function description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Execute the payment and return true if succeeded.
     *
     * @param string $description
     *
     * @return \Laralum\Payments\Payment
     */
    public function pay()
    {
        if (!Settings::first()->ready()) {
            return false;
        }
        
        if ($this->ammount != 0) {
            try {
                Charge::create([
                    'amount'      => $this->ammount,
                    'currency'    => $this->currency,
                    'source'      => $this->source,
                    'description' => $this->description,
                ]);
            } catch (Exception $e) {
                $this->error = $e;

                return false;
            }
        }

        return true;
    }
}
