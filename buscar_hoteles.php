<?php
require_once 'config/conexion.php';

$ubicacion = $_GET['ubicacion'] ?? '';

// Busca hoteles por ubicacion
$resultado = $conexion->query("SELECT * FROM HOTEL WHERE ubicacion LIKE '%$ubicacion%'");

$titulo = 'Buscar hoteles';
include 'includes/encabezado.php';
?>
<h2>Buscar hoteles</h2>

<form action="buscar_hoteles.php" method="get">
    <label for="ubicacion">Ubicación</label>
    <input type="text" id="ubicacion" name="ubicacion" value="<?= $ubicacion ?>">

    <button type="submit">Buscar</button>
</form>

<table>
    <tr>
        <th>Nombre</th><th>Ubicación</th><th>Habitaciones</th><th>Tarifa por noche</th>
    </tr>
    <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $fila['nombre'] ?></td>
            <td><?= $fila['ubicacion'] ?></td>
            <td><?= $fila['habitaciones_disponibles'] ?></td>
            <td><?= $fila['tarifa_noche'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<?php include 'includes/pie.php'; ?>
