<?php

require 'includes/templates/header.php';
require 'config/database.php';
require 'classes/cliente.php';

$db = new Database();
$conexion = $db->conectarDB();

$errores = [];
$nombres = $_POST[''];
$apellidos = $_POST[''];
$email = $_POST[''];
$tel = $_POST[''];
$direccion = $_POST[''];
$usuario = $_POST[''];
$password = $_POST[''];
$password2 = $_POST[''];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = mysqli_escape_string($conexion ,trim($_POST['nombres']));
    $apellidos = mysqli_escape_string($conexion ,trim($_POST['apellidos']));
    $email = mysqli_escape_string($conexion , trim($_POST['email']));
    $tel = mysqli_escape_string($conexion ,trim($_POST['tel']));
    $direccion = mysqli_escape_string($conexion ,trim($_POST['direccion']));
    $usuario = mysqli_escape_string($conexion ,trim($_POST['usuario']));
    $password = mysqli_escape_string($conexion ,trim($_POST['password']));
    $password2 = mysqli_escape_string($conexion ,trim($_POST['password2']));

    if(!$nombres) {
        $errores[] = "Debes agregar un nombre";
    }
    if(!$apellidos) {
        $errores[] = "Debes agregar los apellidos";
    }
    if(!$email) {
        $errores[] = "Debes agregar un email";
    }
    if(!$tel) {
        $errores[] = "Debes agregar un telefono";
    }
    if(!$direccion) {
        $errores[] = "Debes agregar una direccion";
    }
    if(!$usuario) {
        $errores[] = "Debes agregar un usuario";
    }
    if(!$password) {
        $errores[] = "Debes agregar un password";
    }
    if(!$password2) {
        $errores[] = "Debes agregar un password";
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
    }
    
}


?>


    <main>
        <div class="container contenedor">
            <h2 class="text-center text-primary">Registrarse</h2>

            <form class="row g-3" action="register.php" method="POST">
            <div class="col-md-6">
                <label for="nombres" class="form-label">Nombre(s)</label>
                <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Tus Nombres" required>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ambos Apellidos" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="ej: you@example.com" required>
            </div>
            <div class="col-md-3">
                <label for="tel" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="tel" name="tel" placeholder="Número principal" required>
            </div>
            <div class="col-md-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="elija un nombre de usuario" required>
            </div>
            <div class="col-12">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Av. example No.1" required>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="col-md-6">
                <label for="password2" class="form-label">Repita la Contraseña</label>
                <input type="password" class="form-control" id="password2" name="password2" required>
            </div>
            <!-- <div class="col-12">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck"> 
                <label class="form-check-label" for="gridCheck">
                    Check me out
                </label>
                </div>
            </div> -->
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