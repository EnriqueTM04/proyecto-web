<?php

require '../config/config.php';
require '../config/database.php';

if(!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false;

$db = new Database();
$conexion = $db->conectarDB();

$query = "SELECT * FROM productos";
$resultadoConsulta = $conexion->query($query);

$resultado = $_GET['resultado'] ?? null;    //si no existe entonces asignar null

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if($id) {

        //Eliminar el archivo
        $query = "SELECT imagen FROM productos WHERE id = $id";

        $resultado = mysqli_query($conexion, $query);
        $propiedad = mysqli_fetch_assoc($resultado);
        unlink('../imagenes/' . $propiedad['imagen']);

        // Eliminar propiedad
        $query = "DELETE FROM productos WHERE id = $id";

        $resultado = mysqli_query($conexion, $query);

        if($resultado) {
            header('Location: /admin?resultado=3');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZAMAZOR</title>

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
    
    <main class="container mt-4">
        <h1>Administrador de ZAMAZOR</h1>
        <?php if( intval($resultado) === 1) : ?>
            <div class="alert alert-success" role="alert">Producto creado correctamente</div>
        <?php elseif( intval($resultado) === 2) : ?>
            <div class="alert alert-success" role="alert">Producto actualizado correctamente</div>
        <?php elseif( intval($resultado) === 3) : ?>
            <div class="alert alert-success" role="alert">Producto eliminado correctamente</div>
        <?php endif; ?>

        <a href="productos/crear.php" class="btn btn-success mb-3">Nueva Propiedad</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($producto = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                    <tr>
                        <td><?php echo $producto['id'] ?></td>
                        <td><?php echo $producto['title'] ?></td>
                        <td><img src="<?php echo $producto['thumbnail'] ?>" alt="Imagen Producto" class="img-fluid" style="max-width: 100px;" loading="lazy"></td>
                        <td>$<?php echo $producto['price'] ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?php echo $producto['id'] ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                            <a href="admin/productos/modificar.php?id=<?php echo $producto['id'] ?>" class="btn btn-warning">Actualizar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>


    <!-- Footer -->
    <footer class="text-center text-lg-start bg-body-tertiary text-muted">
    <!-- Section: Social media -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <!-- Left -->
        <div class="me-5 d-none d-lg-block">
        <span>Get connected with us on social networks:</span>
        </div>
        <!-- Left -->

        <!-- Right -->
        <div>
        <a href="" class="me-4 text-reset">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="" class="me-4 text-reset">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="" class="me-4 text-reset">
            <i class="fab fa-google"></i>
        </a>
        <a href="" class="me-4 text-reset">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="" class="me-4 text-reset">
            <i class="fab fa-linkedin"></i>
        </a>
        <a href="" class="me-4 text-reset">
            <i class="fab fa-github"></i>
        </a>
        </div>
        <!-- Right -->
    </section>
    <!-- Section: Social media -->

    <!-- Section: Links  -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row mt-3">
            <!-- Grid column -->
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <!-- Content -->
            <h6 class="text-uppercase fw-bold mb-4">
                <i class="fas fa-gem me-3"></i>Company name
            </h6>
            <p>
                Here you can use rows and columns to organize your footer content. Lorem ipsum
                dolor sit amet, consectetur adipisicing elit.
            </p>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
                Products
            </h6>
            <p>
                <a href="#!" class="text-reset">Angular</a>
            </p>
            <p>
                <a href="#!" class="text-reset">React</a>
            </p>
            <p>
                <a href="#!" class="text-reset">Vue</a>
            </p>
            <p>
                <a href="#!" class="text-reset">Laravel</a>
            </p>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">
                Useful links
            </h6>
            <p>
                <a href="#!" class="text-reset">Pricing</a>
            </p>
            <p>
                <a href="#!" class="text-reset">Settings</a>
            </p>
            <p>
                <a href="#!" class="text-reset">Orders</a>
            </p>
            <p>
                <a href="#!" class="text-reset">Help</a>
            </p>
            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <!-- Links -->
            <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
            <p><i class="fas fa-home me-3"></i> New York, NY 10012, US</p>
            <p>
                <i class="fas fa-envelope me-3"></i>
                info@example.com
            </p>
            <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
            <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
            </div>
            <!-- Grid column -->
        </div>
        <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links  -->

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2021 Copyright:
        <a class="text-reset fw-bold" href="https://mdbootstrap.com/">MDBootstrap.com</a>
    </div>
    <!-- Copyright -->
    </footer>
    <!-- Footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../../src/js/script.js"></script>
</body>
</html>