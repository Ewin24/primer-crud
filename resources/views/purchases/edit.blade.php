@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Venta</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('purchases.update', ['client' => $purchase['client']->id, 'product' => $purchase['product']->id]) }}" method="POST">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <h5 class="mb-3">Error en la edición:</h5>
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
                                @foreach($clients as $c)
                                <option value="{{ $c->id }}" 
                                    {{ $c->id == old('client_id', $purchase['client']->id) ? 'selected' : '' }}>
                                    {{ $c->name }} ({{ $c->dni }})
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
                                @foreach($products as $p)
                                <option value="{{ $p->id }}" 
                                    data-stock="{{ $p->stock }}"
                                    {{ $p->id == old('product_id', $purchase['product']->id) ? 'selected' : '' }}>
                                    {{ $p->name }} (Stock: {{ $p->stock + $purchase['pivot']->quantity }})
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
                                value="{{ old('quantity', $purchase['pivot']->quantity) }}"
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
                                value="{{ old('support', $purchase['pivot']->support) }}"
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
                                value="{{ old('date', $purchase['pivot']->date) }}"
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
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.querySelector('select[name="product_id"]');
        const quantityInput = document.querySelector('input[name="quantity"]');
        
        function updateMaxQuantity() {
            if(productSelect.value) {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const stock = parseInt(selectedOption.dataset.stock) + parseInt({{ $purchase['pivot']->quantity }});
                quantityInput.max = stock;
                
                if(quantityInput.value > stock) {
                    quantityInput.value = stock;
                }
            }
        }

        productSelect.addEventListener('change', updateMaxQuantity);
        updateMaxQuantity(); // Initial call
    });
</script>
@endpush
@endsection