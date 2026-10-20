<?php
require_once 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: formulario_hotel.html');
    exit;
}

// Datos enviados por el formulario
$nombre       = trim($_POST['nombre'] ?? '');
$ubicacion    = trim($_POST['ubicacion'] ?? '');
$habitaciones = trim($_POST['habitaciones_disponibles'] ?? '');
$tarifa       = trim($_POST['tarifa_noche'] ?? '');

// Validacion del lado del servidor
$errores = [];

if (strlen($nombre) < 3) {
    $errores[] = 'El nombre del hotel debe tener al menos 3 caracteres.';
}
if ($ubicacion === '') {
    $errores[] = 'La ubicación es obligatoria.';
}
if (filter_var($habitaciones, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
    $errores[] = 'Las habitaciones disponibles deben ser un entero mayor a 0.';
}
if (!is_numeric($tarifa) || (float) $tarifa <= 0) {
    $errores[] = 'La tarifa por noche debe ser un número mayor a 0.';
}

// Insercion con sentencia preparada
$idNuevo = null;
if (empty($errores)) {
    try {
        $habInt = (int) $habitaciones;
        $tarifaNum = (float) $tarifa;
        $stmt = $conexion->prepare(
            'INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) VALUES (?, ?, ?, ?)'
        );
        $stmt->bind_param('ssid', $nombre, $ubicacion, $habInt, $tarifaNum);
        $stmt->execute();
        $idNuevo = $conexion->insert_id;
        $stmt->close();
    } catch (mysqli_sql_exception $ex) {
        error_log('Error al insertar hotel: ' . $ex->getMessage());
        $errores[] = 'No se pudo guardar el hotel. Intente nuevamente.';
    }
}

$titulo = 'Registro de hotel';
include 'includes/encabezado.php';
?>
<h2>Registro de hotel</h2>
<?php if (empty($errores)): ?>
    <div class="mensaje-ok">
        <p>El hotel se registró correctamente con el ID <strong><?= e($idNuevo) ?></strong>.</p>
        <p><?= e($nombre) ?> | <?= e($ubicacion) ?> | <?= e($habitaciones) ?> habitaciones | $<?= e($tarifa) ?> por noche</p>
    </div>
<?php else: ?>
    <div class="mensaje-error">
        <p><strong>No se pudo registrar el hotel:</strong></p>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<p><a href="formulario_hotel.html">Registrar otro hotel</a> | <a href="listar_hoteles.php">Ver hoteles</a></p>
<?php include 'includes/pie.php'; ?>
