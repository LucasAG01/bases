<?php

require_once 'conexion.php';

// Inicializar variables para mensajes y datos del producto a borrar 
$mensaje = '';
$error = '';
$producto_id = '';
$nombre_producto = '';

// Procesar el formulario de borrado cuando se envía 
if( $_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id'])){
    $producto_id = $_POST['id'];


    try{
        //verificar que existew
        $sql_chewck ="SELECT id FROM productos WHERE id= ?";
        $stmt_check = $conProyecto->prepare($sql_chewck);
        $stmt_check->execute([$producto_id]);


        if($stmt_check->rowCount() > 0){
            //eliminar
            $sql_delete = "DELETE FROM productos WHERE id= ?";
            $stmt_delete = $conProyecto->prepare($sql_delete);
            $stmt_delete->execute([$producto_id]);

            $mensaje = "Producto '$nombre_producto' borrado correctamente";
            
        } else {
            // Producto no encontrado Asignado a error
           $error = "Producto no encontrado";
        }

    }catch (PDOException $e){
        // Manejar error de borrado
        $error = "Error al borrar el producto: " . $e->getMessage();
    }
    
}else{
    // Redirigir al listado si no se envió el formulario correctamente
    header('Location: listado.php');
    // Asegura que el script se detenga después de la redirección
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto Borrado</title>
</head>
<body>
<!-- echo htmlspecialchars corresponde a los valores de las variables -->
    <h1>Producto con ID <?php echo htmlspecialchars($producto_id); ?> borrado correctamente</h1>
    <a href="listado.php">Volver al listado</a>
</body>
</html>
