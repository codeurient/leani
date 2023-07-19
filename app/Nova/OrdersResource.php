<?php

namespace App\Nova;

use App\Models\Order;
use App\Nova\Filters\OrderFromDateFilter;
use App\Nova\Filters\OrderStatusFilter;
use App\Nova\Filters\OrderToDateFilter;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class OrdersResource extends Resource
{
    public static $model = Order::class;

    public static $title = 'name';

    public static $search = [
        'id', 'email', 'phone', 'name'
    ];
    public static $group = 'Заказы';

    public static function label()
    {
        return 'Заказы';
    }

    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('ID кактуса', 'cactus_order_id')
                ->sortable()
                ->rules('nullable'),

            Number::make('Стоимость', 'total_cost', function () {
                return $this->total_cost . ' руб.';
            })
                ->sortable()
                ->rules('required', 'numeric'),

            Text::make('Статус', 'status', function () {
                return Order::$statusMsg[$this->status];
            }),

            Text::make('Имя', 'name')
                ->hideFromIndex()
                ->rules('required'),

            Text::make('Фамилия', 'surname')
                ->hideFromIndex()
                ->rules('nullable'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254'),

            Text::make('Телефон', 'phone')
                ->sortable()
                ->rules('required'),

            Text::make('Комментарий', 'comment')
                ->hideFromIndex()
                ->rules('nullable'),

            BelongsTo::make('Пользователь', 'customer', CustomersResource::class),

            DateTime::make('Дата создания', 'created_at')
                ->sortable(),

            Text::make('Адрес', 'address', function () {
                return $this->address->fullAddress;
            })->hideFromIndex(),

            Textarea::make('Информация по доставке', 'delivery', function () {
                $delivery = '';
                if ($this->delivery->code ?? false) $delivery .= 'Код: ' . $this->delivery->code . "\n";
                if ($this->delivery->type ?? false) $delivery .= 'Тип: ' . $this->delivery->type . "\n";
                if ($this->delivery->title ?? false) $delivery .= 'Наименование: ' . $this->delivery->title . "\n";
                if ($this->delivery->pickupPointId ?? false) $delivery .= 'Точка сбора: ' . $this->delivery->pickupPointId . "\n";
                return $delivery;
            })->hideFromIndex(),
        ];
    }

    public function cards(Request $request): array
    {
        return [

        ];
    }

    public function filters(Request $request): array
    {
        return [
            new OrderStatusFilter,
            new OrderFromDateFilter,
            new OrderToDateFilter,
        ];
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
