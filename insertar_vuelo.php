<?php
require_once 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: formulario_vuelo.html');
    exit;
}

// Datos enviados por el formulario
$origen  = trim($_POST['origen'] ?? '');
$destino = trim($_POST['destino'] ?? '');
$fecha   = trim($_POST['fecha'] ?? '');
$plazas  = trim($_POST['plazas_disponibles'] ?? '');
$precio  = trim($_POST['precio'] ?? '');

// Validacion del lado del servidor
$errores = [];

if ($origen === '' || $destino === '') {
    $errores[] = 'El origen y el destino son obligatorios.';
} elseif (strcasecmp($origen, $destino) === 0) {
    $errores[] = 'El origen y el destino no pueden ser iguales.';
}

$fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);
if (!$fechaObj || $fechaObj->format('Y-m-d') !== $fecha) {
    $errores[] = 'La fecha del vuelo no es válida.';
} elseif ($fecha < date('Y-m-d')) {
    $errores[] = 'La fecha del vuelo no puede ser anterior a hoy.';
}

if (filter_var($plazas, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
    $errores[] = 'Las plazas disponibles deben ser un entero mayor a 0.';
}
if (!is_numeric($precio) || (float) $precio <= 0) {
    $errores[] = 'El precio debe ser un número mayor a 0.';
}

// Insercion con sentencia preparada
$idNuevo = null;
if (empty($errores)) {
    try {
        $plazasInt = (int) $plazas;
        $precioNum = (float) $precio;
        $stmt = $conexion->prepare(
            'INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->bind_param('sssid', $origen, $destino, $fecha, $plazasInt, $precioNum);
        $stmt->execute();
        $idNuevo = $conexion->insert_id;
        $stmt->close();
    } catch (mysqli_sql_exception $ex) {
        error_log('Error al insertar vuelo: ' . $ex->getMessage());
        $errores[] = 'No se pudo guardar el vuelo. Intente nuevamente.';
    }
}

$titulo = 'Registro de vuelo';
include 'includes/encabezado.php';
?>
<h2>Registro de vuelo</h2>
<?php if (empty($errores)): ?>
    <div class="mensaje-ok">
        <p>El vuelo se registró correctamente con el ID <strong><?= e($idNuevo) ?></strong>.</p>
        <p><?= e($origen) ?> → <?= e($destino) ?> | <?= e($fecha) ?> | <?= e($plazas) ?> plazas | $<?= e($precio) ?></p>
    </div>
<?php else: ?>
    <div class="mensaje-error">
        <p><strong>No se pudo registrar el vuelo:</strong></p>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<p><a href="formulario_vuelo.html">Registrar otro vuelo</a> | <a href="listar_vuelos.php">Ver vuelos</a></p>
<?php include 'includes/pie.php'; ?>
