<?php

$db_server = "localhost";
$db_user = "root";
$db_password = "Lucas2001";
$db_name = "businessdb";

/** @var mysqli|null $conn */
$conn = null;


try{
    
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
}
catch(mysqli_sql_exception ){
    echo "No se inicio: <br>" ;

}

/*
if($conn){
    echo"You are connected <br>";
}else{
    echo"connection failed";
}
*/
?>