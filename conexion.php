<?php

$host = "localhost";
$user = "root";
$password = "Lucas2001";
$database = "proyecto";

$conexion = mysqli_connect($host, $user, $password, $database);


if($conexion->connect_error){
    die("La conexion falló: " . $conexion->connect_error);
}

echo "Conexión exitosa a la base de datos. <br>";

print mysqli_get_server_info($conexion) . "<br>";




//cambio de base de datos

//$conexion->select_db("prueba");


//cerrar conexion $conexion->close();
