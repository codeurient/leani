<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class AboutBrand extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [

        'meta_title',
        'meta_description',

        'photo_blocks', //FLEXIBLE

        'description',

        'banner_description',

        'slider_photos', //FLEXIBLE

        'review_title',

        'reviews', //FLEXIBLE

        'banner_description',
    ];
}
