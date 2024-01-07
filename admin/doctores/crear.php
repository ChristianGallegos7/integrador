<?php
session_start();

require "../../includes/app.php";

use App\Doctor;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;


$auth = $_SESSION['login'];

if (!$auth) {
    header("Location: ../index.php");
}

$conexion = conectarDb();

$query = "SELECT * FROM tbl_especialidades";
$resultado = mysqli_query($conexion, $query);

$errores = Doctor::getErrores();

$nombre = '';
$apellido = '';
$especialidad = '';
$hora_entrada = '';
$hora_salida = '';
$foto = '';
$telefono = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //crea una nueva instancia
    $doctor = new Doctor($_POST);

    //generar un nombre unico para cada imgen
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    $manager = new Image(new Driver());
    //realiza un re size a la imagen con intervention
    //setear la imagen
    if ($_FILES['foto']['tmp_name']) {
        $image = $manager->read($_FILES['foto']['tmp_name'])->scale(800, 600);
        $doctor->setFoto($nombreImagen);
    }

    $errores = $doctor->validar();

    if (empty($errores)) {

        $doctor->guardar();
        //crear la carpeta para las imagenes
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }
        //guarda la imagen en el servidor
        $image->toPng()->save(CARPETA_IMAGENES . $nombreImagen);

        //guarda en la bd

        $resultado = $doctor->guardar();
        if ($resultado) {
            header('Location: index.php?resultado=1');
        }
    }
}

mysqli_close($conexion);

require "../../includes/templates/header.php";


?>

<main class="crear-doctor">
    <h1 class="text-center m-0 p-5">Crear Doctor</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alert alert-danger alert-dismissible fade show mx-auto w-25 mt-1" role="alert">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endforeach; ?>

    <a href="http://localhost/integrador/admin/doctores/index.php" class="btn btn-success mx-5">Volver</a>


    <form action="" method="POST" enctype="multipart/form-data" class="formulario">
        <fieldset class="formulario-container2">
            <legend>Datos del Doctor</legend>

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
                <label for="foto">Foto:</label>
                <input type="file" class="form-control" name="foto" id="foto" accept=".jpg, .png" value="<?php echo $foto; ?>">
            </div>


            <div>
                <label for="telefono">Telefono</label>
                <input type="tel" class="form-control" name="telefono" id="telefono" value="<?php echo $telefono; ?>">
            </div>

            <button type="submit" class="btn btn-verde">Agregar Doctor</button>
        </fieldset>
    </form>
</main>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<script src="http://localhost/integrador/build/js/app.js"></script>
</body>

</html>