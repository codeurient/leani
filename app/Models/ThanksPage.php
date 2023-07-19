<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class ThanksPage extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [

        'meta_title',
        'meta_description',

        'title',
        'text_order_number',
        'description',

        'blocks',
    ];
}
