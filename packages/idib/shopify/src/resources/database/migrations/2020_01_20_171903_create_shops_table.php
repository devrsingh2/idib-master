<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shopify_domain');
            $table->string('shopify_token')->nullable(true)->default(null);
//            $table->bigInteger('charge_id')->nullable(true)->default(null);
            $table->boolean('grandfathered')->default(false);
            $table->string('namespace')->nullable(true)->default(null);
            // Linking start
            $table->integer('plan_id')->unsigned()->nullable();
            $table->foreign('plan_id')->references('id')->on('plans');
            // Linking end
            $table->boolean('freemium')->default(false);
            $table->timestamps();
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
        Schema::drop('shops');
    }
}
