<?php

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function incluirfooter( ) {
    require __DIR__ . '/templates/footer.php';
}

?>