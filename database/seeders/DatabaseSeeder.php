<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Ejecutar seeders principales
        $this->call([
            ProductSeeder::class,
            SupplierSeeder::class,
            ClientSeeder::class,
        ]);

        // Relacionar productos con proveedores (tabla product_supplier)
        $product1 = Product::find(1); // Laptop HP
        $product2 = Product::find(2); // Teclado Mecánico

        $supplier1 = Supplier::find(1); // TecnoImport
        $supplier2 = Supplier::find(2); // ElectroParts

        $product1->suppliers()->attach([1, 2], [
            'quantity' => 10, 
            'support' => 'Factura 001', 
            'date' => '2023-10-01'
        ]);

        $product2->suppliers()->attach(2, [
            'quantity' => 20, 
            'support' => 'Factura 002', 
            'date' => '2023-10-02'
        ]);

        // Relacionar productos con clientes (tabla product_client)
        $client1 = Client::find(1); // Juan Pérez
        $client2 = Client::find(2); // María Gómez

        $product1->clients()->attach(1, [
            'quantity' => 2, 
            'support' => 'Recibo 001', 
            'date' => '2023-10-05'
        ]);

        $product2->clients()->attach([1, 2], [
            'quantity' => 5, 
            'support' => 'Recibo 002', 
            'date' => '2023-10-06'
        ]);
    }
}