<?php include('../templates/header.php'); ?>
<?php include('../templates/navbar.php'); ?>
<?php include('../includes/db_connection.php'); ?>

<?php
$pelicula_id = $_GET['pelicula_id'] ?? 0;

// Obtener horarios disponibles para la película
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
    <h2>Selecciona Horario y Asientos</h2>
    
    <!-- Selección de horarios -->
    <div id="horarios" style="margin-bottom: 20px;">
        <h3>Horarios Disponibles</h3>
        <?php while ($h = $result_horarios->fetch_assoc()): ?>
            <button class="btn-horario" data-horario="<?php echo $h['horario_id']; ?>">
                <?php echo date("h:i A", strtotime($h['fecha_hora'])) . " - Sala: " . $h['sala_nombre']; ?>
            </button>
        <?php endwhile; ?>
    </div>

    <!-- Selección de asientos -->
    <div id="asientos-container" style="display:none;">
        <h3>Selecciona tus Asientos</h3>
        <div class="leyenda">
            <span style="color: grey;">&#9632; Ocupado</span>
            <span style="color: lightgrey;">&#9632; Disponible</span>
            <span style="color: red;">&#9632; Seleccionado</span>
        </div>
        <div class="sala" id="asientos-grid">
            <!-- Los asientos se cargarán dinámicamente desde la base de datos -->
        </div>
        <button id="continuar" class="btn">Continuar al Pago</button>
    </div>
</div>

<!-- CSS -->
<style>
    .btn-horario {
        background-color: #d32f2f;
        color: white;
        border: none;
        padding: 10px 15px;
        margin: 5px;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn-horario.selected {
        background-color: #b71c1c;
    }

    .sala {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        justify-items: center;
        margin-top: 20px;
    }

    .asiento {
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
        border-radius: 5px;
        background-color: lightgrey;
        color: black;
        cursor: pointer;
    }

    .asiento.ocupado {
        background-color: grey;
        cursor: not-allowed;
    }

    .asiento.seleccionado {
        background-color: red;
        color: white;
    }
</style>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const horariosButtons = document.querySelectorAll('.btn-horario');
    const asientosContainer = document.getElementById('asientos-container');
    const asientosGrid = document.getElementById('asientos-grid');
    let horarioSeleccionado = null;

    // Selección de horario
    horariosButtons.forEach(button => {
        button.addEventListener('click', function() {
            horariosButtons.forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');
            horarioSeleccionado = this.getAttribute('data-horario');
            cargarAsientos(horarioSeleccionado);
        });
    });

    // Función para cargar asientos desde la base de datos
    function cargarAsientos(horario_id) {
        fetch(`cargar_asientos.php?horario_id=${horario_id}`)
        .then(response => response.json())
        .then(data => {
            asientosContainer.style.display = 'block';
            asientosGrid.innerHTML = ''; // Limpia el grid anterior
            
            data.forEach(asiento => {
                const div = document.createElement('div');
                div.classList.add('asiento');
                div.textContent = `${asiento.fila}${asiento.numero_asiento}`;
                div.dataset.asiento = asiento.asiento_id;

                if (asiento.ocupado == 1) {
                    div.classList.add('ocupado');
                } else {
                    div.addEventListener('click', () => {
                        if (!div.classList.contains('ocupado')) {
                            div.classList.toggle('seleccionado');
                        }
                    });
                }
                asientosGrid.appendChild(div);
            });
        });
    }

    // Botón continuar
    document.getElementById('continuar').addEventListener('click', function() {
        const seleccionados = document.querySelectorAll('.asiento.seleccionado');
        const asientosSeleccionados = Array.from(seleccionados).map(a => a.dataset.asiento);

        if (asientosSeleccionados.length > 0) {
            alert("Asientos seleccionados: " + asientosSeleccionados.join(', '));
            // Redirigir a pago.php con datos
            window.location.href = `pago.php?asientos=${asientosSeleccionados.join(',')}&horario_id=${horarioSeleccionado}`;
        } else {
            alert("Por favor selecciona al menos un asiento.");
        }
    });
});
</script>

<?php include('../templates/footer.php'); ?>
