<?php

namespace App\Nova;

use App\Models\ProductColor;
use App\Models\ProductColorSize;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Panel;

class ProductColorSizeResource extends Resource
{
    public static $model = ProductColorSize::class;
    public static $displayInNavigation = false;

    public static function label()
    {
        return 'Размер для цвета продукта';
    }

    public static $title = 'id';

    public static $search = [
        'id'
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            new Panel('Данные размера', array_merge(self::relations($request), [
                BelongsTo::make('Размер', 'size', Sizes::class),

                Select::make('Верх/Низ', 'position')
                    ->options([
                        ProductColorSize::POSITION_TOP => 'Верх',
                        ProductColorSize::POSITION_BOTTOM => 'Низ',
                    ])
                    ->default($request->viaRelationship === 'sizesBottom' ? ProductColorSize::POSITION_BOTTOM : ProductColorSize::POSITION_TOP)
                    ->required(),

                self::cactusVariantId(),
                self::price(),
                self::discount(),
            ])),
        ];
    }

    private static function relations(Request $request)
    {
        if ($request->viaResource === 'product-resources' and $request->viaResourceId) {
            $productColors = ProductColor::select(['id', 'product_id', 'color_id'])
                ->where('product_id', $request->viaResourceId)
                ->with('color')
                ->get();
            $colors = [];
            foreach ($productColors as $productColor) {
                $colors[$productColor->id] = \App\Models\Color::colorFullText($productColor->color);
            }

            return [
                Select::make('Цвет продукта', 'product_color_id')
                    ->options($colors)
                    ->required()
            ];
        } elseif ($request->viaResource === 'product-color-resources') {
            return [
                BelongsTo::make('Цвет продукта', 'productColor', ProductColorResource::class),
                Hidden::make('position')->default($request->viaRelationship === 'sizes' ? ProductColorSize::POSITION_TOP : ProductColorSize::POSITION_BOTTOM)
            ];
        }

        return [
            BelongsTo::make('Продукт', 'product', ProductResource::class)
                ->hideWhenUpdating()
                ->hideWhenCreating(),
            BelongsTo::make('Цвет продукта', 'productColor', ProductColorResource::class),
        ];
    }

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [];
    }
}
