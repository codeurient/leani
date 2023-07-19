<?php

namespace App\Nova;

use ClassicO\NovaMediaLibrary\MediaLibrary;
use Digitalcloud\MultilingualNova\Multilingual;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;

class Contact extends Resource
{
    public static function label() {
        return 'Контакты';
    }
    public static $group = 'Страницы';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contact::class;

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

            Heading::make('Контакты'),
            Text::make('Карта iframe', 'map_iframe')
                ->hideFromIndex()
                ->rules('required', 'max:1000'),
            Flexible::make('','contacts')
                ->fullWidth()
                ->addLayout('', 'contact',[
                    Trix::make('Текст', 'add_contact')
                        ->rules('required', 'max:255'),
                ])
                ->button('Добавить поле'),


            Heading::make('Форма обратной связи'),
            Text::make('Заголовок', 'title')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Название кнопки','button_name'),


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

            Heading::make('Ссылка на социальную сеть'),
            Flexible::make('','social')
                ->addLayout('Social item','social_item',[
                    MediaLibrary::make('Social logo','social_logo')
                        ->rules('required'),
                    Text::make('Url', 'url')
                        ->rules('required', 'max:255'),
                ])
                ->button('Добавить элемент')
                ->rules('required')
                ->fullWidth(),

/*            Heading::make('Политика использования данных'),
            Trix::make('Политика','text_politic')*/

/*            Heading::make('Политика конфиденциальности'),
            Text::make('Текст', 'text')
                ->hideFromIndex()
                ->rules('required', 'max:500'),
            Text::make('Текст для url', 'text_for_url')
                ->hideFromIndex()
                ->rules('required', 'max:255'),
            Text::make('Url', 'url')
                ->hideFromIndex()
                ->rules('required', 'max:500'),*/

            /*Text::make('Название компании', 'company_name')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Адрес', 'address')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Время работы', 'work_time')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Телефон', 'phone')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Email', 'email')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),*/

/*            Flexible::make('Социальные сети', 'socials')
                ->addLayout('Социальная сеть', 'social', [
                    Text::make('Названия', 'name')
                        ->rules('required', 'max:255'),
                    Text::make('Url', 'url')
                        ->rules('required', 'max:255'),
                    MediaLibrary::make('Лого','logo'),
                ])->button('Добавить соцсетей'),*/

            /*GoogleMaps::make('Map', 'map')
                ->zoom(8),*/

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
