<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Almacén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="mb-4">
            @if(!request()->is('/'))
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-chevron-left me-2"></i>Volver
            </a>
            <a href="{{ url()->to('/')}}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-home me-2"></i>Inicio
            </a>
            @endif
        </div>

        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>