<?php
require_once 'config/conexion.php';

// Consulta simple: todos los hoteles
$resultado = $conexion->query('SELECT * FROM HOTEL ORDER BY id_hotel');

$titulo = 'Hoteles registrados';
include 'includes/encabezado.php';
?>
<h2>Hoteles registrados</h2>
<p>Consulta: <code>SELECT * FROM HOTEL ORDER BY id_hotel</code></p>
<?php if ($resultado->num_rows === 0): ?>
    <p>No hay hoteles registrados.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ID</th><th>Nombre</th><th>Ubicación</th><th>Habitaciones disponibles</th><th>Tarifa por noche</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= e($fila['id_hotel']) ?></td>
                <td><?= e($fila['nombre']) ?></td>
                <td><?= e($fila['ubicacion']) ?></td>
                <td><?= e($fila['habitaciones_disponibles']) ?></td>
                <td><?= e($fila['tarifa_noche']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>
<?php include 'includes/pie.php'; ?>
