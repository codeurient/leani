<?php

namespace App\Nova;

use ClassicO\NovaMediaLibrary\MediaLibrary;
use Digitalcloud\MultilingualNova\Multilingual;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Whitecube\NovaFlexibleContent\Flexible;

class HomePage extends Resource
{
    public static function label()
    {
        return 'Главная';
    }

    public static $group = 'Страницы';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\HomePage::class;

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
     * @param Request $request
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


            Heading::make('Баннер'),
            Flexible::make('', 'heading_sliders')
                ->fullWidth()
                ->addLayout('Слайд', 'heading_slider', [
                    /*Boolean::make('Темный ?','on_off'),*/
                    $this->colorsStatic(),
                    Text::make('Заголовок', 'title')
                        ->hideFromIndex()
                        ->rules('max:500'),
                    /*                    Trix::make('Описание', 'description')
                                            ->hideFromIndex(),*/
                    Text::make('Название кнопки', 'button_name')
                        ->hideFromIndex()
                        ->rules('max:255'),

                    Heading::make('Внутренняя ссылка или внешняя сслыка'),
                    Text::make('Внутренняя или внешняя ссылка', 'link')
                        ->hideFromIndex(),
                    /*                    Text::make('Внутренняя ссылка', 'external_link')
                                            ->hideFromIndex(),
                                        Text::make('Внешняя сслыка', 'internal_link')
                                            ->hideFromIndex(),*/

                    Heading::make('Настройка видео'),
                    Boolean::make('Автозапуск видео', 'autostart_video'),
                    MediaLibrary::make('Постер', 'poster'),

                    Heading::make('Фото или видео для компьютера'),
                    MediaLibrary::make('Фото', 'photo_comp')->nullable(),
                    MediaLibrary::make('Видео', 'video_comp')->nullable(),

                    Heading::make('Фото или видео для ноутбука'),
                    MediaLibrary::make('Фото', 'photo_notebook')->nullable(),
                    MediaLibrary::make('Видео', 'video_notebook')->nullable(),

                    Heading::make('Фото или видео для планшета'),
                    MediaLibrary::make('Фото', 'photo_tablet')->nullable(),
                    MediaLibrary::make('Видео', 'video_tablet')->nullable(),

                    Heading::make('Фото или видео для мобильного'),
                    MediaLibrary::make('Фото', 'photo_phone')->nullable(),
                    MediaLibrary::make('Видео', 'video_phone')->nullable(),

                ])
                ->button('Добавить слайд'),


            Text::make('Социальная сеть', 'social')
                ->hideFromIndex()
                ->rules('required', 'max:255'),
            Text::make('Url', 'social_url')
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Heading::make('Настройка видео'),
            Boolean::make('Автозапуск видео', 'autostart_video'),
            MediaLibrary::make('Постер', 'poster')->nullable(),

            Heading::make('Видеоролик с текстом'),
            Text::make('Заголовок', 'title_clip')
                ->hideFromIndex()
                ->rules('required', 'max:255'),
            Trix::make('Описание', 'description_clip')
                ->hideFromIndex()
                ->rules('required'),
            MediaLibrary::make('Видеоролик', 'video_clip')->nullable(),


            Heading::make('Новая Коллекция для desktop'),
            Text::make('Заголовок', 'title_collection_desktop')
                ->hideFromIndex()
                ->rules('required', 'max:255'),


            Flexible::make('Категория', 'categories')
                ->fullWidth()
                ->fullWidth()
                ->addLayout('', 'category', [
                    Text::make('Категория', 'add_category'),

                    Flexible::make('Фото', 'photos')
                        ->fullWidth()
                        ->addLayout('', 'photo', [
                            MediaLibrary::make('Основная фотка', 'main_photo')->nullable(),
                            MediaLibrary::make('Дополнительная фотка', 'additional_photo')->nullable(),
                            Text::make('Url', 'url'),
                        ])
                        ->button('Добавить фото'),
                ])
                ->button('Добавить категорию'),


            Flexible::make('Коллекция', 'collections_desktop')
                ->fullWidth()
                ->addLayout('', 'collection', [
                    MediaLibrary::make('Основная фотка', 'main_photo')->nullable(),
                    MediaLibrary::make('Дополнительная фотка', 'additional_photo')->nullable(),
                    Text::make('Url', 'url'),
                    /*                    Select::make('Продукт', 'product_id')
                                            ->searchable()
                                            ->options($options),*/
                ])
                ->button('Добавить коллекцию'),

            Heading::make('Новая Коллекция для mobile'),
            /*            Text::make('Заголовок', 'title_collection_mobile')
                            ->hideFromIndex()
                            ->rules('required', 'max:255'),*/

            Flexible::make('', 'collections_mobile')
                ->fullWidth()
                ->addLayout('', 'collection', [
                    Text::make('Заголовок', 'title_slide_mobile')
                        ->hideFromIndex()
                        ->rules('required', 'max:255'),
                    MediaLibrary::make('Картинка', 'main_photo')->nullable(),
                    Text::make('Url категории', 'url_slide_mobile')
                        ->hideFromIndex()
                        ->rules('required', 'max:255'),

                ])
                ->button('Добавить коллекцию'),


            Heading::make('Блок с изображением'),
            Flexible::make('', 'banners')
                ->fullWidth()
                ->addLayout('', 'banner', [
                    /*Boolean::make('Темный ?','on_off'),*/
                    $this->colorsStatic(),
                    Trix::make('Текст', 'text')
                        ->hideFromIndex()
                        ->rules('required', 'max:500'),
                    Text::make('Название кнопки', 'button_name')
                        ->hideFromIndex()
                        ->rules('required', 'max:255'),
                    Text::make('Внутренняя или внешняя ссылка', 'link')
                        ->hideFromIndex(),
                    /*                    Text::make('Внутренняя ссылка', 'external_link')
                                            ->hideFromIndex(),
                                        Text::make('Внешняя сслыка', 'internal_link')
                                            ->hideFromIndex(),*/

                    //Heading::make('Настройка видео'),
                    //Boolean::make('Автозапуск видео', 'autostart_video'),
                    //MediaLibrary::make('Постер','poster')->nullable(),

                    Heading::make('Фото для компьютера'),
                    MediaLibrary::make('Фото', 'photo_comp')->nullable(),
                    //MediaLibrary::make('Видео','video_comp')->nullable(),

                    Heading::make('Фото для ноутбука'),
                    MediaLibrary::make('Фото', 'photo_notebook')->nullable(),
                    //MediaLibrary::make('Видео','video_notebook')->nullable(),

                    Heading::make('Фото для планшета'),
                    MediaLibrary::make('Фото', 'photo_tablet')->nullable(),
                    //MediaLibrary::make('Видео','video_tablet')->nullable(),

                    Heading::make('Фото для мобильного'),
                    MediaLibrary::make('Фото', 'photo_phone')->nullable(),
                    //MediaLibrary::make('Видео','video_phone')->nullable(),
                ])
                ->button('Добавить'),


            Heading::make('Заголовок и описание'),
            Text::make('Заголовок', 'title')
                ->hideFromIndex()
                ->rules('required', 'max:255'),
            Trix::make('Описание', 'description')
                ->hideFromIndex(),


            Heading::make('Последный блок'),
            Flexible::make('', 'last_blocks')
                ->fullWidth()
                ->addLayout('Фото с описанием', 'last_block', [
                    Boolean::make('Выключить блок?', 'disable_block'),
                    Trix::make('Текст', 'text')
                        ->hideFromIndex()
                        ->rules('max:500'),
                    Text::make('Название кнопки', 'button_name')
                        ->hideFromIndex()
                        ->rules('required', 'max:255'),
                    Heading::make('Внутренняя или внешняя сслыка'),
                    Text::make('Внутренняя или внешняя ссылка', 'link')
                        ->hideFromIndex(),
                    /*                    Text::make('Внутренняя ссылка', 'external_link')
                                            ->hideFromIndex(),
                                        Text::make('Внешняя сслыка', 'internal_link')
                                            ->hideFromIndex(),*/
                    MediaLibrary::make('Фото', 'photo')->nullable()
                ])
                ->button('Добавить фото')->limit(2),

            Heading::make('Настройка видео'),
            Boolean::make('Автозапуск видео', 'autostart_video_2'),
            MediaLibrary::make('Постер', 'poster_2')->nullable(),

            MediaLibrary::make('Видео', 'video')->nullable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
