<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Partner extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'meta_title',
        'meta_description',

        'description',
        'button_name',
        'banner_description',

        'texts_links', // FLEXIBLE
        //'text_politic',
    ];
}
