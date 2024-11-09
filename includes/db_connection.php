<?php
$host = 'localhost';
$db = 'kino_db';
$user = 'admin';
$password = '12345';

$conexion = new mysqli($host, $user, $password, $db);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>
