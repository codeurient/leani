<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_accounts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->json('meta_title');
            $table->json('meta_description');

            $table->json('title');
            $table->json('card_title');
            $table->json('about_bonus');
            $table->json('bonus_program_terms');
            $table->json('url');
            $table->json('title_for_description');
            $table->json('description');
            $table->json('personal_data_title');
            $table->json('title_for_address');

            $table->json('text');
            $table->json('email');
            $table->json('service');
            $table->json('service_url');

            //$table->json('texts_links'); //FLEXIBLE

            //$table->json('text_bonus_program_terms');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_accounts');
    }
}
