@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="my-4">Proveedores</h1>
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i>Nuevo Proveedor
            </a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>NIT</th>
                <th>Nombres</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->nit }}</td>
                <td>{{ $supplier->names }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->phone }}</td>
                <td>
                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-primary btn-sm">Editar</a>
                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection