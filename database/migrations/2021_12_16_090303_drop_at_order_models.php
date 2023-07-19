<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAtOrderModels extends Migration
{
    public function up()
    {
        Schema::dropIfExists('order_models');
    }
}
