<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    public $casts = [
        'main_image' => 'array',
        'images' => 'array',
        'price' => 'float',
    ];

    public function scopeNotUnique($q)
    {
        return $q->whereRaw('color_id IN (SELECT color_id FROM product_colors GROUP BY color_id HAVING COUNT(*) > 1)')
            ->orderBy('color_id', 'asc');
    }

    public function color(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function sizes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductColorSize::class)->where('position', ProductColorSize::POSITION_TOP);
    }

    public function sizesBottom(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductColorSize::class)->where('position', ProductColorSize::POSITION_BOTTOM);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function processImages()
    {
        $this->main_image = Controller::getMedia($this->getOriginal('main_image'));
        $this->images = Controller::getMedia($this->getOriginal('images'));
    }
}
