<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductColorsTable extends Migration
{
    public function up()
    {
        Schema::create('product_colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('color_id')->constrained()->cascadeOnDelete();

            // Color data
            $table->string('sku')->nullable();
            $table->json('main_image')->nullable();
            $table->json('images')->nullable();

            // Price impact
            $table->decimal('price')->default(0);

            // Discount percentage
            $table->unsignedFloat('discount', 4, 2)->nullable();


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_colors');
    }
}
