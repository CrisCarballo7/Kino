<?php
include('../templates/header.php');
include('../templates/navbar.php');
include('../includes/db_connection.php');

$pelicula_id = $_GET['pelicula_id'] ?? 0;
$horario_id = $_GET['horario_id'] ?? 0;

// Verificar si se seleccionó un horario
if ($horario_id == 0) {
    // Mostrar horarios disponibles
    $stmt_horarios = $conexion->prepare("
        SELECT h.horario_id, h.fecha_hora, s.nombre AS sala_nombre
        FROM horarios h
        JOIN salas s ON h.sala_id = s.sala_id
        WHERE h.pelicula_id = ?
        ORDER BY h.fecha_hora ASC
    ");
    $stmt_horarios->bind_param("i", $pelicula_id);
    $stmt_horarios->execute();
    $result_horarios = $stmt_horarios->get_result();
    ?>

    <div class="container">
        <h2>Selecciona Horario</h2>
        <div class="horarios">
            <?php while ($h = $result_horarios->fetch_assoc()): ?>
                <a href="?pelicula_id=<?php echo $pelicula_id; ?>&horario_id=<?php echo $h['horario_id']; ?>">
                    <button><?php echo date("h:i A", strtotime($h['fecha_hora'])) . " - Sala: " . $h['sala_nombre']; ?></button>
                </a>
            <?php endwhile; ?>
        </div>
    </div>

    <?php
    include('../templates/footer.php');
    exit;
}

// Obtener la información de asientos para el horario seleccionado
$stmt_asientos = $conexion->prepare("
    SELECT a.asiento_id, a.fila, a.numero_asiento,
           IF(ar.asiento_id IS NOT NULL, 1, a.ocupado) AS ocupado
    FROM asientos a
    LEFT JOIN asientos_reservados ar ON a.asiento_id = ar.asiento_id
    JOIN horarios h ON a.sala_id = h.sala_id
    WHERE h.horario_id = ?
    ORDER BY a.fila, a.numero_asiento
");
$stmt_asientos->bind_param("i", $horario_id);
$stmt_asientos->execute();
$result_asientos = $stmt_asientos->get_result();

$asientos = [];
while ($row = $result_asientos->fetch_assoc()) {
    $asientos[$row['fila']][$row['numero_asiento']] = $row['ocupado'];
}
?>

<div class="container">
    <h2>Selecciona tus Asientos</h2>
    <form action="pago.php" method="post">
        <input type="hidden" name="horario_id" value="<?php echo $horario_id; ?>">

        <div class="leyenda">
            <span style="color: grey;">&#9632; Ocupado</span>
            <span style="color: lightgrey;">&#9632; Disponible</span>
            <span style="color: red;">&#9632; Seleccionado</span>
        </div>

        <div class="sala">
            <?php foreach ($asientos as $fila => $numeros): ?>
                <div class="fila">
                    <?php foreach ($numeros as $numero => $ocupado): ?>
                        <?php if ($ocupado): ?>
                            <div class="asiento ocupado"><?php echo $fila . $numero; ?></div>
                        <?php else: ?>
                            <label class="asiento disponible">
                                <input type="checkbox" name="asientos[]" value="<?php echo $fila . $numero; ?>">
                                <?php echo $fila . $numero; ?>
                            </label>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="btn">Continuar al Pago</button>
    </form>
</div>

<?php include('../templates/footer.php'); ?>
