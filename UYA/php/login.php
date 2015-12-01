
<?php

$servername = "localhost";
$username = "convivecon";
$password = "convivecon";
$dbname = "convivecon";
$port = "8889";

// Create connection
$database = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
} 

$alias=$_POST['usuario'];
$clave=$_POST['password'];
$respuesta="";


if($result = $database->query("SELECT alias FROM usuarios WHERE alias = '".$alias."' AND clave = '".$clave."'")){
	if( $result->num_rows > 0 ) {
		$respuesta = "ok";
	}
	else{
		$respuesta = "El nombre de usuario o la clave son incorrectos";
	}
}
else{
 	$respuesta = "Se produjo un error en el servidor!";
}

echo json_encode($respuesta);
?>
