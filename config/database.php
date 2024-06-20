<?php

class Database {
    private $host = "localhost";
    private $database = "tienda_web";
    private $username = "root";
    private $password = "";

    function conectarDB() {

        try {
            $db = new mysqli($this->host, $this->username, $this->password, $this->database);

            return $db;
        } catch (mysqli_sql_exception $e) {
            echo "Error en la consulta MySQL: " . $e->getMessage();
            exit;
        }
        
    }

}

?>