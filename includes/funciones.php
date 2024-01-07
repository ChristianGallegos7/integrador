<?php
define('TEMPLATE_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . '/templates');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function debugear ($variable) {
    echo "<pre>";
        var_dump($variable);
    echo "</pre>";
    exit;
}



?>