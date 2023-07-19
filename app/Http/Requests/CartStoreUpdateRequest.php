<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Traits\HasSessionCart;
use Illuminate\Validation\Validator;

class CartStoreUpdateRequest extends CartListRequest
{
    use HasSessionCart;

    public function rules(): array
    {
        $rules = [
            'count' => 'required|numeric|min:1',
            'count_add' => 'sometimes|boolean',

            'cart_id' => 'sometimes|numeric|exists:carts,id',
            'product_id' => 'required_without:kit_id|numeric|exists:products,id',
            'product_color_id' => 'sometimes|numeric|exists:product_colors,id',
            'product_color_size_id' => 'sometimes|numeric|exists:product_color_sizes,id',
            'product_color_bottom_size_id' => 'sometimes|numeric|exists:product_color_sizes,id',
        ];

        return array_merge(parent::rules(), $rules);
    }

    public function withValidator(Validator $validator)
    {
        parent::withValidator($validator);

        $validator->after(function (Validator $validator) {
            if ($validator->failed()) return;

            if ($this->product_id) {
                $product = Product::with(['colors.sizes'])->find($this->product_id);

                $this->validateProduct($product, $validator, $this->product_color_id, $this->product_color_size_id, $this->product_color_bottom_size_id);
            }
        });
    }

    private function validateProduct(Product $product, Validator $validator, $product_color_id, $product_color_size_id, $product_color_bottom_size_id, $key_prefix = '')
    {
        // If product have colors
        if ($product->colors->count()) {
            $productColor = $product->colors()->with('sizes', 'sizesBottom')->where('id', $product_color_id)->first();

            // If product color not found
            if (!$productColor) {
                $validator->errors()->add($key_prefix . 'product_color_id', trans('validation.custom.product_color_id.selected'));
                return;
            }

            // If product color have sizes
            if ($productColor->sizes->count()) {
                $productColorSize = $productColor->sizes()->where('id', $product_color_size_id)->first();

                // If product color size not found
                if (!$productColorSize) {
                    $validator->errors()->add($key_prefix . 'product_color_size_id', trans('validation.custom.product_color_size_id.selected'));
                }
            }

            // If product color have sizes
            if ($productColor->sizesBottom->count()) {
                $productColorSize = $productColor->sizesBottom()->where('id', $product_color_bottom_size_id)->first();

                // If product color size not found
                if (!$productColorSize) {
                    $validator->errors()->add($key_prefix . 'product_color_bottom_size_id', trans('validation.custom.product_color_size_id.selected'));
                }
            }
        }
    }

    public function authorize(): bool
    {
        return true;
    }
}
