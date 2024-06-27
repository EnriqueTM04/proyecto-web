<?php

require 'includes/templates/header.php';
require 'config/database.php';
require 'classes/cliente.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id === '' || $token==='') {
    header('Location: /index.php');
    exit;
}

$db = new Database();
$conexion = $db->conectarDB();

$mensaje = validaToken($id, $token, $conexion);

?>

<br><br><br><br>

<main>
    <div class="alert alert-success container" role="alert">
    <?php echo $mensaje ?> -- <a href="login.php">Inicia sesion</a>
    </div>
</main>

<?php

require 'includes/templates/footer.php';

?>