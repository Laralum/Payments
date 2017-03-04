<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Laralum\Users\Models\User;

class LaralumPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = with(new User)->getTable();
        $table_columns = ['stripe_id', 'card_brand', 'card_last_four', 'trial_ends_at'];

        if (Schema::hasTable($table_name) and !Schema::hasColumns($table_name, $table_columns)) {
            Schema::table($table_name, function ($table) {
                $table->string('stripe_id')->nullable();
                $table->string('card_brand')->nullable();
                $table->string('card_last_four')->nullable();
                $table->timestamp('trial_ends_at')->nullable();
            });
        }

        if (!Schema::hasTable('subscriptions')) {
            Schema::create('subscriptions', function ($table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('name');
                $table->string('stripe_id');
                $table->string('stripe_plan');
                $table->integer('quantity');
                $table->timestamp('trial_ends_at')->nullable();
                $table->timestamp('ends_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table_name = with(new User)->getTable();
        $table_columns = ['stripe_id', 'card_brand', 'card_last_four', 'trial_ends_at'];

        if (Schema::hasTable($table_name) and Schema::hasColumns($table_name, $table_columns)) {
            Schema::table($table_name, function (Blueprint $table) use ($table_columns) {
                $table->dropColumn($table_columns);
            });
        }
        Schema::dropIfExists('subscriptions');
    }
}
