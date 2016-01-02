<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  include('simple_html_dom.php');

  $resultado = $_POST['valorCaja1'];
  $dato = str_replace(' ','+',$resultado);

  $html = file_get_html('http://www.oepm.es/es/invenciones/resultados.html?field=TITU_RESU&bases=0&keyword=' . $dato);
  $html2 = file_get_html('http://www.oepm.es/es/invenciones/resultados.html?field=TITU_RESU&bases=0&keyword=' . $dato . '&p=2');

  $rpp = 6;  // Resultados por pagina

  // Cogemos los elemtos p de la pagina y los guardamos en un array
  foreach($html->find('p') as $p) {
    $links[] = $p->plaintext;
  }

  // Cogemos los elemtos p de la pagina y los guardamos en un array
  foreach($html2->find('p') as $p) {
    $links2[] = $p->plaintext;
  }

  // Inicializamos todos los arrays a datos no disponibles
  for($i=0; $i<($rpp*2); $i++){
    $titulos[$i] = "No disponible.";
    $clasificaciones[$i] = "No disponible.";
    $n_publicaciones[$i] = "No disponible.";
    $name_solicitante[$i] = "No disponible.";
    $n_solicitud[$i] = "No disponible.";
  }

  // Lo hacemos para la primera página
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

  // Lo hacemos para la segunda página
  $j=0; // Inicializamos la j al primer titulo
  while(strpos($links2[$j],"Título") === false){
    $j++;
  }

  $k=$j+1;
  for($i=6; $i<($rpp*2); $i++){

    $k++;

    // Buscamos el limite de busqueda en cada iteracion
    while(strpos($links2[$k],"Título") === false and $k < count($links2)-1){
      $k++;
    }

    // Buscamos los valores de cada atributo
    for($j;$j<$k;$j++){
      if(strpos($links2[$j],"Título") !== false){
        $titulos[$i] = substr($links2[$j],strpos($links2[$j],":")+1);
      }
      if(strpos($links2[$j],"Clasificación Internacional") !== false){
        $clasificaciones[$i] = substr($links2[$j],strpos($links2[$j],":")+1);
      }
      if(strpos($links2[$j],"Número de Publicación") !== false){
        $n_publicaciones[$i] = substr($links2[$j],strpos($links2[$j],":")+1);
      }
      if(strpos($links2[$j],"Nombre del primer solicitante") !== false){
        $name_solicitante[$i] = substr($links2[$j],strpos($links2[$j],":")+1);
      }
      if(strpos($links2[$j],"Número de solicitud") !== false){
        $n_solicitud[$i] = substr($links2[$j],strpos($links2[$j],":")+1);
      }
    }

    // Actualizamos j para la siguiente iteracion
    $j=$k;
  }

  echo "<table class='table table-hover'>";
  echo "<tr>";
  echo "<td><strong>ID</strong></td>";
  echo "<td><strong>Título</strong></td>";
  echo "<td><strong>Clasificación</strong></td>";
  echo "<td><strong>Nº publicación</strong></td>";
  echo "<td><strong>Solicitante</strong></td>";
  echo "<td><strong>Nº solicitud</strong></td>";
  echo "</tr>";

  $cont = 0;
  for($i=0;$i<($rpp*2);$i++){

    if($titulos[$i] !== "No disponible."){
      $cont = $cont + 1;
      echo "<tr>";
      echo "<td>" . $cont . "</td>";
      echo "<td>" . $titulos[$i] . "</td>";
      echo "<td>" . $clasificaciones[$i] . "</td>";
      echo "<td>" . $n_publicaciones[$i] . "</td>";
      echo "<td>" . $name_solicitante[$i] . "</td>";
      echo "<td>" . $n_solicitud[$i] . "</td>";
      echo "</tr>";
    }
  }
  echo "</table>";
?>
