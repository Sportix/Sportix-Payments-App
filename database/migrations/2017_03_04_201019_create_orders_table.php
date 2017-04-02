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
            // $table->unsignedInteger('account_id')->unsigned()->index();
            $table->string('transaction_id', 64);
            $table->unsignedInteger('product_id')->unsigned()->index();
            $table->string('product_type')->default('FUND');
            $table->string('email', 100)->index();
            $table->integer('total_amount')->default(0);
            $table->integer('payment_amount')->default(0);
            $table->integer('app_fee_percent')->default(0);
            $table->boolean('charge_app_fee')->default(false);
            $table->string('card_last_four', 16)->nullable();
            $table->timestampsTz();
            $table->softDeletes();
        });

        Schema::table('orders', function($table) {
            // $table->foreign('account_id')
            //       ->references('id')->on('accounts')
            //       ->onDelete('cascade');
            //
            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
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
