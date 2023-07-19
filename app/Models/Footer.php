<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Footer extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        //'copyright_name',
        'site_creation_year',
        'phone',
        'socials',
        'blocks' // FLEXIBLE
    ];

    public static function getData()
    {
        return self::query()->first();
    }
}
