
<!-- MOdiicacion del archivo, para podercredenciales del usuario se comprueben con la información de la nueva tabla "usuarios" creada en la base de datos "proyecto".
  Si no existe el usuario, o la contraseña es incorrecta, vuelve a pedir las credenciales al usuario. -->

 <?php
 // Si el usaurio no se ha didentificado, se le piden las credenciales
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic Realm="Contenido restringido"');
        header('HTTP/1.0 401 Unauthorized');
        echo "Usuario no reconocido!";
        exit;
    }

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

            </div>
        </div>
    </div>
</body>
</html>