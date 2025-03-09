@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Clientes</h1>
    <a href="{{ route('clients.create') }}" class="btn btn-success mb-3">Nuevo Cliente</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            <tr>
                <td>{{ $client->dni }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone }}</td>
                <td>
                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary btn-sm">Editar</a>
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
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