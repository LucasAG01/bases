<?php

include 'conexion.php';

//$sql = "INSERT INTO datos (nombre, edad) VALUES ('Lucas', 23)";

if($conexion -> query($sql) === TRUE){
    echo "Nuevo registro creado exitosamente <br>";
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

$conexion->close();