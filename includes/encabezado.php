<?php require_once __DIR__ . '/funciones.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($titulo ?? 'Agencia de Viajes') ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header>
    <h1>Agencia de Viajes</h1>
    <nav>
        <a href="index.html">Inicio</a>
        <a href="formulario_vuelo.html">Nuevo vuelo</a>
        <a href="formulario_hotel.html">Nuevo hotel</a>
        <a href="formulario_reserva.php">Nueva reserva</a>
        <a href="listar_vuelos.php">Ver vuelos</a>
        <a href="listar_hoteles.php">Ver hoteles</a>
        <a href="listar_reservas.php">Ver reservas</a>
        <a href="consulta_avanzada.php">Consulta avanzada</a>
    </nav>
</header>
<main>
