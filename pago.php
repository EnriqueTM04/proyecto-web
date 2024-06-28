<?php 

require 'config/config.php';
require 'config/database.php';
require 'includes/funciones.php';

if(!isset($_SESSION)) {
    session_start();
}

$total = $_GET['total'];

$db = new Database();
$conexion = $db->conectarDB();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$id_usuario = $_SESSION['user_id'];

$query = "SELECT monedero, id_cliente FROM usuarios WHERE id='$id_usuario'";
$resultado = $conexion->query($query);
$resultado = $resultado->fetch_assoc();
$monedero = $resultado['monedero'];
$id_cliente = $resultado['id_cliente'];

if($monedero < $total) {
    header('Location: /cart.php?result=0');
    exit;
}

$query = "SELECT email FROM clientes WHERE id = $id_cliente";
$resultado = $conexion->query($query);
$email = $resultado->fetch_assoc()['email'];
$lista_carrito = [];

$fecha_compra = date('Y-m-d H:i:s');
$id_transaccion = md5(uniqid(rand(), true));
// Seleccionar los primeros 20 caracteres de la cadena generada
$id_transaccion = substr($id_transaccion, 0, 20);

$query = "INSERT INTO compras (id_transaccion, fecha_compra, email, id_cliente, total) VALUES ('$id_transaccion', '$fecha_compra', '$email', '$id_cliente', '$total')";
$conexion->query($query);
$id_compra = $conexion->insert_id;

if($resultado) {
    if($productos != null) {
        foreach($productos as $key => $cantidad) {
            $id = $key;
            $query = "SELECT id, title, price, discountPercentage, stock, vendidos, '$cantidad' AS cantidad  FROM productos WHERE id='$id'";
    
            $resultado = $conexion->query($query);
    
            $lista_carrito[] = $resultado->fetch_assoc();
        }
    }
    
    foreach($lista_carrito as $producto) {
        $_id = $producto['id'];
        $title = $producto['title'];
        $price = $producto['price'];
        $cantidad = $producto['cantidad'];
        $discountPercentage = $producto['discountPercentage'];
        $stock = $producto['stock'];
        $vendidos = $producto['vendidos'];
        $precio_desc = $price - (($price * $discountPercentage)/100);
        $subtotal = $cantidad * $precio_desc;
        $total += $subtotal; 

        // CAMBIAR DATOS PRODUCTOS
        $stock -= $cantidad;
        $vendidos += $cantidad;
        $query = "UPDATE productos SET vendidos='$vendidos', stock='$stock' WHERE id='$_id'";
        $conexion->query($query);

        $query = "INSERT INTO detalles_compras (id_compra, id_producto, nombre, precio, cantidad) VALUES ('$id_compra', '$_id', '$title', '$price', '$cantidad')";
        $conexion->query($query);
    }
    
    
    if($monedero >= $total) {
    
        // REDUCIR EL MONEDERO
        $monedero -= $total;
        $query = "UPDATE usuarios SET monedero='$monedero' WHERE id='$id_usuario'";
        $conexion->query($query);

        include 'fpdf.php';
    
        unset($_SESSION['carrito']);
        header('Location: /cart.php?result=1');
        exit;
    }
}

?>