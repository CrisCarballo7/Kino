<?php include('../templates/header.php'); ?>
<?php include('../templates/navbar.php'); ?>
<?php include('../includes/db_connection.php'); ?>

<?php
$pelicula_id = $_POST['pelicula_id'] ?? 0;
$horario_id = $_POST['horario_id'] ?? 0;
$horario = $_POST['horario'] ?? '';
$cantidad = $_POST['cantidad'] ?? 1;
$asientos = $_POST['asientos'] ?? [];
$precio = $_POST['precio'] ?? 0;

$total = $precio * $cantidad;

$stmt = $conexion->prepare("SELECT p.titulo, s.nombre AS sala_nombre 
    FROM horarios h
    JOIN peliculas p ON h.pelicula_id=p.pelicula_id
    JOIN salas s ON h.sala_id=s.sala_id
    WHERE h.horario_id=? LIMIT 1");
$stmt->bind_param("i", $horario_id);
$stmt->execute();
$res = $stmt->get_result();
$info = $res->fetch_assoc();
?>

<div class="pago-container">
    <h2>Datos de Pago</h2>
    <p><strong>Película:</strong> <?php echo htmlspecialchars($info['titulo']); ?></p>
    <p><strong>Horario:</strong> <?php echo htmlspecialchars($horario); ?></p>
    <p><strong>Asientos:</strong> <?php echo htmlspecialchars(implode(',',$asientos)); ?></p>
    <p><strong>Cantidad:</strong> <?php echo intval($cantidad); ?></p>
    <p><strong>Sala:</strong> <?php echo htmlspecialchars($info['sala_nombre']); ?></p>
    <p><strong>Total:</strong> ₡<?php echo $total; ?></p>

    <form action="confirmacion_reserva.php" method="post">
        <input type="hidden" name="horario_id" value="<?php echo intval($horario_id); ?>">
        <input type="hidden" name="pelicula" value="<?php echo htmlspecialchars($info['titulo']); ?>">
        <input type="hidden" name="horario" value="<?php echo htmlspecialchars($horario); ?>">
        <input type="hidden" name="asientos" value="<?php echo htmlspecialchars(implode(',',$asientos)); ?>">
        <input type="hidden" name="cantidad" value="<?php echo intval($cantidad); ?>">
        <input type="hidden" name="total" value="<?php echo $total; ?>">
        <input type="hidden" name="sala" value="<?php echo htmlspecialchars($info['sala_nombre']); ?>">

        <div class="form-group">
            <label for="nombre_cliente">Nombre Completo:</label>
            <input type="text" name="nombre_cliente" required>
        </div>

        <div class="form-group">
            <label for="email_cliente">Email:</label>
            <input type="email" name="email_cliente" required>
        </div>

        <div class="form-group">
            <label for="telefono_cliente">Teléfono:</label>
            <input type="text" name="telefono_cliente" required>
        </div>

        <div class="form-group">
            <label for="tarjeta">Número de Tarjeta:</label>
            <input type="text" name="tarjeta" required>
        </div>

        <div class="form-group">
            <label for="nombre_titular">Nombre del Titular:</label>
            <input type="text" name="nombre_titular" required>
        </div>

        <button type="submit" class="btn">Confirmar Pago</button>
    </form>
</div>

<?php include('../templates/footer.php'); ?>
