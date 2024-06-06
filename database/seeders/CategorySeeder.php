<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Startup',
                'icon' => null
            ],
            [
                'name' => 'Technology',
                'icon' => null
            ],
            [
                'name' => 'Culinary',
                'icon' => null
            ],
            [
                'name' => 'Gaming',
                'icon' => null
            ],
            [
                'name' => 'Entertainment',
                'icon' => null
            ],
            [
                'name' => 'Sports',
                'icon' => null
            ],
            [
                'name' => 'Business',
                'icon' => null
            ],
            [
                'name' => 'Education',
                'icon' => null
            ]
        ];
        foreach ($categories as $category) {
            Category::create($category);
        };
    }
}
