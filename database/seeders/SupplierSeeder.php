<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            ['nit' => 'NIT123456', 'names' => 'TecnoImport', 'email' => 'tecno@example.com', 'address' => 'Calle 123', 'phone' => '3001112233'],
            ['nit' => 'NIT789012', 'names' => 'ElectroParts', 'email' => 'electro@example.com', 'address' => 'Avenida 456', 'phone' => '3104445566'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}