<?php
include 'database.php';
/** @var mysqli $conn */

$username = "Patrick";
$password = "rock3";    
$hash = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO users (user, password) VALUES ('$username','$hash')";


try{
mysqli_query($conn, $sql);
echo "New record created successfully";
}
catch(mysqli_sql_exception ){
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


mysqli_close($conn)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Hello<br>
    
</body>
</html>
