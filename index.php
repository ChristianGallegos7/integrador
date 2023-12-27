<?php
require "./includes/templates/header.php";
?>

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