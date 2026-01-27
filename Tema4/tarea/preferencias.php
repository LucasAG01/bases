<!-- Permitirá al usuario escoger sus preferencias y las almacenará en la sesión del usuario. -->
<!--   Mostrará un cuadro desplegable por cada una de las preferencias. Estas serán:

    Idioma. El usuario podrá escoger un idioma entre "inglés" y "español".
    Perfil público. Sus posibles opciones será "sí" y "no".
    Zona horaria. Los valores en este caso estarán limitados a "GMT-2", "GMT-1", "GMT", "GMT+1" y "GMT+2".
   -->


<!-- Boton Establecer preferencias -> almacenará las preferencias en la sesión del usuario y volverá a cargar esta misma página, en la que se mostrará el texto "Preferencia de usuario guardadas" -->
<!-- Boton  Mostrar preferencias -> llevará a la página "mostrar.php" -->
<!-- Una vez establecidas las preferencias, deben aparecer seleccionadas como valores por defecto en los tres cuadros desplegables -->


<?php
// inicio de sesion para variables
session_start();

//mensajes de usuario
$mensaje = '';

// verificamos si se ha enviado el formulario, request dice como llegaron los datos y establecer verifica si se ha pulsado el boton
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['establecer'])) {

    // Guardar las preferencias en la sesión
    $_SESSION['preferencias'] = [
        'idioma' => $_POST['idioma'], // recogemos los datos del formulario
        'perfil_publico' => $_POST['perfil_publico'],
        'zona_horaria' => $_POST['zona_horaria']
    ];
        // Mensaje de confirmación 
    $mensaje = 'Preferencias de usuario guardadas.';
}


// cargar preferencias si existen
$preferencias = $_SESSION['preferencias'] ?? [
    'idioma' => 'español', // valor por defecto
    'perfil_publico' => 'sí',
    'zona_horaria' => 'GMT'
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="card" style="width: 500px; margin-top: 50px;">

                        <!--Cabecera tarjeta -->
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center mb-0"><i class="fas fa-cogs"></i> Preferencias Usuario</h3>
                </div>
                <!--cuerpo tarjeta -->
                <div class="card-body p-4">
                        <!-- Mostrar mensaje si no esta vacío -->
                    <?php if (!empty($mensaje)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?php echo $mensaje; ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>


                        <!-- Formulario principal, self envia a esta misma página,  -->
                    <form name="preferencias" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                        <!-- Idioma -->
                        <div class="form-group mb-4">
                            <label for="idioma" class="font-weight-bold">Idioma</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-language"></i>
                                    </span>
                                </div>
                                                    <!-- select con valor selccionado. si coincide, añade selected-->
                                <select name="idioma" id="idioma" class="form-control" required>
                                    <option value="inglés" <?php echo ($preferencias['idioma'] === 'inglés') ? 'selected' : ''; ?>>Inglés</option>
                                    <option value="español" <?php echo ($preferencias['idioma'] === 'español') ? 'selected' : ''; ?>>Español</option>
                                </select>
                            </div>
                        </div>


                        <!-- Perfil Público -->
                        <div class="form-group mb-4">
                            <label for="perfil_publico" class="font-weight-bold">Perfil Público</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-user-check"></i>
                                    </span>
                                </div>

                                <select name="perfil_publico" id="perfil_publico" class="form-control" required> <!-- comprobamos seleccion -->
                                    <option value="sí" <?php echo ($preferencias['perfil_publico'] === 'sí') ? 'selected' : ''; ?>>Sí</option>
                                    <option value="no" <?php echo ($preferencias['perfil_publico'] === 'no') ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                        </div>


                        <!-- Zona Horaria -->
                        <div class="form-group mb-4">
                            <label for="zona_horaria" class="font-weight-bold">Zona Horaria</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                </div>
                                    <!-- select con valor seleccionado. si coincide, añade selected -->
                                <select name="zona_horaria" id="zona_horaria" class="form-control" required>
                                    <option value="GMT-2" <?php echo ($preferencias['zona_horaria'] === 'GMT-2') ? 'selected' : ''; ?>>GMT-2</option>
                                    <option value="GMT-1" <?php echo ($preferencias['zona_horaria'] === 'GMT-1') ? 'selected' : ''; ?>>GMT-1</option>
                                    <option value="GMT" <?php echo ($preferencias['zona_horaria'] === 'GMT') ? 'selected' : ''; ?>>GMT</option>
                                    <option value="GMT+1" <?php echo ($preferencias['zona_horaria'] === 'GMT+1') ? 'selected' : ''; ?>>GMT+1</option>
                                    <option value="GMT+2" <?php echo ($preferencias['zona_horaria'] === 'GMT+2') ? 'selected' : ''; ?>>GMT+2</option>
                                </select>
                            </div>
                        </div>


                        <!-- Botones -->
                        <div class="form-group mt-5">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <!-- boton de envio que establece las preferencias -->
                                    <button type="submit" name="establecer" class="btn btn-primary btn-block py-2">
                                        <i class="fas fa-save mr-2"></i> Establecer Preferencias
                                    </button>
                                </div>

                                <!-- Enlace que redirige a mostrar.php, en este caso es un enlace -->
                                <div class="col-md-6">
                                    <a href="mostrar.php" class="btn btn-success btn-block py-2">
                                        <i class="fas fa-eye mr-2"></i> Mostrar Preferencias
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- card-body -->

            </div><!-- card -->
        </div>
    </div>

</body>

</html>