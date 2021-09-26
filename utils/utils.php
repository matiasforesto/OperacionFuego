<?php

function GetLocation(float $dKe, float $dSk, float $dSa)
{
  try{
      //Posición de los satélites actualmente en servicio y su distancia respectiva al portacarga
      $Kenobi = array("Kenobi", -500.00, -200.00, $dKe);
      $Skywalker = array("Skywalker", 100.00, -100.00, $dSk);
      $Sato = array("Sato", 500.00, 100.00, $dSa);
      
      //calculamos la circunferencia de cada satelite
      $cKe= circunferencia($Kenobi[3]);
      $cSk= circunferencia($Skywalker[3]);
      $cSa= circunferencia($Sato[3]);
      
      //Triangular position del portacarga y devolver la misma buscando la interceccion de las 3 circunferencia
      $position=array("position"=>array("x"=>-100.0, "y"=>75.5));
      return $position;
      
  }catch (Exception $e) {
        //print_r($e);
      echo "No se pueda determinar la posición";
      header("HTTP/1.1 400 Bad Request");
  }
}

function GetMessage(array $msgs)
{
  try{
      //creamos array para rearmar el mesaje
      $msgFull=array();
      $message="";
      
      //rearmamos el mensaje
      foreach($msgs as $msg) { 
        foreach($msg as $clave => $valor) { 
          //print_r($p);
          if($valor!="")
          {
            $msgFull[$clave]=$valor;
          }
        }
      }

      //ordenamos el mensaje
      ksort($msgFull);
      //lo almacenamos en un string
      foreach($msgFull as $p) { 
        $message=$message." ".$p;
      }
    
      //devolver el mensaje armado.
      return $message;

    }catch (Exception $e) {
      //print_r($e);
      echo "No se pueda determinar el mensaje";
      header("HTTP/1.1 400 Bad Request");
  }
}

//la distancia de cada satelite a la nave es el radio ($r) de cada circunferencia
function circunferencia($r)
{
  $pi=3.1416;
  //diametro
   $d=2*$r;
  //circunferencia 
  $c=$pi*$d;
  
  return  $c;
}

//vaalidacion de JSON
function json_validate($string)
{
  // decode the JSON data
  $result = json_decode($string);

  // switch and check possible JSON errors
  switch (json_last_error()) {
    case JSON_ERROR_NONE:
      $error = ''; // JSON is valid // No error has occurred
      break;
    case JSON_ERROR_DEPTH:
      $error = 'The maximum stack depth has been exceeded.';
      break;
    case JSON_ERROR_STATE_MISMATCH:
      $error = 'Invalid or malformed JSON.';
      break;
    case JSON_ERROR_CTRL_CHAR:
      $error = 'Control character error, possibly incorrectly encoded.';
      break;
    case JSON_ERROR_SYNTAX:
      $error = 'Syntax error, malformed JSON.';
      break;
      // PHP >= 5.3.3
    case JSON_ERROR_UTF8:
      $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
      break;
      // PHP >= 5.5.0
    case JSON_ERROR_RECURSION:
      $error = 'One or more recursive references in the value to be encoded.';
      break;
      // PHP >= 5.5.0
    case JSON_ERROR_INF_OR_NAN:
      $error = 'One or more NAN or INF values in the value to be encoded.';
      break;
    case JSON_ERROR_UNSUPPORTED_TYPE:
      $error = 'A value of a type that cannot be encoded was given.';
      break;
    default:
      $error = 'Unknown JSON error occured.';
      break;
  }

  if ($error !== '') {
    // throw the Exception or exit // or whatever :)
    exit($error);
  }

  // everything is OK
  return $result;
}