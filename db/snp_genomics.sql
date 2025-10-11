CREATE DATABASE GenomeAsistant
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  rol ENUM('usuario', 'administrador') DEFAULT 'usuario',
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
  activo BOOLEAN DEFAULT TRUE,
  contraseña_hash VARCHAR(255) NOT NULL
);
