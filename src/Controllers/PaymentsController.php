<?php

namespace Laralum\Payments\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laralum\Payments\Models\Settings;

class PaymentsController extends Controller
{
    /**
      * Display the payments dashboard.
      *
      * @return \Illuminate\Http\Response
      */
     public function index()
     {
         return view('laralum_payments::index', ['settings' => Settings::first()]);
     }

    /**
     * Save the payments settings.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(Request $request)
    {
        $this->authorize('update', Settings::class);

        Settings::first()->update([
            'stripe_key'    => $request->stripe_key ? encrypt($request->stripe_key) : null,
            'stripe_secret' => $request->stripe_secret ? encrypt($request->stripe_secret) : null,
        ]);

        return redirect()->route('laralum::settings.index', ['p' => 'Payments'])->with('success', __('laralum_payments::general.updated_settings'));
    }
}
