<?php 

require 'config/config.php';
require 'config/database.php';

$db = new Database();
$conexion = $db->conectarDB();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$usuario = $_SESSION['user_id'];

$lista_carrito = [];

if($productos != null) {
    foreach($productos as $key => $cantidad) {
        $id = $key;
        $query = "SELECT id, price, discountPercentage, stock, $cantidad AS cantidad  FROM productos WHERE id='" . $id. "'";

        $resultado = $conexion->query($query);

        $lista_carrito[] = $resultado->fetch_assoc();;
    }
    // echo "<pre>";
    // var_dump($lista_carrito);
    // echo "</pre>";
}

echo "<pre>";
var_dump($lista_carrito);
echo "</pre>";

var_dump($usuario);

?>