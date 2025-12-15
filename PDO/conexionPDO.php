<?php

$host = "localhost";
$db = "proyecto";
$user = "root";
$pass ="Lucas2001";
$dsn = "mysql:host=$host;dbname=$db";

$conProyecto = new PDO($dsn, $user, $pass);
// Se recomienda guardar los datos (host, user...) en variables porque si estos cambian
// solo tenenmos que actualizar estas variables


//Obtener version servidor
$version = $conProyecto -> getAttribute(PDO::ATTR_SERVER_VERSION);
echo "version: $version";


//Control de errores
/*
    ERRMODE_SILENT: El modo por defecto, no muestra errores (se recomienda en entornos en producción).
    ERRMODE_WARNING: Además de establecer el código de error, emitirá un mensaje E_WARNING, es el modo empleado para depurar o hacer pruebas para ver errores sin interrumpir el flujo de la aplicación.
    ERRMODE_EXCEPTION: Además de establecer el código de error, lanzará una PDOException que podemos capturar en un bloque try catch(). Lo veremos en el apartado 4.1.

*/ 
$conProyecto -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//cerrar copnexion

//$conProyecto = null;




//Ejecucion de consultas, en caso de INSERT, DLEETE o UPDATE ell método exec devuleve el numero de registros afectados

$registros = $conProyecto->exec('DELETE FROM stocks WHERE unidades=0');

echo "<p>Se han borrad $registros registros</p>";


//Si genera un conjunto de datos como en el caso de SELECT debes utilizar el método query que devuelve un objeto de la clase PDOStatement.

$resultado = $conProyecto->query("SELECT producto, unidades FROM stock");



//PDO trabaja con AUTOCOMMIT

/*
    beginTransaction. Deshabilita el modo "autocommit" y comienza una nueva transacción, que finalizará cuando ejecutes uno de los dos métodos siguientes.
    commit. Confirma la transacción actual.
    rollback. Revierte los cambios llevados a cabo en la transacción actual.

*/


$ok = true;
$conProyecto ->beginTransaction();

if(!$conProyecto->exec('DELETE...')) $ok  = false;
if(!$conProyecto->exec('UPDATE...')) $ok = false;

//...

if($ok) $conProyecto->commit(); //Si todo sale bien, confirma los cambios

else $dwes->rollback(); //si no los revierte. 





//ontención y utilización de conjuntos de resultados

$conProyecto = new PDO("...");
$resultado = $conProyecto->query("SELECT producto, unidades FROM stocks");

while($registro = $resultado->fetch()){
    echo "Producto ".$registro['producto'].": ".$registro['unidades']."<br/>";
}


/*
    el método fetch genera y devuelve a partir de cada registro un array con claves numéricas y asociativas.
    Para cambiar su comportamiento, admite un parámetro opcional que puede tomar uno de los siguientes valores:

        PDO::FETCH_ASSOC. Devuelve solo un array asociativo.
        PDO::FETCH_NUM. Devuelve solo un array con claves numéricas.
        PDO::FETCH_BOTH. Devuelve un array con claves numéricas y asociativas. Es el comportamiento por defecto.
        PDO::FETCH_OBJ. Devuelve un objeto cuyas propiedades se corresponden con los campos del registro
*/ 

$conProyecto = new PDO("...");

$resultado = $conProyecto->query("SELECT producto, unidades FROM stocks");

while($registro = $resultado->fetch(PDO::FETCH_OBJ)){
    echo "Productro. ".$registro->producto.": ".$registro->unidades."<br/>";
}


/*
    PDO::FETCH_LAZY.  Devuelve tanto el objeto como el array con clave dual anterior.
    PDO::FETCH_BOUND. Devuelve true y asigna los valores del registro a variables, según se indique con el método bindColumn.
                    Este método debe ser llamado una vez por cada columna, indicando en cada llamada el número de columna (empezando en 1) y la variable a asignar.
*/ 


//
$conProyecto = new PDO("...");

$resultado = $conProyecto->query("SELECT producto, unidades FROM stocks");
$resultado ->bindColumn(1,$producto);
$resultado ->bindColumn(2,$unidades);

while($registro = $resultado->fetch(PDO::FETCH_OBJ)){
    echo "Producto ".$producto.": ".$unidades."<br />";
}


/*
    Se ùede utilizar fetchAll() que trae todos los datos de golpe, sin abrir ningún puntero, almacenándolos en un array, recomendable cuando no hay muchos datos resultados esperados

*/

$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado as $row){
    echo $row["nombre"]." ".$row["apellido"];
}


