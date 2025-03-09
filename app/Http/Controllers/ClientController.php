<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|unique:clients|max:20',
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'date' => 'required|date',
        ]);

        Client::create($request->all());
        return redirect()->route('clients.index')->with('success', 'Cliente creado.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'dni' => 'required|max:20|unique:clients,dni,' . $client->id,
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'date' => 'required|date',
        ]);

        $client->update($request->all());
        return redirect()->route('clients.index')->with('success', 'Cliente actualizado.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado.');
    }
}