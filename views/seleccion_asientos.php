<?php include('../templates/header.php'); ?>
<?php include('../templates/sidebar.php');
include('../includes/db_connection.php'); ?>

<div class="main-content">
    <div class="asientos-container">
        <h2>Reserva de Asientos</h2>
        
        <div class="leyenda">
            <div class="item-leyenda">
                <div class="asiento reservado"></div>
                <p>Reservado</p>
            </div>
            <div class="item-leyenda">
                <div class="asiento"></div>
                <p>Disponible</p>
            </div>
            <div class="item-leyenda">
                <div class="asiento seleccionado"></div>
                <p>Seleccionado</p>
            </div>
        </div>

        <div class="sala">
            <div class="fila-letra">A</div>
            <div class="asiento" data-fila="A" data-numero="1">A1</div>
            <div class="asiento ocupado" data-fila="A" data-numero="2">A2</div>
            <div class="asiento" data-fila="A" data-numero="3">A3</div>
            <div class="asiento" data-fila="A" data-numero="4">A4</div>

            <div class="fila-letra">B</div>
            <div class="asiento" data-fila="B" data-numero="1">B1</div>
            <div class="asiento" data-fila="B" data-numero="2">B2</div>
            <div class="asiento ocupado" data-fila="B" data-numero="3">B3</div>
            <div class="asiento" data-fila="B" data-numero="4">B4</div>

            <div class="fila-letra">C</div>
            <div class="asiento" data-fila="C" data-numero="1">C1</div>
            <div class="asiento" data-fila="C" data-numero="2">C2</div>
            <div class="asiento" data-fila="C" data-numero="3">C3</div>
            <div class="asiento" data-fila="C" data-numero="4">C4</div>

            <div class="fila-letra">D</div>
            <div class="asiento" data-fila="D" data-numero="1">D1</div>
            <div class="asiento ocupado" data-fila="D" data-numero="2">D2</div>
            <div class="asiento" data-fila="D" data-numero="3">D3</div>
            <div class="asiento" data-fila="D" data-numero="4">D4</div>
        </div>
        
        <button id="continuar">Continuar</button>
    </div>
</div>

<?php include('../templates/footer.php'); ?>
<script src="../assets/js/seleccion_asientos.js"></script>
<link rel="stylesheet" href="../assets/css/style.css">
