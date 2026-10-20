<?php
require_once 'config/conexion.php';

// Minimo de reservas que debe superar un hotel (por defecto 2)
$minimo = filter_input(INPUT_GET, 'minimo', FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
if ($minimo === false || $minimo === null) {
    $minimo = 2;
}

// Consulta avanzada: reservas por hotel (JOIN + GROUP BY + HAVING)
$sql = 'SELECT h.id_hotel, h.nombre, h.ubicacion, COUNT(r.id_reserva) AS total_reservas
        FROM HOTEL h
        INNER JOIN RESERVA r ON r.id_hotel = h.id_hotel
        GROUP BY h.id_hotel, h.nombre, h.ubicacion
        HAVING COUNT(r.id_reserva) > ?
        ORDER BY total_reservas DESC, h.nombre';

$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $minimo);
$stmt->execute();
$resultado = $stmt->get_result();

$titulo = 'Consulta avanzada';
include 'includes/encabezado.php';
?>
<h2>Hoteles con más de <?= e($minimo) ?> reservas</h2>

<form action="consulta_avanzada.php" method="get">
    <label for="minimo">Mostrar hoteles con más de esta cantidad de reservas</label>
    <input type="number" id="minimo" name="minimo" min="0" value="<?= e($minimo) ?>">
    <button type="submit">Consultar</button>
</form>

<p>Consulta ejecutada:</p>
<pre><code>SELECT h.id_hotel, h.nombre, h.ubicacion, COUNT(r.id_reserva) AS total_reservas
FROM HOTEL h
INNER JOIN RESERVA r ON r.id_hotel = h.id_hotel
GROUP BY h.id_hotel, h.nombre, h.ubicacion
HAVING COUNT(r.id_reserva) &gt; <?= e($minimo) ?>

ORDER BY total_reservas DESC, h.nombre;</code></pre>

<?php if ($resultado->num_rows === 0): ?>
    <p>Ningún hotel supera las <?= e($minimo) ?> reservas.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ID hotel</th><th>Nombre</th><th>Ubicación</th><th>Total de reservas</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= e($fila['id_hotel']) ?></td>
                <td><?= e($fila['nombre']) ?></td>
                <td><?= e($fila['ubicacion']) ?></td>
                <td><?= e($fila['total_reservas']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>
<?php include 'includes/pie.php'; ?>
