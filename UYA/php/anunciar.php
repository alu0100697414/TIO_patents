
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
$cont=$_POST['cont'];
if($cont == 1){
	$url_imagen1 = 'pisos/'.$_POST['imagen1'];
	$url_imagen2 = 'pisos/imagen_no_disponible.jpg';
	$url_imagen3 = 'pisos/imagen_no_disponible.jpg';
}
if ($cont == 2) {
	$url_imagen1 = 'pisos/'.$_POST['imagen1'];
	$url_imagen2 = 'pisos/'.$_POST['imagen2'];
	$url_imagen3 = 'pisos/imagen_no_disponible.jpg';
}
if ($cont == 3) {
	$url_imagen1 = 'pisos/'.$_POST['imagen1'];
	$url_imagen2 = 'pisos/'.$_POST['imagen2'];
	$url_imagen3 = 'pisos/'.$_POST['imagen3'];
}

$habitaciones=$_POST['habitaciones'];
$banios=$_POST['banios'];
$tipo_banio=$_POST['tipo_banio'];
$wifi=$_POST['wifi'];
$ciudad=$_POST['ciudad'];
$telefono=$_POST['telefono'];
$precio=$_POST['precio'];
$descripcion=$_POST['descripcion'];

$query="INSERT INTO pisos (habitaciones,banios,tipo_banio,wifi,ciudad,telefono,precio,descripcion,url_imagen1,url_imagen2,url_imagen3) VALUES ($habitaciones,$banios,'$tipo_banio','$wifi','$ciudad','$telefono',$precio,'$descripcion','$url_imagen1','$url_imagen2','$url_imagen3')";

$respuesta="Hola";

if ($conn->query($query) === TRUE) {
    $respuesta="se guardo su piso con exito";
} else {
	$respuesta="ocurrio un error al momento de guardar su piso, vuelva a intentarlo.";
    echo "Error: " . $sql . "<br>" . $conn->error;
}

echo json_encode($url_imagen1);

?>
