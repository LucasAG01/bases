<?php

//HAcemos la conexion, lo suyo es hacerlo en otro doc y usar el require

$host = "localhost";
$db="proyecto";
$user="root";
$pass="Lucas2001";
$dsn="mysql:host=$host;dbname=$db;charset=utf8mb4";
$conProyecto = new PDO($dsn,$user,$pass);
//Protocolos para generar excepciones y que no cierre de forma abrupta, para poder atraparlos en un trycatch
$conProyecto->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

//De momento, no se incluye el uso de Bootstrap, prefiero aprender primero el fncionamiento 

function pintarBoton(){
    //Genera un enlace que apunta al mismo script PHP (recarga la página)
    echo "<a href='{$_SERVER['PHP_SELF']}'>COnsulatr Otro Artículo";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EjTema3</title>
</head>
<body>
    <?php
    // Verifica si se ha enviado el formulario (botón 'enviar' presionado)
    if(isset($_POST['enviar'])){ 
        
        // Obtiene el código del producto desde el formulario
        $codigo=$_POST['producto'];

        // CONSULTA 1: Obtiene información del stock del producto en todas las tiendas
        // Une las tablas stocks y tiendas para obtener el nombre de la tienda
        $consulta = "select unidades, tienda, producto, tiendas.nombre as nombreTienda from stocks, tiendas where tienda=tiendas.id AND producto=$codigo";

       // CONSULTA 2: Obtiene el nombre completo y corto del producto
        $consulta1 = "select nombre, nombre_corto from productos where id=$codigo";


        // Ejecuta la consulta para obtener información del producto
        $consultaProducto = $conProyecto->query($consulta1);

        // Ejecuta la consulta para obtener el stock en tiendas
        $consultaDatos=$conProyecto->query($consulta);

        // Obtiene la primera fila de resultados de la consulta del producto
        // PDO::FETCH_OBJ convierte la fila en un objeto para acceso por propiedades
        $fila=$consultaProducto->fetch(PDO::FETCH_OBJ); 

        // Muestra el nombre del producto como encabezado
        echo "<h4>Unidades producto: ";

        echo "$fila->nombre ($fila->nombre_corto)";
        echo "</h4>";

        //un css de tablas
        echo "<table>";
        echo "<thead>";
         // Encabezados de la tabla (INCOMPLETO - solo tiene una columna definida)
        echo "<tr><th>NOmbre tienda</th>";
        echo "</thead>";
        
        echo "<tbody>";
        // Itera sobre cada fila de resultados del stock en tiendas
        while($filas = $consultaDatos->fetch(PDO::FETCH_OBJ)){
            // Fila de la tabla con el nombre de la tienda
            echo "<tr><td>$filas->nombreTienda</td>";
            echo "<td>";

            // Aquí debería ir el formulario para modificar el stock (COMENTARIO DEL CÓDIGO ORIGINAL)
            // Actualmente solo muestra las unidades

            // Muestra las unidades disponibles en esa tienda
            echo "$filas->unidades";
            echo "</td>";
            echo"</tr>"; // Etiqueta de cierre extra que podría causar error HTML
        }
                                                                        
        
    echo "</tbody>";    
    echo "</table>";
    }
    //cerramos conexiones
    $conProyecto = null;
    ?>
    
</body>
</html>