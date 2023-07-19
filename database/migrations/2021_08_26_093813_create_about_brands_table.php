<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_brands', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->json('meta_title');
            $table->json('meta_description');

            $table->text('text_color');

            $table->json('banner_description');

            $table->boolean('autostart_video');
            $table->integer('poster')->unsigned();

            $table->unsignedBigInteger('photo_comp')->nullable();
            $table->unsignedBigInteger('video_comp')->nullable();
            $table->unsignedBigInteger('photo_notebook')->nullable();
            $table->unsignedBigInteger('video_notebook')->nullable();
            $table->unsignedBigInteger('photo_tablet')->nullable();
            $table->unsignedBigInteger('video_tablet')->nullable();
            $table->unsignedBigInteger('photo_phone')->nullable();
            $table->unsignedBigInteger('video_phone')->nullable();


            $table->json('photo_blocks'); //FLEXIBLE

            $table->json('description');



            $table->json('slider_photos'); //FLEXIBLE

            $table->json('review_title');
            $table->json('reviews'); //FLEXIBLE

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_brands');
    }
}
