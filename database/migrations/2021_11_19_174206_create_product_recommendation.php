<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRecommendation extends Migration
{
    public function up()
    {
        Schema::create('product_recommendation', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('recommendation_id')->constrained('products')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_recommendation');
    }
}
