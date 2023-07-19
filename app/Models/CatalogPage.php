<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class CatalogPage extends Model
{
    use HasTranslations;

    public $translatable = [
        'meta_title',
        'meta_description',
    ];
}
