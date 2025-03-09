@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Producto: {{ $product->name }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Sección de errores generales -->
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

                <!-- Campos del Producto -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección de Proveedores y Stock -->
                <div class="mb-4">
                    <h5 class="mb-3"><i class="fas fa-truck me-2"></i>Proveedores y Stock Actual: {{ $product->stock }}</h5>
                    <div id="suppliers-container">
                        @foreach($product->suppliers as $index => $supplier)
                            <div class="supplier-entry mb-3 p-3 border rounded">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Proveedor <span class="text-danger">*</span></label>
                                        <select name="suppliers[{{ $index }}][id]"
                                                class="form-select @error('suppliers.' . $index . '.id') is-invalid @enderror"
                                                required>
                                            <option value="">Seleccionar Proveedor</option>
                                            @foreach($suppliers as $s)
                                                <option value="{{ $s->id }}" 
                                                    {{ $s->id == $supplier->id ? 'selected' : '' }}>
                                                    {{ $s->names }} ({{ $s->nit }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('suppliers.' . $index . '.id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                                        <input type="number"
                                               name="suppliers[{{ $index }}][quantity]"
                                               class="form-control @error('suppliers.' . $index . '.quantity') is-invalid @enderror"
                                               value="{{ old('suppliers.' . $index . '.quantity', $supplier->pivot->quantity) }}"
                                               min="1"
                                               required>
                                        @error('suppliers.' . $index . '.quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">N° Factura/Comprobante <span class="text-danger">*</span></label>
                                        <input type="text"
                                               name="suppliers[{{ $index }}][support]"
                                               class="form-control @error('suppliers.' . $index . '.support') is-invalid @enderror"
                                               value="{{ old('suppliers.' . $index . '.support', $supplier->pivot->support) }}"
                                               required>
                                        @error('suppliers.' . $index . '.support')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Fecha <span class="text-danger">*</span></label>
                                        <input type="date"
                                               name="suppliers[{{ $index }}][date]"
                                               class="form-control @error('suppliers.' . $index . '.date') is-invalid @enderror"
                                               value="{{ old('suppliers.' . $index . '.date', $supplier->pivot->date) }}"
                                               required>
                                        @error('suppliers.' . $index . '.date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="button" 
                                        class="btn btn-danger btn-sm mt-2" 
                                        onclick="this.parentElement.remove()">
                                    <i class="fas fa-trash me-1"></i>Eliminar
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-secondary" onclick="addSupplier()">
                        <i class="fas fa-plus me-2"></i>Agregar Proveedor
                    </button>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
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

<script>
    let supplierIndex = {{ $product->suppliers->count() }};

    function addSupplier() {
        const container = document.getElementById('suppliers-container');
        const newEntry = document.createElement('div');
        newEntry.className = 'supplier-entry mb-3 p-3 border rounded';
        newEntry.innerHTML = `
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Proveedor <span class="text-danger">*</span></label>
                    <select name="suppliers[${supplierIndex}][id]" class="form-select" required>
                        <option value="">Seleccionar Proveedor</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->names }} ({{ $supplier->nit }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Cantidad <span class="text-danger">*</span></label>
                    <input type="number" 
                           name="suppliers[${supplierIndex}][quantity]" 
                           class="form-control" 
                           placeholder="Cantidad" 
                           min="1" 
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">N° Factura/Comprobante <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="suppliers[${supplierIndex}][support]" 
                           class="form-control" 
                           placeholder="Soporte" 
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Fecha <span class="text-danger">*</span></label>
                    <input type="date" 
                           name="suppliers[${supplierIndex}][date]" 
                           class="form-control" 
                           required>
                </div>
            </div>
            <button type="button" 
                    class="btn btn-danger btn-sm mt-2" 
                    onclick="this.parentElement.remove()">
                <i class="fas fa-trash me-1"></i>Eliminar
            </button>
        `;
        container.appendChild(newEntry);
        supplierIndex++;
    }
</script>
@endsection