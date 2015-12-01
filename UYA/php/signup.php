
<?php

$servername = "localhost";
$username = "convivecon";
$password = "convivecon";
$dbname = "convivecon";
$port = "8889";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$alias=$_POST['alias'];
$clave=$_POST['clave'];
$nombre=$_POST['nombre_y_apellidos'];
$correo=$_POST['correo'];
$tlf=$_POST['tlf'];
$respuesta ="Error en el servidor";

if($result = $conn->query("SELECT alias FROM usuarios WHERE alias = '".$alias."'")){
	if( $result->num_rows > 0 ) {
		$respuesta = "Nombre de usuario no disponible";
	}
	else{
		if($result = $conn->query("SELECT correo FROM usuarios WHERE correo = '".$correo."'")){
			if( $result->num_rows > 0 ) {
				$respuesta = "Correo no disponible";
			}
			else{
				$query="INSERT INTO usuarios (nombre_y_apellidos,alias,clave,correo,tlf) VALUES ('$nombre','$alias','$clave','$correo',$tlf)";
				if ($conn->query($query) === TRUE) {
    				$respuesta="Nuevo usuario creado";
				} else {
  					$respuesta="ocurrio un error al momento de guardar sus datos, vuelva a intentarlo.";
				}
			}
		}
	}	
}

echo json_encode($respuesta);

?>
