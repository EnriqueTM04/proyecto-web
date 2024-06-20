<?php 

require 'config/config.php';
require 'config/database.php';

$db = new Database();
$conexion = $db->conectarDB();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$id_usuario = $_SESSION['user_id'];

$query = "SELECT monedero FROM usuarios WHERE id='$id_usuario'";
$resultado = $conexion->query($query);
$monedero = $resultado->fetch_assoc()['monedero'];

$total = 0;
$lista_carrito = [];

if($productos != null) {
    foreach($productos as $key => $cantidad) {
        $id = $key;
        $query = "SELECT id, price, discountPercentage, stock, $cantidad AS cantidad  FROM productos WHERE id='" . $id. "'";

        $resultado = $conexion->query($query);

        $lista_carrito[] = $resultado->fetch_assoc();
    }
}

foreach($lista_carrito as $producto) {
    $_id = $producto['id'];
    $price = $producto['price'];
    $cantidad = $producto['cantidad'];
    $discountPercentage = $producto['discountPercentage'];
    $stock = $producto['stock'];
    $precio_desc = $price - (($price * $discountPercentage)/100);
    $subtotal = $cantidad * $precio_desc;
    $total += $subtotal; 
}

// echo "<pre>";
// var_dump($lista_carrito);
// echo "</pre>";

// var_dump(number_format($total, 2));


if($monedero >= $total) {
    unset($_SESSION['carrito']);
    header('Location: /cart.php?result=1');
    exit;
}

else {
    header('Location: /cart.php?result=0');
    exit;
}

?>