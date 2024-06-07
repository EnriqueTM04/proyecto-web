<?php

require 'config/config.php';
require 'config/database.php';

$db = new Database();
$conexion = $db->conectarDB();

$query = "SELECT id, title, price FROM productos";
$resultado = $conexion->query($query);
// $productos = mysqli_fetch_assoc($resultado);
// while($productos = mysqli_fetch_assoc($resultado)) {
//     echo "<pre>";
//     var_dump($productos);
//     echo "</pre>";
// }
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
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php while($producto = mysqli_fetch_assoc($resultado)) : ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img src="/images/productos/1/1.png" alt="">
                        <!--Colocar la imagen(IMPORTANTE PARA DESPUES)-->
                        <div class="card-body">
                            <h5 class="card-title"> <?php echo $producto['title'] ?> </h5>
                            <p class="card-text">$ <?php echo number_format($producto['price'], 2, '.', ',') ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="detalles.php?id=<?php echo $producto['id']; ?>&token=<?php //cifrar informacion mediante contrasenia
                                    echo hash_hmac('sha1', $producto['id'], KEY_TOKEN); ?>" class="btn btn-primary">Ver Más</a>
                                </div>
                                <small class="btn btn-success">Agregar</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>  
        </div>
            
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>