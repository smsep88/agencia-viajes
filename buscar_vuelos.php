<?php
require_once 'config/conexion.php';

$origen  = trim($_GET['origen'] ?? '');
$destino = trim($_GET['destino'] ?? '');

// Busqueda por origen y destino
$stmt = $conexion->prepare('SELECT * FROM VUELO WHERE origen LIKE ? AND destino LIKE ?');
$likeOrigen  = '%' . $origen . '%';
$likeDestino = '%' . $destino . '%';
$stmt->bind_param('ss', $likeOrigen, $likeDestino);
$stmt->execute();
$resultado = $stmt->get_result();

$titulo = 'Buscar vuelos';
include 'includes/encabezado.php';
?>
<h2>Buscar vuelos</h2>

<form action="buscar_vuelos.php" method="get">
    <label for="origen">Origen</label>
    <input type="text" id="origen" name="origen" value="<?= e($origen) ?>">

    <label for="destino">Destino</label>
    <input type="text" id="destino" name="destino" value="<?= e($destino) ?>">

    <button type="submit">Buscar</button>
</form>

<table>
    <tr>
        <th>ID</th><th>Origen</th><th>Destino</th><th>Fecha</th><th>Plazas</th><th>Precio</th>
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
<?php include 'includes/pie.php'; ?>
