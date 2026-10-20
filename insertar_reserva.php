<?php
require_once 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: formulario_reserva.php');
    exit;
}

// Datos enviados por el formulario
$idCliente    = trim($_POST['id_cliente'] ?? '');
$fechaReserva = trim($_POST['fecha_reserva'] ?? '');
$idVuelo      = trim($_POST['id_vuelo'] ?? '');
$idHotel      = trim($_POST['id_hotel'] ?? '');

// Validacion del lado del servidor
$errores = [];
$entero = ['options' => ['min_range' => 1]];

if (filter_var($idCliente, FILTER_VALIDATE_INT, $entero) === false) {
    $errores[] = 'El ID de cliente debe ser un entero mayor a 0.';
}
$fechaObj = DateTime::createFromFormat('Y-m-d', $fechaReserva);
if (!$fechaObj || $fechaObj->format('Y-m-d') !== $fechaReserva) {
    $errores[] = 'La fecha de la reserva no es válida.';
}
if (filter_var($idVuelo, FILTER_VALIDATE_INT, $entero) === false) {
    $errores[] = 'Debe seleccionar un vuelo.';
}
if (filter_var($idHotel, FILTER_VALIDATE_INT, $entero) === false) {
    $errores[] = 'Debe seleccionar un hotel.';
}

// Insercion: las claves foraneas aseguran que el vuelo y el hotel existan
$idNuevo = null;
if (empty($errores)) {
    try {
        $cliente = (int) $idCliente;
        $vuelo   = (int) $idVuelo;
        $hotel   = (int) $idHotel;
        $stmt = $conexion->prepare(
            'INSERT INTO RESERVA (id_cliente, fecha_reserva, id_vuelo, id_hotel) VALUES (?, ?, ?, ?)'
        );
        $stmt->bind_param('isii', $cliente, $fechaReserva, $vuelo, $hotel);
        $stmt->execute();
        $idNuevo = $conexion->insert_id;
        $stmt->close();
    } catch (mysqli_sql_exception $ex) {
        error_log('Error al insertar reserva: ' . $ex->getMessage());
        $errores[] = 'No se pudo guardar la reserva. Verifique que el vuelo y el hotel existan.';
    }
}

$titulo = 'Registro de reserva';
include 'includes/encabezado.php';
?>
<h2>Registro de reserva</h2>
<?php if (empty($errores)): ?>
    <div class="mensaje-ok">
        <p>La reserva se registró correctamente con el ID <strong><?= e($idNuevo) ?></strong>.</p>
        <p>Cliente <?= e($idCliente) ?> | Vuelo #<?= e($idVuelo) ?> | Hotel #<?= e($idHotel) ?> | <?= e($fechaReserva) ?></p>
    </div>
<?php else: ?>
    <div class="mensaje-error">
        <p><strong>No se pudo registrar la reserva:</strong></p>
        <ul>
            <?php foreach ($errores as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<p><a href="formulario_reserva.php">Registrar otra reserva</a> | <a href="listar_reservas.php">Ver reservas</a></p>
<?php include 'includes/pie.php'; ?>
