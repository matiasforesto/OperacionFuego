<?php
ini_set('display_errors','1');
//http://35.193.197.34/testMatias/OperacionFuego/topsecret_split/
include "../utils/utils.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET'){ //ESPERA POST o GET

    $satellites=array();

    if(isset($_REQUEST['Kenobi'])){
        $Kenobi=$_REQUEST['Kenobi'];
        $satellites['Kenobi']=$Kenobi;
    }
    else{
            $satellites['Kenobi']="";
        }

    if(isset($_REQUEST['Skywalker'])){
        $Skywalker=$_REQUEST['Skywalker'];
        $satellites['Skywalker']=$Skywalker;
    }else{
            $satellites['Skywalker']="";
    }

    if(isset($_REQUEST['Sato'])){
        $Sato=$_REQUEST['Sato'];
        $satellites['Sato']=$Sato;
    }else{
            $satellites['Sato']="";
    }

    //ejecutamos topSecret para recuperar la posicion y el mensaje
    $position = topSecretSplit($satellites); 
    //respuesta
    header("HTTP/1.1 200 OK");
    print_r(json_encode($position));
    exit();
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
echo "los metodos request disponibles son: GET y POST";
header("HTTP/1.1 400 Bad Request");
exit();
?>