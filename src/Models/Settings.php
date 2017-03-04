<?php

namespace Laralum\Payments\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'laralum_payments_settings';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['stripe_key', 'stripe_secret'];
}
