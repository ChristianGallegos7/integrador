<?php
require "./includes/templates/header.php";
?>


<header class="header header__section" id="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="#">
                    <img class="logo" src="http://localhost/proyecto/build/img/logo.webp" alt="ayudae">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto animate__animated animate__fadeInLeft"> <!-- Alineado a la izquierda con animación -->
                        
                    </ul>
                    <ul class="navbar-nav mx-auto"> <!-- Alineado al centro -->
                        <!-- No hay elementos en este grupo -->
                        <li class="nav-item">
                            <a class="nav-link" href="#header">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#main">Especialidades</a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav animate__animated animate__fadeInRight"> <!-- Alineado a la derecha con animación -->
                        <li class="nav-item">
                            <a href="http://localhost/integrador/login.php" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="http://localhost/integrador/registro.php" class="nav-link">Register</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="header__info animate__animated animate__fadeIn">
            <div class="header__image">
                <img src="http://localhost/integrador/build/img/img-1.webp" alt="IMAGEN DE PACIENTE">
            </div>
            <div class="header__text">
                <h1>CITAS MEDICAS</h1>
                <p>Nuestro servicio está disponible en la ciudad de Quito.</p>
                <p class="ultimo">Para agendar una cita deber crear una cuenta!</p>
                <a href="http://localhost/integrador/registro.php" class="btn crear">Crear cuenta</a>
            </div>
        </div>
    </header>
<div class="container">
    <main class="main__section" id="main">
        <div class="container">
            <div class="especialidades__info">
                <h1 class="text-center">Especialidades</h1>

                <div class="especialidades">

                    <div class="especialidades__text">
                        <h2>Especialidades Disponibles</h2>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dicta illum voluptatem maiores totam
                            consectetur officiis repellendus. Voluptatibus harum quo impedit!</p>
                    </div>

                    <div class="especialidades__images row">
                        <div class="corazon col-md-4">
                            <h3>Corazón</h3>
                            <img src="./build/img/icon-5.webp" class="esp esp_corazon" alt="Especialidad 1">
                        </div>
                        <div class="fracturas col-md-4">
                            <h3>Fracturas</h3>
                            <img src="./build/img/icon-4.png" class="esp esp_fracturas" alt="Especialidad 2">
                        </div>
                        <div class="examenes col-md-4">
                            <h3>Examenes</h3>
                            <img src="./build/img/icon-7.png" class="esp esp_examenes" alt="Especialidad 3">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>

<?php
require "includes/templates/footer.php";
?>
