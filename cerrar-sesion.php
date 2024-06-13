<?php

    session_start();
    $_SESSION = [];
    var_dump($_SESSION);
    header('Location: /');

?>