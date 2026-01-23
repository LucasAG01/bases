<!-- Presenta un listado de los productos de la tienda, y permite al usuario seleccionar aquellos que va a comprar.-->

<!--_SESSION['nombre'], la que creamos al hacer el login, si no es así volvemos a "login.php" -->

<?php
session_start();

if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit;
}

//Esto es para obtener los productos de la base de datos
require_once 'conexion.php';

$consulta = "select id, nombre, pvp from productos order by nombre";
$stmt = $conexion->prepare($consulta);

try {
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    cerrarTodo($conexion, $stmt);
    die("Error al ejecutar la consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cesta</title>
</head>
<?php 
    if (isset($_POST['vaciar'])) {
        unset($_SESSION['cesta']);
    }
    if (isset($_POST['comprar'])) {
    $datos = consultarProducto($_POST['id']);
    $_SESSION['cesta'][$datos->id] = $datos->id;
    
    }
?>




<body>

        <div class="float float-right d-inline-flex mt-2">
            <i class="fa fa-shopping-cart mr-2 fa-2x"></i>
            <?php
            if(isset($_SESSION['cesta'])){
                $numProductos = count($_SESSION['cesta']);
                echo "<span class='badge badge-pill badge-danger align-self-center'>$numProductos</span>";
            } else {
                echo "<span class='badge badge-pill badge-danger align-self-center'>0</span>";
            }
            ?>


            <i class="fas fa-user mr-3 fa-2x"></i>
            <input type="text" size="10px" value="<?php echo $_SESSION['nombre']; ?>" class="form-control mr-2 bg-transparent text-white" disabled>
            <a href="cerrar.php" class="btn btn-danger align-self-center">Logout</a>
        </div>


    <!-- Botones  -->

    <form method="POST" class="form-inline" name="vaciar" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <a href="cesta.php" class="btn btn-success mr-2">Ir a Cesta</a>
        <input type="submit" name="vaciar" value="Vaciar Cesta" class="btn btn-warning">
    </form>

    <?php

    if(isset($_POST['vaciar'])){
        unset($_SESSION['cesta']);
    }


    while($filas = $stmt->fetch(PDO::FETCH_OBJ)){

    echo "<tr><th scope='row' class='text-center'>";
    echo "<form action = '{$_SERVER['PHP_SELF']}' method='POST'>";
    echo "<input type='hidden' name='id' value='{$filas->id}'>";
    echo "<input type='submit' name='comprar' value='Añadir' class='btn btn-primary>";
    echo "</form>";

    echo "</th>";
    echo "<td>{$filas->nombre}, Precio: {$filas->pvp} (€)</td>";
    
    echo "<td class='text-center'>";
    if (isset($_SESSION['cesta'][$filas->id])) {
        echo "<span class='badge badge-success'>En Cesta</span>";
    } else {
        echo "<span class='badge badge-secondary'>No en Cesta</span>";
    }
    echo "</td></tr>";

    } //while

    ?>
    
</body>
</html>