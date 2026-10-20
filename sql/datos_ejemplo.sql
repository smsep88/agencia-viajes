-- OPCIONAL: datos de respaldo. Los datos de la tarea se ingresan desde los formularios.
USE AGENCIA;

INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) VALUES
('Santiago', 'Lima',         '2027-01-10', 40, 120000.00),
('Santiago', 'Buenos Aires', '2027-01-15', 35,  95000.00),
('Santiago', 'Punta Arenas', '2027-02-02', 50, 180000.00);

INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) VALUES
('Hotel Miraflores', 'Lima',         20, 65000.00),
('Hotel Palermo',    'Buenos Aires', 15, 58000.00),
('Hotel Estrecho',   'Punta Arenas', 12, 72000.00);

INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) VALUES
(1001, '2026-10-01', 1, 1),
(1002, '2026-10-02', 1, 1),
(1003, '2026-10-03', 1, 1),
(1004, '2026-10-04', 2, 1),
(1005, '2026-10-05', 3, 1),
(1006, '2026-10-06', 2, 2),
(1007, '2026-10-07', 2, 2),
(1008, '2026-10-08', 1, 2),
(1009, '2026-10-09', 3, 3),
(1010, '2026-10-10', 3, 3);
