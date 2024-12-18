CREATE DATABASE IF NOT EXISTS kino_db;
USE kino_db;

-- Tabla de Usuarios (admin)
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (username, contrasena) VALUES ('admin', '12345');

-- Tabla de Películas
DROP TABLE IF EXISTS peliculas;
CREATE TABLE peliculas (
    pelicula_id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    duracion_minutos INT,
    clasificacion VARCHAR(10),
    precio INT,
    imagen VARCHAR(255)
);

-- Tabla de Salas
DROP TABLE IF EXISTS salas;
CREATE TABLE salas (
    sala_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    capacidad INT NOT NULL
);

INSERT INTO salas (nombre, capacidad) VALUES ('Sala 1', 50);

-- Tabla de Horarios
DROP TABLE IF EXISTS horarios;
CREATE TABLE horarios (
    horario_id INT AUTO_INCREMENT PRIMARY KEY,
    pelicula_id INT,
    sala_id INT,
    fecha_hora DATETIME NOT NULL,
    FOREIGN KEY (pelicula_id) REFERENCES peliculas(pelicula_id) ON DELETE CASCADE,
    FOREIGN KEY (sala_id) REFERENCES salas(sala_id)
);

-- Tabla de Asientos
DROP TABLE IF EXISTS asientos;
CREATE TABLE asientos (
    asiento_id INT AUTO_INCREMENT PRIMARY KEY,
    sala_id INT,
    fila CHAR(1) NOT NULL,
    numero_asiento INT NOT NULL,
    ocupado TINYINT DEFAULT 0,
    FOREIGN KEY (sala_id) REFERENCES salas(sala_id)
);

ALTER TABLE asientos ADD UNIQUE(sala_id, fila, numero_asiento);


-- Insertar asientos para Sala 1 (A-D, 4 asientos cada uno)
INSERT INTO asientos (sala_id, fila, numero_asiento) VALUES
(1,'A',1),(1,'A',2),(1,'A',3),(1,'A',4),
(1,'B',1),(1,'B',2),(1,'B',3),(1,'B',4),
(1,'C',1),(1,'C',2),(1,'C',3),(1,'C',4),
(1,'D',1),(1,'D',2),(1,'D',3),(1,'D',4);

-- Tabla de Reservas
DROP TABLE IF EXISTS reservas;
CREATE TABLE reservas (
    reserva_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(100),
    email_cliente VARCHAR(100),
    telefono_cliente VARCHAR(20),
    horario_id INT,
    cantidad INT,
    fecha_reserva DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (horario_id) REFERENCES horarios(horario_id)
);

-- Tabla de Asientos Reservados
DROP TABLE IF EXISTS asientos_reservados;
CREATE TABLE asientos_reservados (
    asiento_reservado_id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT,
    asiento_id INT,
    FOREIGN KEY (reserva_id) REFERENCES reservas(reserva_id),
    FOREIGN KEY (asiento_id) REFERENCES asientos(asiento_id)
);

-- Tabla de Pagos
DROP TABLE IF EXISTS pagos;
CREATE TABLE pagos (
    pago_id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT,
    monto INT,
    tarjeta VARCHAR(20),
    nombre_titular VARCHAR(100),
    fecha_pago DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reserva_id) REFERENCES reservas(reserva_id)
);

-- Insertar películas y horarios de ejemplo
INSERT INTO peliculas (titulo, descripcion, duracion_minutos, clasificacion, precio, imagen)
VALUES ('Avatar 2', 'Secuela de Avatar', 180, 'TP', 3500, 'assets/img/peliculas/avatar.jpg'),
       ('The Batman', 'Nueva entrega de Batman', 180, 'M16', 3500, 'assets/img/peliculas/batman.jpg');

INSERT INTO horarios (pelicula_id, sala_id, fecha_hora)
VALUES (1, 1, '2024-12-25 12:00:00'),
       (1, 1, '2024-12-25 15:00:00'),
       (2, 1, '2024-12-25 17:00:00'),
       (2, 1, '2024-12-25 20:00:00');
