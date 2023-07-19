<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataForLeaniAtProducts extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('separate_display');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->mediumText('composition')->nullable();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('composition');

            $table->boolean('separate_display')->default(false);
        });
    }
}
