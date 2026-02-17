<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Conexion;

$pdo = Conexion::getConexion();

echo "✅ Conectado a la BD correctamente";
