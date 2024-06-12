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

echo validaToken($id, $token, $conexion);



?>