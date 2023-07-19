<?php

namespace App\Nova;

use ClassicO\NovaMediaLibrary\MediaLibrary;
use Digitalcloud\MultilingualNova\Multilingual;
use Drobee\NovaSluggable\SluggableText;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Information extends Resource
{
    public static function label() {
        return 'Информация';
    }
    public static $group = 'Страницы';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Information::class;

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

            Heading::make('Цвет для баннера'),
            $this->colorsStatic(),

            Heading::make('Описание для баннера'),
            Trix::make('Описание', 'banner_description'),

            Heading::make('Настройка видео'),
            Boolean::make('Автозапуск видео', 'autostart_video'),
            MediaLibrary::make('Постер','poster')->nullable(),

            Heading::make('Фото или видео для компьютера'),
            MediaLibrary::make('Фото','photo_comp')->hideFromIndex()->nullable(),
            MediaLibrary::make('Видео','video_comp')->hideFromIndex()->nullable(),

            Heading::make('Фото или видео для ноутбука'),
            MediaLibrary::make('Фото','photo_notebook')->hideFromIndex()->nullable(),
            MediaLibrary::make('Видео','video_notebook')->hideFromIndex()->nullable(),

            Heading::make('Фото или видео для планшета'),
            MediaLibrary::make('Фото','photo_tablet')->hideFromIndex()->nullable(),
            MediaLibrary::make('Видео','video_tablet')->hideFromIndex()->nullable(),

            Heading::make('Фото или видео для мобильного'),
            MediaLibrary::make('Фото','photo_phone')->hideFromIndex()->nullable(),
            MediaLibrary::make('Видео','video_phone')->hideFromIndex()->nullable(),



            Heading::make('Информация'),
            Flexible::make('','infos')
                ->fullWidth()
                ->addLayout('Информация', 'info',[
                    Text::make('Заголовок', 'title')
                        ->rules('required', 'max:255'),
                    Trix::make('Описание', 'description')
                        ->rules('required'),
                    Flexible::make('','logos')
                        ->fullWidth()
                        ->addLayout('Информация', 'logo',[
                            MediaLibrary::make('Лого','add_logo'),
                        ])
                        ->button('Добавить лого'),
                ])
                ->button('Добавить инфо'),

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
