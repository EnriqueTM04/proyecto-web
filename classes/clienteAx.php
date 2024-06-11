<?php

require_once '../config/database.php';
require_once 'cliente.php';

$datos = [];

if(isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $db = new Database();
    $conexion = $db->conectarDB();

    if($accion === 'existeUsuario') {
        $datos['ok'] = usuarioExiste($_POST['usuario'], $conexion);
    } else if($accion === 'existeEmail') {
        $datos['ok'] = correoExiste($_POST['email'], $conexion);
    }
}

echo json_encode($datos);

?>