<?php
require_once 'config/conexion.php';

// Consulta simple: todas las reservas
$resultado = $conexion->query('SELECT * FROM RESERVA ORDER BY id_reserva');

$titulo = 'Reservas registradas';
include 'includes/encabezado.php';
?>
<h2>Reservas registradas</h2>
<p>Consulta: <code>SELECT * FROM RESERVA ORDER BY id_reserva</code></p>
<?php if ($resultado->num_rows === 0): ?>
    <p>No hay reservas registradas.</p>
<?php else: ?>
    <p>Total de reservas: <strong><?= e($resultado->num_rows) ?></strong></p>
    <table>
        <tr>
            <th>ID reserva</th><th>ID cliente</th><th>Fecha de reserva</th><th>ID vuelo</th><th>ID hotel</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= e($fila['id_reserva']) ?></td>
                <td><?= e($fila['id_cliente']) ?></td>
                <td><?= e($fila['fecha_reserva']) ?></td>
                <td><?= e($fila['id_vuelo']) ?></td>
                <td><?= e($fila['id_hotel']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>
<?php include 'includes/pie.php'; ?>
