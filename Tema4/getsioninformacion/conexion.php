<!--meteremos los parámetros para iniciar la conexión y alguna otra función útil.
 Con require_once la "llamaremos" desde los otros archivos, lo que nos evitará tener que repetir código
  -->

<?php

$host = "localhost";
$usuario = "root";
$db ="proyecto";
$pass = "Lucas2001";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try{
    $conexion = new PDO($dsn, $usuario, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

function consultarProducto($id){
    global $conexion;
    $consulta = "select id, nombre, pvp from productos where id = :id";
    $stmt = $conexion->prepare($consulta);
    try{
        $stmt->execute([
            ':id' => $id
        ]);
        $producto = $stmt->fetch(PDO::FETCH_OBJ);
        cerrarTodo($conexion, $stmt);
        return $producto;
        
    } catch (PDOException $e) {
        cerrarTodo($conexion, $stmt);
        die("Error al ejecutar la consulta: " . $e->getMessage());
    }
}

function cerrarTodo($conexion, $stmt){
    $stmt = null;
    $conexion = null;
}