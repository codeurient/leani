<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Color extends Model
{
    use HasFactory, HasTranslations;

    public static function colorFullText($color_row): string
    {
        $color = $color_row->color;
        if ($color_row->more_color) {
            $color .= ' / ' . $color_row->more_color;
        }

        return $color_row->colors_name . ' (' . $color . ')';
    }

    public $translatable = [
        'colors_name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function nameProduct()
    {
        return $this->belongsToMany(NameProduct::class);
    }
}
