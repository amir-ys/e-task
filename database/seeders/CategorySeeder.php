<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            ["title" => "sport"],
            ["title" => "Economic"],
            ["title" => "Social"]
        ];

        foreach ($categories as $category) {
            Category::query()->firstOrCreate(
                $category
            );
        }
    }
}
