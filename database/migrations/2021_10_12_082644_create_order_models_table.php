<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_models', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('status');
            $table->unsignedInteger('price');
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->string('zip');
            $table->string('city');
            $table->string('country');
            $table->string('pay_method');
            $table->string('delivery');
            $table->string('promo_code')->nullable();
            $table->text('message')->nullable();
            $table->json('order_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_models');
    }
}
