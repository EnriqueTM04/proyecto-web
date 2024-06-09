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
            $precio_desc = $price - (($price * $discountPercentage)/100);
            $dir_images = 'src/images/productos/' . '1' . '/';

            $rutaImg = $dir_images . '1.png';

            if(!file_exists($rutaImg)) {
                $rutaImg = '';
            }

            $imagenes = array();
            $dir = dir($dir_images);

            while(($archivo = $dir->read())!= false) {
                if($archivo != '1.png' && (strpos($archivo, 'png') || strpos($archivo, 'jpg'))) {
                    $imagenes[] = $dir_images . $archivo;
                }
            }
            $dir->close();
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

                    <a href="carrito.php" class="btn btn-primary">Carrito</a>
                </div>

            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $rutaImg ?>" alt="Imagen producto" class="d-block w-100">
                            </div>
                            <?php foreach($imagenes as $img) : ?>
                            <div class="carousel-item">
                            <img src="<?php echo $img ?>" alt="Imagen producto" class="d-block w-100">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 order-md-2 detalles">
                    <h2 class="text-center"><?php echo $title; ?></h2>
                    <?php if($discountPercentage> 0) { ?>
                        <p class="bg-success text-bg-secondary badge">OFERTA ESPECIAL</p>
                        <p class="precio-original"> $<del><?php echo number_format($price, 2, '.', ','); ?></del> </p>
                        <h3 class="fw-semibold">
                            $ <?php echo number_format($precio_desc, 2, '.', ','); ?>
                            <small class="text-success fw-normal"> -%<?php echo $discountPercentage; ?></small>
                        </h3>
                    <?php } else { ?>
                        <h3> $ <?php echo number_format($price, 2, '.', ','); ?></h3>
                    <?php } ?>
                    <p><?php echo $descripcion; ?></p>

                    <div class="d-grid gap-3 col-10 mx-auto">
                        <buton class="btn btn-primary" type="button">Comprar</buton>
                        <buton class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al Carrito</buton>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="src/js/script.js"></script>
</body>
</html>