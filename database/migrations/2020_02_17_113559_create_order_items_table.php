<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id');
            $table->string('line_item_id')->nullable();
            $table->string('variant_id')->nullable();
            $table->string('title')->nullable();
            $table->string('quantity')->nullable();
            $table->float('price')->nullable();
            $table->string('sku')->nullable();
            $table->string('variant_title')->nullable();
            $table->string('vendor')->nullable();
            $table->string('fulfillment_service')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('requires_shipping')->nullable();
            $table->string('taxable')->nullable();
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
        Schema::dropIfExists('order_items');
    }
}
