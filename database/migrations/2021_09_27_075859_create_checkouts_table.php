<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->json('meta_title');
            $table->json('meta_description');

            $table->json('title');
            $table->json('title_shipping_fields');
            $table->json('description');

            $table->json('exchange_and_return_of_goods');
            $table->json('link_of_exchange_and_return_of_goods');

            $table->json('payment_title');
            $table->json('button_name');

            $table->json('texts_links'); //FLEXIBLE


            //$table->json('text_сontract_offer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
}
