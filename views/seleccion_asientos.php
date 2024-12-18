<?php include('../templates/header.php'); ?>
<?php include('../templates/navbar.php'); ?>
<?php include('../includes/db_connection.php'); ?>

<?php
$pelicula_id = $_GET['pelicula_id'] ?? 0;
$horario = $_GET['horario'] ?? '';
$cantidad = $_GET['cantidad'] ?? 1;
$precio = $_GET['precio'] ?? 0;

// Obtener información de la película, sala y horario
$stmt = $conexion->prepare("
    SELECT p.titulo, h.horario_id, s.sala_id, s.nombre AS sala_nombre
    FROM peliculas p
    JOIN horarios h ON p.pelicula_id=h.pelicula_id
    JOIN salas s ON h.sala_id=s.sala_id
    WHERE p.pelicula_id=? AND h.fecha_hora=? LIMIT 1
");
$stmt->bind_param("is", $pelicula_id, $horario);
$stmt->execute();
$result = $stmt->get_result();
$info = $result->fetch_assoc();

if (!$info) {
    echo "<div class='container'><h2>Error: Horario no encontrado</h2></div>";
    include('../templates/footer.php');
    exit;
}

$sala_id = $info['sala_id'];
$horario_id = $info['horario_id'];

// Obtener asientos de la sala
$asientos_sql = "
    SELECT a.asiento_id, a.fila, a.numero_asiento,
           IF(ar.asiento_id IS NOT NULL, 1, a.ocupado) AS ocupado_final
    FROM asientos a
    LEFT JOIN (
        SELECT asiento_id FROM asientos_reservados
        JOIN reservas r ON r.reserva_id = asientos_reservados.reserva_id
        WHERE r.horario_id = ?
    ) ar ON a.asiento_id = ar.asiento_id
    WHERE a.sala_id = ?
    ORDER BY a.fila, a.numero_asiento
";
$stmt_asientos = $conexion->prepare($asientos_sql);
$stmt_asientos->bind_param("ii", $horario_id, $sala_id);
$stmt_asientos->execute();
$asientos_res = $stmt_asientos->get_result();

$asientos_data = [];
while ($a = $asientos_res->fetch_assoc()) {
    $asientos_data[$a['fila']][$a['numero_asiento']] = [
        'id' => $a['asiento_id'],
        'ocupado' => $a['ocupado_final']
    ];
}
?>

<div class="asientos-container">
    <h2>Reserva de Asientos</h2>
    <p><strong>Película:</strong> <?php echo htmlspecialchars($info['titulo']); ?></p>
    <p><strong>Horario:</strong> <?php echo htmlspecialchars($horario); ?></p>
    <p><strong>Cantidad:</strong> <?php echo intval($cantidad); ?></p>
    <p><strong>Sala:</strong> <?php echo htmlspecialchars($info['sala_nombre']); ?></p>

    <div class="leyenda">
        <div class="item-leyenda"><span class="asiento-label ocupado">X</span> Ocupado</div>
        <div class="item-leyenda"><span class="asiento-label disponible">A</span> Disponible</div>
        <div class="item-leyenda"><span class="asiento-label seleccionado">S</span> Seleccionado</div>
    </div>

    <form action="pago.php" method="post">
        <input type="hidden" name="pelicula_id" value="<?php echo intval($pelicula_id); ?>">
        <input type="hidden" name="horario_id" value="<?php echo intval($horario_id); ?>">
        <input type="hidden" name="horario" value="<?php echo htmlspecialchars($horario); ?>">
        <input type="hidden" name="cantidad" value="<?php echo intval($cantidad); ?>">
        <input type="hidden" name="precio" value="<?php echo intval($precio); ?>">

        <div class="sala">
            <?php foreach ($asientos_data as $fila => $asientos): ?>
                <div class="fila-letra"><?php echo $fila; ?></div>
                <?php foreach ($asientos as $numero_asiento => $asiento): ?>
                    <?php if ($asiento['ocupado'] == 1): ?>
                        <div><input type="checkbox" disabled> <?php echo $fila . $numero_asiento; ?></div>
                    <?php else: ?>
                        <div>
                            <label>
                                <input type="checkbox" name="asientos[]" value="<?php echo $asiento['id']; ?>">
                                <?php echo $fila . $numero_asiento; ?>
                            </label>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn" style="margin-top:20px;">Continuar al Pago</button>
    </form>
</div>

<?php include('../templates/footer.php'); ?>
