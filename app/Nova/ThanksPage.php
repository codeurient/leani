<?php

namespace App\Nova;

use ClassicO\NovaMediaLibrary\MediaLibrary;
use Digitalcloud\MultilingualNova\Multilingual;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class ThanksPage extends Resource
{
    public static function label() {
        return 'Страница благодарности';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ThanksPage::class;
    public static $group = 'Страницы';

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


            Heading::make('Мета теги'),
            Text::make('Заголовок метатега', 'meta_title')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Описание метатега', 'meta_description')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),

            Heading::make('Шапка'),
            Trix::make('Заголовок', 'title')
                ->hideFromIndex()
                ->rules('max:255'),
            Text::make('Текст возле номера заказа', 'text_order_number')
                ->hideFromIndex()
                ->rules( 'max:255'),
            Text::make('Описание', 'description')
                ->hideFromIndex()
                ->rules( 'max:255'),

            Heading::make('Блок с изображением и описанием'),
            Flexible::make('','blocks')
                ->fullWidth()
                ->addLayout('Описание', 'block',[
                    MediaLibrary::make('Картинка','photo'),
                    Trix::make('Описание', 'description')
                        ->hideFromIndex(),
                    Text::make('Название кнопки', 'button_name')
                        ->hideFromIndex()
                        ->rules( 'max:255'),
                    Text::make('Url', 'url')
                        ->hideFromIndex()
                        ->rules( 'max:255'),
                ])
                ->button('Добавить описание')->limit(2),



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
