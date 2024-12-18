<?php include('../templates/header.php'); ?>
<?php include('../includes/db_connection.php'); ?>
<?php include('../templates/navbar.php'); ?>

<?php
$sql = "SELECT p.*, GROUP_CONCAT(h.fecha_hora SEPARATOR ',') AS horarios
        FROM peliculas p
        LEFT JOIN horarios h ON p.pelicula_id=h.pelicula_id
        GROUP BY p.pelicula_id";
$result = $conexion->query($sql);
?>

<div class="container">
    <h2>Cartelera de Películas</h2>
    <div class="pelicula-list">
        <?php while($row = $result->fetch_assoc()):
            $horarios = explode(',', $row['horarios']);
        ?>
        <div class="pelicula-item">
            <img src="../<?php echo $row['imagen']; ?>" alt="<?php echo $row['titulo']; ?>">
            <h3><?php echo $row['titulo']; ?></h3>
            <p><?php echo $row['clasificacion']; ?></p>
            <p>Precio: ₡<?php echo $row['precio']; ?></p>
            <form action="seleccion_asientos.php" method="get">
                <input type="hidden" name="pelicula_id" value="<?php echo $row['pelicula_id']; ?>">
                <input type="hidden" name="precio" value="<?php echo $row['precio']; ?>">
                <label>Horario:</label>
                <select name="horario" required>
                    <?php foreach($horarios as $h): ?>
                        <option value="<?php echo $h; ?>"><?php echo $h; ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Cantidad Entradas:</label>
                <input type="number" name="cantidad" value="1" min="1" required>
                <button type="submit" class="btn">Reservar</button>
            </form>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('../templates/footer.php'); ?>
