<?php
// conexion.php
$host = 'localhost';
$dbname = 'proyecto';
$username = 'root';  
$password = 'Lucas2001';      

// Crear la conexión PDO
try {
    // Establecer la conexión
    $conProyecto = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar el modo de error de PDO a excepción
    $conProyecto->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Manejar error de conexión
    die("Error de conexión: " . $e->getMessage());
}
?>



<!-- 
    htmlspecialchars() es una función de PHP que convierte caracteres especiales de HTML en entidades seguras.
    Se usa para prevenir ataques XSS (Cross-Site Scripting). 
     
    Es algo más relacionado con el correcto manejo de la salida en HTML que con la seguridad de la base de datos.
    Por ejemplo, convierte caracteres como <, >, &, " y ' en sus equivalentes HTML (&lt;, &gt;, &amp;, &quot; y &#039; respectivamente).

    Prettier Usado para formatear el código fuente de manera consistente y legible.
    IA para  estilos

    lucas Alcobia
-->