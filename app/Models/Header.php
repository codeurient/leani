<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Header extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'blocks',
    ];

    public function category(){
        return $this->hasMany(Category::class);
    }

    public static function getData()
    {
        return self::latest()->first();
    }
}
