<?php

namespace Laralum\Payments\Controllers;

use App\Http\Controllers\Controller;
use Laralum\Payments\Models\User;
use Laralum\Payments\Models\Settings;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(Request $request)
    {
        $this->authorize('update', Settings::class);

        Settings::first()->update($request->all());

        return redirect()->route('laralum::settings.index', ['p' => 'Payments'])->with('success', __('laralum_payments::general.updated_settings'));
    }

}
