<?php

require_once '../config/database.php';
require_once 'cliente.php';

$datos = [];

if(isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if($accion == 'existeUsuario') {
        $db = new Database();
        $conexion = $db->conectarDB();
        $datos['ok'] = usuarioExiste($_POST['usuario'], $conexion);
    }
}

echo json_encode($datos);

?>