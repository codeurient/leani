<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class LogAndReg extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'meta_title',
        'meta_description',

        'title',
        'description',
        'button_name',
        'text_under_the_login_form',
        'registration_button_name',
        'link_name_for_registration',
        'registration_block_header',

        'texts_links', // FLEXIBLE
    ];
}
