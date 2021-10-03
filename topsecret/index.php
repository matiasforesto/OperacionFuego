<?php
header("Content-Type: application/json");

$mensajeError=array("error"=>"");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  if (isset($_POST['satellites']) ){
      $satellites = $_POST['satellites']; //viene como parametro POST
  }
  elseif(file_get_contents("php://input")){
      $satellites = file_get_contents("php://input");// viene raw
  }
  else{
      $mensajeError["error"]="topsecret espera el parametro 'satellites' en POST, o puedes pasar un raw de JSON";
      print_r(json_encode($mensajeError));
      header("HTTP/1.1 404 Bad Request");
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
$mensajeError["error"]="Metodos request disponible : POST ";
print_r(json_encode($mensajeError));
header("HTTP/1.1 404 Bad Request");
exit();
?>