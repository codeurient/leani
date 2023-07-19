<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionToProductColorSizes extends Migration
{
    public function up()
    {
        Schema::table('product_color_sizes', function (Blueprint $table) {
            $table->string('position');
        });
    }

    public function down()
    {
        Schema::table('product_color_sizes', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
}
