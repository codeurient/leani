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

class PersonalAccount extends Resource
{
    public static function label() {
        return 'Личный кабинет';
    }
    public static $group = 'Страницы';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PersonalAccount::class;

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


            Heading::make('Личные кабинет'),
            Text::make('Заголовок', 'title')
                ->rules('required'),
            Text::make('Заголовок карточки', 'card_title')
                ->rules('required'),
            Text::make('Про бонус', 'about_bonus')
                ->placeholder('1 БОНУС = 1 РУБЛЬ')
                ->rules('required'),
            Text::make('Условия программы бонусов', 'bonus_program_terms')
                ->rules('required'),
            Text::make('Url', 'url')
                ->rules('required'),
            Text::make('Заголовок для описания', 'title_for_description')
                ->rules('required'),
            Trix::make('Описание', 'description')
                ->hideFromIndex()
                ->rules('required'),

            Text::make('Заголовок личных данных ', 'personal_data_title')
                ->hideFromIndex()
                ->rules('required'),
            Text::make('Заголовок для адреса', 'title_for_address')
                ->hideFromIndex()
                ->rules('required'),

            Heading::make('Способ связи'),
            Trix::make('Текст ', 'text')
                ->hideFromIndex()
                ->rules('required', 'max:255'),
            Text::make('Email', 'email')
                ->hideFromIndex()
                ->rules('required', 'max:255'),
            Text::make('Сервис', 'service')
                ->hideFromIndex()
                ->rules('required', 'max:255'),
            Text::make('Сервис URl', 'service_url')
                ->hideFromIndex()
                ->rules('required', 'max:255'),


/*            Heading::make('Политика использования данных'),
            Flexible::make('','texts_links')
                ->fullWidth()
                ->addLayout('Текст', 'text',[
                    Text::make('Текст','add_text')
                ])
                ->addLayout('Текст и ссылка', 'link',[
                    Text::make('Текст ссылки','add_text_link'),
                    Text::make('Ссылка','add_link'),
                ])
                ->button('Добавить'),*/

/*            Heading::make('Политика использования данных'),
            Trix::make('Условия программы бонусов','text_bonus_program_terms')*/
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
