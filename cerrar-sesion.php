<?php

    session_start();
    $_SESSION = [];
    session_destroy();
    var_dump($_SESSION);
    header('Location: index.php');
    exit;

?>