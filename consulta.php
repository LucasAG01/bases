<?php

include 'conexion.php';


$sql = "SELECT * FROM familias";


$resultado = $conexion->query($sql);
// Verificar si hay resultados y mostrarlos
if($resultado->num_rows > 0){
    while($fila = $resultado->fetch_assoc()){
        echo "Codigo: " . $fila["cod"] . " - Nombre: " . $fila["nombre"] . "<br>";
    }
} else {
    echo "0 resultados";
}

$conexion->close();




$error = $conexion->connect_errno;
if ($error == null) {
    $resultado = $conexion->query('DELETE FROM stock WHERE unidades=0');
    if ($resultado) {
        echo "<p>Se han borrado $conexion->affected_rows registros.</p>";
    }
    $conexion->close(); //cerramos la conexion
}