<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToCustomers extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('address')->nullable();
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }
}
