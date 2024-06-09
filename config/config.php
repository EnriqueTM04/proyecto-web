<?php 

define("KEY_TOKEN", "ADEIDH739432");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])) {
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>