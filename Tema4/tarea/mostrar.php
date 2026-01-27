<!-- Muestra las preferencias del usuario almacenadas en la sesión. -->
<!-- Boton de establecer , lleva a preferencias.php -->
<!-- Boton de borrar preferencias, recarga la pagina mostrar.php y un texto
         de "preferencias de usuario borradas" y mostrar que estan borradas en los campos de preferencias -->
<!-- Si tratamso de borrar las preferncias y no hay almacenadas, mensaje de error "Debes fijar primero las preferencias" -->



<?php
session_start();

//Procesar solicitud post cuando se pulsa el boton borrar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrar'])) {
    // Si existen preferencias, las borramos y mostramos mensaje de exito
    if (isset($_SESSION['preferencias'])) {
        unset($_SESSION['preferencias']);
        $_SESSION['mensaje'] = "Preferencias de usuario borradas.";
        $_SESSION['tipo_mensaje'] = "success";
        // Si no existen preferencias, mostramos mensaje de error
    } else {
        $_SESSION['mensaje'] = "Debes fijar primero las preferencias.";
        $_SESSION['tipo_mensaje'] = "warning";
    }

    // Redirigir para evitar reenvío del formulario
    header("Location: mostrar.php");
    exit();
}



// Si existen mensajes en la sesión, los cargamos y los eliminamos de la sesión
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    $tipo_mensaje = $_SESSION['tipo_mensaje'];
    //Borrado de variables de sesion
    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo_mensaje']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>mostrar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <!--Cabecera tarjeta -->
                    <div class="card-header bg-info text-white">
                        <h3 class="text-center mb-0"><i class="fas fa-user"></i> Preferencias del Usuario</h3>
                    </div>

                    <!-- Cuerpo de la tarjeta -->
                    <div class="card-body">
                        <!-- Mostrar mensaje de confirmación o error (si existe) -->
                        <?php
                        if (isset($mensaje)):
                        ?>
                            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php
                        endif;
                        ?>
                        <!-- Mostrar preferencias si existen -->
                        <?php if (isset($_SESSION['preferencias'])): ?>

                            <div class="mb-4">
                                <h5>Preferencias almacenadas:</h5>

                                <!-- lista de preferencias -->
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>Idioma:</strong>
                                        <!--Dentro de preferencias el idioma-->
                                        <?php echo ($_SESSION['preferencias']['idioma'] == 'español') ? 'Español' : 'Inglés'; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Perfil público:</strong>
                                        <!--Dentro de preferencias el perfil-->
                                        <?php echo ($_SESSION['preferencias']['perfil_publico'] == 'si') ? 'Sí' : 'No'; ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Zona horaria:</strong>
                                        <!--Dentro de preferencias zona horaria-->
                                        <?php echo $_SESSION['preferencias']['zona_horaria']; ?>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <!--Si no hay preferencias almacenadas sale esto-->
                            <div class="alert alert-warning" role="alert">
                                No hay preferencias de usuario almacenadas.
                            </div>
                        <?php endif; ?>


                        <!-- Botones -->
                        <div class="mt-4">
                            <div class="row">
                                <!-- Botón para borrar preferencias (formulario POST) -->
                                <div class="col-md-6 mb-2">
                                    <!-- Formulario para borrar -->
                                    <form action="mostrar.php" method="post">
                                        <button type="submit" name="borrar" class="btn btn-danger btn-block">
                                            Borrar Preferencias
                                        </button>
                                    </form>
                                </div>
                                <!-- Botón para ir a la página de establecer preferencias -->
                                <div class="col-md-6">
                                    <a href="preferencias.php" class="btn btn-primary btn-block">
                                        Establecer Preferencias
                                    </a>
                                </div>
                            </div>
                        </div><!-- Fin botones -->
                    </div> <!-- Fin cuerpo tarjeta  -->
                </div> <!-- Fin tarjeta  -->
            </div> <!-- Fin columna  -->
        </div> ><!-- Fin fila  -->
    </div> <!-- Fin contenedor  -->
</body>

</html>