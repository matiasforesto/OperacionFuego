<?php
//http://35.193.197.34/testMatias/OperacionFuego/topsecret_split/
include "../utils/utils.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET'){ //ESPERA POST o GET

    //$satelites = array('Kenobi', 'Skywalker', 'Sato');// los satelites que acepto
    $REQUEST_METHOD=$_SERVER['REQUEST_METHOD'];
    $nameKe="";
    $dKe=0.0;
    $nameSk="";
    $dSk=0.0;
    $nameSa="";
    $dSa=0.0;
    $messages=array();

    if(isset($_REQUEST['Kenobi'])){
        //validamos que este bien armado el JSON
        $Kenobi=$_REQUEST['Kenobi'];
        $Kenobi = json_validate($Kenobi);
        
        if ( !is_object($Kenobi) ) {
         $Kenobi = array('error'=>$Kenobi); 
        }
        
        foreach($Kenobi as $c=>$v) {
            if($c=="Kenobi"){
                $nameKe=$c;
            }
            $dKe= $v->distance;
            $msgKe= $v->message;
            array_push ( $messages , (array)$msgKe );
        } 
    }

    if(isset($_REQUEST['Skywalker'])){
        //validamos que este bien armado el JSON
        $Skywalker=$_REQUEST['Skywalker'];
        $Skywalker = json_validate($Skywalker);
        
        if ( !is_object($Skywalker) ) {
         $Skywalker = array('error'=>$Skywalker); 
        }
        
        foreach($Skywalker as $c=>$v) {
            if($c=="Skywalker"){
                $nameSk=$c;
            }
            $dSk= $v->distance;
            $msgSk= $v->message;
            array_push ( $messages , (array)$msgSk );
        }
    }

    if(isset($_REQUEST['Sato'])){
        //validamos que este bien armado el JSON
        $Sato=$_REQUEST['Sato'];
        $Sato = json_validate($Sato);
        
        if ( !is_object($Sato) ) {
         $Sato = array('error'=>$Sato); 
        }
        
        foreach($Sato as $c=>$v) {
            if($c=="Sato"){
                $nameSa=$c;
            }
            $dSa= $v->distance;
            $msgSa= $v->message;
            array_push ( $messages , (array)$msgSa );
        }
    }

    if($nameKe=="" || $nameSk=="" || $nameSa=="")
    {
        print("Algunos satelites no estan en linea, disponibles: {$nameKe} - {$nameSk} - {$nameSa}");
        header("HTTP/1.1 404 Bad Request");
        exit();
    }

        //echo "entro con {$REQUEST_METHOD} de split";
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
        exit();
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
echo "los metodos request disponibles son: GET y POST";
header("HTTP/1.1 400 Bad Request");
exit();
?>