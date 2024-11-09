CREATE DATABASE kino_db;
USE kino_db;

-- Tabla de Usuario
CREATE TABLE usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    telefono VARCHAR(15),
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

-- Tabla de Películas
CREATE TABLE peliculas (
    pelicula_id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    duracion_minutos INT,
    clasificacion VARCHAR(10)
);

-- Tabla de Salas
CREATE TABLE salas (
    sala_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    capacidad INT NOT NULL
);

-- Tabla de Asientos
CREATE TABLE asientos (
    asiento_id INT AUTO_INCREMENT PRIMARY KEY,
    sala_id INT,
    numero_asiento INT NOT NULL,
    fila CHAR(1) NOT NULL,
    FOREIGN KEY (sala_id) REFERENCES salas(sala_id)
);

-- Tabla de Funciones
CREATE TABLE funciones (
    funcion_id INT AUTO_INCREMENT PRIMARY KEY,
    pelicula_id INT,
    sala_id INT,
    fecha_hora DATETIME NOT NULL,
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(pelicula_id),
    FOREIGN KEY (sala_id) REFERENCES salas(sala_id)
);

-- Tabla de Reservas
CREATE TABLE reservas (
    reserva_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    funcion_id INT,
    fecha_reserva DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id),
    FOREIGN KEY (funcion_id) REFERENCES funciones(funcion_id)
);

-- Tabla de Asientos Reservados
CREATE TABLE asientos_reservados (
    asiento_reservado_id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT,
    asiento_id INT,
    FOREIGN KEY (reserva_id) REFERENCES reservas(reserva_id),
    FOREIGN KEY (asiento_id) REFERENCES asientos(asiento_id)
);
