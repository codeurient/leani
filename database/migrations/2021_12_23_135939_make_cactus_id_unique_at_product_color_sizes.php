<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeCactusIdUniqueAtProductColorSizes extends Migration
{
    public function up()
    {
        Schema::table('product_color_sizes', function (Blueprint $table) {
            $table->unsignedBigInteger('cactus_id')->unique()->change();
        });
    }

    public function down()
    {
        Schema::table('product_color_sizes', function (Blueprint $table) {
            $table->unsignedBigInteger('cactus_id')->change();
        });
    }
}
