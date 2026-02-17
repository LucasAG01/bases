<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Jugador;

session_start();

$_SESSION['barcode_generado'] = Jugador::generarEAN13();

header('Location: fcrear.php');
exit;
