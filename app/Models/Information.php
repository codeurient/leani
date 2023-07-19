<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Information extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [

        'meta_title',
        'banner_description',
        'meta_description',

        'infos', // FLEXIBLE

    ];
}
