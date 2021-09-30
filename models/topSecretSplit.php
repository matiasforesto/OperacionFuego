<?php
class topSecretSplit{

    function buscarNaveRaw($satellites)
    {
        return $satellites;
    }

    function buscarNaveParameters($satellites){

        require_once "../utils/utils.php";
        
        $nameKe="";
        $dKe=null;
        $nameSk="";
        $dSk=null;
        $nameSa="";
        $dSa=null;
        $messages=array();
        
        if(!isset($satellites["Kenobi"]))
            {
                print("Kenobi no esta en linea");
                header("HTTP/1.1 404 Bad Request");
                exit();
            }
            else{
                //validamos que este bien armado el JSON Kenobi
                $Kenobi = json_validate($satellites["Kenobi"]);
                if ( !is_object($Kenobi) ) {
                    $Kenobi = array('error'=>$Kenobi); 
                    print("Kenobi no esta en linea");
                    header("HTTP/1.1 404 Bad Request");
                exit();
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
        
                
        if($satellites["Skywalker"] == "")
        {
            print("Skywalker no esta en linea");
            header("HTTP/1.1 404 Bad Request");
            exit();
        }
        else{
                //validamos que este bien armado el JSON
                $Skywalker = json_validate($satellites["Skywalker"]);
                    
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
        
        
        if($satellites["Sato"] == "")
        {
            print("Sato no esta en linea");
            header("HTTP/1.1 404 Bad Request");
            exit();
        }
        else{
                //validamos que este bien armado el JSON
            $Sato = json_validate($satellites["Sato"]);
                    
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
            

        if(!is_numeric($dKe) || !is_numeric($dSk) || !is_numeric($dSa))
        {
            print("Algunas de las distancias no estan bien cargada : {$nameKe}:{$dKe} - {$nameSk}:{$dSk} - {$nameSa}:{$dSa}");
            header("HTTP/1.1 404 Bad Request");
            exit();
        }

        //GetLocation pasar las disntancias de los 3 satelites hasta la nave portacarga 
        $position = GetLocation($dKe, $dSk, $dSa);
        //GetMessage pasar el array de mensajes captados por los 3 satelites
        $message = GetMessage($messages);
            
        //armamos el array final de salida pasando el mensaje
        $position["message"]=$message;
        
        return $position;   
    }

}
