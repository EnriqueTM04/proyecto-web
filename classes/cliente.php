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

function validaToken($id, $token, $conexion): string {
    $msg = "";
    $id = mysqli_escape_string($conexion ,$id);
    $token = mysqli_escape_string($conexion, $token);
    $query = "SELECT id FROM usuarios WHERE id = '$id' AND token LIKE '$token' LIMIT 1";
    $resultado = $conexion->query($query);

    if(mysqli_fetch_column($resultado) > 0) {
        if(activarUsuario($id, $conexion)) {
            $msg = "Cuenta activada exitosamente";
        }
        else {
            $msg = "Error al activar la cuenta";
        }
    }
    else {
        $msg = "NO existe el cliente registrado";
    }
    return $msg;
}

function activarUsuario($id, $conexion) {
    $query = "UPDATE usuarios SET activacion = 1, token = '' WHERE id = $id";
    $resultado = $conexion->query($query);
    
    return $resultado;
}

?>