<?php
/*
 Implementa la clase "Famila" que contendrá los atributos de la tabla usuario.
 Tiene el método "recuperarFamilias()" que usaremos para rellenar los "options" para la lista desplegable del campo familia en crear y actualizar productos,
 este método devuelve el "$stmt".
*/ 


class Familia extends Conexion{

private $cod;
private $nombre;

public function __construct()
{
    return parent::__construct();
}

public function recuperarFamilias(){
    $consulta="select * from familias order by nombre";
    $stmt=$this->conexion->prepare($consulta);

    try{
        $stmt->execute();
    }catch(PDOException $ex){
        die("Error al recuperar: ".$ex->getMessage());
    }
    return $stmt;
}



}