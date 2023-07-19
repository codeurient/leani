<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCactusIdToProductColorSizes extends Migration
{
    public function up()
    {
        Schema::table('product_color_sizes', function (Blueprint $table) {
            $table->unsignedBigInteger('cactus_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('product_color_sizes', function (Blueprint $table) {
            $table->dropColumn('cactus_id');
        });
    }
}
