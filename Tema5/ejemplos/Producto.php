<?php
class Producto extends Conexion
{
    private $id;
    private $nombre;
    private $nombre_corto;
    private $pvp;
    private $familia;
    private $descripcion;

    public function __construct()
    {
        
        parent::__construct();
    }

    // setters
    public function setId($i)
    {
        
        $this->id = $i;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setNombre_corto($nombre_corto)
    {
        $this->nombre_corto = $nombre_corto;
    }

    public function setPvp($pvp)
    {
        $this->pvp = $pvp;
    }

    public function setFamilia($familia)
    {
        $this->familia = $familia;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    // Métodos para hacer el CRUD
    // 1 - Create ---------
    function create()
    {
        $insert = "insert into productos(nombre, nombre_corto, pvp, familia, descripcion) values(:n, :nc, :p, :f, :d)";
        $stmt = $this->conexion->prepare($insert);

        try {
            
            $stmt->execute([
                ':n' => $this->nombre,
                ':nc' => $this->nombre_corto,
                ':p' => $this->pvp,
                ':f' => $this->familia,
                ':d' => $this->descripcion
            ]);
        } catch (PDOException $ex) {
           
            die("Ocurrio un error al insertar el producto: " . $ex->getMessage());
        }
    }

    // 2 - Read ------------
    function read()
    {
        $consulta = "select * from productos where id=:i";
        $stmt = $this->conexion->prepare($consulta);

        try {
           
            $stmt->execute([':i' => $this->id]);
        } catch (PDOException $ex) {
            die("Error al recuperar el producto: " . $ex->getMessage());
        }

       
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // 3 - Update
    function update()
    {
        $update = "update productos set nombre=:n, nombre_corto=:nc, pvp=:p, familia=:f, descripcion=:d where id=:i";
        $stmt = $this->conexion->prepare($update);

        try {
            
            $stmt->execute([
                ':i' => $this->id,
                ':n' => $this->nombre,
                ':nc' => $this->nombre_corto,
                ':p' => $this->pvp,
                ':f' => $this->familia,
                ':d' => $this->descripcion
            ]);
        } catch (PDOException $ex) {
            die("Ocurrio un error al actualizar el producto: " . $ex->getMessage());
        }
    }

    // 4 - Delete
    function delete()
    {
        $borrar = "delete from productos where id=:i";
        $stmt = $this->conexion->prepare($borrar);

        try {
            
            $stmt->execute([':i' => $this->id]);
        } catch (PDOException $ex) {
            die("Ocurrio un error al borrar el producto: " . $ex->getMessage());
        }
    }

    // Otros métodos de utilidad
    // 1 - recuperarProductos
    function recuperarProductos()
    {
        $consulta = "select * from productos order by nombre";
        $stmt = $this->conexion->prepare($consulta);

        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar productos: " . $ex->getMessage());
        }

        return $stmt;
    }

    // 2 - Para comprobar si el nombre_corto ya existe (tiene atributo unique)
    // Es diferente para el create y el update:
    // - En create: buscamos en todos los valores
    // - En update: buscamos en todos menos el producto actual
    function existeNombreCorto($nc)
    {
        // ERROR 9: Usas '=' en lugar de '==' o '==='
        // ERROR 10: La condición está invertida - id es null en create, tiene valor en update
        if ($this->id == null) {
            // Caso CREATE: no tenemos ID aún, comprobamos si existe el nombre_corto en toda la tabla
            $consulta = "select * from productos where nombre_corto=:nc";
        } else {
            // Caso UPDATE: tenemos ID, excluimos el producto actual de la comprobación
            $consulta = "select * from productos where nombre_corto = :nc AND id != :i";
        }

        $stmt = $this->conexion->prepare($consulta);

        try {
            if ($this->id == null) {
                $stmt->execute([':nc' => $nc]);
            } else {
                $stmt->execute([':nc' => $nc, ':i' => $this->id]);
            }
        } catch (PDOException $ex) {
            die("Error al comprobar el nombre corto: " . $ex->getMessage());
        }

        
        // rowCount() devuelve el número de filas encontradas
        if ($stmt->rowCount() == 0) {
            return false; // No existe
        }
        return true; // Existe
    }
}