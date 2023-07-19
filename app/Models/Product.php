<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasTranslations;

    public $casts = [
        'main_image' => 'array',
        'images' => 'array',
        'review_photos' => 'array',
        'price' => 'float',
    ];

    public array $translatable = [
        'name',
        'description',
        'details',
        'meta_title',
        'meta_description',

        'menu_title',
        'main_attributes',
    ];

    public function scopeSort($q, $direction = 'asc')
    {
        return $q->orderBy('sort', $direction)
            ->orderBy('name->' . \App::getLocale(), $direction);
    }

    public function colors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductColor::class);
    }

    public function sizes(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(ProductColorSize::class, ProductColor::class)->where('position', ProductColorSize::POSITION_TOP);
    }

    public function sizesBottom(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(ProductColorSize::class, ProductColor::class)->where('position', ProductColorSize::POSITION_BOTTOM);
    }

    public function recommendations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_recommendation', 'product_id', 'recommendation_id');
    }

    public function processImages()
    {
        $this->main_image = Controller::getMedia($this->getOriginal('main_image'));
        $this->images = Controller::getMedia($this->getOriginal('images'));
        $this->review_photos = Controller::getMedia($this->getOriginal('review_photos'));
        $this->photo = Controller::getMedia($this->getOriginal('photo'));

        if ($this->relationLoaded('colors')) {
            foreach ($this->colors as &$color) {
                $color->processImages();
            }
        }

        if ($this->relationLoaded('recommendations')) {
            foreach ($this->recommendations as &$recommendation) {
                $recommendation->processImages();
            }
        }
    }
}
