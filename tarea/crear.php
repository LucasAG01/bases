<?php

require_once 'conexion.php';

$errores = [];
$datos =[
    'nombre' => '',
    'nombre_corto' => '',
    'descripcion' => '',
    'pvp' => '',
    'familia' => ''
];

// Obtener familias para el select

try{
    $sqlFamilias = "SELECT cod, nombre FROM familias ORDER BY nombre";
    $stmtFamilias = $conProyecto->query($sqlFamilias);
    $familias = $stmtFamilias->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener las familias: " . $e->getMessage());
}


// Procesar el formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar los datos del formulario
    $datos['nombre'] = trim($_POST['nombre']);
    $datos['nombre_corto'] = trim($_POST['nombre_corto']);
    $datos['descripcion'] = trim($_POST['descripcion']);
    $datos['pvp'] = trim($_POST['pvp']);
    $datos['familia'] = trim($_POST['familia']);

    // Validaciones básicas
    if (empty($datos['nombre'])) {
        $errores[] = "El nombre es obligatorio.";
    }
    if (empty($datos['nombre_corto'])) {
        $errores[] = "El nombre corto es obligatorio.";
    }
    if (!is_numeric($datos['pvp']) || $datos['pvp'] < 0) {
        $errores[] = "El PVP debe ser un número positivo.";
    }
    if (empty($datos['familia'])) {
        $errores[] = "La familia es obligatoria.";
    }

    // Si no hay errores, insertar el nuevo producto en la base de datos
    if (empty($errores)) {
        try {
            $sqlInsert = "INSERT INTO productos (nombre, nombre_corto, descripcion, pvp, familia) 
                          VALUES (?, ?, ?, ?, ?)";
            $stmtInsert = $conProyecto->prepare($sqlInsert);
            $stmtInsert->execute([
                $datos['nombre'],
                $datos['nombre_corto'],
                $datos['descripcion'],
                str_replace(',', '.', $datos['pvp']), 
                $datos['familia']
            ]);

            // Redirigir al listado con un mensaje de éxito
            header('Location: listado.php?mensaje=Producto creado correctamente');
            exit();

        } catch (PDOException $e) {
            // Manejar error de inserción 
            $errores[] = "Error al crear el producto: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <h1>Crear nuevo Producto</h1>

        <!-- Mostrar errores si existen   --> 
   <?php if (isset($errores['general'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($errores['general']); ?>
            </div>
   <?php endif; ?>




    <!-- Formulario de creación de producto,  -->

   <form action="crear.php" method="post">
    
    <!--> Campo Nombre  -->
   <div class="mb-3">
        <label for="nombre" class="form-label">Nombre completo *</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($datos['nombre']); ?>" required>
        <?php if (isset($errores['nombre'])): ?>
            <div class="error"><?php echo htmlspecialchars($errores['nombre']); ?></div>
        <?php endif; ?>
        <div class="form-text">Max 200 chars</div>
    </div>

            <!-- Campo Nombre corto  -->
    <div class="mb-3">
        <label for="nombre_corto" class="form-label">Nombre corto *</label>
        <input type="text" class="form-control" id="nombre_corto" name="nombre_corto" value="<?php echo htmlspecialchars($datos['nombre_corto']); ?>" required>
        <?php if (isset($errores['nombre_corto'])): ?>
            <div class="error"><?php echo htmlspecialchars($errores['nombre_corto']); ?></div>
        <?php endif; ?>
        <div class="form-text">Max 50 chars</div>
    </div>


    <!-- Campo Descripción  -->
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($datos['descripcion']); ?></textarea>
        <div class="form-text">Max 500 chars</div>
    </div>


    <!-- Campo PVP  -->
    <div class="mb-3">
        <label for="pvp" class="form-label">PVP *</label>
        <input type="text" class="form-control" id="pvp" name="pvp" value="<?php echo htmlspecialchars($datos['pvp']); ?>" required>
        <?php if (isset($errores['pvp'])): ?>
            <div class="error"><?php echo htmlspecialchars($errores['pvp']); ?></div>
        <?php endif; ?>
        <div class="form-text">Número positivo, usa punto o coma para decimales</div>
    </div>



    <!-- Campo Familia  -->
    <div class="mb-3">
        <label for="familia" class="form-label">Familia *</label>
        <select class="form-select" id="familia" name="familia" required>
            <option value="">Seleccione una familia</option>
            <?php foreach ($familias as $familia): ?>
                <option value="<?php echo htmlspecialchars($familia['cod']); ?>" <?php if ($datos['familia'] === $familia['cod']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($familia['nombre']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errores['familia'])): ?>
            <div class="error"><?php echo htmlspecialchars($errores['familia']); ?></div>
        <?php endif; ?>
    </div>


    <!-- Botones de acción  -->
    <div class="btn-container">
        <button type="submit" class="btn btn-primary">Crear Producto</button>
        <a href="listado.php" class="btn btn-secondary">Cancelar</a>
    </div>

    <!-- Nota sobre campos obligatorios  -->
    <div class="mt-3 text-muted">
        <small>* Campos obligatorios</small>
    </div>

   </form> <!-- Fin del formulario  -->

</div> <!-- Fin del contenedor del formulario  -->
    
</body>
</html>
