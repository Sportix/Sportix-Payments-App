<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('account_id')->index();
            $table->unsignedInteger('product_id')->index();
            $table->string('product_type')->default('FUND');
            $table->string('email', 100)->index();
            $table->integer('total_amount')->default(0);
            $table->integer('fee_amount')->default(0);
            $table->integer('app_fee_percent')->default(0);
            $table->boolean('charge_app_fee')->default(false);
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
