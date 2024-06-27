<?php

    require '../../config/config.php';
    require '../../config/database.php';
    
    if(!isset($_SESSION)) {
        session_start();
    }
    
    $auth = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : false;
    
    if($auth !== 'admin') {
        header('Location: ../index.php');
    }

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
        exit;
    }

    $db = new Database();
    $conexion = $db->conectarDB();

    $consulta = "SELECT * FROM productos WHERE id = $id";
    $resultado = $conexion->query($consulta);
    $producto = mysqli_fetch_assoc($resultado);

    // ARREGLO CON MENSAJES DE ERRORES
    $errores = [];

    $title = $producto['title'] ?? '';
    $descripcion = $producto['descripcion'] ?? '';
    $price = $producto['price'] ?? '';
    $category = $producto['category'] ?? '';
    $discountPercentage = $producto['discountPercentage'] ?? '';
    $brand = $producto['brand'] ?? '';
    $thumbnail = $producto['thumbnail'] ?? '';

    // EJECUTAR CODIGO DESPUES DE QUE USUARIO ENVIA FORMULARIO
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //en caso de que coloquen codigo sql, pueda hacer inyeccion sql, deshabilitarlo y guardarlo como entidad
        $title = mysqli_real_escape_string( $conexion, $_POST['title'] );
        $price = mysqli_real_escape_string( $conexion, $_POST['price'] );
        $descripcion  = mysqli_real_escape_string( $conexion, $_POST['descripcion'] );
        $category  = mysqli_real_escape_string( $conexion, $_POST['category'] );
        $discountPercentage = mysqli_real_escape_string( $conexion, $_POST['discountPercentage'] );
        $brand  = mysqli_real_escape_string( $conexion, $_POST['brand'] );
        $thumbnail  = mysqli_real_escape_string( $conexion, $_POST['thumbnail'] );

        // ASIGNAR FILES HACIA VARIABLE
        $imagen = $_FILES['imagen'];

        if(!$title) {
            $errores[] = "Debes agregar un titulo";
        }

        if(!$price) {
            $errores[] = "Debes agregar un precio";
        }

        if(!$descripcion) {
            $errores[] = "Debes agregar un descripcion";
        }

        if(!$category) {
            $errores[] = "Debes agregar una categoria";
        }

        if(!$discountPercentage) {
            $errores[] = "Debes agregar un descuento";
        }

        if(!$brand) {
            $errores[] = "Debes agregar una brand";
        }

        if(!$thumbnail) {
            $errores[] = "Debes agregar un thumbnail";
        }

        if(!$imagen['name'] || $imagen['error']) {
            $errores[] = "La imagen es obligatoria";
        }

        // VALIDAR POR TAMAÑO (1Mb maximo)
        $medida = 1000 * 1000; //bytes a kb

        if($imagen['size']> $medida) {
            $errores[] = "La imagen es muy pesada";
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";

        // Revisar que arreglo de errores este vacio
        if(empty($errores)) {

            /**  SUBIDA DE ARCHIVOS */ 
            // Crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir(!$carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }

            // Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

            // Insertar en la base de datos
            $query = "UPDATE producto (title, descripcion, category, price, discountPercentage, brand, thumbnail) VALUES ('$title', '$descripcion', '$category', '$price', '$discountPercentage', '$brand', '$thumbnail') WHERE id = $id";
            var_dump($query);
            // $resultado = mysqli_query($conexion, $query);

            if($resultado) {
                // REDIRECCIONAR AL USUARIO
                header('Location: /admin?resultado=2');
            }
        }
    }
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
                    <strong>ZAMAZOR</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>  

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto"></ul>
                    <div class="dropdown">
                        <button id="btn_session" class="btn btn-outline-light me-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            MODO ADMINISTRACION
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                            <li><a class="dropdown-item" href="../../cerrar-sesion.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container my-5">
        <h1>Actualizar Producto</h1>

        <a href="/admin" class="btn btn-success mb-4">Volver</a>

        <?php foreach ($errores as $error): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
        <?php endforeach; ?>

        <form class="row g-3" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <div class="col-md-6">
                    <label for="title" class="form-label">Titulo:</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Titulo Producto" value="<?php echo $title; ?>">
                </div>

                <div class="col-md-6">
                    <label for="price" class="form-label">Precio:</label>
                    <input type="number" id="price" name="price" class="form-control" placeholder="Precio Producto" value="<?php echo $price; ?>">
                </div>

                <div class="col-md-6">
                    <label for="category" class="form-label">Categoria:</label>
                    <input type="text" id="category" name="category" class="form-control" placeholder="Categoria Producto" value="<?php echo $category; ?>">
                </div>

                <div class="col-md-6">
                    <label for="discountPercentage" class="form-label">Descuento (%):</label>
                    <input type="number" id="discountPercentage" name="discountPercentage" class="form-control" placeholder="Descuento" value="<?php echo $discountPercentage; ?>">
                </div>

                <div class="col-md-6">
                    <label for="brand" class="form-label">Marca:</label>
                    <input type="text" id="brand" name="brand" class="form-control" placeholder="Marca Producto" value="<?php echo $brand; ?>">
                </div>

                <div class="col-md-6">
                    <label for="thumbnail" class="form-label">Thumbnail:</label>
                    <input type="text" id="thumbnail" name="thumbnail" class="form-control" placeholder="Thumbnail URL" value="<?php echo $thumbnail; ?>">
                </div>

                <div class="col-md-12">
                    <label for="imagen" class="form-label">Imagen:</label>
                    <input type="file" accept="image/jpeg, image/png" id="imagen" name="imagen" class="form-control">
                </div>

                <div class="col-md-12">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" rows="4"><?php echo $descripcion; ?></textarea>
                </div>
            </fieldset>

            <div class="col-12">
                <input type="submit" value="Actualizar Producto" class="btn btn-primary">
            </div>
        </form>
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
