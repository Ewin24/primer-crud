<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Client;
use App\Models\Supplier;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener datos de productos (nombre y stock)
        $products = Product::select('name', 'stock')->get();

        // Obtener el número de clientes y proveedores
        $clientsCount = Client::count();
        $suppliersCount = Supplier::count();

        // Pasar los datos a la vista
        return view('welcome', [
            'products' => $products,
            'clientsCount' => $clientsCount,
            'suppliersCount' => $suppliersCount,
        ]);
    }
}