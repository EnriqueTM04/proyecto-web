<?php

// CREAR  IDENTIFICADOR
function generarToken() : string {
    return md5(uniqid(mt_rand(), false));
}

?>