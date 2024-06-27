<?php

require '../../config/database.php';

$db = new Database();
$conexion = $db->conectarDB();

// Top 5 productos más vendidos
$sql_productos = "SELECT title, SUM(vendidos) as total_vendidos FROM productos
                  GROUP BY id
                  ORDER BY total_vendidos DESC 
                  LIMIT 5";
$result_productos = $conexion->query($sql_productos);

$productos = [];
$vendidos = [];

if ($result_productos->num_rows > 0) {
    while ($row = $result_productos->fetch_assoc()) {
        $productos[] = $row['title'];
        $vendidos[] = $row['total_vendidos'];
    }
}

// Top 5 categorías más vendidas
$sql_categorias = "SELECT category, SUM(p.vendidos) as total_vendidos 
                   FROM productos p 
                   GROUP BY category 
                   ORDER BY total_vendidos DESC 
                   LIMIT 5";
$result_categorias = $conexion->query($sql_categorias);

$categorias = [];
$vendidos_cat = [];

if ($result_categorias->num_rows > 0) {
    while ($row = $result_categorias->fetch_assoc()) {
        $categorias[] = $row['category'];
        $vendidos_cat[] = $row['total_vendidos'];
    }
}

// Total de ganancias
$sql_ganancias = "SELECT SUM(total) as total_ganancias FROM compras";
$result_ganancias = $conexion->query($sql_ganancias);

$total_ganancias = 0;

if ($result_ganancias->num_rows > 0) {
    $row = $result_ganancias->fetch_assoc();
    $total_ganancias = $row['total_ganancias'];
}

// Usuarios creados por día
$sql_usuarios = "SELECT fecha_ingreso, COUNT(*) as usuarios_creados 
                 FROM clientes 
                 GROUP BY fecha_ingreso";
$result_usuarios = $conexion->query($sql_usuarios);

$fechas = [];
$usuarios_creados = [];

if ($result_usuarios->num_rows > 0) {
    while ($row = $result_usuarios->fetch_assoc()) {
        $fechas[] = $row['fecha_ingreso'];
        $usuarios_creados[] = $row['usuarios_creados'];
    }
}

// Stock total de productos
$sql_stock = "SELECT title, stock FROM productos";
$result_stock = $conexion->query($sql_stock);

$titles_stock = [];
$stock = [];

if ($result_stock->num_rows > 0) {
    while ($row = $result_stock->fetch_assoc()) {
        $titles_stock[] = $row['title'];
        $stock[] = $row['stock'];
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="/admin/index.php" class="navbar-brand">
                    <strong>ZAMAZOR</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>  

                <div class="collapse navbar-collapse" id="navbarHeader">
                <!--mb-2 mb-lg-0-->
                    <ul class="navbar-nav me-auto">
                    </ul>
                    <div class="dropdown">
                    <button id="btn_session" class="btn btn-outline-light me-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        MODO ADMINISTRACION
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="btn_session">
                        <li><a class="dropdown-item" href="../cerrar-sesion.php">Cerrar Sesión</a></li>
                        <li><a class="dropdown-item" href="productos/crear.php">Agregar Producto</a></li>
                        <li><a class="dropdown-item" href="estadisticas/graficos.php">Estadisticas</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </header>

    <main class="container">
        <h1 class="text-center my-4">Admin Dashboard</h1>

        <div class="row">
            <div class="col-md-6">
                <h2>Top 5 Productos Más Vendidos</h2>
                <canvas id="productosVendidosChart" width="300" height="300"></canvas>
            </div>
            <div class="col-md-6">
                <h2>Top 5 Categorías Más Vendidas</h2>
                <canvas id="categoriasVendidasChart" width="300" height="300"></canvas>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-12">
                <h2>Total de Ganancias</h2>
                <p>Total Ganancias: $<?php echo number_format($total_ganancias, 2); ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2>Usuarios Creados por Día</h2>
                <canvas id="usuariosCreadosChart" width="600" height="300"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2>Stock Total de Productos</h2>
                <canvas id="stockProductosChart" width="600" height="300"></canvas>
            </div>
        </div>
    </main>

    <script>
        var ctxProductos = document.getElementById('productosVendidosChart').getContext('2d');
        var productosVendidosChart = new Chart(ctxProductos, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($productos); ?>,
                datasets: [{
                    label: 'Productos vendidos',
                    data: <?php echo json_encode($vendidos); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxCategorias = document.getElementById('categoriasVendidasChart').getContext('2d');
        var categoriasVendidasChart = new Chart(ctxCategorias, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($categorias); ?>,
                datasets: [{
                    label: 'Categorías más vendidas',
                    data: <?php echo json_encode($vendidos_cat); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxUsuarios = document.getElementById('usuariosCreadosChart').getContext('2d');
        var usuariosCreadosChart = new Chart(ctxUsuarios, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($fechas); ?>,
                datasets: [{
                    label: 'Usuarios creados por día',
                    data: <?php echo json_encode($usuarios_creados); ?>,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxStock = document.getElementById('stockProductosChart').getContext('2d');
        var stockProductosChart = new Chart(ctxStock, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($titles_stock); ?>,
                datasets: [{
                    label: 'Stock de productos',
                    data: <?php echo json_encode($stock); ?>,
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
