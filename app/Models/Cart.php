<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public float $cost;
    public float $total_cost;

    public function getTitleAttribute()
    {
        $title = '';
        if ($this->product_id) {
            $title .= $this->product->name;
        }

        return $title;
    }

    public function calcCost()
    {
        $this->cost = 0;

        // If in cart product
        if ($this->product_id) {
            $this->costFromProduct($this->product, $this->product_color_id, $this->product_color_size_id, $this->product_color_bottom_size_id);
        }

        $this->cost = round($this->cost, 2);
        $this->total_cost = round($this->cost * $this->count, 2);
    }

    public function scopeSearchByCustomer($q, $customer_id = null, $session_cart = [])
    {
        return $q->where('customer_id', $customer_id)
            ->when(!$customer_id, function ($q) use ($session_cart) {
                $q->whereIn('id', $session_cart);
            });
    }

    public function scopeNotPayed($q)
    {
        return $q->where('payed', false);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    private function costFromProduct(Product $product, $product_color_id = null, $product_color_size_id = null, $product_color_bottom_size_id = null)
    {
        $this->cost = $this->calcDiscount($product->price, $product->discount);

        // If chosen product color
        if ($product_color_id) {
            $productColor = $product->colors->first(function ($value, $key) use ($product_color_id) {
                return $value->id === $product_color_id;
            });
            $this->cost += $this->calcDiscount($productColor->price, $productColor->discount);;

            if ($product_color_size_id) {
                $productColorSize = $product->sizes->first(function ($value, $key) use ($product_color_size_id) {
                    return $value->id === $product_color_size_id;
                });
                $this->cost += $this->calcDiscount($productColorSize->price, $productColorSize->discount);;
            }

            if ($product_color_bottom_size_id) {
                $productColorSize = $product->sizesBottom->first(function ($value, $key) use ($product_color_bottom_size_id) {
                    return $value->id === $product_color_bottom_size_id;
                });
                $this->cost += $this->calcDiscount($productColorSize->price, $productColorSize->discount);;
            }
        }

        $this->cost = round($this->cost, 2);
    }

    private function calcDiscount($price, $discount): float
    {
        if(!$discount) return round(floatval($price), 2);

        return round($price - ($price * $discount / 100), 2);
    }
}
