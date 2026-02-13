<?php
/*
Implementa la clase "Usuario" que contendrá los atributos de la tabla usuario.
Tiene el método "isValido($usu, $pass)" que devolverá true si encuentra a un usuario con esa contraseña y false en otro caso.
*/ 

class Usuario extends Conexion
{
    private $usuario;
    private $pass;

    public function __construct()
    {
        parent::__construct();  // CORREGIDO: quitado el return
    }

    public function isValido($u, $p)
    {
        $pass1 = hash('sha256', $p);  // CORREGIDO: bien definida la variable
        
        $consulta = "select * from usuarios where usuario=:u AND pass=:p";
        $stmt = $this->conexion->prepare($consulta);
        
        try {
            // CORREGIDO: array con los valores y usando '=>' en lugar de '->'
            $stmt->execute([
                ':u' => $u,
                ':p' => $pass1  // CORREGIDO: usando $pass1 (el hash) en lugar de $p
            ]);
        } catch (PDOException $ex) {
            die("Error al consultar usuario: " . $ex->getMessage());
        }
        
        // CORREGIDO: comparación correcta con '=='
        if ($stmt->rowCount() == 0) {
            return false;  // No existe el usuario
        }
        return true;  // Usuario válido
    }
}