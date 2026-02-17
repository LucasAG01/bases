<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Jugador;
use Faker\Factory;

$faker = Factory::create('es_ES');

$posiciones = [
    'Portero',
    'Defensa',
    'Lateral Izquierdo',
    'Lateral Derecho',
    'Central',
    'Delantero'
];

// crea 10 jugadores
for ($i = 0; $i < 10; $i++) {
    $nombre = $faker->firstName;
    $apellidos = $faker->lastName . ' ' . $faker->lastName;
    $posicion = $posiciones[array_rand($posiciones)];

    // dorsal único: prueba hasta que no exista
    do {
        $dorsal = $faker->numberBetween(1, 99);
    } while (Jugador::existeDorsal($dorsal));

    // barcode único (usa tu método)
    $barcode = Jugador::generarEAN13();

    Jugador::insertar($nombre, $apellidos, $dorsal, $posicion, $barcode);
}

header('Location: jugadores.php');
exit;
