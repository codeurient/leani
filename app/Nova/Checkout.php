<?php

namespace App\Nova;

use Digitalcloud\MultilingualNova\Multilingual;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Checkout extends Resource
{
    public static function label() {
        return 'Оформление заказа';
    }
    public static $group = 'Страницы';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Checkout::class;

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
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Описание метатега', 'meta_description')
                ->sortable()
                ->rules('required', 'max:255'),


            Heading::make('Поля для страницы оформления заказа'),
            Text::make('Заголовок', 'title')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Поле заголовка доставки', 'title_shipping_fields')
                ->sortable()
                ->rules('required', 'max:255'),
            Trix::make('Описание', 'description')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Порядок обмена и возврата товара', 'exchange_and_return_of_goods')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Ссылка на порядок обмена и возврата товара', 'link_of_exchange_and_return_of_goods')
                ->sortable()
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Text::make('Заголовок платежа', 'payment_title')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Название кнопки', 'button_name')
                ->sortable()
                ->rules('required', 'max:255'),


            Heading::make('Политика использования данных'),
            Flexible::make('','texts_links')
                ->fullWidth()
                ->addLayout('Текст', 'text',[
                    Text::make('Текст','add_text')
                ])
                ->addLayout('Текст и ссылка', 'link',[
                    Text::make('Текст ссылки','add_text_link'),
                    Text::make('Ссылка','add_link'),
                ])
                ->button('Добавить'),

/*            Heading::make('Политика использования данных'),
            Trix::make('Договор оферты','text_сontract_offer')*/
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
