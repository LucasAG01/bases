<!--autentificar al usuario de la aplicación web.
 Todos los usuarios de la aplicación deberán autentificarse utilizando esta página antes de poder acceder al resto de páginas.
  -->

<?php
session_start();
require_once 'conexion.php';
function error($mensaje){
    $_SESSION['error'] = $mensaje;
    header("Location: login.php");
    exit;
}
?>
s


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
            if(isset($_POST['login'])){
                $nombre = trim($_POST['usuario']);
                $pass = trim($_POST['pass']);
                if(strlen($nombre) == 0 || strlen($pass) == 0){
                    error("Debe introducir un nombre de usuario y una contraseña");
                }


                // Creamos el sha256 de la contraseña
                $pass_sha256 = hash("sha256", $pass);
                // Preparamos la consulta
                $consulta  = "select * from usuarios where nombre = :nombre and pass = :pass";
                $stmt = $conexion->prepare($consulta);
                try{
                    $stmt->execute([
                        ':nombre' => $nombre,
                        ':pass' => $pass_sha256
                    ]);
                }
                catch(PDOException $e){
                    cerrarTodo($conProyecto, $stmt);
                    error("Error al ejecutar la consulta: " . $e->getMessage());
                }
                
                if($stmt->rowCount() == 0){
                    unset($_POST['login']);
                    cerrarTodo($conProyecto, $stmt);
                    error("Error, Nombre de usuario o password incorrecto");
                }

                cerrarTodo($conexion, $stmt);


                // Nos hemos validado correctamente creamos la sesion de usuario con el nombre de usuario
                $_SESSION['usuario'] = $nombre;
                // Redirigimos a la página principal
                header("Location: index.php");

            
            }else{}
            
?>
        <div class="container mt-5">

            
                    
        



    </body>
</html>
