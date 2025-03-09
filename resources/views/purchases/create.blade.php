@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-cart-plus me-2"></i>Registrar Nueva Compra</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf

                <!-- Sección de errores generales -->
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <h5 class="mb-3">Error en la compra:</h5>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Cliente <span class="text-danger">*</span></label>
                            <select name="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                                <option value="">Seleccionar Cliente</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} ({{ $client->dni }})
                                </option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Producto <span class="text-danger">*</span></label>
                            <select name="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                <option value="">Seleccionar Producto</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    data-stock="{{ $product->stock }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Stock: {{ $product->stock }})
                                </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                            <input type="number"
                                name="quantity"
                                class="form-control @error('quantity') is-invalid @enderror"
                                value="{{ old('quantity') }}"
                                min="1"
                                required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">N° Comprobante <span class="text-danger">*</span></label>
                            <input type="text"
                                name="support"
                                class="form-control @error('support') is-invalid @enderror"
                                value="{{ old('support') }}"
                                required>
                            @error('support')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date"
                                name="date"
                                class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date') }}"
                                required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Registrar Compra
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateMaxQuantity() {
        const productSelect = document.querySelector('select[name="product_id"]');
        const quantityInput = document.querySelector('input[name="quantity"]');
        
        if(productSelect.value) {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const stock = selectedOption.dataset.stock;
            quantityInput.max = stock;
            
            if(quantityInput.value > stock) {
                quantityInput.value = stock;
            }
        }
    }

    // Eventos
    document.addEventListener('DOMContentLoaded', function() {
        updateMaxQuantity();
    });

    document.querySelector('select[name="product_id"]').addEventListener('change', updateMaxQuantity);
</script>
@endpush
@endsection