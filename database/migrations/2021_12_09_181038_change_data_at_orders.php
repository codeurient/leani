<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataAtOrders extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('full_name');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('name');
            $table->string('surname')->nullable();
            $table->json('delivery');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['name', 'surname', 'delivery']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('full_name');
        });
    }
}
