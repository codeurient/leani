<?php

namespace App\Http\Controllers;

use App\Models\ProductPage;
use App\Services\ResponseService;

class ProductPageController extends Controller
{
    public function index()
    {
        $productPage = ProductPage::latest()->first();
        $productPage->processImages();

        return ResponseService::success($productPage);
    }
}
