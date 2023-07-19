<?php

namespace App\Http\Controllers;

use App\Models\CatalogPage;
use App\Models\Product;
use App\Services\ResponseService;

class CatalogController extends Controller
{
    public function catalogPage()
    {
        return ResponseService::successWithHeaderFooter(CatalogPage::latest()->first());
    }

    public function catalog()
    {
        $products = Product::sort()
            ->with(['colors' => function ($q) {
                $q->with('color');
                $q->with('sizes.size')->with('sizesBottom.size');
            }])
            ->get();

        foreach ($products as &$product) {
            $product->processImages();
        }

        return ResponseService::successWithHeaderFooter($products);
    }
}
