<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nit' => 'required|unique:suppliers|max:20',
            'names' => 'required|string|max:100',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Proveedor creado.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nit' => 'required|max:20|unique:suppliers,nit,' . $supplier->id,
            'names' => 'required|string|max:100',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
        ]);

        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Proveedor actualizado.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado.');
    }
}