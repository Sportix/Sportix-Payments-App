<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->index();
            $table->string('product_name');
            $table->integer('payment_amount')->default(0);
            $table->boolean('is_fixed_payment')->default(0);
            $table->string('payment_description')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_recurring')->default(0);
            $table->string('recurring_interval')->nullable();
            $table->smallInteger('recurring_cycles')->default(0);
            // $table->boolean('has_custom_form')->default(0);
            // $table->integer('custom_form_id')->default(0)->index();
            $table->date('due_date')->nullable();
            $table->boolean('charge_app_fee')->default(0);
            $table->integer('app_fee_percent')->default(0);
            $table->datetime('published_at')->nullable();
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
        Schema::dropIfExists('products');
    }
}
