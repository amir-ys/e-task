<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            [
                "name" => 'user',
                "email" => 'user@ehna.com'
            ],
            [
                "password" => 12345678
            ]
        );
    }
}
