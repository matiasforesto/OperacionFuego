<?php
//http://35.193.197.34/testMatias/OperacionFuego/topsecret/
//ini_set('display_errors','1');
include "../utils/utils.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  
  if (isset($_POST['satellites'])){

    $satellites = $_POST['satellites']; //viene por el POST de topsecret
    
    //validamos que este bien armado el JSON
    $satellites = json_validate($satellites);
    if ( !is_object($satellites) ) {
      $satellites = array('error'=>$satellites); 
    }
  
    $Kenobi="";
    $dKe=0.0;
    
    $Skywalker="";
    $dSk=0.0;
    
    $Sato="";
    $dSa=0.0;
    
    $messages=array();

    foreach($satellites as $satellite) { 
      foreach($satellite as $s) {
        
        //Controlamos que la distancia sea un numero
        if(!is_numeric($s->distance))
        {
          print($s->name." No trae una distancia numerica: ". $s->distance);
          header("HTTP/1.1 404 Bad Request");
          exit();
        }

          switch ($s->name) {
            case 'Kenobi':
                $Kenobi= $s->name;
                $dKe= $s->distance;
                $msgKe= $s->message;
                array_push ( $messages , (array)$msgKe );
            break;

            case 'Skywalker':
                $Skywalker= $s->name;
                $dSk= $s->distance;
                $msgSk= $s->message;
                array_push ( $messages , (array)$msgSk );
            break;
            
            case 'Sato':
                $Sato= $s->name;
                $dSa= $s->distance;
                $msgSa= $s->message;
                array_push ( $messages , (array)$msgSa );
            break;
            
            default:
               print($s->name." No es un satelite en linea");
               header("HTTP/1.1 404 Bad Request");
               exit();
            break;
          }
         
      }//fin foreach satellite
  }//fin foreach satellites
    
  if($Kenobi=="" || $Skywalker=="" || $Sato=="")
  {
    print("Algunos satelites no estan en linea, disponibles: {$Kenobi} - {$Skywalker} - {$Sato}");
    header("HTTP/1.1 404 Bad Request");
    exit();
  }
  /*GetLocation pasar las disntancias de los 3 satelites hasta la nave portacarga 
    INPUT GetLocation(dKe, dSk, dSa) 
    OUTPUT [-500, -200] location satelite*/
    $position = GetLocation($dKe, $dSk, $dSa);
    //GetMessage pasar el array de mensajes captados por los 3 satelites
    $message = GetMessage($messages);
    
    //armamos el array final de salida pasando el mensaje
    $position["message"]=$message;
    
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