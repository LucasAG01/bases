<?php
namespace App;

use PDO;
use PDOException;

class Conexion{

    public static function getConexion(){
        $host = 'localhost';
        $db   = 'practicaUnidad5';
        $user = 'gestor';
        $pass='secreto';
        $charset = 'utf8mb4';

        $dsn="mysql:host=$host;dbname=$db;charset=$charset";

        try{
            $pdo = new PDO($dsn, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
        catch(PDOException $e){
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

    }
}