<?php
require 'includes/templates/header.php';
require 'config/database.php';

$db = new Database();
$conexion = $db->conectarDB();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = [];

if($productos != null) {
    foreach($productos as $key => $cantidad) {
        $id = $key;
        $query = "SELECT id, title, price, descripcion, discountPercentage, $cantidad AS cantidad  FROM productos WHERE id='" . $id. "'";

        $resultado = $conexion->query($query);

        $lista_carrito[] = $resultado->fetch_assoc();;
    }
    // echo "<pre>";
    // var_dump($lista_carrito);
    // echo "</pre>";
}

?>

<main>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover table-borderless">
                <thead>
                    <tr>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($lista_carrito == null) { ?>
                        <tr>
                            <td class="text-center"><b>-</b></td>
                            <td class="text-center"><b>-</b></td>
                            <td class="text-center"><b>-</b></td>
                            <td class="text-center"><b>-</b></td>
                            <td class="text-center"><b>-</b></td>
                        </tr>
                    <?php } else { 
                        $total = 0;
                        foreach($lista_carrito as $producto) {
                            $_id = $producto['id'];
                            $title = $producto['title'];
                            $price = $producto['price'];
                            $cantidad = $producto['cantidad'];
                            $discountPercentage = $producto['discountPercentage'];
                            $precio_desc = $price - (($price * $discountPercentage)/100);
                            $subtotal = $cantidad * $precio_desc;
                            $total += $subtotal; 
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $title; ?></td>
                                <td class="text-center">$ <?php echo number_format($precio_desc, 2, '.', ','); ?></td>
                                <td class="text-center">
                                    <input 
                                    type="number" 
                                    min="1" 
                                    max="20" 
                                    step="1" 
                                    value="<?php echo $cantidad; ?>"
                                    size="3" 
                                    id="cantidad_<?php echo $_id; ?>"
                                    onchange="actualizarCantidad(this.value, <?php echo $_id; ?>)">
                                </td>
                                <td class="text-center">
                                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]" class=""><?php echo number_format($subtotal, 2, '.', ','); ?></div>
                                </td>
                                <td class="text-center">
                                    <button id="btn-elimina" class="btn btn-danger btn-sm" onclick="eliminarProducto(<?php echo $_id; ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                    <tr>
                        <td colspan="3"></td>
                        <td>
                            <p class="h3 text-center" id="total">$ <?php echo number_format($total, 2, '.', ',') ?></p>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-end">
                <?php if($auth) { ?>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Confirmar compra
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">¿Proceder al pago?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Es todo lo que desea comprar o quiere agregar más productos?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aguregar más</button>
                            <a type="button" class="btn btn-primary" href="pago.php">COMPRAR</a>
                        </div>
                        </div>
                    </div>
                    </div>
                <?php } else { ?>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Proceder al pago
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">No has iniciado sesión</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        <div class="modal-body">
                            <p>Para disfrutar de todas las ventajas y poder adquirir nuestros productos, por favor crea una cuenta con nosotros. ¡Estamos emocionados de tenerte como parte de nuestra comunidad!</p>
                            <p>Si ya estas registrado inicia sesión</p>
                        </div>
                            <div class="modal-footer">
                                <a type="button" class="btn btn-info" href="register.php">Crear Cuenta</a>
                                <a type="button" class="btn btn-primary" href="login.php">Iniciar Sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
</div>

<br><br><br><br><br><br><br><br><br><br><br>

    
<?php

require 'includes/templates/footer.php';

?>