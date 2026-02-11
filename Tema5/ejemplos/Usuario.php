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
        return parent::__construct();
    }

    public function isValido($u, $p)
    {
        $pass1 =
            hash('sha256', $p);
        $consulta = "select * from usuarios where usuario=:u AND pass=:p";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute([
                /*
                ':u'->$u,
                ':p'->$pass1
                */
            ]);
        } catch (PDOException $ex) {
            die("Error al consultar usuario: " . $ex->getMessage());
        }
        if ($stmt->rowCount() == 0) return false;
        return true;
    }
}
