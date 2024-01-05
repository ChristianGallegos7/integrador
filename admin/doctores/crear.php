<?php
session_start();

$auth = $_SESSION['login'];

if(!$auth){
    header("Location: ../index.php");
}

require "../../includes/config/database.php";

$conexion = conectarDb();

$query = "SELECT * FROM tbl_especialidades";
$resultado = mysqli_query($conexion, $query);

$errores = [];

$nombre = '';
$apellido = '';
$especialidad = '';
$hora_entrada = '';
$hora_salida = '';
$foto = '';
$telefono = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad = $_POST['especialidad'];
    $hora_entrada = $_POST['hora_entrada'];
    $hora_salida = $_POST['hora_salida'];
    $foto = $_FILES['foto'];
    $telefono = $_POST['telefono'];

    // Validaciones...
    if (!$nombre) {
        $errores[] = "El nombre es requerido";
    }

    if (!$apellido) {
        $errores[] = "El apellido es requerido";
    }

    if (!$especialidad) {
        $errores[] = "La especialidad es requerido";
    }
    if (!$hora_entrada) {
        $errores[] = "La hora de entrada es requerido";
    }

    if (!$hora_salida) {
        $errores[] = "La hora de salida es requerido";
    }

    if (!$foto['name']) {
        $errores[] = "La foto es requerida";
    }

    if (!$telefono) {
        $errores[] = "El telefono es requerida";
    }


    if (empty($errores)) {
        $carpetaImagenes = "../../imagenes/";

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
        move_uploaded_file($foto['tmp_name'], $carpetaImagenes . $nombreImagen);

        $doctor = "INSERT INTO tbl_doctores(nombre,apellido,especialidad,hora_entrada,hora_salida,foto,telefono) 
                   VALUES('$nombre','$apellido','$especialidad','$hora_entrada','$hora_salida', '$nombreImagen','$telefono')";

        $result = mysqli_query($conexion, $doctor);

        if ($result) {
            header('Location: index.php?resultado=1');
        }
    }
}

mysqli_close($conexion);

require "../../includes/templates/header.php";


?>

<main>
    <h1>Crear Doctor</h1>

    <?php foreach ($errores as $error) : ?>
        <div>
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <a href="http://localhost/proyecto/admin/doctores/index.php" class="crearVolver">Volver</a>
    

    <form action="" method="POST" enctype="multipart/form-data" class="formulario">
        <fieldset>
            <legend>Información General</legend>

            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
            </div>
            <div>
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" id="apellido" value="<?php echo $apellido; ?>">
            </div>
            <div>
                <label for="especialidad">Especialidad:</label>
                <select name="especialidad" id="especialidad">
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
                <input type="time" name="hora_entrada" id="hora_entrada" value="<?php echo $hora_entrada; ?>">
            </div>
            <div>
                <label for="hora_salida">Hora de Salida:</label>
                <input type="time" name="hora_salida" id="hora_salida" value="<?php echo $hora_salida; ?>">
            </div>


            <div>
                <label for="foto">Foto:</label>
                <input type="file" name="foto" id="foto" accept=".jpg, .png" value="<?php echo $foto; ?>">
            </div>

           
            <div>
                <label for="telefono">Telefono</label>
                <input type="tel" name="telefono" id="telefono"  value="<?php echo $telefono; ?>">
            </div>

            <button type="submit" class="btn-verde">Agregar Doctor</button>
        </fieldset>
    </form>
</main>
</body>

</html>