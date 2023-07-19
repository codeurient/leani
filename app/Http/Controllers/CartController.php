<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartListRequest;
use App\Http\Requests\CartStoreUpdateRequest;
use App\Models\Cart;
use App\Services\ResponseService;
use App\Traits\HasAuthCheck;

class CartController extends Controller
{
    use HasAuthCheck;

    public function storeUpdate(CartStoreUpdateRequest $request)
    {
        $cart = Cart::notPayed()->searchByCustomer($this->customer_id, $request->session_cart)
            ->when($request->cart_id, function ($q) use ($request) {
                return $q->where('id', $request->cart_id);
            }, function ($q) use ($request) {
                return $q->when($request->product_id, function ($q) use ($request) {
                    return $q->where('product_id', $request->product_id)
                        ->where('product_color_id', $request->product_color_id)
                        ->where('product_color_size_id', $request->product_color_size_id)
                        ->where('product_color_bottom_size_id', $request->product_color_bottom_size_id);
                });
            })
            ->first();

        if (!$cart) $cart = new Cart();

        if ($request->count_add) $cart->count += $request->count;
        else $cart->count = $request->count;

        $cart->customer_id = $this->customer_id;

        $cart->product_id = $request->product_id;
        $cart->product_color_id = $request->product_color_id;
        $cart->product_color_size_id = $request->product_color_size_id;
        $cart->product_color_bottom_size_id = $request->product_color_bottom_size_id;

        $cart->save();

        $request->session_cart = array_merge($request->session_cart ?? [], [$cart->id]);

        return $this->list($request);
    }

    public function list(CartListRequest $request)
    {
        $cart = Cart::notPayed()->searchByCustomer($this->customer_id, $request->session_cart)->with(['product' => function ($q) {
            $q->with('colors.color');
            $q->with('colors.sizes.size');
            $q->with('colors.sizesBottom.size');
        }])->get();

        foreach ($cart as &$item) {
            $item->product->processImages();
        }

        return ResponseService::success($cart);
    }

    public function delete($id, CartListRequest $request)
    {
        $cart = Cart::notPayed()->searchByCustomer($this->customer_id, $request->session_cart)->where('id', $id)->firstOrFail();
        $cart->delete();

        return ResponseService::success('Product removed from cart.');
    }
}
