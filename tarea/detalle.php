<?php
require_once 'conexion.php';

// Verificar que se ha proporcionado un ID de producto
if (!isset($_GET['id'])) {
    header('Location: listado.php');
    exit();
}

// 
$id = intval($_GET['id']);


// Obtener los detalles del producto desde la base de datos
try{
    $sql = "SELECT p.*, f.nombre as familia_nombre 
            FROM productos p 
            JOIN familias f ON p.familia = f.cod 
            WHERE p.id = ?";

    $stmt = $conProyecto->prepare($sql);
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$producto) {
        header('Location: listado.php');
        exit();
    }
}catch (PDOException $e){
    header('Location: listado.php?error=Error en la consulta');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .detalle-card {
            max-width: 600px;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: none;
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
        .detalle-item {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        .detalle-item:last-child {
            border-bottom: none;
        }
        .detalle-label {
            font-weight: bold;
            color: #495057;
            min-width: 150px;
        }
        .detalle-value {
            color: #212529;
        }
        .btn-volver {
            margin-top: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Detalles del Producto -->
    <div class="detalle-card card">

        <!-- Encabezado de la tarjeta -->
        <div class="card-header text-center">
            <h2 class="mb-0">Detalles del Producto</h2>
        </div>
        

        <!-- Cuerpo de la tarjeta -->
        <div class="card-body">
            <!-- ID del Producto -->
            <div class="detalle-item d-flex">
                <span class="detalle-label">ID:</span>
                <span class="detalle-value"><?php echo htmlspecialchars($producto['id']); ?></span>
            </div>
            
            <!-- Nombre Corto -->
            <div class="detalle-item d-flex">
                <span class="detalle-label">Nombre Corto:</span>
                <span class="detalle-value"><?php echo htmlspecialchars($producto['nombre_corto']); ?></span>
            </div>
            
            <!-- Nombre Completo -->
            <div class="detalle-item d-flex">
                <span class="detalle-label">Nombre Completo:</span>
                <span class="detalle-value"><?php echo htmlspecialchars($producto['nombre']); ?></span>
            </div>
            
            <!-- descripcion -->
            <div class="detalle-item">
                <div class="detalle-label mb-2">Descripción:</div>
                <div class="detalle-value">
                    <?php 
                    if (!empty($producto['descripcion'])) {
                        echo nl2br(htmlspecialchars($producto['descripcion']));
                    } else {
                        echo '<span class="text-muted">Sin descripción</span>';
                    }
                    ?>
                </div>
            </div>
            
            <!-- precio -->
            <div class="detalle-item d-flex">
                <span class="detalle-label">PVP:</span>
                <span class="detalle-value"><?php echo number_format($producto['pvp'], 2) . ' €'; ?></span>
            </div>
            
            <!-- Familia -->
            <div class="detalle-item d-flex">
                <span class="detalle-label">Familia:</span>
                <span class="detalle-value"><?php echo htmlspecialchars($producto['familia_nombre']); ?></span>
            </div>
            
            <!-- codigo de Familia -->
            <div class="detalle-item d-flex">
                <span class="detalle-label">Código Familia:</span>
                <span class="detalle-value"><?php echo htmlspecialchars($producto['familia']); ?></span>
            </div>
            
            <!-- volver-->
            <div class="mt-4">
                <a href="listado.php" class="btn btn-secondary btn-volver">
                    ← Volver al Listado
                </a>
            </div>
        </div>

        
    </div>
</body>
</html>