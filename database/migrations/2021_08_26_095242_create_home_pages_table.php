<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->json('meta_title');
            $table->json('meta_description');

            $table->json('heading_sliders'); // FLEXIBLE

            $table->json('social');
            $table->json('social_url');

            $table->boolean('autostart_video');
            $table->integer('poster')->unsigned()->nullable();

            $table->json('title_clip');
            $table->json('description_clip');
            $table->integer('video_clip')->unsigned()->nullable();


            $table->json('categories'); //FLEXIBLE
            $table->json('title_collection_desktop');
            $table->json('collections_desktop'); //FLEXIBLE
            //$table->json('title_collection_mobile');
            $table->json('collections_mobile'); //FLEXIBLE

            $table->json('banners'); // FLEXIBLE

            $table->json('title');
            $table->json('description');

            $table->json('last_blocks'); // FLEXIBLE

            $table->boolean('autostart_video_2');
            $table->integer('poster_2')->unsigned()->nullable();
            $table->integer('video')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_pages');
    }
}
