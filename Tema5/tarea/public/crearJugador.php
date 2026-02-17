<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Jugador;

session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: fcrear.php');
    exit;
}

$nombre    = trim($_POST['nombre']);
$apellidos = trim($_POST['apellidos']);
$dorsalRaw = trim($_POST['dorsal']);
$posicion  = trim($_POST['posicion']);
$barcode   = trim($_POST['barcode']);

$dorsal = ($dorsalRaw === '') ? null : (int)$dorsalRaw;

// Validación
if ($dorsal !== null && Jugador::existeDorsal($dorsal)) {
    die("El dorsal ya existe");
}

if (Jugador::existeBarcode($barcode)) {
    die("El código de barras ya existe. Genera otro.");
}


Jugador::insertar($nombre, $apellidos, $dorsal, $posicion, $barcode);

$_SESSION['msg_ok'] = 'Jugador Creado con exito';

header('Location: jugadores.php');
exit;
