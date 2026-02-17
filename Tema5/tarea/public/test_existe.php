<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Jugador;

echo "Dorsal 1 existe? ";
var_dump(Jugador::existeDorsal(1));

echo "<br>Barcode 0952945303398 existe? ";
var_dump(Jugador::existeBarcode("0952945303398"));
