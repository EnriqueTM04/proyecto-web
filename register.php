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
    $email = mysqli_escape_string($conexion ,filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL));
    $tel = mysqli_escape_string($conexion ,trim($_POST['tel']));
    $direccion = mysqli_escape_string($conexion ,trim($_POST['direccion']));
    $usuario = mysqli_escape_string($conexion ,trim($_POST['usuario']));
    $password = mysqli_escape_string($conexion ,trim($_POST['password']));
    $password2 = mysqli_escape_string($conexion ,trim($_POST['password2']));

    // registrarCliente([$nombres, $apellidos, $email, $tel, $direccion], $conexion);
    $query = $sql = "INSERT INTO clientes (nombres, apellidos, email, tel, direccion, fecha_ingreso) VALUES ('$nombres', '$apellidos', '$email', '$tel', now())";
    $conexion->query($query);

    if($conexion) {
        // registrar Usuario
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (usuario, password, token, id_cliente) VALUES ('$usuario', '$passwordHash', '$token', '$id')";
    }
    
}


?>


    <main>
        <div class="container contenedor">
            <h2 class="text-center text-primary">Registrarse</h2>

            <form class="row g-3" action="register.php" method="POST">
            <div class="col-md-6">
                <label for="nombres" class="form-label">Nombre(s)</label>
                <input type="text" class="form-control" id="nombres" placeholder="Tus Nombres" required>
            </div>
            <div class="col-md-6">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" placeholder="Ambos Apellidos" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="ej: you@example.com" required>
            </div>
            <div class="col-md-3">
                <label for="tel" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="tel" placeholder="Número principal" required>
            </div>
            <div class="col-md-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" placeholder="elija un nombre de usuario" required>
            </div>
            <div class="col-12">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" placeholder="Av. example No.1" required>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" required>
            </div>
            <div class="col-md-6">
                <label for="password2" class="form-label">Repita la Contraseña</label>
                <input type="password" class="form-control" id="password2" required>
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