@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Proveedor</h4>
        </div>
        
        <div class="card-body">
            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-3">
                    <!-- Sección de Información Básica -->
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3"><i class="fas fa-id-card me-2"></i>Información Básica</h5>
                        
                        <div class="mb-3">
                            <label for="nit" class="form-label">NIT <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nit') is-invalid @enderror" 
                                   id="nit" 
                                   name="nit" 
                                   value="{{ old('nit', $supplier->nit) }}"
                                   placeholder="Ej: 123456789-1"
                                   required>
                            @error('nit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="names" class="form-label">Nombre del Proveedor <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('names') is-invalid @enderror" 
                                   id="names" 
                                   name="names" 
                                   value="{{ old('names', $supplier->names) }}"
                                   placeholder="Ej: Distribuciones Pérez S.A."
                                   required>
                            @error('names')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección de Contacto -->
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3"><i class="fas fa-address-book me-2"></i>Información de Contacto</h5>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $supplier->email) }}"
                                   placeholder="Ej: contacto@proveedor.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $supplier->phone) }}"
                                   placeholder="Ej: +57 321 555 1234"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sección de Dirección -->
                    <div class="col-12">
                        <h5 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Dirección</h5>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Dirección Completa <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="2"
                                      placeholder="Ej: Carrera 45 # 12-34, Bogotá D.C."
                                      required>{{ old('address', $supplier->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
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
@endsection

@push('styles')
<style>
    .card {
        border-radius: 15px;
    }
    .form-label {
        font-weight: 600;
    }
    .required-asterisk {
        color: #dc3545;
        margin-left: 3px;
    }
    .card-header.bg-warning {
        background-color: #ffc107 !important;
    }
</style>
@endpush