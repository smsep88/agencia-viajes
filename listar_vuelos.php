<?php
require_once 'config/conexion.php';

// Consulta simple: todos los vuelos
$resultado = $conexion->query('SELECT * FROM VUELO ORDER BY id_vuelo');

$titulo = 'Vuelos registrados';
include 'includes/encabezado.php';
?>
<h2>Vuelos registrados</h2>
<p>Consulta: <code>SELECT * FROM VUELO ORDER BY id_vuelo</code></p>
<?php if ($resultado->num_rows === 0): ?>
    <p>No hay vuelos registrados.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ID</th><th>Origen</th><th>Destino</th><th>Fecha</th><th>Plazas disponibles</th><th>Precio</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= e($fila['id_vuelo']) ?></td>
                <td><?= e($fila['origen']) ?></td>
                <td><?= e($fila['destino']) ?></td>
                <td><?= e($fila['fecha']) ?></td>
                <td><?= e($fila['plazas_disponibles']) ?></td>
                <td><?= e($fila['precio']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>
<?php include 'includes/pie.php'; ?>
