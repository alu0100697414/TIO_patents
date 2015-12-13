<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

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

  include('simple_html_dom.php');

  $resultado = $_POST['valorCaja1'];
  $dato = str_replace(' ','+',$resultado);

  $html = file_get_html('http://www.oepm.es/es/invenciones/resultados.html?field=TITU_RESU&bases=0&keyword=' . $dato);

  $rpp = 6;  // Resultados por pagina

  // Cogemos los elemtos p de la pagina y los guardamos en un array
  foreach($html->find('p') as $p) {
    $links[] = $p->plaintext;
  }

  // Inicializamos todos los arrays a datos no disponibles
  for($i=0; $i<$rpp; $i++){
    $titulos[$i] = "No disponible.";
    $clasificaciones[$i] = "No disponible.";
    $n_publicaciones[$i] = "No disponible.";
    $name_solicitante[$i] = "No disponible.";
    $n_solicitud[$i] = "No disponible.";
  }

  $j=0; // Inicializamos la j al primer titulo
  while(strpos($links[$j],"Título") === false){
    $j++;
  }

  $k=$j+1;
  for($i=0; $i<$rpp; $i++){

    $k++;

    // Buscamos el limite de busqueda en cada iteracion
    while(strpos($links[$k],"Título") === false and $k < count($links)-1){
      $k++;
    }

    // Buscamos los valores de cada atributo
    for($j;$j<$k;$j++){
      if(strpos($links[$j],"Título") !== false){
        $titulos[$i] = substr($links[$j],strpos($links[$j],":")+1);
      }
      if(strpos($links[$j],"Clasificación Internacional") !== false){
        $clasificaciones[$i] = substr($links[$j],strpos($links[$j],":")+1);
      }
      if(strpos($links[$j],"Número de Publicación") !== false){
        $n_publicaciones[$i] = substr($links[$j],strpos($links[$j],":")+1);
      }
      if(strpos($links[$j],"Nombre del primer solicitante") !== false){
        $name_solicitante[$i] = substr($links[$j],strpos($links[$j],":")+1);
      }
      if(strpos($links[$j],"Número de solicitud") !== false){
        $n_solicitud[$i] = substr($links[$j],strpos($links[$j],":")+1);
      }
    }

    // Actualizamos j para la siguiente iteracion
    $j=$k;
  }

  for($i=0;$i<$rpp;$i++){
    echo "<h4>Patente " . ($i+1) . ":</h4>";
    echo "Título:" . $titulos[$i] . "<br>";
    echo "Clasificación:" . $clasificaciones[$i] . "<br>";
    echo "Nº publicación: " . $n_publicaciones[$i] . "<br>";
    echo "Solicitante: " . $name_solicitante[$i] . "<br>";
    echo "Nº solicitud: " . $n_solicitud[$i] . "<br>";
  }
?>
