-- Base de datos AGENCIA: vuelos, hoteles y reservas
CREATE DATABASE IF NOT EXISTS AGENCIA
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE AGENCIA;

CREATE TABLE IF NOT EXISTS VUELO (
    id_vuelo           INT AUTO_INCREMENT PRIMARY KEY,
    origen             VARCHAR(60)   NOT NULL,
    destino            VARCHAR(60)   NOT NULL,
    fecha              DATE          NOT NULL,
    plazas_disponibles INT           NOT NULL,
    precio             DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS HOTEL (
    id_hotel                 INT AUTO_INCREMENT PRIMARY KEY,
    nombre                   VARCHAR(100)  NOT NULL,
    ubicacion                VARCHAR(100)  NOT NULL,
    habitaciones_disponibles INT           NOT NULL,
    tarifa_noche             DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS RESERVA (
    id_reserva    INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente    INT  NOT NULL,
    fecha_reserva DATE NOT NULL,
    id_vuelo      INT  NOT NULL,
    id_hotel      INT  NOT NULL,
    CONSTRAINT fk_reserva_vuelo FOREIGN KEY (id_vuelo) REFERENCES VUELO (id_vuelo),
    CONSTRAINT fk_reserva_hotel FOREIGN KEY (id_hotel) REFERENCES HOTEL (id_hotel)
) ENGINE=InnoDB;
