<?php

// CREAR  IDENTIFICADOR
function generarToken() : string {
    return md5(uniqid(mt_rand(), false));
}

function usuarioExiste($usuario, $conexion): bool {
    $query = "SELECT id FROM usuarios WHERE usuario LIKE '$usuario' LIMIT 1";
    $resultado = $conexion->query($query);

    if(mysqli_fetch_column($resultado) > 0) {
        return true;
    }
    else {
        return false;
    }

}

function correoExiste($email, $conexion): bool {
    $query = "SELECT id FROM clientes WHERE email LIKE '$email' LIMIT 1";
    $resultado = $conexion->query($query);

    if(mysqli_fetch_column($resultado) > 0) {
        return true;
    }
    else {
        return false;
    }

}

?>