<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Jugador;

$jugadores = Jugador::getJugadores();

echo "<pre>";
print_r($jugadores);
echo "</pre>";
