<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Almacén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container text-center mt-5">
        <h1 class="mb-4">Sistema de Gestión de Almacén</h1>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Productos</h5>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Administrar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Proveedores</h5>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-primary">Administrar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Clientes</h5>
                        <a href="{{ route('clients.index') }}" class="btn btn-primary">Administrar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Compras</h5>
                        <a href="{{ route('purchases.index') }}" class="btn btn-primary">Administrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>