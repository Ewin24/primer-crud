<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Client;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('suppliers', 'clients')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $clients = Client::all();
        return view('products.create', compact('suppliers', 'clients'));
    }

    // En ProductController.php

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Eliminar validación de stock
            'suppliers' => 'required|array',
            'suppliers.*.id' => 'required|exists:suppliers,id',
            'suppliers.*.quantity' => 'required|integer|min:1',
            'suppliers.*.support' => 'required|string|max:255',
            'suppliers.*.date' => 'required|date',
        ]);

        $stock = collect($request->suppliers)->sum('quantity');

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $stock
        ]);

        $suppliersData = [];
        foreach ($request->suppliers as $supplier) {
            $suppliersData[$supplier['id']] = [
                'quantity' => $supplier['quantity'],
                'support' => $supplier['support'],
                'date' => $supplier['date']
            ];
        }
        $product->suppliers()->sync($suppliersData);

        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $suppliers = Supplier::all();
        $clients = Client::all();
        $product->load('suppliers', 'clients');
        return view('products.edit', compact('product', 'suppliers', 'clients'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'suppliers' => 'required|array|min:1',
            'suppliers.*.id' => 'required|exists:suppliers,id',
            'suppliers.*.quantity' => 'required|integer|min:1',
            'suppliers.*.support' => 'required|string|max:255',
            'suppliers.*.date' => 'required|date',
        ]);

        $newStock = collect($request->suppliers)->sum('quantity');

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'stock' => $newStock
        ]);

        $suppliersData = [];
        foreach ($request->suppliers as $supplier) {
            $suppliersData[$supplier['id']] = [
                'quantity' => $supplier['quantity'],
                'support' => $supplier['support'],
                'date' => $supplier['date']
            ];
        }

        $product->suppliers()->sync($suppliersData);

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado y stock recalculado');
    }

    public function destroy(Product $product)
    {
        $product->suppliers()->detach();
        $product->clients()->detach();
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }
}
