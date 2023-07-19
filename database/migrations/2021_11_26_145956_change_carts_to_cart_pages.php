<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCartsToCartPages extends Migration
{
    public function up()
    {
        Schema::dropIfExists('carts');

        Schema::create('cart_pages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->json('meta_title');
            $table->json('meta_description');

            $table->json('fields');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_pages');

        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->json('meta_title');
            $table->json('meta_description');

            $table->json('fields');

            $table->timestamps();
        });
    }
}
