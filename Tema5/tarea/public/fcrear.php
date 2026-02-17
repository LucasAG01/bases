<?php



require __DIR__ . '/../vendor/autoload.php';


use Philo\Blade\Blade;

session_start();

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new Blade($views, $cache);

$barcode = $_SESSION['barcode_generado'] ?? '';

$errores = $_SESSION['errores_crear'] ?? [];
$old = $_SESSION['old_crear'] ?? [];

unset($_SESSION['errores_crear'], $_SESSION['old_crear']);

echo $blade->view()->make('vcrear', [
    'barcode' => $barcode,
    'errores' => $errores,
    'old' => $old
])->render();

