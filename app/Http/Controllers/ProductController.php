<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product(Request $request)
    {
        $product_slug = $request->product_slug;

        $product = Product::where('slug', $product_slug)
            ->with(['colors' => function ($q) {
                $q->with('color');
                $q->with('sizes.size')->with('sizesBottom.size');
            }, 'recommendations.colors'])
            ->firstOrFail();

        $product->processImages();

        return ResponseService::successWithHeaderFooter($product);
    }
}
