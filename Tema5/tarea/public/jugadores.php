<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Jugador;
use Philo\Blade\Blade;

session_start();

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new Blade($views, $cache);

$jugadores = Jugador::getJugadores();

$msg = $_SESSION['msg_ok'] ?? '';
unset($_SESSION['msg_ok']);

echo $blade->view()->make('vjugadores', [
    'jugadores' => $jugadores,
    'msg' => $msg
])->render();
