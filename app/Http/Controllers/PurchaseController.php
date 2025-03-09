<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Client::with('products')->get()
            ->flatMap(function ($client) {
                return $client->products->map(function ($product) use ($client) {
                    return [
                        'client' => $client,
                        'product' => $product,
                        'pivot' => $product->pivot
                    ];
                });
            });

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        return view('purchases.create', compact('clients', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'support' => 'required|string|max:255',
            'date' => 'required|date'
        ]);

        $product = Product::find($request->product_id);

        if ($request->quantity > $product->stock) {
            return back()->withInput()
                ->withErrors(['quantity' => 'La cantidad solicitada supera el stock disponible']);
        }

        $client = Client::find($request->client_id);
        $client->products()->attach($request->product_id, [
            'quantity' => $request->quantity,
            'support' => $request->support,
            'date' => $request->date
        ]);

        // Actualizar stock
        $product->stock -= $request->quantity;
        $product->save();

        return redirect()->route('purchases.index')
            ->with('success', 'Compra registrada exitosamente');
    }

    public function edit(Client $client, Product $product)
    {
        $purchase = $client->products()
            ->where('product_id', $product->id)
            ->firstOrFail();

        $clients = Client::all();
        $products = Product::all();

        return view('purchases.edit', [
            'purchase' => [
                'client' => $client,
                'product' => $product,
                'pivot' => $purchase->pivot
            ],
            'clients' => $clients,
            'products' => $products
        ]);
    }

    public function update(Request $request, $clientId, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'support' => 'required|string|max:255',
            'date' => 'required|date'
        ]);

        $client = Client::findOrFail($clientId);
        $product = Product::findOrFail($productId);
        $oldQuantity = $client->products()->where('product_id', $productId)->first()->pivot->quantity;

        if ($request->quantity > ($product->stock + $oldQuantity)) {
            return back()->withInput()
                ->withErrors(['quantity' => 'La nueva cantidad supera el stock disponible']);
        }

        // Actualizar stock
        $product->stock += $oldQuantity;
        $product->stock -= $request->quantity;
        $product->save();

        $client->products()->updateExistingPivot($productId, [
            'quantity' => $request->quantity,
            'support' => $request->support,
            'date' => $request->date
        ]);

        return redirect()->route('purchases.index')
            ->with('success', 'Compra actualizada correctamente');
    }

    public function destroy($clientId, $productId)
    {
        $client = Client::findOrFail($clientId);
        $purchase = $client->products()->where('product_id', $productId)->first();

        // Restaurar stock
        $product = Product::find($productId);
        $product->stock += $purchase->pivot->quantity;
        $product->save();

        $client->products()->detach($productId);

        return redirect()->route('purchases.index')
            ->with('success', 'Compra eliminada correctamente');
    }
}
