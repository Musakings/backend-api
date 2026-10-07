
<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop',
                'price' => 5000000,
                'stock' => 10,
            ],
            [
                'name' => 'Keyboard',
                'price' => 300000,
                'stock' => 25,
            ],
            [
                'name' => 'Mouse',
                'price' => 150000,
                'stock' => 30,
            ],
            [
                'name' => 'Monitor',
                'price' => 2000000,
                'stock' => 8,
            ],
            [
                'name' => 'Headset',
                'price' => 250000,
                'stock' => 15,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}