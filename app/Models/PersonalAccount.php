<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class PersonalAccount extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'meta_title',
        'meta_description',

        'title',
        'card_title',
        'about_bonus',
        'bonus_program_terms',
        'url',
        'title_for_description',
        'description',
        'personal_data_title',
        'title_for_address',

        'text',
        'email',
        'service',
        'service_url',

        //'texts_links', // FLEXIBLE

        //'text_bonus_program_terms',
    ];
}
