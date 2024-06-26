<?php
//Comentario de prueba
require 'includes/templates/header.php';
require 'config/database.php';

$db = new Database();
$conexion = $db->conectarDB();

$query = "SELECT id, title, price, descripcion, discountPercentage, thumbnail FROM productos";
$resultado = $conexion->query($query);
// $productos = mysqli_fetch_assoc($resultado);
// while($productos = mysqli_fetch_assoc($resultado)) {
//     echo "<pre>";
//     var_dump($productos);
//     echo "</pre>";
// }

// BORRAR CARRITO MOMENTANEAMENTE
// session_destroy();

?>

<main>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php while($producto = mysqli_fetch_assoc($resultado)) : ?>
            <div class="col">
                <div class="card shadow-sm productos">
                    <img src="<?php echo $producto['thumbnail']; ?>" height="250px" alt="Imagen producto" class="card-img-top" loading="lazy">
                    <!--Colocar la imagen(IMPORTANTE PARA DESPUES)-->
                    <div class="card-body">
                        <h4 class="card-title"> <?php echo $producto['title'] ?> </h4>
                        <p class="card-text"><del><?php echo $price = $producto['price']; ?></del></p>
                        <h5 class="card-text">$ <?php
                            $price = $producto['price'];
                            $discountPercentage =  $producto['discountPercentage'];
                            $precio_desc = $price - (($price * $discountPercentage)/100);
                            echo number_format($precio_desc, 2, '.', ','); 
                        ?><small class="text-success fst-italic modal-sm"> %<?php echo $discountPercentage; ?> OFF</small></h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="producto.php?id=<?php echo $producto['id']; ?>&token=<?php //cifrar informacion mediante contrasenia
                                echo hash_hmac('sha1', $producto['id'], KEY_TOKEN); ?>" class="btn btn-primary">Ver Más</a>
                            </div>
                            <button class="btn btn-outline-info" type="button" onclick="addProducto(<?php echo $producto['id']; ?>, '<?php echo hash_hmac('sha1', $producto['id'], KEY_TOKEN); ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart-plus icono-carrito" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#0dcaf0" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M12.5 17h-6.5v-14h-2" />
                                    <path d="M6 5l14 1l-.86 6.017m-2.64 .983h-10.5" />
                                    <path d="M16 19h6" />
                                    <path d="M19 16v6" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>  
    </div>
</main>

    
<?php

require 'includes/templates/footer.php';

?>