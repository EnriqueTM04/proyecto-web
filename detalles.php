<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$conexion = $db->conectarDB();

// TOMAR DATOS Y VERIDICAR QUE EXISTAN
$id = isset($_GET['id']) ? $_GET['id'] : '';
$id = filter_var($id, FILTER_VALIDATE_INT);
$token = isset($_GET['token']) ? $_GET['token'] : '';


// ENVIAR A PRODUCTOS
if($id === '' || $token === '') {
    header("Location: /index.php");
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token === $token_tmp) {
        $query = "SELECT count(id) FROM productos WHERE id=" . $id;
        $resultado = $conexion->query($query);
        if($resultado->fetch_column() > 0) {
            $query = "SELECT title, price, descripcion, discountPercentage  FROM productos WHERE id=" . $id . " LIMIT 1";
            $resultado = $conexion->query($query);
            $producto = mysqli_fetch_assoc($resultado);
            $title = $producto['title'];
            $price = $producto['price'];
            $descripcion = $producto['descripcion'];
            $discountPercentage = $producto['discountPercentage'];
            $precio_desc = $precio - ($precio * $discountPercentage)/100;
        }
    }
    else {
        header("Location: /index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Web</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>

    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="/index.php" class="navbar-brand">
                    <strong>Nombre pagina</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>  

                <div class="collapse navbar-collapse" id="navbarHeader">
                <!--mb-2 mb-lg-0-->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Productos</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">Catalogo</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">Contacto</a>
                        </li>
                    </ul>

                    <a href="carrito.php" class="btn btn-primary">Carrito</a>
                </div>

            </div>
        </div>
    </header>

    <main>
        <div class="container contenedor">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <img src="images/productos/1/1.png" alt="Imagen producto">
                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $title; ?></h2>
                    <h3>$ <?php echo number_format($price, 2, '.', ','); ?></h3>
                    <p><?php echo $descripcion; ?></p>

                    <div class="d-grid gap-3 col-10 mx-auto">
                        <buton class="btn btn-primary" type="button">Comprar</buton>
                        <buton class="btn btn-outline-primary" type="button">Agregar al Carrito</buton>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>