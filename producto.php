<?php
require 'includes/templates/header.php';
require 'config/database.php';

$db = new Database();
$conexion = $db->conectarDB();

// TOMAR DATOS Y VERIDICAR QUE EXISTAN
$id = isset($_GET['id']) ? $_GET['id'] : '';
$id = filter_var($id, FILTER_VALIDATE_INT);
$token = isset($_GET['token']) ? $_GET['token'] : '';


// ENVIAR A PRODUCTOS
if($id === '' || $token === '' || !$id) {
    header("Location: /index.php");
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token === $token_tmp) {
        $query = "SELECT count(id) FROM productos WHERE id=" . $id;
        $resultado = $conexion->query($query);
        if($resultado->fetch_column() > 0) {
            $query = "SELECT title, price, descripcion, discountPercentage, thumbnail  FROM productos WHERE id=" . $id . " LIMIT 1";
            $resultado = $conexion->query($query);
            $producto = mysqli_fetch_assoc($resultado);
            $title = $producto['title'];
            $price = $producto['price'];
            $descripcion = $producto['descripcion'];
            $discountPercentage = $producto['discountPercentage'];
            $thumbnail = $producto['thumbnail'];
            $precio_desc = $price - (($price * $discountPercentage)/100);
            $dir_images = 'src/images/productos/' . '1' . '/';
            
            if($resultado) {
                $query = "SELECT url FROM imagenes WHERE producto_id = $id";
                $resultado = $conexion->query($query);
                // $imagenes = mysqli_fetch_all($resultado);       
                // echo "<pre>";
                // var_dump($imagenes);
                // echo "</pre>";       
                // exit;  
            }

            // $rutaImg = $dir_images . '1.png';

            // if(!file_exists($rutaImg)) {
            //     $rutaImg = '';
            // }

            // $imagenes = array();
            // $dir = dir($dir_images);

            // while(($archivo = $dir->read())!= false) {
            //     if($archivo != '1.png' && (strpos($archivo, 'png') || strpos($archivo, 'jpg'))) {
            //         $imagenes[] = $dir_images . $archivo;
            //     }
            // }
            // $dir->close();
        }
    }
    else {
        header("Location: /index.php");
    }
}

?>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div id="carouselImages" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $thumbnail ?>" alt="Imagen producto" class="d-block w-100" loading="lazy">
                            </div>
                            <?php while($imagenes = mysqli_fetch_assoc($resultado)) : ?>
                            <div class="carousel-item">
                            <img src="<?php echo $imagenes['url'] ?>" alt="Imagen producto" class="d-block w-100">
                            </div>
                            <?php endwhile; ?>
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
    
<?php

require 'includes/templates/footer.php';

?>