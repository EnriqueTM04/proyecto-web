<?php

require 'includes/templates/header.php';
require 'config/database.php';
require 'classes/cliente.php';

$db = new Database();
$conexion = $db->conectarDB();

$errores = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = mysqli_escape_string($conexion ,trim($_POST['nombres']));
    $apellidos = mysqli_escape_string($conexion ,trim($_POST['apellidos']));
    $email = mysqli_escape_string($conexion , trim($_POST['email']));
    $tel = mysqli_escape_string($conexion ,trim($_POST['tel']));
    $direccion = mysqli_escape_string($conexion ,trim($_POST['direccion']));
    $usuario = mysqli_escape_string($conexion ,trim($_POST['usuario']));
    $password = mysqli_escape_string($conexion ,trim($_POST['password']));
    $password2 = mysqli_escape_string($conexion ,trim($_POST['password2']));

    if(strlen(trim($nombres)) < 1) {
        $errores[] = "Debes agregar un nombre";
    }
    if(strlen(trim($apellidos)) < 1) {
        $errores[] = "Debes agregar los apellidos";
    }
    if(strlen(trim($email))<1 && filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        $errores[] = "Debes agregar un correo válido";
    }
    if(strlen(trim($tel)) !== 10) {
        $errores[] = "Debes agregar un telefono valido";
    }
    if(strlen(trim($direccion)) < 1) {
        $errores[] = "Debes agregar una direccion";
    }
    if(strlen(trim($usuario)) < 1) {
        $errores[] = "Debes agregar un usuario";
    }
    if(strlen(trim($password)) < 1) {
        $errores[] = "Debes agregar un password";
    }
    if(strcmp($password, $password2) !== 0) {
        $errores[] = "Debes repetir la misma password";
    }

    if(usuarioExiste($usuario, $conexion)) {
        $errores[] = "El nombre de $usuario no esta disponible";
    }

    if(correoExiste($email, $conexion)) {
        $errores[] = "El correo $email ya esta registrado";
    }

    if(empty($errores)) {
        // registrarCliente
        $query = $sql = "INSERT INTO clientes (nombres, apellidos, email, tel, direccion, fecha_ingreso) VALUES ('$nombres', '$apellidos', '$email', '$tel', '$direccion', CURRENT_DATE)";
        $resultado = $conexion->query($query);

        if($resultado) {
            // registrar Usuario
            $id = $conexion->insert_id;
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $token = generarToken();
            $query = "INSERT INTO usuarios (usuario, password, token, id_cliente) VALUES ('$usuario', '$passwordHash', '$token', '$id')";
            $resultado = $conexion->query($query);
            if(!$resultado) {
                $errores[] = "Error al registrar usuario";
            }
        } else {
            $errores[] = "Error al registrar cliente";
        }

        if(empty($errores)) {
            // REDIRIGIR POSTERIORMENTE AL USUARIO
        }
    }
    
}


?>


    <main>
        <div class="container contenedor">
            <h2 class="text-center text-primary">Registrarse</h2>
                <?php if(!empty($errores)) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <ul>
                            <?php foreach($errores as $error) : ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

            <form class="row g-3" action="register.php" method="POST">
            <div class="col-md-6">
                <label for="nombres" class="form-label">Nombre(s)</label>
                <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Tus Nombres">
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ambos Apellidos">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="ej: you@example.com">
            </div>
            <div class="col-md-3">
                <label for="tel" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="tel" name="tel" placeholder="Número principal">
            </div>
            <div class="col-md-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="elija un nombre de usuario">
                <span id="validaUsuario" class="text-warning"></span>
            </div>
            <div class="col-12">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Av. example No.1">
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="col-md-6">
                <label for="password2" class="form-label">Repita la Contraseña</label>
                <input type="password" class="form-control" id="password2" name="password2">
            </div>
            <div class="col-12">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck" required> 
                <label class="form-check-label" for="gridCheck">
                    Confirmo que los datos ingresados son válidos
                </label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Crear Cuenta</button>
            </div>
            </form>

            <br><br><br><br><br><br><br>
        </div>
    </main>


<?php

require 'includes/templates/footer.php';

?>