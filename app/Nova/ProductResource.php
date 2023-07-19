<?php

namespace App\Nova;

use App\Models\Product;
use ClassicO\NovaMediaLibrary\MediaLibrary;
use Digitalcloud\MultilingualNova\Multilingual;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasManyThrough;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class ProductResource extends Resource
{
    public static string $model = Product::class;
    public static $group = 'Продукты';
    public static $title = 'name';
    public static $search = [
        'id'
    ];

    public static function label()
    {
        return __('Products');
    }

    public static function singularLabel()
    {
        return __('Product');
    }

    public function fields(Request $request): array
    {
        return [
            Multilingual::make('Language'),
            ID::make()->sortable(),

            new Panel('Данные продукта', [
                Text::make('Название продукта', 'name')
                    ->sortable()
                    ->rules(['required']),

                Slug::make('Slug')
                    ->from('name')
                    ->sortable()
                    ->rules(['max:255']),

                Text::make('Состав продукта', 'composition')
                    ->sortable(),

                self::SKUField(),

                self::price(),

                $this->isNewBoolean(),
                $this->discountBoolean(),
                NovaDependencyContainer::make([
                    self::discount(),
                ])->dependsOn('on_sale', true),

                Trix::make('Описание', 'description')
                    ->hideFromIndex(),
                Trix::make('Детали', 'details')
                    ->hideFromIndex(),

                Flexible::make('Основные характеристики', 'main_attributes')
                    ->addLayout('Характеристика', 'wysiwyg', [
                        Text::make('Название характеристики', 'attribute_text'),
                    ])
                    ->hideFromIndex()
                    ->nullable(),

                MediaLibrary::make('Отзывы к продукту', 'review_photos')
                    ->array()
                    ->hideFromIndex()
                    ->nullable()
            ]),

            new Panel('Отображение в каталоге', [
                Text::make('Название в меню', 'menu_title')
                    ->hideFromIndex(),

                $this->sort(),

                $this->colorsStatic()->hideFromIndex(),

                MediaLibrary::make('Фото', 'photo')->hideFromIndex()->nullable(),
            ]),

            new Panel('Медиа продукта', [
                self::mainImages('отображение в каталоге'),
                self::images('отображение в карточке товара'),
            ]),

            HasMany::make('Цвета продукта', 'colors', ProductColorResource::class),

            HasManyThrough::make('Размеры для цвета бюстгальтера', 'sizes', ProductColorSizeResource::class),
            HasManyThrough::make('Размеры для низа', 'sizesBottom', ProductColorSizeResource::class),

            BelongsToMany::make('Рекомендации к продукту', 'recommendations', ProductResource::class),

            new Panel('Мета данные', [
                Text::make('Мета тег заголовка', 'meta_title')
                    ->hideFromIndex()
                    ->sortable()
                    ->rules('max:255'),
                Text::make('Мета тег описание', 'meta_description')
                    ->hideFromIndex()
                    ->sortable()
                    ->rules('max:255'),
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
