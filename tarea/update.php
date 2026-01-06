<?php
// editar.php
require_once 'conexion.php';

$errores = [];
$datos = [];
$id = 0;

// Verificar que se ha recibido el ID por GET
if (!isset($_GET['id'])) {
    header('Location: listado.php');
    exit();
}

$id = intval($_GET['id']);

// Obtener las familias para el select
try {
    $sqlFamilias = "SELECT cod, nombre FROM familias ORDER BY nombre";
    $stmtFamilias = $conProyecto->query($sqlFamilias);
    $familias = $stmtFamilias->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener las familias: " . $e->getMessage());
}

// Cargar datos del producto actual
try {
    $sqlProducto = "SELECT * FROM productos WHERE id = ?";
    $stmtProducto = $conProyecto->prepare($sqlProducto);
    $stmtProducto->execute([$id]);
    $productoActual = $stmtProducto->fetch(PDO::FETCH_ASSOC);
    
    if (!$productoActual) {
        header('Location: listado.php?error=Producto no encontrado');
        exit();
    }
    
    // Inicializar $datos con los valores actuales
    $datos = $productoActual;
    
} catch (PDOException $e) {
    header('Location: listado.php?error=Error al cargar el producto');
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar los datos del formulario
    $datos['nombre'] = trim($_POST['nombre'] ?? '');
    $datos['nombre_corto'] = trim($_POST['nombre_corto'] ?? '');
    $datos['descripcion'] = trim($_POST['descripcion'] ?? '');
    $datos['pvp'] = trim($_POST['pvp'] ?? '');
    $datos['familia'] = $_POST['familia'] ?? '';
    
    // Validaciones básicas
    if (empty($datos['nombre'])) {
        $errores['nombre'] = "El nombre es obligatorio.";
    }
    if (empty($datos['nombre_corto'])) {
        $errores['nombre_corto'] = "El nombre corto es obligatorio.";
    }
    if (!is_numeric($datos['pvp']) || $datos['pvp'] < 0) {
        $errores['pvp'] = "El PVP debe ser un número positivo.";
    }
    if (empty($datos['familia'])) {
        $errores['familia'] = "La familia es obligatoria.";
    }

    // Si no hay errores, actualizar el producto en la base de datos
    if (empty($errores)) {
        try {
            // Verificar si el nombre_corto ya existe (excepto para el producto actual)
            $sqlCheck = "SELECT id FROM productos WHERE nombre_corto = ? AND id != ?";
            $stmtCheck = $conProyecto->prepare($sqlCheck);
            $stmtCheck->execute([$datos['nombre_corto'], $id]);
            
            if ($stmtCheck->rowCount() > 0) {
                $errores['nombre_corto'] = 'El nombre corto ya existe. Por favor, elige otro.';
            } else {
                // Actualizar el producto
                $sqlUpdate = "UPDATE productos 
                             SET nombre = ?, nombre_corto = ?, descripcion = ?, 
                                 pvp = ?, familia = ? WHERE id = ?";
                $stmtUpdate = $conProyecto->prepare($sqlUpdate);
                
                $stmtUpdate->execute([
                    $datos['nombre'],
                    $datos['nombre_corto'],
                    $datos['descripcion'],
                    str_replace(',', '.', $datos['pvp']),
                    $datos['familia'],
                    $id
                ]);
                
                // Redirigir al listado con mensaje de éxito
                header('Location: listado.php?mensaje=Producto actualizado correctamente');
                exit();
            }
            
        } catch (PDOException $e) {
            $errores['general'] = 'Error al actualizar el producto: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0d6efd; 
            margin-bottom: 30px; 
            text-align: center;
        }
        .form-label {
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
        }
        .btn-container {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Editar Producto</h1>

    <!-- Mostrar errores generales si existen -->
    <?php if (isset($errores['general'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($errores['general']); ?>
        </div>
    <?php endif; ?>

    <!-- Formulario de edición de producto -->
    <form action="editar.php?id=<?php echo $id; ?>" method="post">
        
        <!-- Campo Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo *</label>
            <input type="text" 
                   class="form-control <?php echo isset($errores['nombre']) ? 'is-invalid' : ''; ?>" 
                   id="nombre" 
                   name="nombre" 
                   value="<?php echo htmlspecialchars($datos['nombre']); ?>" 
                   required>
            <?php if (isset($errores['nombre'])): ?>
                <div class="error"><?php echo htmlspecialchars($errores['nombre']); ?></div>
            <?php endif; ?>
            <div class="form-text">Max 200 chars</div>
        </div>

        <!-- Campo Nombre corto -->
        <div class="mb-3">
            <label for="nombre_corto" class="form-label">Nombre corto *</label>
            <input type="text" 
                   class="form-control <?php echo isset($errores['nombre_corto']) ? 'is-invalid' : ''; ?>" 
                   id="nombre_corto" 
                   name="nombre_corto" 
                   value="<?php echo htmlspecialchars($datos['nombre_corto']); ?>" 
                   required>
            <?php if (isset($errores['nombre_corto'])): ?>
                <div class="error"><?php echo htmlspecialchars($errores['nombre_corto']); ?></div>
            <?php endif; ?>
            <div class="form-text">Max 50 chars</div>
        </div>

        <!-- Campo Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" 
                      id="descripcion" 
                      name="descripcion" 
                      rows="4"><?php echo htmlspecialchars($datos['descripcion']); ?></textarea>
            <div class="form-text">Max 500 chars</div>
        </div>

        <!-- Campo PVP -->
        <div class="mb-3">
            <label for="pvp" class="form-label">PVP *</label>
            <input type="text" 
                   class="form-control <?php echo isset($errores['pvp']) ? 'is-invalid' : ''; ?>" 
                   id="pvp" 
                   name="pvp" 
                   value="<?php echo htmlspecialchars($datos['pvp']); ?>" 
                   required>
            <?php if (isset($errores['pvp'])): ?>
                <div class="error"><?php echo htmlspecialchars($errores['pvp']); ?></div>
            <?php endif; ?>
            <div class="form-text">Número positivo, usa punto o coma para decimales</div>
        </div>

        <!-- Campo Familia -->
        <div class="mb-4">
            <label for="familia" class="form-label">Familia *</label>
            <select class="form-select <?php echo isset($errores['familia']) ? 'is-invalid' : ''; ?>" 
                    id="familia" 
                    name="familia" 
                    required>
                <option value="">Seleccione una familia</option>
                <?php foreach ($familias as $familia): ?>
                    <option value="<?php echo htmlspecialchars($familia['cod']); ?>" 
                        <?php echo ($datos['familia'] == $familia['cod']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($familia['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['familia'])): ?>
                <div class="error"><?php echo htmlspecialchars($errores['familia']); ?></div>
            <?php endif; ?>
        </div>

        <!-- Botones de acción -->
        <div class="btn-container">
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            <a href="listado.php" class="btn btn-secondary">Cancelar</a>
        </div>

        <!-- Nota sobre campos obligatorios -->
        <div class="mt-3 text-muted">
            <small>* Campos obligatorios</small>
        </div>

    </form> <!-- Fin del formulario -->

</div> <!-- Fin del contenedor del formulario -->
    
</body>
</html>