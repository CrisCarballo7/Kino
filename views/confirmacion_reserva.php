<?php include('../templates/header.php');
include('../includes/db_connection.php'); ?>

<div class="confirmacion-container">
    <h2>Resumen de tu Reserva</h2>
    <div class="detalles-reserva">
        <p><strong>Película:</strong> <span id="titulo-pelicula">The Batman</span></p>
        <p><strong>Asientos Seleccionados:</strong> <span id="asientos-seleccionados">A1, A3, B2</span></p>
        <p><strong>Precio por Asiento:</strong> ₡3500</p>
        <p><strong>Total:</strong> ₡<span id="total-reserva">10500</span></p>
    </div>
    <button id="confirmar-compra">Confirmar Compra</button>
</div>

<?php include('../templates/footer.php'); ?>
<script src="../assets/js/confirmacion.js"></script>
<link rel="stylesheet" href="../assets/css/style.css">
