@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Historial de Compras</h1>
        <a href="{{ route('purchases.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Nueva Compra
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase['client']->name }}</td>
                            <td>{{ $purchase['product']->name }}</td>
                            <td>{{ $purchase['pivot']->quantity }}</td>
                            <td>{{ $purchase['pivot']->date }}</td>
                            <td>
                                <a href="{{ route('purchases.edit', ['client' => $purchase['client']->id, 'product' => $purchase['product']->id]) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $purchase['client']->id }}{{ $purchase['product']->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal de Confirmación -->
                        <div class="modal fade" id="deleteModal{{ $purchase['client']->id }}{{ $purchase['product']->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de eliminar esta compra?
                                        <ul class="mt-2">
                                            <li>Cliente: {{ $purchase['client']->name }}</li>
                                            <li>Producto: {{ $purchase['product']->name }}</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('purchases.destroy', ['client' => $purchase['client']->id, 'product' => $purchase['product']->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection