<?php

namespace App\Nova\Filters;

use App\Models\Order;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class OrderStatusFilter extends Filter
{
    public $name = 'Статус заказа';

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('status', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        $options = [];

        foreach (Order::$statusMsg as $status => $msg) {
            $options[$msg] = $status;
        }

        return $options;
    }
}
