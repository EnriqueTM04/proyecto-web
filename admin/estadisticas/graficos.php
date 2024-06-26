<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Top 5 productos más vendidos
$sql_productos = "SELECT title, SUM(vendidos) as total_vendidos FROM productos
                  GROUP BY id
                  ORDER BY total_vendidos DESC 
                  LIMIT 5";
$result_productos = $conn->query($sql_productos);

$productos = [];
$vendidos = [];

if ($result_productos->num_rows > 0) {
    while ($row = $result_productos->fetch_assoc()) {
        $productos[] = $row['title'];
        $vendidos[] = $row['total_vendidos'];
    }
}

// Top 5 categorías más vendidas
$sql_categorias = "SELECT category, SUM(dc.cantidad) as total_vendidos 
                   FROM productos p 
                   JOIN detalles_compras dc ON p.id = dc.id_producto 
                   GROUP BY category 
                   ORDER BY total_vendidos DESC 
                   LIMIT 5";
$result_categorias = $conn->query($sql_categorias);

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
$result_ganancias = $conn->query($sql_ganancias);

$total_ganancias = 0;

if ($result_ganancias->num_rows > 0) {
    $row = $result_ganancias->fetch_assoc();
    $total_ganancias = $row['total_ganancias'];
}

// Usuarios creados por día
$sql_usuarios = "SELECT fecha_ingreso, COUNT(*) as usuarios_creados 
                 FROM clientes 
                 GROUP BY fecha_ingreso";
$result_usuarios = $conn->query($sql_usuarios);

$fechas = [];
$usuarios_creados = [];

if ($result_usuarios->num_rows > 0) {
    while ($row = $result_usuarios->fetch_assoc()) {
        $fechas[] = $row['fecha_ingreso'];
        $usuarios_creados[] = $row['usuarios_creados'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Top 5 Productos Más Vendidos</h2>
    <canvas id="productosVendidosChart" width="400" height="400"></canvas>

    <h2>Top 5 Categorías Más Vendidas</h2>
    <canvas id="categoriasVendidasChart" width="400" height="400"></canvas>

    <h2>Total de Ganancias</h2>
    <p>Total Ganancias: $<?php echo number_format($total_ganancias, 2); ?></p>

    <h2>Usuarios Creados por Día</h2>
    <canvas id="usuariosCreadosChart" width="400" height="400"></canvas>

    <script>
        var ctxProductos = document.getElementById('productosVendidosChart').getContext('2d');
        var productosVendidosChart = new Chart(ctxProductos, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($productos); ?>,
                datasets: [{
                    label: 'Productos más vendidos',
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
    </script>
</body>
</html>
