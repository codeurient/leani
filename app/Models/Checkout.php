<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Checkout extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'meta_title',
        'meta_description',

        'title',
        'title_shipping_fields',
        'description',

        'exchange_and_return_of_goods',
        'link_of_exchange_and_return_of_goods',

        'payment_title',
        'button_name',

        'texts_links', // FLEXIBLE

        //'text_сontract_offer',
    ];
}
