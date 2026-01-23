<!--autentificar al usuario de la aplicación web.
 Todos los usuarios de la aplicación deberán autentificarse utilizando esta página antes de poder acceder al resto de páginas.
  -->

<?php
session_start();
require_once 'conexion.php';
function error($mensaje)
{
    $_SESSION['error'] = $mensaje;
    header("Location: login.php");
    exit;
}
?>



<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body style="background: silver;">

    <?php
    if (isset($_POST['login'])) {
        $nombre = trim($_POST['usuario']);
        $pass = trim($_POST['pass']);
        if (strlen($nombre) == 0 || strlen($pass) == 0) {
            error("Debe introducir un nombre de usuario y una contraseña");
        }


        // Creamos el sha256 de la contraseña
        $pass_sha256 = hash("sha256", $pass);
        // Preparamos la consulta
        $consulta  = "SELECT * FROM usuarios WHERE usuario = :usuario AND pass = :pass";
        $stmt = $conexion->prepare($consulta);
        try {
            $stmt->execute([
                ':usuario' => $nombre,
                ':pass' => $pass_sha256
            ]);
        } catch (PDOException $e) {
            cerrarTodo($conexion, $stmt);
            error("Error al ejecutar la consulta: " . $e->getMessage());
        }

        if ($stmt->rowCount() == 0) {
            unset($_POST['login']);
            cerrarTodo($conProyecto, $stmt);
            error("Error, Nombre de usuario o password incorrecto");
        }

        cerrarTodo($conexion, $stmt);


        // Nos hemos validado correctamente creamos la sesion de usuario con el nombre de usuario
        $_SESSION['usuario'] = $nombre;
        // Redirigimos a la página principal
        header('Location:listado.php');
    } else {
    ?>
        <div class="container mt-5">
            <div class="d-flex justify-content-center h-100">
                <div class="card" style="width: 400px; margin-top: 50px;">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center mb-0"><i class="fas fa-sign-in-alt"></i> Login</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <form name="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <!-- Bloque Usuario -->
                            <div class="input-group form-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="usuario" placeholder="Usuario" required autofocus>
                            </div>

                            <!-- Bloque Contraseña -->
                            <div class="input-group form-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="form-control" name="pass" placeholder="Contraseña" required>
                            </div>

                            <!-- Bloque Boton de login -->
                            <div class="form-group">
                                <button type="submit" name="login" class="btn btn-primary btn-block py-2" style="font-size: 1.1rem;">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='mt-3 text-danger font-weight-bold text-lg'>";
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        echo "</div>";
    }
    ?> <!--fin del else-->
</body>

</html> 