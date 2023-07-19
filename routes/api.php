<?php

use App\Http\Controllers\AboutBrandController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\LogAndRegController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PersonalAccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\ThanksPageController;
use App\Http\Middleware\LocaleMiddleware;
use App\Services\Cactus\CactusService;
use App\Services\DaDataService;
use App\Services\PayPal\PayPalService;
use App\Services\TalkMe\TalkMeService;
use App\Services\Yookassa\YookassaService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '{lang}', 'middleware' => 'locale'], function () {

    // Pages
    Route::get('/home-page', [HomePageController::class, 'homepage'])->name('homepage');
    Route::get('/aboutbrand', [AboutBrandController::class, 'aboutBrand'])->name('aboutbrand');
    Route::get('/catalog-page', [CatalogController::class, 'catalogPage']);

    Route::get('/partner', [PartnerController::class, 'partner'])->name('partner');
    Route::post('/partner-send', [PartnerController::class, 'partner_send']);

    Route::get('/product-page', [ProductPageController::class, 'index']);

    Route::get('/information', [InformationController::class, 'information'])->name('information');
    Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
    Route::post('/contact-send', [ContactController::class, 'contact_send']);

    Route::get('/personal-account', [PersonalAccountController::class, 'personalaccount'])->name('personalaccount');
    Route::get('/log-and-reg', [LogAndRegController::class, 'logandreg'])->name('logandreg');
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/thanks-page', [ThanksPageController::class, 'thankspage'])->name('thankspage');
    Route::get('/header', [HeaderController::class, 'header'])->name('header');
    Route::get('/footer', [FooterController::class, 'footer'])->name('footer');
    // ----------

    // Catalog
    Route::group(['prefix' => 'catalog'], function () {
        // Full data and list
        Route::get('/', [CatalogController::class, 'catalog']);

        // Get product not in category
        Route::get('/products/{product_slug}', [ProductController::class, 'product']);
    });

    // Cart and order cart
    Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
        Route::get('/', [CartController::class, 'list']);

        Route::post('/store', [CartController::class, 'storeUpdate']);
        Route::put('/update', [CartController::class, 'storeUpdate']);

        Route::delete('/delete/{id}', [CartController::class, 'delete']);

        Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
            Route::post('/', [OrderController::class, 'store']);
        });
    });

    // Auth
    Route::group(['middleware' => 'guest'], function () {
        Route::post('/register-check-send', [AuthController::class, 'registerCheckSend'])->name('register-check');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login-send', [AuthController::class, 'loginSend']);
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:api');
    // ----------

    // Customer
    Route::get('/customer-info', [CustomerController::class, 'client'])->name('client')->middleware('auth:api');
    Route::post('/customer-edit', [CustomerController::class, 'edit'])->middleware('auth:api');
});

// Yookassa
Route::group(['prefix' => 'yookassa'], function () {
    Route::post('/notification', [YookassaService::class, 'notification']);
});

// PayPal
Route::group(['prefix' => 'paypal'], function () {
    Route::post('/webhooks', [PayPalService::class, 'webhooks']);
});

// Dadata
Route::group(['prefix' => 'dadata', 'as' => 'dadata.'], function () {
    Route::get('/fetch', [DaDataService::class, 'fetch']);
});

// Cactus
Route::group(['prefix' => 'cactus', 'as' => 'cactus.'], function () {
    Route::get('/tariffs', [CactusService::class, 'tariffs']);
});

// Talk-Me
Route::group(['prefix' => 'talk-me', 'as' => 'talk-me.'], function () {
    Route::get('/messages', [TalkMeService::class, 'getMessagesByClient']);

    Route::post('/send-message', [TalkMeService::class, 'sendMessage']);

    Route::post('/set-message-status', [TalkMeService::class, 'setMessageStatus']);
});
