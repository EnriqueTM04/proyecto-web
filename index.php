<?php

require 'config/config.php';

if(!isset($_SESSION)) {
    session_start();
}

$auth = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : false;

if($auth === 'admin') {
    header('Location: admin/index.php');
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "tienda_web";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener los productos
$sql = "SELECT * FROM productos ORDER BY RAND() LIMIT 3";
$result = $conn->query($sql);
// Inicio del documento HTML/PHP
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <script src="./CARPETA PRUEBAS/jquery/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="./CARPETA PRUEBAS/Bootstrap/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="./CARPETA PRUEBAS/Bootstrap/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="productosProyecto.js"></script>
    <script src="principal.js"></script>
</head>
<body>
<header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="index.php" class="navbar-brand">
                    <strong>ZAMAZOR</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>  

                <div class="collapse navbar-collapse" id="navbarHeader">
                <!--mb-2 mb-lg-0-->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="productos.php" class="nav-link active navegacion-responsive">Productos</a>
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
                            <li><a class="dropdown-item" href="#">Historial compras</a></li>
                            <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
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
    <main class="background-radial-gradient principal">
    <style>
        .background-radial-gradient {
        background-color: hsl(218, 41%, 15%);
        background-image: radial-gradient(650px circle at 0% 0%,
            hsl(218, 41%, 35%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%),
            radial-gradient(1250px circle at 100% 100%,
            hsl(218, 41%, 45%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%);
        }
    </style>
    <div class="container">
        <!-- Carrusel -->
        <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://cdn.dummyjson.com/products/images/groceries/Ice%20Cream/thumbnail.png" class="img-fluid" width="500" height="auto">
                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1 style="color: black; font-size: 100px;" class="text-white">ZAMAZOR</h1>
                            <p style="color: black;" class="opacity-75 text-white">Tu opcion confiable para comprar en linea.</p>
                            <p style="color: black;"><a class="btn btn-lg btn-secondary text-white" href="register.php">Registrate</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://cdn.dummyjson.com/products/images/kitchen-accessories/Black%20Aluminium%20Cup/thumbnail.png" class="img-fluid" width="500" height="auto">
                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1 style="color: black;" class="text-white">Tenemos las mejores ofertas</h1>
                            <p style="color: black;" class="text-white">Dejate llevar por las ofertas que nuestra pagina te<br> ofrece, sorprendete con la gran cantidad de descuentos disponibles para ti.</p>
                            <p style="color: black;"><a class="btn btn-lg btn-secondary text-white" href="login.php">Inicia sesion</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://cdn.dummyjson.com/products/images/laptops/Apple%20MacBook%20Pro%2014%20Inch%20Space%20Grey/thumbnail.png" class="img-fluid" width="500" height="auto">
                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1 style="color: black;" class="text-white">Aprovecha la oportunidad</h1>
                            <p style="color: black;" class="text-white">Solo por esta vez regalaremos $10,000 al registrarte<br> para que comiences a comprar desde ahora tus productos favoritos.</p>
                            <p style="color: black;"><a class="btn btn-lg btn-secondary text-white" href="register.php">Registrate ahora</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
        </div>
        <!-- Carrusel -->
    </div>
    <div id="verProductos" class="container">
        <h1 class="text-white">Podria interesarte...</h1>
        <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <div class="card text-center">
                <img src="<?php echo $row['thumbnail']; ?>" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $row['title']; ?></h5>
                  <p class="card-text"><?php echo $row['descripcion']; ?></p>
                  <h6 class="card-subtitle mb-2 text-body-secondary">$<?php echo $row['price']; ?></h6>
                </div>
              </div>
            </div>
        <?php
            }
        } else {
            echo "No hay productos disponibles";
        }
        ?>
        </div>
    </div>
    <div class="container">
        <h1 class="text-white">¿Qué ofrecemos?</h1>
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Amplia Variedad de Productos</h5>
                        <p class="card-text">Una selección diversa y actualizada de productos para satisfacer las necesidades y preferencias de diferentes tipos de clientes.</p>
                        <div style="text-align: center;">
                          <i class="fa-solid fa-user fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Experiencia de Usuario Intuitiva</h5>
                        <p class="card-text">Una plataforma fácil de navegar con una interfaz intuitiva que facilite la búsqueda, selección y compra de productos de manera rápida y eficiente.</p>
                        <div style="text-align: center;">
                          <i class="fa-solid fa-face-smile fa-3x"></i>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Seguridad en las Transacciones</h5>
                        <p class="card-text">Garantizar la seguridad y protección de la información personal y financiera de los clientes durante todo el proceso de compra, utilizando métodos de pago seguros y tecnologías de encriptación.</p>
                        <div style="text-align: center;">
                          <i class="fa-solid fa-money-bill fa-3x"></i>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>
    </main>
    <footer class="py-3 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Derechos reservados 2024</p>
    </div>
    </footer>
</body>
</html>

<?php
// Cierra la conexión a la base de datos
$conn->close();
?>
