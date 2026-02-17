<?php
session_start();

if (isset($_POST['guardar'])) {   
    $_SESSION['idioma'] = $_POST['idioma'];
    $_SESSION['perfil'] = $_POST['perfil'];
    $_SESSION['zona'] = $_POST['zona'];
    $mensaje = "Preferencias de usuario guardadas";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
if(isset($mensaje)){
    echo "<p>$mensaje</p>";
}
?>

    <form name="preferencias" method="post">

        <label for="">Idioma</label>
        <select name="idioma" id="idioma">
            <option value="ingles" <?php if (isset($_SESSION['idioma']) && $_SESSION['idioma'] == 'ingles') echo 'selected'; ?>>Inglés</option>
            
            <option value="español" <?php if (isset($_SESSION['idioma']) && $_SESSION['idioma'] == 'español') echo 'selected'; ?>>Español</option>
        </select>

        <br><br>

        <label for="">Perfil público</label>
        <select name="perfil">
            <option value="si"
            <?php if(isset($_SESSION['perfil']) && $_SESSION['perfil']=="si") echo "selected"; ?>>
            Sí
            </option>

            <option value="no"
            <?php if(isset($_SESSION['perfil']) && $_SESSION['perfil']=="no") echo "selected"; ?>>
            No
            </option>
        </select>

        <br><br>

        <label for="">Zona horaria</label>
        <select name="zona" id="zona">
            <option value="GMT-2">GMT-2</option>
            <option value="GMT-1">GMT-1</option>
            <option value="GMT">GMT</option>
            <option value="GMT+1">GMT+1</option>
            <option value="GMT+2">GMT+2</option>
        </select>

        <br><br>

        <button type="submit" name="guardar">Guardar preferencias</button>

    </form>


    <a href="mostrar.php">Mostrar preferencias</a>
    
</body>
</html>