<?php

namespace App\Nova;

use Digitalcloud\MultilingualNova\Multilingual;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Footer extends Resource
{
    public static function label() {
        return 'Подвал';
    }
    public static $group = 'Страницы';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Footer::class;

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

            /*            Text::make('Автор', 'copyright_name')
                            ->rules('required', 'max:255'),*/
            Flexible::make('', 'blocks')
                ->fullWidth()
                ->addLayout('', 'block', [
                    Text::make('Название меню', 'menu_name')
                        ->sortable()
                        ->rules( 'required', 'max:255'),
                    Select::make('Меню','menu')
                        ->options([
                            '/' => 'main',
                            '/catalog' => '/catalog',
                            '/about-brand' => '/about-brand',
                            '/kits' => '/kits',
                            '/partners' => '/partners',
                            '/info' => '/info',
                            '/contacts' => '/contacts',
                            '/checkout' => '/checkout',
                            '/thank-page' => '/thanks-page',
                            '/cabinet' => '/cabinet',
                        ])
                        ->rules('required'),
                ])->button('Добавить меню'),




            Text::make('Год создания сайта ', 'site_creation_year')
                ->rules('required', 'max:255'),

            Text::make('Номер телефона', 'phone')
                ->rules('required', 'max:255'),

            Flexible::make('Социальные сети', 'socials')
                ->fullWidth()
                ->addLayout('Социальная сеть', 'social', [
                    Text::make('Названия', 'name')
                        ->rules('required', 'max:255'),
                    Text::make('Url', 'url')
                        ->rules('required', 'max:255'),
                ])->button('Добавить соцсетей'),



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
