<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Sizes extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'sizes_name',
    ];
}
