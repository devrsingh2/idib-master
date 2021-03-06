<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuitFabricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suit_fabrics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id');
            $table->string('name')->nullable();
            $table->string('fabric_image')->nullable();
            $table->string('display_image')->nullable();
            $table->string('large_image')->nullable();
            $table->string('article_number')->nullable();
            $table->string('composition')->nullable();
            $table->string('weight')->nullable();
            $table->string('fabric_type')->nullable();
            $table->float('price')->nullable();
            $table->bigInteger('material_parent')->nullable();
            $table->bigInteger('pattern_parent')->nullable();
            $table->bigInteger('season_parent')->nullable();
            $table->bigInteger('color_parent')->nullable();
            $table->bigInteger('collection_parent')->nullable();
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
        Schema::dropIfExists('suit_fabrics');
    }
}
