<?php
session_start();

$auth = $_SESSION['login'];

if(!$auth){
    header("Location: ../index.php");
}
//base de datos
include "../../includes/config/database.php";

//obtener el id que mandamos desde el index para actualizar
$id = $_GET['id'] ?? null;
//verificar si es un int y que no nos pasen un string o algo raro
$id = filter_var($id, FILTER_VALIDATE_INT);

// si es un string o otra cosa que no redirija al index
if (!$id) {
    header('Location: index.php');
    exit;
}

require "../../includes/templates/header.php";
$conexion = conectarDb();

//obtener los datos del doctor
$consultaDoctor = "SELECT * FROM tbl_doctores WHERE id = " . $id;
$resultadoDoctor = mysqli_query($conexion, $consultaDoctor);
$datosDoctor = mysqli_fetch_assoc($resultadoDoctor);

// echo "<pre>";
//     var_dump($datosDoctor);
// echo "</pre>";


//seleccionar la especialidad 
$query = "SELECT * FROM tbl_especialidades";
$resultado = mysqli_query($conexion, $query);

//arreglo de errores
$errores = [];

$nombre = $datosDoctor['nombre'];
$apellido = $datosDoctor['apellido'];
$especialidad = $datosDoctor['especialidad'];
$hora_entrada = $datosDoctor['hora_entrada'];
$hora_salida = $datosDoctor['hora_salida'];

$foto = $datosDoctor['foto'];
$telefono = $datosDoctor['telefono'];



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad = $_POST['especialidad'];
    $hora_entrada = $_POST['hora_entrada'];
    $hora_salida = $_POST['hora_salida'];
    $telefono = $_POST['telefono'];
    //imagen 
    $foto = $_FILES['foto'];

    if (!$nombre) {
        $errores[] = "El nombre es requerido";
    }

    if (!$apellido) {
        $errores[] = "El apellido es requerido";
    }

    if (!$especialidad) {
        $errores[] = "la especialidad es requerido";
    }
    if (!$hora_entrada) {
        $errores[] = "El horario es requerido";
    }

    if (!$hora_salida) {
        $errores[] = "El horario es requerido";
    }


    if (empty($errores)) {

        // //SUBIR ARCHIVOS
        // //CREEAAMOS LAA CARPETAA

        $carpetaImagenes = "../../imagenes/";
        // SI LA CARPETA NO EXISTE LA CREA
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';
        //si actualizamos la imagen tenemos que eliminarla de la carpeta para que no se llene el servidor

        if ($foto['name']) {
            // ELIMINAR LA IMAGEN PREVIA
            unlink($carpetaImagenes . $datosDoctor['foto']);

            // GENERAR UN NOMBRE ÚNICO PARA LA NUEVA IMAGEN
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // SUBIR LA NUEVA IMAGEN
            move_uploaded_file($foto['tmp_name'], $carpetaImagenes . $nombreImagen);
        } else {
            // SI NO SE SUBE UNA NUEVA IMAGEN, MANTENER LA IMAGEN ACTUAL
            $nombreImagen = $datosDoctor['foto'];
        }



        //query para insertarwd
        $doctor = "UPDATE tbl_doctores SET 
            nombre = '$nombre',
            apellido = '$apellido', 
            especialidad = '$especialidad',
            hora_entrada = '$hora_entrada',
            hora_salida = '$hora_salida',
            foto = '$nombreImagen',
            telefono = '$telefono'
            WHERE id = $id ";

        //insertar en la base
        $result = mysqli_query($conexion, $doctor);

        if ($result) {
            //redireccionar si se inserto correctamente el doctor en la base de datos
            //mandamos el parametro resultado para crear la alerta desde el index
            header('Location: index.php?resultado=2');
        }
    }
}
mysqli_close($conexion);

?>
<main class="crear-doctor">
    <h1 class="m-0 text-center">Actualizar Doctor</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alert alert-danger alert-dismissible fade show mx-auto w-25 mt-3" role="alert">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endforeach; ?>
    <a href="http://localhost/integrador/admin/doctores/index.php" class="btn btn-warning mx-5">Volver</a>

    <form method="POST" enctype="multipart/form-data" class="formulario">
        <fieldset>
            <legend>Información General</legend>

            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
            </div> 
            <div>
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" name="apellido" id="apellido" value="<?php echo $apellido; ?>">
            </div>
            <div>
                <label for="especialidad">Especialidad:</label>
                <select class="form-control" name="especialidad" id="especialidad">
                    <option value="">Seleccione una especialdiad por Doctor</option>
                    <?php while ($row = mysqli_fetch_assoc($resultado)) : ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo $especialidad === $row['id'] ? 'selected' : '' ?>>
                            <?php echo $row['nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label for="hora_entrada">Hora de Entrada:</label>
                <input type="time" class="form-control" name="hora_entrada" id="hora_entrada" value="<?php echo $hora_entrada; ?>">
            </div>
            <div>
                <label for="hora_salida">Hora de Salida:</label>
                <input type="time" class="form-control" name="hora_salida" id="hora_salida" value="<?php echo $hora_salida; ?>">
            </div>
            <div>
                <label for="telefono">Telefono</label>
                <input type="tel" class="form-control" name="telefono" id="telefono" value="<?php echo $telefono; ?>">
            </div>
            <div>
                <label for="foto">Foto:</label>
                <input type="file" class="form-control" name="foto" id="foto" accept=".jpg">
                <img width="150px" src="http://localhost/integrador/imagenes/<?php echo $foto; ?>" alt="IMAGEN">
            </div>
            

            <button type="submit" class="btn btn-verde">Actualizar Doctor</button>

        </fieldset>
    </form>
</main>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<script src="http://localhost/integrador/build/js/app.js"></script>
</body>

</html>