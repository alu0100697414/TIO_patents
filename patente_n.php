<?php
  // error_reporting(E_ALL);
  // ini_set('error_reporting', E_ALL);
  //
  // $servername = "localhost";
  // $username = "alu4586";
  // $password = "4OP3Xa";
  // $dbname = "alu4586";
  // $port = "8889";
  //
  // // Crea la conexión con la base de datos
  // $database = new mysqli($servername, $username, $password, $dbname, $port);
  //
  // // Chequea la conexión
  // if ($database->connect_error) {
  //   die("Connection failed: " . $database->connect_error);
  // };
  //
  // // Consulta que muestra cada fila entera de la tabla
  // $result = $database->query( "SELECT titulo,id FROM p_nacional" );
  //
  // if( $result->num_rows > 0 ) {
	//   while( $row = $result->fetch_object() ) {
  // 	  echo json_encode($row);
  //     echo "<br>";
	//   }
  // }
  //
  // else{
  //   echo "ERROR EN LA CONSULTA. ESTÁ VACÍA LA TABLA.";
  // }
  //
  // // Consulta que muestra solo el id de cada fila de la tabla
  // $result = $database->query( "SELECT id FROM p_nacional" );
  //
  // if( $result->num_rows > 0 ) {
	//   while( $row = $result->fetch_object() ) {
  //     echo str_replace('"','',json_encode($row->id));
  //     echo "<br>";
	//   }
  // }
  //
  // else {
  //   echo "ERROR EN LA CONSULTA. ESTÁ VACÍA LA TABLA.";
  // }
  //
  // $result->close();
  // $database->close();
  //
  // echo "<br>";echo "<br>";echo "<br>";

  // $html = file_get_contents('http://www.oepm.es/es/invenciones/resultados.html?field=TITU_RESU&bases=0&keyword=bicicleta');
  //
  // echo $html;
  //
  //
  // $DOM = new DOMDocument();
  // $DOM->loadHTML($html);
  //
  //
  // $h2 = $DOM->getElementsByTagName( 'h2' );
  //
  // echo $h2->length;

  $resultado = $_POST['valorCaja1'];

  function Obtener_contenidos($url,$inicio='',$final){
    $source = @file_get_contents($url)or die('se ha producido un error');
    $posicion_inicio = strpos($source, $inicio) + strlen($inicio);
    $posicion_final = strpos($source, $final) - $posicion_inicio;
    $found_text = substr($source, $posicion_inicio, $posicion_final);

    return $inicio . $found_text .$final;
  }

  $url = 'http://www.oepm.es/es/invenciones/resultados.html?field=TITU_RESU&bases=0&keyword=' . $resultado; /// pagina web del contenido

  // Obtener_contenidos(url,ancla inicio,ancla final);
  echo "<br>";
  echo "<h3 style='margin-left:5%;'>Patentes Nacionales</h3>";
  echo "<br>";
  echo utf8_encode(Obtener_contenidos($url,'<ul class="resBusquedas"><li>','</li></ul>'));
  echo "<br>";
?>
