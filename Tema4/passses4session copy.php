
<!-- MOdiicacion del archivo, almacenando en la sesión de usuario los instantes de todas sus últimas visitas. Si es su primera visita, muestra un mensaje de bienvenida. En caso contrario, muestra la fecha y hora de todas sus visitas anteriores. Añade un botón a la página que permita borrar el registro de visitas.

Utiliza también una variable de sesión para comprobar si el usuario se ha autentificado correctamente. De esta forma no hará falta comprobar las credenciales con la base de datos constantemente.  -->

 <?php
 // Si el usaurio no se ha didentificado, se le piden las credenciales
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic Realm="Contenido restringido"');
        header('HTTP/1.0 401 Unauthorized');
        echo "Usuario no reconocido!";
        exit;
    }


    // GUardamos el usuario en variable sesion, si no existe es porque es la primera vez
    session_start();
    if(!isset($_SESSION['usuario'])){
        // Conecxion a la base de datos
        $host = 'localhost';
        $dbname = 'proyecto';
        $user = 'gestor';
        $pass = 'secreto';
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        // Crear la conexión
        try{
            $conProyecto = new PDO($dsn, $user, $pass);
            $conProyecto->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
        }
        catch (PDOException $ex){
            echo "Error de conexión a la base de datos: " . $ex->getMessage();
            exit;
        }


        // Hacemos la consulta
        $consulta = "select * from usuarios where usuario = :usuario and password = :password";

        $stmt = $conProyecto->prepare($consulta);
        $password = hash('sha256', $_SERVER['PHP_AUTH_PW']);

        try{
            // Ejecutamos la consulta
            $stmt->execute([
                ':usuario' => $_SERVER['PHP_AUTH_USER'],
                ':password' => $password
            ]);
        }
        catch (PDOException $ex){
            echo "Error en la consulta a la base de datos: " . $ex->getMessage();
            exit;
        }


        // Si no hay resultados, el usuario no es válido
        if ($stmt->rowCount() == 0) {
            header('WWW-Authenticate: Basic Realm="Contenido restringido"');
            header('HTTP/1.0 401 Unauthorized');
            echo "Usuario no reconocido!";
            $stmt = null;
            $conProyecto = null;
            exit;
        }

        $stmt = null;
        $conProyecto = null;

        //Si las credenciales fueron correctas creo la sesiosn del usaurio con el nombre

        $_SESSION['usuario'] = $_SERVER['PHP_AUTH_USER'];

    
    }
    else{ 
        // Si ya existe la variable de sesión usuario, es que ya se ha autentificado correctamente
        setlocale(LC_ALL, 'es_ES.UTF-8');
        date_default_timezone_set('Europe/Madrid');
        $ahora = new DateTime();
        $fecha = $ahora->format('d-m-Y H:i:s');

       // Comrpobamos si se ha enviado el formulario que limpioa las visitas
        if (isset($_POST['limpiar'])) {
            unset($_SESSION['visita']);
        } else {
            $_SESSION['visita'][] = $fecha;
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifj
h" crossorigin="anonymous">
    <title>Document</title>
</head>
<body style='background:gray'>
    <h3 class='text-center mt-3'>Directivas PHP_AUTH</h3>
    <div class='container my-3'>
        <div class='card text-white bg-primary mb-3 m-auto' style="max-width: 22rem;">
            <div class="card-header font-weight-bold text-center">PHP_AUTH</div>
            <div class="card-body" style='font-size: 1.2em'>

                <p class="card-text">PHP_AUTH_USER: <?php echo $_SERVER['PHP_AUTH_USER']; ?></p>
                <p class="card-text">PHP_AUTH_PW: <?php echo hash('sha256', $_SERVER['PHP_AUTH_PW']); ?></p>
                <p class="card-text">AUTH_TYPE: <?php echo $_SERVER['AUTH_TYPE']; ?></p>


                <?php
                if(isset($_SESSION['visita'])){
                    echo "<p class='text-success font-weight-bold mt-3'>Bienvenido, es tu primera Visita.</p>";
                }else{
                    echo "<p class='text-success font-weight-bold mt-3'>Bienvenido de nuevo, tus visitas anteriores fueron:</p>";
                    echo "<ul class='list-group'>";
                    foreach($_SESSION['visita'] as $k => $v){
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>$v</li>";
                    }
                    echo "</ul>";

                    // Formulario para limpiar las visitas
                    echo "<form method='post' class='mt-3'>
                            <button type='submit' name='limpiar' class='btn btn-danger btn-block'>Limpiar Registro de Visitas</button>
                          </form>";
                }
                ?>



                <!-- Bioton de limpieza -->
                <form name='vaciar' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                    <input type='submit' name="limpiar" value='Vaciar Registro de Visitas' class="btn btn-warning">
                </form>

            </div>
        </div>
    </div>
</body>
</html>