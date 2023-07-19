<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogAndRegsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_and_regs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->json('meta_title');
            $table->json('meta_description');

            $table->json('title');
            $table->json('description');
            $table->json('button_name');
            $table->json('text_under_the_login_form');
            $table->json('registration_button_name');
            $table->json('link_name_for_registration');
            $table->json('registration_block_header');

            $table->json('texts_links'); //FLEXIBLE
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_and_regs');
    }
}
