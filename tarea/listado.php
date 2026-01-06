<?php
require_once 'conexion.php';

// Mensajes de éxito o error 
$mensaje = '';
$error = '';

// Obtener mensajes de la URL si existen
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
}

// Obtener la lista de productos con sus familias
$sql = "SELECT p.id, p.nombre, p.nombre_corto, p.pvp, f.nombre as familia_nombre 
        FROM productos p 
        JOIN familias f ON p.familia = f.cod 
        ORDER BY p.id";

// Ejecutar la consulta y obtener los productos
$stmt = $conProyecto->query($sql);
// Obtener todos los productos como un array asociativo
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>listado lucasAlcobia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin: 20px auto;
            max-width: 1200px;
            padding: 20px;
        }
        .actions {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <!-- Mostrar mensajes de éxito o error si existen -->
    <div class="table-container">
        <h1 class="mb-4">Listado de Productos</h1>

        <!--Botyon crear producto-->
        <div class="mb-3">
            <a href="crear.php" class="btn btn-success">
            <i>+</i> Nuevo Producto
            </a>
        </div>

<!-- ************************Si hay productods  -->
        <?php
        if (count($productos) > 0): 
        ?>

            <table class="table table-striped">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Nombre Corto</th>
                        <th>PVP</th>
                        <th>Familia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre_corto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['pvp']); ?></td>
                            <td><?php echo htmlspecialchars($producto['familia_nombre']); ?></td>
                            <td class="actions">
                                <!-- Botones de acción: Editar, Borrar, Ver Detalles -->
                                <a href="editar.php?id=<?php echo $producto['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                <!-- Formulario para borrar el producto  -->
                                <form action="borrar.php" method="POST" style="display: inline;">
                                    <!-- Campo oculto con el ID del producto  -->
                                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                    <!-- Botón de borrar con confirmación  -->
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirm('¿Estás seguro de borrar el producto <?php echo addslashes($producto['nombre']); ?>?')">Borrar
                                    </button>
                                </form>
                                <!-- Enlace para ver detalles del producto  -->
                                <a href="detalle.php?id=<?php echo $producto['id']; ?>" class="btn btn-info btn-sm"> Ver</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
<!-- ************************Si NO  hay productods  -->                 
       <?php else: ?>
            <div class="alert alert-info">
            <p>No hay productos registrados.</p>
            <a href="crear.php"> Crea  El primero</a>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>