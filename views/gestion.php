<?php include('../templates/header.php'); ?>
<?php include('../templates/sidebar.php'); 
include('../includes/db_connection.php');?>

<div class="main-content">
    <div class="gestion-container">
        <h2>Agregar Nueva Película</h2>
        <form id="formAgregar">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="imagen">URL de Imagen:</label>
            <input type="text" id="imagen" name="imagen" required>
            
            <label for="duracion">Duración (min):</label>
            <input type="number" id="duracion" name="duracion" required>
            
            <label for="clasificacion">Clasificación:</label>
            <select id="clasificacion" name="clasificacion">
                <option value="TP">Todo Público</option>
                <option value="M15">Mayores de 15</option>
                <option value="M18">Mayores de 18</option>
            </select>
            
            <label for="precio">Precio por Entrada (₡):</label>
            <input type="number" id="precio" name="precio" required>

            <label for="horarios">Horarios (separados por coma):</label>
            <input type="text" id="horarios" name="horarios" placeholder="Ej. 12:00, 14:30, 17:00" required>

            <label for="sala">Número de Sala:</label>
            <input type="number" id="sala" name="sala" required>

            <button type="submit">Guardar Película</button>
        </form>
        
        <h2>Lista de Películas</h2>
        <div id="lista-peliculas">

        </div>
    </div>
</div>

<?php include('../templates/footer.php'); ?>
<script src="../assets/js/gestion.js"></script>
<link rel="stylesheet" href="../assets/css/style.css">
