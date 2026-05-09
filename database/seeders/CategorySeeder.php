<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Work', 'color' => '#667eea'],
            ['name' => 'Personal', 'color' => '#764ba2'],
            ['name' => 'Health', 'color' => '#f093fb'],
            ['name' => 'Learning', 'color' => '#4facfe'],
            ['name' => 'Shopping', 'color' => '#43e97b'],
            ['name' => 'Projects', 'color' => '#fa709a'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['color' => $category['color']]
            );
        }
    }
}