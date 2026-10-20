<?php
require_once 'config/conexion.php';

$base = $conexion->query('SELECT DATABASE() AS nombre')->fetch_assoc()['nombre'];

$titulo = 'Prueba de conexión';
include 'includes/encabezado.php';
?>
<h2>Prueba de conexión con MySQL</h2>
<div class="mensaje-ok">
    <p><strong>Conexión exitosa.</strong></p>
    <p>Servidor: <?= e($conexion->host_info) ?></p>
    <p>Versión de MySQL: <?= e($conexion->server_info) ?></p>
    <p>Base de datos en uso: <?= e($base) ?></p>
</div>
<?php include 'includes/pie.php'; ?>
