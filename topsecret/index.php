<?php
      //http://34.136.51.66/OperacionFuego/topsecret/
      //ini_set('display_errors','1');

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  if (isset($_POST['satellites']) ){
      $satellites = $_POST['satellites']; //viene por el POST de topsecret
  }
  elseif(file_get_contents("php://input")){
      $satellites = file_get_contents("php://input");// viene raw
  }
  else{
      echo "No viene en el POST el JSON de satellites";
      header("HTTP/1.1 400 Bad Request");
      exit();
  }
  
   require_once "../controllers/topSecret.php";
   $topSecretController = new topSecretController();
   $position = $topSecretController->topSecretIn($satellites);
   
    //respuesta
    header("HTTP/1.1 200 OK");
    print_r(json_encode($position));
    exit();
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
echo "Metodos request disponible : POST ";
header("HTTP/1.1 400 Bad Request");
exit();
?>