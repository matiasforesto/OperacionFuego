<?php
class topSecretSplit{

    function buscarNaveRaw($satellites)
    {
        require_once "../utils/utils.php";
        
        $satellites = json_validate($satellites);
        if ( !is_object($satellites) ) {
            return $satellites;
        }

        $Kenobi="";
        $dKe=0.0;
        $Skywalker="";
        $dSk=0.0;
        $Sato="";
        $dSa=0.0;

        $messages=array();
        $mensajeError=array("error"=>"");
        
        $detectedkenobi=0;
        $detectedSkywalker=0;
        $detectedSato=0;

        foreach($satellites as $c=>$s) {
            foreach($s as $vs) {

                //Controlamos que la distancia sea un numero
                if(!is_numeric($s->distance))
                {
                    $mensajeError["error"]=$c." No trae una distancia numerica: ". $s->distance;
                    return  $mensajeError;
                }

                switch ($c) {
                    case 'Kenobi':
                        if($detectedkenobi==0){
                            $Kenobi= $c;
                            $dKe= $s->distance;
                            $msgKe= $s->message;
                            array_push ( $messages , (array)$msgKe );
                            $detectedkenobi=1;
                        }
                    break;

                    case 'Skywalker':
                        if($detectedSkywalker==0){
                            $Skywalker= $c;
                            $dSk= $s->distance;
                            $msgSk= $s->message;
                            array_push ( $messages , (array)$msgSk );
                            $detectedSkywalker=1;
                        }
                    break;
                    
                    case 'Sato':
                        if($detectedSato==0){
                            $Sato= $c;
                            $dSa= $s->distance;
                            $msgSa= $s->message;
                            array_push ( $messages , (array)$msgSa );
                            $detectedSato=1;
                        }
                    break;
                    
                    default:
                        $mensajeError["error"]=$c." No es un satelite en linea";
                        return  $mensajeError;
                    break;
                }
            }
        }//fin foreach satellites

        if($Kenobi=="" || $Skywalker=="" || $Sato=="")
        {
            $mensajeError["error"]="Algunos satelites no estan en linea, disponibles: {$Kenobi} | {$Skywalker} | {$Sato}";
            return  $mensajeError;
        }

        //GetLocation pasar las disntancias de los 3 satelites hasta la nave portacarga 
        $position = GetLocation($dKe, $dSk, $dSa);
        //GetMessage pasar el array de mensajes captados por los 3 satelites
        $message = GetMessage($messages);
        
        //armamos el array final de salida pasando el mensaje
        $position["message"]=$message;
        return $position;
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
        $mensajeError=array("error"=>"");
        
        if(!isset($satellites["Kenobi"]))
            {
                $mensajeError["error"]="Kenobi no esta en linea";
                return  $mensajeError;
            }
            else{
                //validamos que este bien armado el JSON Kenobi
                $Kenobi = json_validate($satellites["Kenobi"]);
                if ( !is_object($Kenobi) ) {
                    return $Kenobi;
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
        
                
        if(!isset($satellites["Skywalker"]))
        {
            $mensajeError["error"]="Skywalker no esta en linea";
            return  $mensajeError;
        }
        else{
                //validamos que este bien armado el JSON
                $Skywalker = json_validate($satellites["Skywalker"]);
                if ( !is_object($Skywalker) ) {
                    return $Skywalker; 
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
        
        
        if(!isset($satellites["Sato"]))
        {
            $mensajeError["error"]="Sato no esta en linea";
            return  $mensajeError;
        }
        else{
                //validamos que este bien armado el JSON
            $Sato = json_validate($satellites["Sato"]); 
            if ( !is_object($Sato) ) {
                return $Sato;
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
            $mensajeError["error"]="Algunas de las distancias no estan bien cargada : {$nameKe}:{$dKe} - {$nameSk}:{$dSk} - {$nameSa}:{$dSa}";
            return  $mensajeError;
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
