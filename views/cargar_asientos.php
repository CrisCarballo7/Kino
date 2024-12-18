<?php
include('../includes/db_connection.php');

$horario_id = $_GET['horario_id'] ?? 0;

// Consulta los asientos y su estado
$stmt = $conexion->prepare("
    SELECT a.asiento_id, a.fila, a.numero_asiento, 
           IF(ar.asiento_id IS NOT NULL, 1, a.ocupado) AS ocupado
    FROM asientos a
    LEFT JOIN asientos_reservados ar ON a.asiento_id = ar.asiento_id
    JOIN horarios h ON a.sala_id = h.sala_id
    WHERE h.horario_id = ?
    ORDER BY a.fila, a.numero_asiento
");
$stmt->bind_param("i", $horario_id);
$stmt->execute();
$result = $stmt->get_result();

$asientos = [];
while ($row = $result->fetch_assoc()) {
    $asientos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($asientos);
?>
