<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
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
    <header>
        <img src="Banner completo.png" class="img-fluid" alt="">
        <!-- Menu de Navegación -->
        <nav class="navbar bg-dark navbar-dark fixed-top" aria-label="First navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">ZAMAZOR</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon text-white"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbars">
                    <ul class="navbar-nav me-auto mb-2">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="productos.php">Productos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Menu de Navegación -->
    </header>
    <main>
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
                    <img src="./CARPETA PRUEBAS/ejemplo2.webp" class="img-fluid">
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>Oferta 1</h1>
                            <p class="opacity-75">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga vel magni esse distinctio exercitationem tempore temporibus! Vel quis nisi delectus.</p>
                            <p><a class="btn btn-lg btn-secondary" href="#">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./CARPETA PRUEBAS/ejemplo2.webp" class="img-fluid">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Oferta 2</h1>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates fuga nobis, odio vero deserunt quas? Recusandae soluta asperiores quasi aspernatur.</p>
                            <p><a class="btn btn-lg btn-secondary" href="#">Learn more</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./CARPETA PRUEBAS/ejemplo2.webp" class="img-fluid">
                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1>Oferta 3</h1>
                            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque ipsum nihil impedit, necessitatibus laudantium dolorum nobis perspiciatis quis delectus maxime.</p>
                            <p><a class="btn btn-lg btn-secondary" href="#">Browse gallery</a></p>
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
        <h1>Podria interesarte...</h1>
        <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <div class="card text-center" style="">
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
        <h1>¿Qué ofrecemos?</h1>
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
