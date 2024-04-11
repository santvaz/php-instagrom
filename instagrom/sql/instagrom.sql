CREATE DATABASE IF NOT EXISTS instagrom;

USE instagrom;

CREATE TABLE
    usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(30) NOT NULL,
        email VARCHAR(60) NOT NULL,
        nick VARCHAR(30) NOT NULL,
        tipo ENUM ('Administrador', 'Instagromer') NOT NULL,
        password VARCHAR(60) NOT NULL
    );

CREATE TABLE
    mensajes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        foto VARCHAR(255) NOT NULL,
        mensaje TEXT,
        fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    );

CREATE TABLE
    administradores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    );

CREATE TABLE
    publicaciones (
        id INT AUTO_INCREMENT PRIMARY KEY,
        imagen VARCHAR(255) NOT NULL,
        ubicacion VARCHAR(255) DEFAULT 'Ubicación no especificada',
        mensaje TEXT NOT NULL,
        usuario_id INT NOT NULL,
        fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    );

INSERT INTO
    usuarios (nombre, nick, tipo, password)
VALUES
    ('Admin', 'admin', 'Administrador', '1234');

INSERT INTO
    administradores (usuario_id)
VALUES
    (1);