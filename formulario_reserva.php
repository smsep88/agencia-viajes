<?php
require_once 'config/conexion.php';

// Los vuelos y hoteles ya registrados se ofrecen como opciones de la reserva
$vuelos  = $conexion->query('SELECT id_vuelo, origen, destino, fecha FROM VUELO ORDER BY id_vuelo');
$hoteles = $conexion->query('SELECT id_hotel, nombre, ubicacion FROM HOTEL ORDER BY id_hotel');

$titulo = 'Registrar reserva';
include 'includes/encabezado.php';
?>
<script src="js/validaciones.js"></script>
<h2>Registrar reserva</h2>
<?php if ($vuelos->num_rows === 0 || $hoteles->num_rows === 0): ?>
    <div class="mensaje-error">
        Para crear una reserva primero debe registrar al menos un vuelo y un hotel.
    </div>
<?php else: ?>
    <form action="insertar_reserva.php" method="post" onsubmit="return validarReserva(this)" novalidate>
        <div id="errores"></div>

        <label for="id_cliente">ID del cliente</label>
        <input type="number" id="id_cliente" name="id_cliente" min="1">

        <label for="fecha_reserva">Fecha de la reserva</label>
        <input type="date" id="fecha_reserva" name="fecha_reserva" value="<?= date('Y-m-d') ?>">

        <label for="id_vuelo">Vuelo</label>
        <select id="id_vuelo" name="id_vuelo">
            <option value="">-- Seleccione un vuelo --</option>
            <?php while ($v = $vuelos->fetch_assoc()): ?>
                <option value="<?= e($v['id_vuelo']) ?>">
                    #<?= e($v['id_vuelo']) ?> – <?= e($v['origen']) ?> → <?= e($v['destino']) ?> (<?= e($v['fecha']) ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <label for="id_hotel">Hotel</label>
        <select id="id_hotel" name="id_hotel">
            <option value="">-- Seleccione un hotel --</option>
            <?php while ($h = $hoteles->fetch_assoc()): ?>
                <option value="<?= e($h['id_hotel']) ?>">
                    #<?= e($h['id_hotel']) ?> – <?= e($h['nombre']) ?> (<?= e($h['ubicacion']) ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Guardar reserva</button>
    </form>
<?php endif; ?>
<?php include 'includes/pie.php'; ?>
