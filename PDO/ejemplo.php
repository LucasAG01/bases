<?php
$host = "localhost";
$db = "proyecto";
$user = "root";
$pass = "Lucas2001";
$dsn = "mysql::host=$host;dbname=$db;charset=utf8mb4";
$conProyecto = new PDO($dsn,$user,$pass);
$conProyecto ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    //Definimos la variable para comprobar ejecución
    $isOk = true;
    //Iniciamos la transacción
    $conProyecto->beginTransaction();

    $update ="update stocks set unidades=1 where producto=(select id from productos where nombre_corto='PAPYRE62GB') and tienda=1";

    if(!$conProyecto->exec($update)) $isOk=false;


    $insert = "insert into stocks select id, 2, 1 from productos where nombre_corto='PAPYRRE62GB'"; //es queivalente a insert into stocks values(15, 2, 1)

    if(!$conProyecto->exec($insert)) $isOk=false;


    //SI fue bien , confirmamos los cambios 
    //y caso contrario los desacemos

    if($isOK){
        $conProyecto ->commit();
        echo "<p>Los cambios se realizaron correctamente.</p>";
    }else{
        $conProyecto->rollBack();
        echo "<p>No se ehan podido realizar los cambios.</p>";
    }
    //Cerramos la conexion.
    $conProyecto = null;

?>
</body>
</html>