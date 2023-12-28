<?php
// Incluir el archivo de configuración de la base de datos
include "./includes/config/database.php";
require "./includes/templates/header.php";

// Conectar a la base de datos
$conexion = conectarDb();

$errores = [];

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$email) {
        $errores[] = "El correo es obligatorio para iniciar sesion";
    }

    if (!$password) {
        $errores[] = "La contraseña es obligatorio para iniciar sesion";
    }

    // echo "<pre>";
    //     var_dump($errores);
    // echo "</pre>";

    if (empty($errores)) {
        //revisar si el usuario existe
        $query = "SELECT * FROM tbl_usuarios WHERE correo = '$email' ";
        $resultado = mysqli_query($conexion, $query);

        // var_dump($resultado);
        if ($resultado->num_rows) {
            //revisar si el passoword es correcto
            $usuario = mysqli_fetch_assoc($resultado);
            //verificar si el passwors es correcto

            $auth = password_verify($password, $usuario['contrasena']);

            if ($auth) {
                //el usuario esta autenticado
                session_start();
                $_SESSION['usuario'] = $usuario['correo'];
                $_SESSION['login'] = true;

                if ($usuario['rol'] == "2") {
                    header('Location: dash.php');
                    exit();
                } else {
                    header('Location: ./admin/index.php');
                    exit();
                }
            } else {
                $errores[] = "Contraseña incorrecta";
            }
        } else {
            $errores[] = "Usuario no encontrado";
        }
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
<main class="main-login">
    <div class="container">
        <div class="formulario-container">
            <h1>Iniciar Sesión</h1>
            <?php foreach ($errores as $error) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <form action="login.php" method="post" novalidate class="formulario">
                <fieldset>
                    <legend class="visually-hidden">LOGIN</legend>
                    <div class="mb-3">
                        <label for="correo" class="form-label">E-Mail</label>
                        <input type="text" class="form-control" name="correo" id="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn loginbtn">Iniciar Sesión</button>
                </fieldset>
            </form>
            <p class="text-center">¿No tienes una cuenta? <a href="http://localhost/integrador/registro.php">Crear cuenta</a></p>
        </div>
    </div>
</main>




<?php
require "./includes/templates/footer.php";
?>