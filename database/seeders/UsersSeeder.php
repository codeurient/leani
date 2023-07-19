<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(['email' => User::$adminEmail], [
            'name' => 'Leani Admin',
            'password' => \Hash::make('secret123'),
        ]);
    }
}
