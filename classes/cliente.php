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
    $query = "UPDATE usuarios SET activacion = 1, monedero = 10000.00, token = '' WHERE id = $id";
    $resultado = $conexion->query($query);
    
    return $resultado;
}

function loginAdmin($usuario, $password, $conexion): bool {
    $query = "SELECT id, password, usuario FROM usuarios WHERE usuario LIKE 'admin' LIMIT 1";
    $resultado = $conexion->query($query);

    if($resultado) {
        $row = mysqli_fetch_assoc($resultado);
    
        if(password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = 'admin';
            header('Location: /admin/index.php');
            exit;
        }
    }
    return false;
}

function login($usuario, $password, $conexion): string {
    $query = "SELECT id, password, usuario FROM usuarios WHERE usuario LIKE '$usuario' LIMIT 1";
    $resultado = $conexion->query($query);

    if($resultado) {
        if(esActivo($usuario, $conexion)) {
            $row = mysqli_fetch_assoc($resultado);
        
            if(password_verify($password, $row['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['usuario'];
                header('Location: index.php');
                exit;
            }
        }
        else {
            return 'El usuario no esta activado';
        }
    } 

    return 'El usuario y/o contraseña son incorrectos';
}

function esActivo($usuario, $conexion): bool {
    $query = "SELECT activacion FROM usuarios WHERE usuario LIKE '$usuario' LIMIT 1";
    $resultado = $conexion->query($query);
    $row = mysqli_fetch_assoc($resultado);
    if($row['activacion'] == 1) {
        return true;
    }

    else {
        return false;
    }

}

?>