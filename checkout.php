<?php

require 'config/config.php';
require 'config/database.php';

$db = new Database();
$conexion = $db->conectarDB();

$query = "SELECT id, title, price FROM productos";
$resultado = $conexion->query($query);

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = [];

if($productos != null) {
    foreach($productos as $key => $cantidad) {
        $id = $key;
        $query = "SELECT id, title, price, descripcion, discountPercentage, $cantidad AS cantidad  FROM productos WHERE id='" . $id. "'";

        $resultado = $conexion->query($query);

        $lista_carrito[] = mysqli_fetch_assoc($resultado);
    }
    // echo "<pre>";
    // var_dump($lista_carrito);
    // echo "</pre>";
}

?>


<?php

require 'includes/templates/header.php';

?>

    <main>
        <div class="container contenedor">
            <div class="table-response"></div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Total</th>
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
                                    onchange="">
                                </td>
                                <td class="text-center">
                                    <div class="" id="subtotal_<?php echo $_id; ?>" name=""></div>
                                </td>d>
                            </tr>
                        
                        <?php }
                    } ?>
                    
                </tbody>
            </table>
        </div>
            
    </main>
    
<?php

require 'includes/templates/footer.php';

?>