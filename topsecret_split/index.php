<?php
header("Content-Type: application/json");

$mensajeError=array("error"=>"");

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET'){ //ESPERA POST o GET
 
    require_once "../controllers/topSecretSplit.php";
    if(!empty($_REQUEST)){
        
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

    }else{
        $mensajeError["error"]="topsecret_split espera los parametros 'Kenobi', 'Skywalker' y 'Sato' en POST O GET, o puedes pasar un raw de JSON";
        print_r(json_encode($mensajeError));
        header("HTTP/1.1 404 Bad Request");
        exit();
    }

}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
$mensajeError["error"]="los metodos request disponibles son: GET y POST";
print_r(json_encode($mensajeError));
header("HTTP/1.1 404 Bad Request");
exit();
?>