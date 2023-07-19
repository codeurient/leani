<?php

namespace App\Nova;

use ClassicO\NovaMediaLibrary\MediaLibrary;
use Digitalcloud\MultilingualNova\Multilingual;
use Drobee\NovaSluggable\Slug;
use Drobee\NovaSluggable\SluggableText;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Header extends Resource
{
    public static function label() {
        return 'Шапка';
    }
    public static $group = 'Страницы';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Header::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Multilingual::make('Language'),
            ID::make(__('ID'), 'id')->sortable(),

            Flexible::make('', 'blocks')
                ->fullWidth()
                ->addLayout('', 'block', [
                    Text::make('Название меню', 'menu_name')
                        ->sortable()
                        ->rules( 'required', 'max:255'),
                    Select::make('Опции','options')
                        ->options([
                            '/' => 'main',
                            '/catalog' => '/catalog',
                            '/about-brand' => '/about-brand',
                            '/kits' => '/kits',
                            '/partners' => '/partners',
                            '/info' => '/info',
                            '/contacts' => '/contacts',
                            '/checkout' => '/checkout',
                            '/thank-page' => '/thanks page',
                        ])
                        ->rules('required'),

                    Boolean::make('Flash', 'flash'),

                    Heading::make('Подменю'),
                    Flexible::make('', 'subcategories')
                        ->fullWidth()
                        ->addLayout('', 'category', [
                            /*Select::make('Категория', 'category_id')
                                ->searchable()
                                ->options(
                                    \App\Models\Category::query()
                                        ->select('id','category_name->' .App::currentLocale().' as name')
                                        ->pluck('name','id')
                                )->displayUsingLabels(),*/

                            Text::make('Подменю', 'category_name'),
                            Text::make('Url', 'url'),

                        ])->button('Добавить')

                ])->button('Добавить')

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
