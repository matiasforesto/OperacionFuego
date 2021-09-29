<?php
//http://34.136.51.66/OperacionFuego/topsecret/
//ini_set('display_errors','1');
//require_once "../utils/utils.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  
  if (isset($_POST['satellites'])){

    require_once "../models/topSecret.php";
    $satellites = $_POST['satellites']; //viene por el POST de topsecret
    
    $topSecret = new topSecret();
    $position = $topSecret->topSecretIn($satellites);
  
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