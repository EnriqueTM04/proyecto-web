<?php

require 'includes/templates/header.php';
require 'config/database.php';
require 'classes/cliente.php';

if($_SESSION['login']) {
    header('Location: index.php');
  }

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
            
            $id = $conexion->insert_id;
            $token = generarToken();

            require 'classes/Mailer.php';
            $mailer = new Mailer();

            // registrar Usuario
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO usuarios (usuario, password, token, id_cliente) VALUES ('$usuario', '$passwordHash', '$token', '$id')";
            $resultado = $conexion->query($query);
            $idUsuario = $conexion->insert_id;
            if($idUsuario > 0) {

                $url = SITE_URL . '/activar_cliente.php?id=' . $idUsuario . '&token=' . $token;

                $asunto = 'Activar Cuenta Zamazor';
                $cuerpo = "
                <html>
                    <head>
                        <title>Activa tu cuenta</title>
                    </head>
                    <body>
                        <h1>Bienvenido a Nuestro Sitio</h1>
                        <p>Hola $nombres, Gracias por registrarte. Por favor, haz clic en el enlace de abajo para activar tu cuenta:</p>
                        <p><a href= '$url'>Activa tu cuenta</a></p>
                        <p>Si el enlace no funciona, copia y pega la siguiente URL en tu navegador:</p>
                        <p>'$url'</p>
                        <br>
                        <p>Saludos,<br>El equipo de Nuestro Sitio</p>
                    </body>
                </html>
                ";
                
                if($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    echo "Para terminar el proceso sigue las instrucciones enviadas a tu correo $email";
                    exit;
                }
            }
            else {
                $errores[] = "Error al registrar usuario";
            }
        } else {
            $errores[] = "Error al registrar cliente";
        }

        if(empty($errores)) {
            // /REDIRIGIR POSTERIORMENTE AL USUARIO
        }
    }
    
}


?>

<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registrarse</h3>
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
            <form class="row g-3" action="register.php" method="POST" id="formulario_registro" autocomplete="off">
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
                <span id="validaEmail" class="text-warning"></span>
            </div>
            <div class="col-md-3">
                <label for="tel" class="form-label">Teléfono</label>
                <input type="tel" class="form-control" id="tel" name="tel" placeholder="Tel principal" required>
            </div>
            <div class="col-md-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usename" required>
                <span id="validaUsuario" class="text-warning"></span>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php

require 'includes/templates/footer.php';

?>