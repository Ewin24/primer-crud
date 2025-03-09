<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Laptop HP', 'description' => 'Laptop de 15 pulgadas', 'stock' => 50],
            ['name' => 'Teclado Mecánico', 'description' => 'Teclado RGB', 'stock' => 100],
            ['name' => 'Monitor 24"', 'description' => 'Monitor Full HD', 'stock' => 30],
            ['name' => 'Mouse Inalámbrico', 'description' => null, 'stock' => 200],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}