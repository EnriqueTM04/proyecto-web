<?php

require '../config/config.php';
require '../config/database.php';

if(isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if($accion === 'agregar') {
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;

        $respuesta = agregar($id, $cantidad);

        if($respuesta > 0 ) {
            $datos['ok'] =  true;
        } else {
            $datos['ok'] = false;
        }

        $datos['sub'] = '$ ' . number_format($respuesta, 2, '.', ',');
    } 

    else if($accion === 'quitar') {
        $datos['ok'] = quitar($id);
    }
    
    else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}

echo json_encode($datos);

function agregar($id, $cantidad) : float {
    $respuesta = 0;
    if($id > 0 && $cantidad >0 && is_numeric($cantidad)) {
        if(isset($_SESSION['carrito']['productos'][$id])) {
            $_SESSION['carrito']['productos'][$id] =  $cantidad;

            $db = new Database();
            $conexion = $db->conectarDB();

            $query = "SELECT price, discountPercentage  FROM productos WHERE id=" . $id . " LIMIT 1";
            $resultado = $conexion->query($query);
            $producto = mysqli_fetch_assoc($resultado);
            $price = $producto['price'];
            $discountPercentage = $producto['discountPercentage'];
            $precio_desc = $price - (($price * $discountPercentage)/100);
            $respuesta = $cantidad * $precio_desc;

            return $respuesta;
        }
    }
    else {
        return $respuesta;
    }
}

function quitar($id): bool {
    if($id > 0) {
        if(isset($_SESSION['carrito']['productos'][$id])) {
            unset($_SESSION['carrito']['productos'][$id]);
            $respuesta = true;
        }
        else {
            $respuesta = false;
        }
    }
    return $respuesta;
}

?>