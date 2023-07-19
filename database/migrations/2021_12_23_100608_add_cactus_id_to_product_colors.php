<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCactusIdToProductColors extends Migration
{
    public function up()
    {
        Schema::table('product_colors', function (Blueprint $table) {
            $table->unsignedBigInteger('cactus_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('product_colors', function (Blueprint $table) {
            $table->dropColumn('cactus_id');
        });
    }
}
