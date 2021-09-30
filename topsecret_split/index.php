<?php
//http://34.136.51.66/OperacionFuego/topsecret_split/

ini_set('display_errors','1');

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET'){ //ESPERA POST o GET
 
    require_once "../controllers/topSecretSplit.php";
    if(!empty($_REQUEST))
    {
        $satellites=$_REQUEST;
        
        $topSecretSplitController = new topSecretSplitController();
        $position = $topSecretSplitController->topSecretSplitParameters($satellites);
         
        //respuesta
        header("HTTP/1.1 200 OK");
        print_r(json_encode($position));
        exit();

    }elseif(file_get_contents("php://input")){
        
        $satellites = file_get_contents("php://input");// viene raw
        
        $topSecretSplitController = new topSecretSplitController();
        $position = $topSecretSplitController->topSecretSplitRaw($satellites);
         
        //respuesta
        header("HTTP/1.1 200 OK");
        print_r(json_encode($position));
        exit();

    }

}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
echo "los metodos request disponibles son: GET y POST";
header("HTTP/1.1 400 Bad Request");
exit();
?>