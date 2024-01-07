<?php
//base de datos
require "./includes/app.php";


$conexion = conectarDb();

//arreglo de errores
$errores = [];

$nombre = '';
$apellido = '';
$cedula = '';
$telefono = '';
$correo = '';
$contrasena = '';


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    if (!$nombre) {
        $errores[] = "El nombre es obligatorio";
    }
    if (!$apellido) {
        $errores[] = "El apellido es obligatorio";
    }
    if (!$cedula) {
        $errores[] = "La cedula es obligatorio";
    }
    if (!$telefono) {
        $errores[] = "El telefono es obligatorio";
    }
    if (!$correo) {
        $errores[] = "El correo es obligatorio";
    }
    if (!$contrasena) {
        $errores[] = "La contraseña es obligatorio";
    }

    //hash a la contraseña
    $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

    if (empty($errores)) {
        //query para insertar en la base
        $query = "INSERT INTO tbl_usuarios(nombre,apellido,cedula,telefono,correo,contrasena,rol) VALUES('$nombre','$apellido','$cedula','$telefono','$correo','$contrasenaHash', $rol)";

        $resultado = mysqli_query($conexion, $query);


        if ($resultado) {
            header("Location: ./index.php?registro=1");
        } else {
            echo "no se inserto";
        }
    }
}
//cerrar la conexion
mysqli_close($conexion);
require "./includes/templates/header.php";
?>

<main class="main-registro">
    <div class="container">
        <div class="formulario-container">
            <h1>Registrarse</h1>

            <?php foreach ($errores as $error) : ?>
                <div class="alert alert-danger alert-dismissible fade show"  role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                </div>
            <?php endforeach; ?>

            <form action="registro.php" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                    <div class="invalid-feedback">Por favor, ingresa tu nombre.</div>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
                    <div class="invalid-feedback">Por favor, ingresa tu apellido.</div>
                </div>

                <div class="mb-3">
                    <label for="cedula" class="form-label">Cédula:</label>
                    <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo $cedula; ?>" required>
                    <div class="invalid-feedback">Por favor, ingresa tu cédula.</div>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required>
                    <div class="invalid-feedback">Por favor, ingresa tu número de teléfono.</div>
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo:</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo; ?>" required>
                    <div class="invalid-feedback">Por favor, ingresa un correo válido.</div>
                </div>

                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" value="<?php echo $contrasena; ?>" required>
                    <div class="invalid-feedback">Por favor, ingresa una contraseña.</div>
                </div>

                <input type="hidden" name="rol" value="2">

                <button type="submit" class="btn registrobtn">Registrarse</button>
            </form>
            <p class="login-p text-center">Ya tienes una cuenta? <a href="http://localhost/integrador/login.php">Iniciar Sésion</a></p>

        </div>
    </div>
</main>

<?php
require "./includes/templates/footer.php";
?>
