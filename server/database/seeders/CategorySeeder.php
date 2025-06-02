<?php
// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Green Tea', 'description' => 'Fresh and healthy green tea varieties'],
            ['name' => 'Black Tea', 'description' => 'Classic black tea blends'],
            ['name' => 'Herbal Tea', 'description' => 'Caffeine-free herbal infusions'],
            ['name' => 'Iced Tea', 'description' => 'Refreshing cold tea beverages'],
            ['name' => 'Tea Accessories', 'description' => 'Tea brewing equipment and accessories'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}