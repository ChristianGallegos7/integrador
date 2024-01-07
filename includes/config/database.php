<?php

function conectarDb() {
    $host = 'localhost';
    $dbname = 'citas_medicas';
    $usuario = 'root';
    $contrasena = '';

    $db = new mysqli($host, $usuario, $contrasena, $dbname);

    if ($db->connect_error) {
        die("Error de conexión: " . $db->connect_error);
    }

    $db->set_charset("utf8");

    return $db;
}

?>
