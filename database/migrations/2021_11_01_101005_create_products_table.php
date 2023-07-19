<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Product data
            $table->json('name');
            $table->string('slug');
            $table->string('sku')->nullable();
            $table->json('description')->nullable();
            $table->json('details')->nullable();
            $table->json('main_image')->nullable();
            $table->json('images')->nullable();

            // Catalog data
            $table->boolean('separate_display')->default(false);
            $table->json('menu_title')->nullable();
            $table->bigInteger('sort')->default(0);
            $table->string('text_color')->nullable();
            $table->unsignedBigInteger('photo')->nullable();

            // Base product price
            $table->decimal('price')->default(0);

            // Discount percentage
            $table->unsignedFloat('discount', 4, 2)->nullable();

            // Product meta
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
