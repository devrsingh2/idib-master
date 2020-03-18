<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFabricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabrics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id');
            $table->string('name')->nullable();
            $table->string('fabric_image')->nullable();
            $table->string('display_image')->nullable();
            $table->string('large_image')->nullable();
            $table->string('description')->nullable();
            $table->string('price')->nullable();
            $table->bigInteger('material_parent')->nullable();
            $table->bigInteger('pattern_parent')->nullable();
            $table->bigInteger('season_parent')->nullable();
            $table->bigInteger('color_parent')->nullable();
            $table->bigInteger('category_parent')->nullable();
            $table->boolean('status')->default(1);
            $table->string('order_id')->nullable();
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
        Schema::dropIfExists('fabrics');
    }
}
