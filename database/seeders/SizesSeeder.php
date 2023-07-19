<?php

namespace Database\Seeders;

use App\Models\Sizes;
use Illuminate\Database\Seeder;

class SizesSeeder extends Seeder
{
    private static $sizes = [
        [
            'sizes_name' => 'XS',
        ],
        [
            'sizes_name' => 'S',
        ],
        [
            'sizes_name' => 'M',
        ],
        [
            'sizes_name' => 'L',
        ],
        [
            'sizes_name' => 'XL',
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$sizes??[] as $size) {
            Sizes::firstOrCreate([
                'sizes_name' => $size['sizes_name']
            ]);
        }
    }
}
