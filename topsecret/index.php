<?php
//http://34.136.51.66/OperacionFuego/topsecret/
//ini_set('display_errors','1');
include "../utils/utils.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  
  //print_r( $_POST);
  //exit();
  if (isset($_POST['satellites'])){

    $satellites = $_POST['satellites']; //viene por el POST de topsecret
    
    //ejecutamos topSecret para recuperar la posicion y el mensaje
    $position = topSecret($satellites);
  
    //respuesta
    header("HTTP/1.1 200 OK");
    print_r(json_encode($position));
    
  }else{
      echo "No viene en el POST el JSON de satellites";
      header("HTTP/1.1 400 Bad Request");
  }
  
  exit();
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
echo "Metodos request disponible : POST ";
header("HTTP/1.1 400 Bad Request");
exit();
?>