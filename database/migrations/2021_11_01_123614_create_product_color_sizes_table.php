<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductColorSizesTable extends Migration
{
    public function up()
    {
        Schema::create('product_color_sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_color_id')->constrained()->cascadeOnDelete();
            $table->foreignId('size_id')->constrained()->cascadeOnDelete();

            // Price impact
            $table->decimal('price')->default(0);

            // Discount percentage
            $table->unsignedFloat('discount', 4, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_sizes');
    }
}
