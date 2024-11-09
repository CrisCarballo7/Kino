<?php include('../templates/header.php');
include('../includes/db_connection.php'); ?>

<div class="login-container">
    <h2>Login de Administrador</h2>
    <form id="loginForm">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Ingresar</button>
    </form>
</div>

<?php include('../templates/footer.php'); ?>
<script src="../assets/js/login.js"></script>
<link rel="stylesheet" href="../assets/css/style.css">
