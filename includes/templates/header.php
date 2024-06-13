<?php

require 'config/config.php';

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
    <link href="src/css/styles.css" rel="stylesheet">
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
                            <a href="#" class="nav-link active navegacion-responsive">Productos</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link navegacion-responsive">Catalogo</a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link navegacion-responsive">Contacto</a>
                        </li>
                    </ul>

                    <a href="cart.php" class="btn btn-primary me-2"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M6 2a1 1 0 0 1 .993 .883l.007 .117v1.068l13.071 .935a1 1 0 0 1 .929 1.024l-.01 .114l-1 7a1 1 0 0 1 -.877 .853l-.113 .006h-12v2h10a3 3 0 1 1 -2.995 3.176l-.005 -.176l.005 -.176c.017 -.288 .074 -.564 .166 -.824h-5.342a3 3 0 1 1 -5.824 1.176l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-12.17h-1a1 1 0 0 1 -.993 -.883l-.007 -.117a1 1 0 0 1 .883 -.993l.117 -.007h2zm0 16a1 1 0 1 0 0 2a1 1 0 0 0 0 -2zm11 0a1 1 0 1 0 0 2a1 1 0 0 0 0 -2z" stroke-width="0" fill="currentColor" />
                    </svg> <span id="num_cart" class="badge bg-info-subtle"><?php if($num_cart > 0) echo $num_cart; ?></span></a>

                    <?php if($auth) : ?>
                        <div class="dropdown">
                        <button id="btn_session" class="btn btn-outline-light me-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Mi Cuenta
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                            <li><a class="dropdown-item" href="cerrar-sesion.php">Cerrar Sesión</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                        </div>
                    <?php endif; ?>
                    <?php if(!$auth) : ?>
                            <a class="btn btn-outline-light me-2" href="login.php">Iniciar Sesión</a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </header>