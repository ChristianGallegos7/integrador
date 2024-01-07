<?php
    require "funciones.php";
    require "config/database.php";
    require __DIR__ . '/../vendor/autoload.php';

    //conectarnos a la base

    $db = conectarDb();

    use App\Doctor;

    Doctor::setDB($db);

    
