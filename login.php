<?php

require 'includes/templates/header.php';
require 'config/database.php';
require 'classes/cliente.php';

if(isset($_SESSION['login'])) {
  header('Location: index.php');
}

$db = new Database();
$conexion = $db->conectarDB();

$errores = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = mysqli_escape_string($conexion ,trim($_POST['usuario']));
  $password = mysqli_escape_string($conexion ,trim($_POST['password']));
    
  if(!$usuario || !$password) {
    $errores[] = "Debe llenar todos los campos";
  }

  if(!$errores) {
    if(!loginAdmin($usuario, $password, $conexion)) {
      $errores[] = login($usuario, $password, $conexion);
    }
  }
}

?>

<!-- Section: Design Block -->
<section class="background-radial-gradient overflow-hidden">
  <style>
    .background-radial-gradient {
      background-color: hsl(218, 41%, 15%);
      background-image: radial-gradient(650px circle at 0% 0%,
          hsl(218, 41%, 35%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%),
        radial-gradient(1250px circle at 100% 100%,
          hsl(218, 41%, 45%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%);
    }

    #radius-shape-1 {
      height: 220px;
      width: 220px;
      top: -60px;
      left: -130px;
      background: radial-gradient(#44006b, #ad1fff);
      overflow: hidden;
    }

    #radius-shape-2 {
      border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
      bottom: -60px;
      right: -110px;
      width: 300px;
      height: 300px;
      background: radial-gradient(#44006b, #ad1fff);
      overflow: hidden;
    }

    .bg-glass {
      background-color: hsla(0, 0%, 100%, 0.9) !important;
      backdrop-filter: saturate(200%) blur(25px);
    }
  </style>

  <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center mb-5">
      <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
        <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
          LAS MEJORES OFERTAS <br />
          <span style="color: hsl(218, 81%, 75%)">siempre pensando en ti</span>
        </h1>
        <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
          ¡Descubre las mejores ofertas que jamás hayas imaginado! Entra en un mundo de ahorro y calidad con nuestras promociones exclusivas. Desde productos de tecnología de vanguardia hasta artículos para el hogar que transformarán tu espacio, tenemos todo lo que necesitas a precios irresistibles. No pierdas más tiempo buscando, ¡las mejores ofertas están aquí!
        </p>
      </div>

      <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
        <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
        <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

        <div class="card bg-glass">
          <div class="card-body px-4 py-5 px-md-5">
            <form action="login.php" method="POST" autocomplete="off">
              <h2 class="text-center text-primary">Iniciar Sesion</h2><br>

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

              <!-- Email input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="usuario" id="usuario" class="form-control" placeholder="Tu Username" name="usuario" required/>
                <label class="form-label" for="usuario">Usuario</label>
              </div>

              <!-- Password input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <input type="password" id="password" class="form-control" name="password" placeholder="Tu contraseña" required/>
                <label class="form-label" for="password">Password</label>
              </div>

              <!-- Submit button -->
              <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-primary btn-block mb-4">
                  Iniciar Sesión
                </button>
            </div>

              <div class="d-flex justify-content-center mb-4">
                <a href="#">¿Olvidaste tu contraseña?</a>
                </label>
              </div>

              <!-- Register buttons -->
              <div class="text-center">
                <p>¿Aún no tienes cuenta?</p>
                <a href="register.php" class="btn btn-info">CREAR CUENTA</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Section: Design Block -->

<?php

require 'includes/templates/footer.php';

?>