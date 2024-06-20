<?php

require '../config/config.php';

if(!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Web</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../src/css/styles.css" rel="stylesheet">
</head>
<body>

    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="/admin/index.php" class="navbar-brand">
                    <strong>Nombre pagina</strong>
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
                        <li><a class="dropdown-item" href="cerrar-sesion.php">Cerrar Sesión</a></li>
                        <li><a class="dropdown-item" href="#">Historial compras</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </header>
    
    <main>
    <img src="/src/images/logo/Banner completo.png" class="imagen-admin" alt="Logo tienda" loading="lazy">
        <div class="container">
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="button">Button</button>
                <br>
                <button class="btn btn-primary" type="button">Button</button>
            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="src/js/script.js"></script>
</body>
</html>