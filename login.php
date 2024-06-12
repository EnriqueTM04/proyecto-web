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
    
}

?>

<<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp"
                    style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">We are The Lotus Team</h4>
                </div>

                <form>
                  <p>Please login to your account</p>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="form2Example11" class="form-control"
                      placeholder="Phone number or email address" />
                    <label class="form-label" for="form2Example11">Username</label>
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="form2Example22" class="form-control" />
                    <label class="form-label" for="form2Example22">Password</label>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="button">Log
                      in</button>
                    <a class="text-muted" href="#!">Forgot password?</a>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Don't have an account?</p>
                    <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Create new</button>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">We are more than just a company</h4>
                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                  exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php

require 'includes/templates/footer.php';

?>