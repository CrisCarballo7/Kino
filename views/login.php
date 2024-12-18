<?php include('../templates/header.php'); ?>
<?php include('../includes/db_connection.php'); ?>
<?php include('../templates/navbar.php'); ?>

<?php
$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE username=? AND contrasena=? LIMIT 1");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows > 0){
        $_SESSION['admin_logged'] = true;
        header('Location: gestion.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>

<div class="container">
    <h2>Login de Administrador</h2>
    <?php if($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn">Ingresar</button>
    </form>
</div>

<?php include('../templates/footer.php'); ?>
