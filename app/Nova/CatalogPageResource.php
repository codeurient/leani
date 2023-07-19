<?php

namespace App\Nova;

use App\Models\CatalogPage;
use Digitalcloud\MultilingualNova\Multilingual;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class CatalogPageResource extends Resource
{
    public static $model = CatalogPage::class;

    public static $title = 'id';

    public static $search = [
        ''
    ];

    public static function label()
    {
        return 'Каталог';
    }

    public static $group = 'Страницы';


    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            Multilingual::make('Language'),

            Text::make('Заголовок метатега', 'meta_title')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Описание метатега', 'meta_description')
                ->sortable()
                ->rules('required', 'max:255'),
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
