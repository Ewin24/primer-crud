<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Almacén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 10px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .chart-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container text-center mt-5">
        <h1 class="mb-4">Sistema de Gestión de Almacén</h1>
        <div class="row justify-content-center">
            <!-- Tarjeta de Productos -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-box me-2"></i>Productos</h5>
                        <p class="card-text">Administra el inventario de productos.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Administrar</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Proveedores -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-truck me-2"></i>Proveedores</h5>
                        <p class="card-text">Gestiona la información de proveedores.</p>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-primary">Administrar</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Clientes -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-users me-2"></i>Clientes</h5>
                        <p class="card-text">Administra la información de clientes.</p>
                        <a href="{{ route('clients.index') }}" class="btn btn-primary">Administrar</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Compras -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-shopping-cart me-2"></i>Compras</h5>
                        <p class="card-text">Gestiona las compras realizadas.</p>
                        <a href="{{ route('purchases.index') }}" class="btn btn-primary">Administrar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficas -->
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fas fa-chart-bar me-2"></i>Stock de Productos</h5>
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5><i class="fas fa-chart-pie me-2"></i>Distribución de Clientes y Proveedores</h5>
                    <canvas id="clientsSuppliersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Datos para la gráfica de stock de productos
        const stockData = {
            labels: {!! json_encode($products->pluck('name')) !!}, // Nombres de los productos
            datasets: [{
                label: 'Stock',
                data: {!! json_encode($products->pluck('stock')) !!}, // Stock de los productos
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                borderColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                borderWidth: 1
            }]
        };

        // Datos para la gráfica de distribución de clientes y proveedores
        const clientsSuppliersData = {
            labels: ['Clientes', 'Proveedores'],
            datasets: [{
                label: 'Cantidad',
                data: [{{ $clientsCount }}, {{ $suppliersCount }}], // Número de clientes y proveedores
                backgroundColor: ['#4e73df', '#1cc88a'],
                borderColor: ['#4e73df', '#1cc88a'],
                borderWidth: 1
            }]
        };

        // Configuración de la gráfica de stock
        const stockChart = new Chart(document.getElementById('stockChart'), {
            type: 'bar',
            data: stockData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Configuración de la gráfica de distribución
        const clientsSuppliersChart = new Chart(document.getElementById('clientsSuppliersChart'), {
            type: 'pie',
            data: clientsSuppliersData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    </script>
</body>

</html>