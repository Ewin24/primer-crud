<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $clients = [
            ['dni' => 'DNI111222', 'name' => 'Juan Pérez', 'email' => 'juan@example.com', 'address' => 'Carrera 7', 'phone' => '3205556677', 'date' => '2023-01-15'],
            ['dni' => 'DNI333444', 'name' => 'María Gómez', 'email' => 'maria@example.com', 'address' => 'Calle 100', 'phone' => '3156667788', 'date' => '2023-02-20'],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}