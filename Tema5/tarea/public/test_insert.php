<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Jugador;

$ok = Jugador::insertar(
    "Antonio",
    "Gil Gil",
    1,
    "Portero",
    "0952945303398"
);

echo $ok ? "✅ Insertado" : "❌ No insertado";
