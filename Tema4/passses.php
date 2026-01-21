
<!--//Usar funcion header para solicitar autenticacion, envía un Acceso no autorizado 401, 


if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic Realm="Contenido restringido"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Usuario no reconocido!";
    exit;
}
?>
-->
<!-- En este caso aabjo, es para verificar que si el usaurio no es getsor y la contraseña secreto, que salte el acceso denegado 
 Primero haremos aqui la funcion de pedir() datos luego deabjo del html tag, creeamos los parametros esos
 
php
if ($_SERVER['PHP_AUTH_USER']!='gestor' || $_SERVER['PHP_AUTH_PW']!='secreto') {
    header('WWW-Authenticate: Basic Realm="Contenido restringido"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Usuario no reconocido!";
    exit;
}
?>
 -->

<?php
function pedir(){
    header('WWW-Authenticate: Basic Realm="Contenido Protegido"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Datos Incorrectos o Usuario NO reconocido!!!";
die();
}

?>


<!DOCTYPE html>
<html lang="en">


<?php
if(!isset($_SERVER['PHP_AUTH_USER'])){
    pedir();
}else{
    if(($_SERVER['PHP_AUTH_USER']!='gestor') || ($_SERVER['PHP_AUTH_PW']!='secreto')){
        pedir();
    }
}

?>


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
                <p class="card-text">PHP_AUTH_PW: <?php echo $_SERVER['PHP_AUTH_PW']; ?></p>
                <p class="card-text">AUTH_TYPE: <?php echo $_SERVER['AUTH_TYPE']; ?></p>

            </div>
        </div>
    </div>
</body>
</html>