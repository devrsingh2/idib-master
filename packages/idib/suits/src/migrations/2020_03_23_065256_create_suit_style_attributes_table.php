<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuitStyleAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suit_style_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('style_id');
            $table->string('name');
            $table->string('parent')->nullable();
            $table->string('designType')->nullable();
            $table->string('description')->nullable();
            $table->string('class_name')->nullable();
            $table->float('price');
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('order_id')->nullable();
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
        Schema::dropIfExists('suit_style_attributes');
    }
}
