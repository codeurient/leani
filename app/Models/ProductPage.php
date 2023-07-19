<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class ProductPage extends Model
{
    use HasTranslations;

    public array $translatable = [
        'size_chart',
        'size_chart_link',
    ];

    public function processImages()
    {
       $this->size_chart = Controller::getMedia($this->size_chart);
    }
}
