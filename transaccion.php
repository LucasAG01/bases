<?php
include 'conexion.php';

/*Como ya comentamos, si necesitas utilizar transacciones deberás asegurarte
de que estén soportadas por el motor de almacenamiento que gestiona tus tablas en MySQL.
Si utilizas InnoDB, por defecto cada consulta individual se incluye dentro de su propia transacción.
Puedes gestionar este comportamiento con el método autocommit (función mysqli_autocommit).
*/
$conexion -> autocommit(FALSE); // Desactivar el autocommit

$sql = "DELETE FROM stock WHERE unidades=0"; //iniciamos transaccion

if ($conexion -> query($sql) === TRUE) {
    $conexion -> commit(); // Confirmar la transacción
    echo "Transacción completada exitosamente.";
} else {
    $conexion -> rollback(); // Revertir la transacción en caso de error
}



/*
    Según la información que figura en la tabla stock de la base de datos proyecto,
    la tienda 1 (CENTRAL) tiene 2 unidades del producto de código 3DSNG y la tienda 3 (SUCURSAL2) ninguno.
    Suponiendo que los datos son esos (no hace falta que los compruebes en el código),
    utiliza una transacción para mover una unidad de ese producto de la tienda 1 a la tienda 3.
*/



