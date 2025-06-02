<?php
// database/seeders/ProductSeeder.php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // Green Tea
            ['name' => 'Classic Green Tea', 'price' => 15.99, 'stock_quantity' => 100, 'category_id' => 1, 'sku' => 'TEA-GT001'],
            ['name' => 'Jasmine Green Tea', 'price' => 18.99, 'stock_quantity' => 75, 'category_id' => 1, 'sku' => 'TEA-GT002'],
            ['name' => 'Matcha Green Tea', 'price' => 25.99, 'stock_quantity' => 50, 'category_id' => 1, 'sku' => 'TEA-GT003'],
            ['name' => 'Sencha Green Tea', 'price' => 19.99, 'stock_quantity' => 65, 'category_id' => 1, 'sku' => 'TEA-GT004'],
            ['name' => 'Dragon Well Green Tea', 'price' => 22.99, 'stock_quantity' => 45, 'category_id' => 1, 'sku' => 'TEA-GT005'],

            // Black Tea
            ['name' => 'Earl Grey', 'price' => 16.99, 'stock_quantity' => 80, 'category_id' => 2, 'sku' => 'TEA-BT001'],
            ['name' => 'English Breakfast', 'price' => 14.99, 'stock_quantity' => 120, 'category_id' => 2, 'sku' => 'TEA-BT002'],
            ['name' => 'Ceylon Black Tea', 'price' => 17.99, 'stock_quantity' => 60, 'category_id' => 2, 'sku' => 'TEA-BT003'],
            ['name' => 'Darjeeling Black Tea', 'price' => 21.99, 'stock_quantity' => 55, 'category_id' => 2, 'sku' => 'TEA-BT004'],
            ['name' => 'Assam Black Tea', 'price' => 18.99, 'stock_quantity' => 70, 'category_id' => 2, 'sku' => 'TEA-BT005'],

            // Herbal Tea
            ['name' => 'Chamomile Tea', 'price' => 13.99, 'stock_quantity' => 90, 'category_id' => 3, 'sku' => 'TEA-HT001'],
            ['name' => 'Peppermint Tea', 'price' => 12.99, 'stock_quantity' => 85, 'category_id' => 3, 'sku' => 'TEA-HT002'],
            ['name' => 'Ginger Lemon Tea', 'price' => 15.99, 'stock_quantity' => 70, 'category_id' => 3, 'sku' => 'TEA-HT003'],
            ['name' => 'Lavender Tea', 'price' => 16.99, 'stock_quantity' => 60, 'category_id' => 3, 'sku' => 'TEA-HT004'],
            ['name' => 'Hibiscus Tea', 'price' => 14.99, 'stock_quantity' => 75, 'category_id' => 3, 'sku' => 'TEA-HT005'],

            // Oolong Tea
            ['name' => 'Traditional Oolong', 'price' => 24.99, 'stock_quantity' => 40, 'category_id' => 4, 'sku' => 'TEA-OT001'],
            ['name' => 'Iron Goddess Oolong', 'price' => 28.99, 'stock_quantity' => 35, 'category_id' => 4, 'sku' => 'TEA-OT002'],
            ['name' => 'Milk Oolong', 'price' => 26.99, 'stock_quantity' => 45, 'category_id' => 4, 'sku' => 'TEA-OT003'],
            ['name' => 'High Mountain Oolong', 'price' => 32.99, 'stock_quantity' => 30, 'category_id' => 4, 'sku' => 'TEA-OT004'],

            // White Tea
            ['name' => 'Silver Needle White Tea', 'price' => 35.99, 'stock_quantity' => 25, 'category_id' => 5, 'sku' => 'TEA-WT001'],
            ['name' => 'White Peony Tea', 'price' => 29.99, 'stock_quantity' => 35, 'category_id' => 5, 'sku' => 'TEA-WT002'],
            ['name' => 'Moonlight White Tea', 'price' => 31.99, 'stock_quantity' => 30, 'category_id' => 5, 'sku' => 'TEA-WT003'],

            // Tea Accessories
            ['name' => 'Glass Tea Infuser', 'price' => 12.99, 'stock_quantity' => 150, 'category_id' => 6, 'sku' => 'ACC-INF001'],
            ['name' => 'Bamboo Tea Strainer', 'price' => 8.99, 'stock_quantity' => 200, 'category_id' => 6, 'sku' => 'ACC-STR001'],
            ['name' => 'Ceramic Tea Pot', 'price' => 45.99, 'stock_quantity' => 50, 'category_id' => 6, 'sku' => 'ACC-POT001'],
            ['name' => 'Tea Timer', 'price' => 15.99, 'stock_quantity' => 80, 'category_id' => 6, 'sku' => 'ACC-TIM001'],
            ['name' => 'Tea Storage Tin', 'price' => 9.99, 'stock_quantity' => 120, 'category_id' => 6, 'sku' => 'ACC-TIN001'],
            ['name' => 'Electric Tea Kettle', 'price' => 89.99, 'stock_quantity' => 25, 'category_id' => 6, 'sku' => 'ACC-KET001'],
            ['name' => 'Tea Cup Set (4 pieces)', 'price' => 32.99, 'stock_quantity' => 40, 'category_id' => 6, 'sku' => 'ACC-CUP001'],

            // Gift Sets
            ['name' => 'Green Tea Starter Set', 'price' => 49.99, 'stock_quantity' => 30, 'category_id' => 7, 'sku' => 'GIFT-SET001'],
            ['name' => 'Premium Tea Collection', 'price' => 89.99, 'stock_quantity' => 20, 'category_id' => 7, 'sku' => 'GIFT-SET002'],
            ['name' => 'Herbal Tea Wellness Kit', 'price' => 39.99, 'stock_quantity' => 35, 'category_id' => 7, 'sku' => 'GIFT-SET003'],
            ['name' => 'Tea Ceremony Set', 'price' => 125.99, 'stock_quantity' => 15, 'category_id' => 7, 'sku' => 'GIFT-SET004'],
            ['name' => 'Monthly Tea Subscription Box', 'price' => 29.99, 'stock_quantity' => 100, 'category_id' => 7, 'sku' => 'GIFT-SUB001'],

            // Seasonal/Special Teas
            ['name' => 'Winter Spice Blend', 'price' => 17.99, 'stock_quantity' => 60, 'category_id' => 8, 'sku' => 'SEA-WIN001'],
            ['name' => 'Summer Mint Cooler', 'price' => 15.99, 'stock_quantity' => 70, 'category_id' => 8, 'sku' => 'SEA-SUM001'],
            ['name' => 'Holiday Cinnamon Tea', 'price' => 18.99, 'stock_quantity' => 50, 'category_id' => 8, 'sku' => 'SEA-HOL001'],
            ['name' => 'Spring Blossom Mix', 'price' => 19.99, 'stock_quantity' => 55, 'category_id' => 8, 'sku' => 'SEA-SPR001'],

            // Wellness Teas
            ['name' => 'Detox Green Blend', 'price' => 21.99, 'stock_quantity' => 65, 'category_id' => 9, 'sku' => 'WEL-DET001'],
            ['name' => 'Sleep Time Herbal', 'price' => 16.99, 'stock_quantity' => 80, 'category_id' => 9, 'sku' => 'WEL-SLE001'],
            ['name' => 'Energy Boost Tea', 'price' => 18.99, 'stock_quantity' => 75, 'category_id' => 9, 'sku' => 'WEL-ENE001'],
            ['name' => 'Immunity Support Blend', 'price' => 19.99, 'stock_quantity' => 70, 'category_id' => 9, 'sku' => 'WEL-IMM001'],
            ['name' => 'Digestive Aid Tea', 'price' => 17.99, 'stock_quantity' => 60, 'category_id' => 9, 'sku' => 'WEL-DIG001'],

            // Premium/Rare Teas
            ['name' => 'Aged Pu-erh Tea', 'price' => 55.99, 'stock_quantity' => 20, 'category_id' => 10, 'sku' => 'PREM-PUE001'],
            ['name' => 'First Flush Darjeeling', 'price' => 45.99, 'stock_quantity' => 25, 'category_id' => 10, 'sku' => 'PREM-DAR001'],
            ['name' => 'Ceremonial Grade Matcha', 'price' => 65.99, 'stock_quantity' => 15, 'category_id' => 10, 'sku' => 'PREM-MAT001'],
            ['name' => 'Vintage Reserve Black', 'price' => 49.99, 'stock_quantity' => 18, 'category_id' => 10, 'sku' => 'PREM-VIN001'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}