<header class="navbar">
    <div class="nav-left">
        <img src="../assets/img/kino_logo.jpg" alt="Logo Kino" class="logo-cine">
        <h1>Cine KINO</h1>
    </div>
    <nav class="nav-right">
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="cartelera.php">Cartelera</a></li>
            <?php if(!isset($_SESSION['admin_logged'])): ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
            <?php else: ?>
                <li><a href="gestion.php">Gestión</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
