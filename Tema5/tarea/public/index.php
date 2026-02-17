<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Jugador;

$jugadores = Jugador::getJugadores();

if (count($jugadores) === 0) {
    header('Location: instalacion.php');
    exit;
}

header('Location: jugadores.php');
exit;
