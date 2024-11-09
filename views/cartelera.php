<?php include('../templates/header.php');
include('../includes/db_connection.php'); ?>



<div class="cartelera-container">
    <h1>Cartelera de Películas</h1>
    <div class="fila-peliculas">
        <!-- Película 1: Avatar 2 -->
        <div class="pelicula">
            <img src="../img/peliculas/avatar.jpg" alt="Avatar 2">
            <div class="info-pelicula">
                <h3>Avatar 2</h3>
                <p>TP</p>
                <button class="btn-reservar" onclick="reservarPelicula()">Reservar</button>
            </div>
        </div>
        
        <!-- Película 2: The Batman -->
        <div class="pelicula">
            <img src="../img/peliculas/batman.jpg" alt="The Batman">
            <div class="info-pelicula">
                <h3>The Batman</h3>
                <p>M16</p>
                <button class="btn-reservar" onclick="reservarPelicula()">Reservar</button>
            </div>
        </div>
    </div>
</div>

<?php include('../templates/footer.php'); ?>
<script src="../assets/js/cartelera.js"></script>
<link rel="stylesheet" href="../assets/css/style.css">
