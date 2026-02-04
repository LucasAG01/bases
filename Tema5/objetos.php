<?php


//$conProyecto = new mysqli();
//$conProyecto->connect('localhost', 'gestor', 'secreto', 'proyecto');


// php4 introducen
// Los objetos se pasan por valor, no referencia
// Tods son publicos
// No hay interfaces
// No hay métodos destructores

// php5
// métodos estáticos
// métodos constructores y destrucortes
// herencia
// interfaces
// abstractas


// Herecia múlñtiple
// sobrecarga de métodos
// "" de operadores


//Creacion de clases

class Producto
{
    private $codigo;
    public $nombre;
    public $pvp;

    public function muestraCodigo()
    {
        echo "<p>" . $this->codigo . "<p>";
    }

    public function muestraNombre()
    {
        echo "<p>" . "Este es el nombre-> ".$this->nombre . "<p>";
    }
}


// Cada clase figura en su propio fichero.

$p = new Producto();

// Para que la linea anteirori se ejecute sin error, previamente debemos haber declarado la clase.
// En ese mismo fichero hay que incluir la clase

// require_once('producto.php');


// Para acceder desde un objeto a sus atributos o métodos, debes usar ->

$p->nombre = 'Samsung Galaxy A6'; //Asigne Producto p un nombre

$p->muestraNombre();


// Creación de clases

// 

class Objeto
{
    private $codigo;
   
    /*
    public function setCodigo($nuevo_codigo) {
    if (noExisteCodigo($nuevo_codigo)) {
        $this->codigo = $nuevo_codigo;
        return true;
    }
    return false;
    
}
    */
    public function getCodigo(){return $this->codigo;}

}




// Metodos mágicos
// __set y __get. Si se declaran estos dos métodos en una clase, 
// PHP los invoca automáticamente cuando desde un objeto se intenta usar un atributo no existente o no accesible.
// Por ejemplo, el código siguiente simula que la clase Producto tiene cualquier atributo que queramos usar.


class Producto1{
    private $atributos = array();

    public function __get($atributo)
    {
        return $this->atributos[$atributo];
    }

    public function __set($atributo, $valor)
    {
        $this->atributos[$atributo] = $valor;
    }
}



// Cuando un objeto se invoca, crea referencia al objeto que hizo la llamda.
// Se alamcena en la variable $this

// Dentro de la clase para acceder a sus métodos o atributos porpios usaremos $this->nombre
// salvo que el atributo o el método sea estático, 


class Persona{
    private $nombre;
    private $perfil;

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($n){
        $this->nombre=$n;
    }

    public function saludo(){
        // Fíhjate como hacemos referencia al método getNombre
        echo "Hola {$this->getNombre()}, Buenos días <br>";
    }
}

$persona1 = new Persona();
$persona1->setNombre("Lucas");
$persona1->saludo();



// Una clase también puede tener constantes, para acceder a ella hay que hacerlo así.

class DB{
    const USUARIO = 'gestor';
}

echo DB::USUARIO;

// No es necesario que exista ningún objeto de una clase para poder acceder al avlor de las constantes
// NO se confunde con métodos estáticos.

class ProductoEstatico{
    private static $num_productos =0;
    public static function nuevoProducto(){
        self::$num_productos++;
    }

    public static function getNumProductos(){
        return self::$num_productos;
    }
}

// No puden ser llamdos desde un objeto usando ->, se accede desde el nombre de la clase
// y el operador de resolución

ProductoEstatico::nuevoProducto();

// Si es privado ocmo $num_productos, solo podrá acceder a él desde los métodos de la propia clase
// usadno la palabra self. De la misma forma que this hace ref al objeto, self hace ref a la clase

ProductoEstatico::nuevoProducto(); //incremneta en 1
echo ProductoEstatico::getNumProductos(); // muestra 1

// Los estaticos se usan para guardar información de la misma.
// suelen realizar tarea específica o devolver objeto concreto.
// Clases matemáticas suelen tener métodos estáticos para realziar raices cuadradas.
// No creamos objetos para realizar operaciones

// Los métodos estáticos se llaman desde la clase. No es posible llamarlos desde un objeto y por tanto, no podemos usar $this dentro de un método estático. 



// Métodos contructores

class PersonaGameOtro{
    public static $id;
    private $nombre;
    private $perfil;
    public function __construct(){
        $perfil="Público";
    }
}
//creamos persona1 que tiene inicializado su atributo $perfil a Público.
$persona1=new Persona();
// Podemos comprobarlo
var_dump($persona1);
echo "<br>";



class PersonaGame{
    public static $id;
    private $nombre;
    private $plataforma;

    public function __construct($n, $p)
    {
        $this->nombre = $n;
        $this->plataforma = $p;
    }

}

// Creamos un objeto de la clase PersonaGame e inicializamos sus atributos;
// Fíjate que ya NO podremos user: $perosna1=New Persona(); ya que el constructor espera dos parámetros.
$persona3 = new PersonaGame("Persona3Portable","PSP");

//Comprobacion
//var_dump($persona3);


//Métodos _destruct define accione que se ejecutarán cuando se leimine el objeto.
class Coche{
    private static $num_coches =0;
    private $codigo;
    public function __construct($codigo)
    {
        $this->$codigo = $codigo;
        self::$num_coches++;
    }

    public function __destruct()
    {
        self::$num_coches--;
    }
}
$co = new Coche('CHV');






//Uso de Objetos
/*
public function precioProducto (Producto $p):float{
    return $precio;
}
*/


//funcion toString

class Alumno{
    public $nombre;
    public $apellidos;
    public $perfil;

    public function __toString(): String
    {
        return "{$this->apellidos}, {$this->nombre}, Tu perfil es: {$this->perfil}";
    }
}

$alumno1 = new Alumno();
$alumno1->nombre="Lucas";
$alumno1->apellidos="Alcobia";
$alumno1->perfil="Público";
echo $alumno1; // muestra Alcobia, Lucas, Tu perfil es: Público
echo "<br>";


//Serialize

/*La función serialize() en PHP convierte un valor (generalmente un objeto o array)
  en una representación de cadena de texto (string) que puede ser almacenada o transmitida,
  para luego reconstruirse con unserialize().
*/

$serializado = serialize($alumno1);
echo $serializado;
// O:6:"Alumno":3:{s:6:"nombre";s:5:"Lucas";s:9:"apellidos";s:7:"Alcobia";s:6:"perfil";s:8:"Público";}


// Almacenar en sesión
$_SESSION['usuario'] = $serializado;

// Recuperar después
$usuario_recuperado = unserialize($serializado);
echo $usuario_recuperado->nombre; // Lucas








// herencia

// Definir nuevas clases basadas en otra ya existente
/*
class Animal {
    public $codigo;
    public $nombre;
    public $nombre_corto;
    public $pvp;

    public function muetra(){
        echo "<p>". $this->codigo. "</p>";
    }
}

class Perro extends Animal{
    public $raza;
    public $Pienso;
}

$perro1 = new Perro();
*/
//Si a la funciuon le ponemos final anyes de function, no se transferirra a las herencias

// Abstract obloga a que solo se pueda heredar, si Animal fuese abrastacto, no podria hacer un new Animal(), solo podria haber perros



//Más herecia.
// Vamos a hacer una pequeña modificación en nuestra clase Producto.
// Para facilitar la creación de nuevos objetos,
// crearemos un constructor al que se le pasará un array con los valores de los atributos del nuevo producto.

class Animal{
    public $codigo;
    public $nombre;
    public $nombre_corto;
    public $pvp;

    public function __construct($row) {
        $this->codigo = $row['cod'];
        $this->nombre = $row['nombre'];
        $this->nombre_corto = $row['nombre_corto'];
        $this->pvp = $row['pvp'];
    }
    public function muestra() {
        echo "<p>" . $this->codigo . "</p>";
    }
}


//Apuntes herncia en el ONENOTE


//INterfaces
// deben ser publicas los metdos pueden tener consts pero no atributos.
// Es una clase vacia que solo contiene declaraciones de métodos.
// Se definen usando la palabra interface

//Asegurar quer todos los Animales tengan un metodo muestra
interface iMuestra {
    public function muestra();
}

// Cuando cree un una sublase, debo añadir el implemets

class Gato extends Animal implements iMuestra{
    public $pate;
    private $pipeta;
    public function muestra(){
        echo "<p>". $this->pate. "pate</p>";
    }
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
    
</body>
</html>


