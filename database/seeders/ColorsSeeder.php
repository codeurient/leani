<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorsSeeder extends Seeder
{
    private static $colors = [
        [
            'colors_name' => [
                'ru' => 'Белый',
                'en' => 'White',
            ],
            'slug' => 'white',
            'color' => '#FFFFFF',
            'more_color' => null,
        ],
        [
            'colors_name' => [
                'ru' => 'Бирюзовый',
                'en' => 'Turquoise',
            ],
            'slug' => 'turquoise',
            'color' => '#40E0D0',
            'more_color' => null,
        ],
        [
            'colors_name' => [
                'ru' => 'Фиолетовый',
                'en' => 'Purple',
            ],
            'slug' => 'purple',
            'color' => '#800080',
            'more_color' => null,
        ],
        [
            'colors_name' => [
                'ru' => 'Черный',
                'en' => 'Black',
            ],
            'slug' => 'black',
            'color' => '#000000',
            'more_color' => null,
        ],
        [
            'colors_name' => [
                'ru' => 'Зелёный',
                'en' => 'Green',
            ],
            'slug' => 'green',
            'color' => '#009933',
            'more_color' => null,
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$colors??[] as $color) {
            Color::firstOrCreate([
                'slug' => $color['slug']
            ], [
                'colors_name' => $color['colors_name'],
                'color' => $color['color'],
                'more_color' => $color['more_color'],
            ]);
        }
    }
}
