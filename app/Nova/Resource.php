<?php

namespace App\Nova;

use App\Nova\Rule\SliderValidationRule;
use ClassicO\NovaMediaLibrary\MediaLibrary;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;
use Yna\NovaSwatches\Swatches;

abstract class Resource extends NovaResource
{
    /**
     * Build an "index" query for the given resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Laravel\Scout\Builder $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query): \Illuminate\Database\Eloquent\Builder
    {
        return parent::relatableQuery($request, $query);
    }

    public static function SKUField(): Text
    {
        return Text::make('Артикул', 'sku')
            ->rules(['max:255'])
            ->sortable();
    }

    public function mainImages($description = null): MediaLibrary
    {
        $title = 'Основное изображение';
        if ($description) $title .=  ' (' . $description . ')';
        return MediaLibrary::make($title, 'main_image')
            ->hideFromIndex()
            ->array()
            ->rules([new SliderValidationRule('Фото', 2)]);
    }

    public function images($description = null): MediaLibrary
    {
        $title = 'Изображения';
        if ($description) $title .=  ' (' . $description . ')';
        return MediaLibrary::make($title, 'images')
            ->array()
            ->hideFromIndex();
    }

    public function price($text = 'Цена', $required = true): Number
    {
        return Number::make($text, 'price')
            ->min(0)
            ->step(0.01)
            ->default(0)
            ->sortable()
            ->required($required);
    }

    public function discountBoolean($title = 'Бирка SALE'): Boolean
    {
        return Boolean::make($title, 'on_sale');
    }

    public function isNewBoolean($title = 'Бирка NEW'): Boolean
    {
        return Boolean::make($title, 'is_new');
    }

    public function discount($text = 'Скидка в %'): Number
    {
        return Number::make($text, 'discount')
            ->min(0)
            ->max(99)
            ->step(0.1)
            ->nullable()
            ->sortable();
    }

    public function cactusVariantId(): Text
    {
        return Text::make('ID в Кактус', 'cactus_id')->required();
    }

    public function colorSelect($name, $column): Swatches
    {
        return Swatches::make($name, $column)
            ->withProps([
                'show-fallback' => true,
                'fallback-type' => 'input',
                'fallback-input-type' => 'color',
                'spacing-size' => 2,
                'shapes' => 'squares',
                'row-length' => 6,
                'swatch-style' => ['width' => '22px', 'height' => '22px', 'borderRadius' => '0px',],
                'trigger-style' => ['width' => '30px', 'height' => '30px', 'borderRadius' => '0px',],
                // More options at https://saintplay.github.io/vue-swatches/api/props.html
            ]);
    }

    public function sort()
    {
        return Number::make('Сортировка', 'sort')
            ->default(0)
            ->required()
            ->sortable();
    }

    public function colorsStatic()
    {
        return Select::make('Цвет текста', 'text_color')->options([
            'dark' => 'Тёмный',
            'light' => 'Белый',
            'gray' => 'Серый',
            'green' => 'Зелёный',
        ]);
    }
}
