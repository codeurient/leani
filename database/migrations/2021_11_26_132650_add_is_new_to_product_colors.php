<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsNewToProductColors extends Migration
{
    public function up()
    {
        Schema::table('product_colors', function (Blueprint $table) {
            $table->boolean('is_new')->default(false);
        });
    }

    public function down()
    {
        Schema::table('product_colors', function (Blueprint $table) {
            $table->dropColumn('is_new');
        });
    }
}
