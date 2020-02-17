<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('shpoify_order_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('line_item_id')->nullable();
            $table->string('app_id')->nullable();
            $table->string('checkout_id')->nullable();
            $table->text('token')->nullable();
            $table->text('gateway')->nullable();
            $table->float('subtotal_price')->nullable();
            $table->float('total_price')->nullable();
            $table->string('currency')->nullable();
            $table->text('cart_token')->nullable();
            $table->text('checkout_token')->nullable();
            $table->text('order_status_url')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
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
