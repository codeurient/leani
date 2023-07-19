<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogPagesTable extends Migration
{
    public function up()
    {
        Schema::create('catalog_pages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->json('meta_title');
            $table->json('meta_description');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalog_pages');
    }
}
