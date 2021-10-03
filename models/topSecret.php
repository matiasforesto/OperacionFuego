<?php
class topSecret{

    function buscarNave($satellites){
        
        require_once "../utils/utils.php";
        //validamos que este bien armado el JSON
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
        
        foreach($satellites as $satellite) { 
            foreach($satellite as $s) {
            
                //Controlamos que la distancia sea un numero
                if(!is_numeric($s->distance))
                {
                    $mensajeError["error"]=$c." No trae una distancia numerica: ". $s->distance;
                    return  $mensajeError;
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
                    $mensajeError["error"]=$s->name." No es un satelite en linea";
                    return  $mensajeError;
                break;
                }
            
            }//fin foreach satellite
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

}