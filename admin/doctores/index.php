<?php

session_start();

$auth = $_SESSION['login'];

if (!$auth) {
    header("Location: ../index.php");
}
// include "../templates/header.php";
include "../../includes/config/database.php";

$conexion = conectarDb();
//Escribir el query
$query = "SELECT * FROM tbl_doctores";
//consultar la bd para mostrar los doctores en la tabla abajo, se hace el fetch assoc 
$resultadoConsulta = mysqli_query($conexion, $query);

$queryEspecialidad = "SE";


//muestra mensaje condicional si se crea el doctor
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        //obtener la imagen
        $queryObtenerImagen = "SELECT foto FROM tbl_doctores WHERE id = '$id'";

        $resultadoImagen = mysqli_query($conexion, $queryObtenerImagen);

        $datosImagenes = mysqli_fetch_assoc($resultadoImagen);

        //eliminar la imagen del servidor 

        $carpetaImagenes = "../../imagenes/";
        $rutaImagen = $carpetaImagenes . $datosImagenes['foto'];

        unlink($rutaImagen);


        //elimar el doctor
        $queryEliminar = "DELETE FROM tbl_doctores where id = '$id'";
        $resultado = mysqli_query($conexion, $queryEliminar);

        if ($resultado) {
            header('Location: index.php?resultado=3');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700;900&display=swap" rel="stylesheet">
    <style>
        a {
            color: black;
        }
    </style>
</head>

<body class="container mt-5">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Logo</a>
            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/integrador/admin/doctores/index.php">Doctores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section2">Sección 2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section3">Sección 3</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php if ($resultado == 1) : ?>
        <div class="alert alert-success" role="alert">
            Doctor Creado Correctamente
        </div>
    <?php elseif ($resultado == 2) : ?>
        <div class="alert alert-success" role="alert">
            Doctor Actualizado Correctamente
        </div>
    <?php elseif ($resultado == 3) : ?>
        <div class="alert alert-success" role="alert">
            Doctor Eliminado Correctamente
        </div>
    <?php endif; ?>

    <h1>Listado de Doctores</h1>
    <a href="http://localhost/proyecto/admin/doctores/crear.php" class="btn btn-primary">Crear doctor</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Especialidad</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Foto</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($doctor = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                <tr>
                    <td><?php echo $doctor['id']; ?></td>
                    <td><?php echo $doctor['nombre']; ?></td>
                    <td><?php echo $doctor['apellido']; ?></td>
                    <td><?php echo $doctor['especialidad']; ?></td>
                    <td><?php echo $doctor['hora_entrada']; ?></td>
                    <td><?php echo $doctor['hora_salida']; ?></td>
                    <td><img width="75px" src="../../imagenes/<?php echo $doctor['foto']; ?>" alt="IMAGEN DEL DOCTOR"></td>
                    <td><?php echo $doctor['telefono']; ?></td>

                    <td>
                        <a href="./actualizar.php?id=<?php echo $doctor['id']; ?>" class="btn btn-warning">Editar</a>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $doctor['id'] ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>