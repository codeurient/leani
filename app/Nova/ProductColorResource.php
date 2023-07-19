<?php

namespace App\Nova;

use App\Models\ProductColor;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Panel;

class ProductColorResource extends Resource
{
    public static $model = ProductColor::class;
    public static $group = 'Продукты';
    public static $displayInNavigation = false;

    public static $with = ['color'];

    public static function label()
    {
        return 'Цвет продукта';
    }

    public function title()
    {
        return \App\Models\Color::colorFullText($this->color);
    }

    public static $search = [
        'id'
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            new Panel('Данные цвета', [
                BelongsTo::make('Продукт', 'product', ProductResource::class),
                BelongsTo::make('Цвет', 'color', Color::class),
                self::SKUField(),
                self::cactusVariantId(),
                self::price(),

                $this->isNewBoolean(),
                $this->discountBoolean(),
                NovaDependencyContainer::make([
                    self::discount(),
                ])->dependsOn('on_sale', true),
            ]),

            HasMany::make('Размеры для цвета бюстгальтера', 'sizes', ProductColorSizeResource::class),

            HasMany::make('Размеры для цвета низа', 'sizesBottom', ProductColorSizeResource::class),

            new Panel('Медиа', [
                self::mainImages('отображение в каталоге'),
                self::images('отображение в карточке товара'),
            ]),
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
