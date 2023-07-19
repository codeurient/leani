<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnSaleToProductColors extends Migration
{
    public function up()
    {
        Schema::table('product_colors', function (Blueprint $table) {
            $table->boolean('on_sale')->default(false);
        });
    }

    public function down()
    {
        Schema::table('product_colors', function (Blueprint $table) {
            $table->dropColumn('on_sale');
        });
    }
}
