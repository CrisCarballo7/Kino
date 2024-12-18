<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cine KINO - Inicio</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<header class="navbar">
    <div class="nav-left">
        <img src="assets/img/kino_logo.jpg" alt="Logo Kino" class="logo-cine">
        <h1>Cine KINO</h1>
    </div>
    <nav class="nav-right">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="views/cartelera.php">Cartelera</a></li>
            <?php if(!isset($_SESSION['admin_logged'])): ?>
                <li><a href="views/login.php">Iniciar Sesión</a></li>
            <?php else: ?>
                <li><a href="views/gestion.php">Gestión</a></li>
                <li><a href="views/logout.php">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div class="container" style="text-align: center;">
    <img src="assets/img/kino_logo.jpg" alt="Cine Kino Logo" style="width:150px;margin-top:50px;">
    <h2>Bienvenido a Cine KINO</h2>
    <p>Disfruta de las mejores películas con la mejor calidad y comodidad.</p>
    <a href="views/cartelera.php" class="btn">Ver Cartelera</a>
    <a href="views/login.php" class="btn">Iniciar Sesión (Admin)</a>
</div>

<footer class="footer">
    <p>Cine Kino © 2024. Todos los derechos reservados</p>
</footer>
</body>
</html>
