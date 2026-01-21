<!--meteremos los parámetros para iniciar la conexión y alguna otra función útil.
 Con require_once la "llamaremos" desde los otros archivos, lo que nos evitará tener que repetir código
  -->

<?php

$host = "localhost";
$usuario = "gestor";
$db ="proyecto";
$pass = "secreto";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try{
    $conexion = new PDO($dsn, $usuario, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

function consultarProducto($id){

}

function cerrarTodo($conexion, $stmt){
    $stmt = null;
    $conexion = null;
}