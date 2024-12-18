<?php include('../templates/header.php'); ?>
<?php include('../templates/navbar.php'); ?>
<?php include('../includes/db_connection.php'); ?>

<?php
$horario_id = $_POST['horario_id'] ?? 0;
$pelicula = $_POST['pelicula'] ?? '';
$horario = $_POST['horario'] ?? '';
$asientos = $_POST['asientos'] ?? '';
$cantidad = $_POST['cantidad'] ?? 1;
$total = $_POST['total'] ?? 0;
$sala = $_POST['sala'] ?? '';

$nombre_cliente = $_POST['nombre_cliente'] ?? '';
$email_cliente = $_POST['email_cliente'] ?? '';
$telefono_cliente = $_POST['telefono_cliente'] ?? '';
$tarjeta = $_POST['tarjeta'] ?? '';
$nombre_titular = $_POST['nombre_titular'] ?? '';

// Insertar reserva
$stmt = $conexion->prepare("INSERT INTO reservas (nombre_cliente, email_cliente, telefono_cliente, horario_id, cantidad) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssii", $nombre_cliente, $email_cliente, $telefono_cliente, $horario_id, $cantidad);
$stmt->execute();
$reserva_id = $stmt->insert_id;

// Insertar pago
$stmt2 = $conexion->prepare("INSERT INTO pagos (reserva_id, monto, tarjeta, nombre_titular) VALUES (?,?,?,?)");
$stmt2->bind_param("iiss", $reserva_id, $total, $tarjeta, $nombre_titular);
$stmt2->execute();

// Asientos reservados
$asientos_array = explode(',', $asientos);
foreach($asientos_array as $as_str) {
    $fila = substr($as_str,0,1);
    $numero = substr($as_str,1);
    $as_sql = "SELECT asiento_id FROM asientos WHERE sala_id=(SELECT sala_id FROM horarios WHERE horario_id=$horario_id) AND fila='$fila' AND numero_asiento=$numero LIMIT 1";
    $as_r = $conexion->query($as_sql);
    $as_data = $as_r->fetch_assoc();
    if($as_data){
        $aid = $as_data['asiento_id'];
        $stmt3 = $conexion->prepare("INSERT INTO asientos_reservados (reserva_id, asiento_id) VALUES (?,?)");
        $stmt3->bind_param("ii", $reserva_id, $aid);
        $stmt3->execute();
    }
}
?>

<div class="confirmacion-container">
    <h2>Comprobante de Reserva</h2>
    <img src="../assets/img/kino_logo.jpg" alt="Logo Kino" style="width:100px;">
    <p><strong>Película:</strong> <?php echo htmlspecialchars($pelicula); ?></p>
    <p><strong>Asientos:</strong> <?php echo htmlspecialchars($asientos); ?></p>
    <p><strong>Cantidad:</strong> <?php echo intval($cantidad); ?></p>
    <p><strong>Total:</strong> ₡<?php echo intval($total); ?></p>
    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($nombre_cliente); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email_cliente); ?></p>
    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono_cliente); ?></p>
    <p><strong>Horario:</strong> <?php echo htmlspecialchars($horario); ?></p>
    <p><strong>Sala:</strong> <?php echo htmlspecialchars($sala); ?></p>
    <p><strong>Número de Reserva:</strong> <?php echo $reserva_id; ?></p>

    <a href="../index.php" class="btn">Volver al Inicio</a>
</div>

<?php include('../templates/footer.php'); ?>
