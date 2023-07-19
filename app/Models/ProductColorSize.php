<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class ProductColorSize extends Model
{
    use BelongsToThrough;

    protected $casts = [
      'price' => 'float',
    ];

    const POSITION_TOP = 'top';
    const POSITION_BOTTOM = 'bottom';

    public function productColor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function size(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Sizes::class);
    }

    public function product(): \Znck\Eloquent\Relations\BelongsToThrough
    {
        return $this->belongsToThrough(Product::class, ProductColor::class);
    }
}
