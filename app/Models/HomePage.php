<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class HomePage extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [

        'meta_title',
        'meta_description',

        'heading_sliders',//FLEXIBLE

        'social',
        'social_url',

        'title_clip',
        'description_clip',

        'categories',//FLEXIBLE

        'title_collection_desktop',
        'collections_desktop', //FLEXIBLE
        //'title_collection_mobile',
        'collections_mobile', //FLEXIBLE

        'banners',//FLEXIBLE

        'title',
        'description',

        'last_blocks',//FLEXIBLE

    ];
}
