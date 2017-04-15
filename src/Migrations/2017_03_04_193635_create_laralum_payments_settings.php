<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Laralum\Payments\Models\Settings;

class CreateLaralumPaymentsSettings extends Migration
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
                $table->text('stripe_key')->nullable();
                $table->text('stripe_secret')->nullable();
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
