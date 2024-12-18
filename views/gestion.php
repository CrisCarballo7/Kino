<?php
include('../templates/header.php');
include('../includes/db_connection.php');
include('../templates/navbar.php');

if (!isset($_SESSION['admin_logged'])) {
    header('Location: login.php');
    exit;
}

// Procesar acciones de la tabla
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'] ?? '';

    // Agregar nueva película
    if ($accion == 'agregar') {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_POST['imagen'];
        $duracion = $_POST['duracion'];
        $clasificacion = $_POST['clasificacion'];
        $precio = $_POST['precio'];

        $stmt = $conexion->prepare("INSERT INTO peliculas (titulo, descripcion, duracion_minutos, clasificacion, precio, imagen) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisis", $titulo, $descripcion, $duracion, $clasificacion, $precio, $imagen);
        $stmt->execute();
    }

    // Editar película existente
    elseif ($accion == 'editar') {
        $pelicula_id = $_POST['pelicula_id'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_POST['imagen'];
        $duracion = $_POST['duracion'];
        $clasificacion = $_POST['clasificacion'];
        $precio = $_POST['precio'];

        $stmt = $conexion->prepare("UPDATE peliculas SET titulo = ?, descripcion = ?, duracion_minutos = ?, clasificacion = ?, precio = ?, imagen = ? WHERE pelicula_id = ?");
        $stmt->bind_param("ssisisi", $titulo, $descripcion, $duracion, $clasificacion, $precio, $imagen, $pelicula_id);
        $stmt->execute();
    }

    // Eliminar película
    elseif ($accion == 'eliminar') {
        $pelicula_id = $_POST['pelicula_id'];
        $stmt = $conexion->prepare("DELETE FROM peliculas WHERE pelicula_id = ?");
        $stmt->bind_param("i", $pelicula_id);
        $stmt->execute();
    }
}

// Obtener la lista de películas
$peliculas = $conexion->query("SELECT * FROM peliculas");
?>

<div class="container">
    <h2>Gestión de Películas</h2>

    <!-- Tabla para agregar películas -->
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="accion" value="agregar">
        <table class="add-table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Duración</th>
                    <th>Clasificación</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="titulo" placeholder="Título" required></td>
                    <td><textarea name="descripcion" placeholder="Descripción" required></textarea></td>
                    <td><input type="number" name="duracion" placeholder="Duración (min)" required></td>
                    <td>
                        <select name="clasificacion" required>
                            <option value="TP">Todo Público</option>
                            <option value="M15">Mayores de 15</option>
                            <option value="M18">Mayores de 18</option>
                        </select>
                    </td>
                    <td><input type="number" name="precio" placeholder="Precio" required></td>
                    <td><input type="text" name="imagen" placeholder="URL de Imagen" required></td>
                    <td><button type="submit">Agregar</button></td>
                </tr>
            </tbody>
        </table>
    </form>

    <!-- Tabla para gestionar películas -->
    <h2>Lista de Películas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Duración</th>
                <th>Clasificación</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = $peliculas->fetch_assoc()): ?>
            <tr>
                <form method="post">
                    <input type="hidden" name="accion" value="editar">
                    <input type="hidden" name="pelicula_id" value="<?php echo $p['pelicula_id']; ?>">
                    <td><?php echo $p['pelicula_id']; ?></td>
                    <td><input type="text" name="titulo" value="<?php echo $p['titulo']; ?>" required></td>
                    <td><textarea name="descripcion" required><?php echo $p['descripcion']; ?></textarea></td>
                    <td><input type="number" name="duracion" value="<?php echo $p['duracion_minutos']; ?>" required></td>
                    <td>
                        <select name="clasificacion" required>
                            <option value="TP" <?php echo $p['clasificacion'] == 'TP' ? 'selected' : ''; ?>>Todo Público</option>
                            <option value="M15" <?php echo $p['clasificacion'] == 'M15' ? 'selected' : ''; ?>>Mayores de 15</option>
                            <option value="M18" <?php echo $p['clasificacion'] == 'M18' ? 'selected' : ''; ?>>Mayores de 18</option>
                        </select>
                    </td>
                    <td><input type="number" name="precio" value="<?php echo $p['precio']; ?>" required></td>
                    <td><input type="text" name="imagen" value="<?php echo $p['imagen']; ?>"></td>
                    <td class="actions">
                        <button type="submit">Guardar</button>
                        <button type="submit" formnovalidate formaction="crud_peliculas.php" name="accion" value="eliminar">Eliminar</button>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../templates/footer.php'); ?>
