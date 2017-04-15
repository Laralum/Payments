<?php

namespace Laralum\Payments\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Payments\Models\Settings;
use Stripe\Balance;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class APIController extends Controller
{
    /**
      * Set the Stripe API Key.
      *
      * @return void
      */
     public function __construct()
     {
         Stripe::setApiKey(decrypt(Settings::first()->stripe_secret));
     }

     /**
      * Returns the balance.
      *
      * @return arary
      */
     public function balance(Request $request)
     {
         return Balance::retrieve($request->all());
     }

      /**
       * Returns the charges.
       *
       * @return arary
       */
      public function charges(Request $request)
      {
          return Charge::all($request->all());
      }

      /**
       * Returns the customers.
       *
       * @return arary
       */
      public function customers(Request $request)
      {
          return Customer::all($request->all());
      }
}
