<?php
if( isset($_GET['habitaciones']) ) {
  get_pisos($_GET['habitaciones'],$_GET['wc'],$_GET['tipo_banio'],$_GET['wifi'],$_GET['ciudad'],$_GET['desde'],$_GET['hasta']);
} else {
  die("Solicitud no válida.");
}

function get_pisos($habitaciones,$wc,$tipo_banio,$wifi,$ciudad,$desde,$hasta) {

  //Cambia por los detalles de tu base datos
  $dbserver = "localhost";
  $dbuser = "convivecon";
  $password = "convivecon";
  $dbname = "convivecon";
  $port = "8889";

  $database = new mysqli($dbserver, $dbuser, $password, $dbname,$port);

  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }

  $jsondata = array();

  //Sanitize ipnut y preparar query


  if ( $result = $database->query( "SELECT id_piso,habitaciones,banios,tipo_banio,wifi,ciudad,telefono,precio,descripcion,date,url_imagen1,url_imagen2,url_imagen3 FROM pisos WHERE habitaciones = ".$habitaciones." AND banios = ".$wc." AND tipo_banio LIKE'%".$tipo_banio."%' AND wifi LIKE '%".$wifi."%' AND ciudad LIKE '%".$ciudad."%' AND (precio BETWEEN ".$desde." AND ".$hasta.")" ) ) {

  if( $result->num_rows > 0 ) {
    $jsondata["success"] = true;
    $jsondata["data"]["message"] = sprintf("Se han encontrado %d resultados", $result->num_rows);
    $jsondata["data"]["pisos"] = array();
    while( $row = $result->fetch_object() ) {
       //$jsondata["data"]["users"][] es un array no asociativo. Tendremos que utilizar JSON_FORCE_OBJECT en json_enconde
       //si no queremos recibir un array en lugar de un objeto JSON en la respuesta
       //ver http://www.php.net/manual/es/function.json-encode.php para m�s info
       $jsondata["data"]["pisos"][] = $row;
     }
     //echo($result->fetch_object());
   } else {

     $jsondata["success"] = false;
     $jsondata["data"] = array(
       'message' => 'No se encontró ningún resultado.'
     );

   }

   $result->close();

  } else {

    $jsondata["success"] = false;
    $jsondata["data"] = array(
      'message' => $database->error
    );

  }


  header('Content-type: application/json; charset=utf-8');
  echo json_encode($jsondata, JSON_FORCE_OBJECT);

  $database->close();

}

exit();

?>
