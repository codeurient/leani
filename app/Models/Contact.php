<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Contact extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'meta_title',
        'meta_description',

        'contacts', // FLEXIBLE
        'banner_description',

        'title',
        'button_name',

        'texts_links', // FLEXIBLE

        'social', // FLEXIBLE

        //'text_politic',
    ];
}
