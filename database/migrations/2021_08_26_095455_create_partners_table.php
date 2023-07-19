<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->json('meta_title');
            $table->json('meta_description');
            $table->boolean('autostart_video');
            $table->integer('poster')->unsigned()->nullable();
            $table->integer('photo_comp')->unsigned()->nullable();
            $table->integer('video_comp')->unsigned()->nullable();
            $table->integer('photo_notebook')->unsigned()->nullable();
            $table->integer('video_notebook')->unsigned()->nullable();
            $table->integer('photo_tablet')->unsigned()->nullable();
            $table->integer('video_tablet')->unsigned()->nullable();
            $table->integer('photo_phone')->unsigned()->nullable();
            $table->integer('video_phone')->unsigned()->nullable();
            $table->json('description');
            $table->json('button_name');
            $table->json('banner_description');
            $table->json('texts_links'); //FLEXIBLE
            $table->text('text_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partners');
    }
}
