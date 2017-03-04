<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laralum\Payments\Models\Settings;

class LaralumPaymentsSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('laralum_payments_settings')) {
            Schema::create('laralum_payments_settings', function ($table) {
                $table->increments('id');
                $table->string('stripe_key')->nullable();
                $table->string('stripe_secret')->nullable();
                $table->timestamps();
            });
            Settings::create([]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laralum_payments_settings');
    }
}
