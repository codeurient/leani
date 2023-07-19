<?php

namespace App\Nova;

use App\Models\ProductPage;
use ClassicO\NovaMediaLibrary\MediaLibrary;
use Digitalcloud\MultilingualNova\Multilingual;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class ProductPageResource extends Resource
{
    public static $model = ProductPage::class;

    public static $group = 'Страницы';

    public static function label() {
        return 'Страница продукта';
    }

    public static $title = 'id';

    public static $search = [
        'id'
    ];

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Multilingual::make('Language'),

            MediaLibrary::make('Изображение размерной сетки', 'size_chart')->required(),

            Text::make('Ссылка для размерной сетки', 'size_chart_link')->required(),
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
