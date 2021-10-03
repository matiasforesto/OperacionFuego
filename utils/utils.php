<?php

function GetLocation(float $dKe, float $dSk, float $dSa){
  try{
      //Posición de los satélites actualmente en servicio y su distancia respectiva al portacarga
      $Kenobi = array("Kenobi", -500.00, -200.00, $dKe);
      $Skywalker = array("Skywalker", 100.00, -100.00, $dSk);
      $Sato = array("Sato", 500.00, 100.00, $dSa);
      
      $datos_satelites=array();
      array_push($datos_satelites, $Kenobi);
      array_push($datos_satelites, $Skywalker);
      array_push($datos_satelites, $Sato);
      //Triangular position del portacarga y devolver la misma
      $position = trilateracion($datos_satelites);
    
      //$position=array("position"=>array("x"=>-100.0, "y"=>75.5));
      return $position;
      
  }catch (Exception $e) {
    $mensajeError=array("error"=>"No se pueda determinar la posición");
    return $mensajeError;
  }
}

function GetMessage(array $msgs){
  try{
      //creamos array para rearmar el mesaje
      $msgFull=array();
      $message="";
      
      //rearmamos el mensaje
      foreach($msgs as $msg) { 
        foreach($msg as $clave => $valor) {     
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
      $mensajeError=array("error"=>"No se pueda determinar el mensaje");
      return $mensajeError;
  }
}

function trilateracion(array $positions)
{
  ini_set('display_errors','1');
    //assuming elevation = 0
    //$earthR = 6371; // in km ( = 3959 in miles) en mi caso cual es la distancia a pasar?
     
      $kenobi_lng=$positions[0][1];//longitud
      $kenobi_lat=$positions[0][2];//latitud
      $kenobi_distancia=$positions[0][3]; //distancia

      $Skywalker_lng=$positions[1][1];//longitud
      $Skywalker_lat=$positions[1][2];//latitud
      $Skywalker_distancia=$positions[1][3];//distancia

      $Sato_lng=$positions[2][1];//longitud
      $Sato_lat=$positions[2][2];//latitud
      $Sato_distancia=$positions[2][3];//distancia
      
      //voy a pasar un promedio de las distancias de los 3 satelites a la nave como suponiendo que los 3 satelites estan a la misma altura en el espacio con respecto a la nave
      $earthR= (($kenobi_distancia+$Skywalker_distancia+$Sato_distancia)/3);

      $LatA = $kenobi_lat;
      $LonA = $kenobi_lng;
      $DistA = $kenobi_distancia;

      $LatB = $Skywalker_lat;
      $LonB = $Skywalker_lng;
      $DistB = $Skywalker_distancia;

      $LatC = $Sato_lat;
      $LonC = $Sato_lng;
      $DistC = $Sato_distancia;

      /*
      #using authalic sphere
      #if using an ellipsoid this step is slightly different
      #Convert geodetic Lat/Long to ECEF xyz
      #   1. Convert Lat/Long to radians
      #   2. Convert Lat/Long(radians) to ECEF
      */
      $xA = $earthR *(cos(deg2rad($LatA)) * cos(deg2rad($LonA)));
      $yA = $earthR *(cos(deg2rad($LatA)) * sin(deg2rad($LonA)));
      $zA = $earthR *(sin(deg2rad($LatA)));

      $xB = $earthR *(cos(deg2rad($LatB)) * cos(deg2rad($LonB)));
      $yB = $earthR *(cos(deg2rad($LatB)) * sin(deg2rad($LonB)));
      $zB = $earthR *(sin(deg2rad($LatB)));

      $xC = $earthR *(cos(deg2rad($LatC)) * cos(deg2rad($LonC)));
      $yC = $earthR *(cos(deg2rad($LatC)) * sin(deg2rad($LonC)));
      $zC = $earthR *(sin(deg2rad($LatC)));

      /*
      INSTALL:
      sudo pear install Math_Vector-0.7.0
      sudo pear install Math_Matrix-0.8.7
      */
      require_once 'Math/Matrix.php';
      require_once 'Math/Vector.php';
      require_once 'Math/Vector3.php';


      $P1vector = new Math_Vector3(array($xA,$yA,$zA));
      $P2vector = new Math_Vector3(array($xB,$yB,$zB));
      $P3vector = new Math_Vector3(array($xC,$yC,$zC));

      #from wikipedia: http://en.wikipedia.org/wiki/Trilateration
      #transform to get circle 1 at origin
      #transform to get circle 2 on x axis

      // CALC EX
      $P2minusP1 = Math_VectorOp::substract($P2vector, $P1vector);
      $l = new Math_Vector($P2minusP1);
      $P2minusP1_length = $l->length();
      $norm = new Math_Vector3(array($P2minusP1_length,$P2minusP1_length,$P2minusP1_length));
      $d = $norm; //save calc D
      $ex = Math_VectorOp::divide($P2minusP1, $norm);
      //echo "ex: ".$ex->toString()."\n";
      $ex_x = floatval( $ex->_tuple->getData()[0] ) ;
      $ex_y = floatval( $ex->_tuple->getData()[1] ) ;
      $ex_z = floatval( $ex->_tuple->getData()[2] ) ;
      $ex = new Math_Vector3(array($ex_x,$ex_y,$ex_z));

      // CALC i
      $P3minusP1 = Math_VectorOp::substract($P3vector, $P1vector);
      $P3minusP1_x = floatval( $P3minusP1->_tuple->getData()[0] ) ;
      $P3minusP1_y = floatval( $P3minusP1->_tuple->getData()[1] ) ;
      $P3minusP1_z = floatval( $P3minusP1->_tuple->getData()[2] ) ;
      $P3minusP1 = new Math_Vector3(array($P3minusP1_x,$P3minusP1_y,$P3minusP1_z));
      $i = Math_VectorOp::dotProduct($ex, $P3minusP1);
      //echo "i = $i\n";

      // CALC EY
      $iex = Math_VectorOp::scale($i, $ex);
      //echo " iex = ".$iex->toString()."\n";
      $P3P1iex = Math_VectorOp::substract($P3minusP1, $iex);
      //echo " P3P1iex = ".$P3P1iex->toString()."\n";
      $l = new Math_Vector($P3P1iex);
      $P3P1iex_length = $l->length();
      $norm = new Math_Vector3(array($P3P1iex_length,$P3P1iex_length,$P3P1iex_length));
      //echo "norm: ".$norm->toString()."\n";
      $ey = Math_VectorOp::divide($P3P1iex, $norm);
      //echo " ey = ".$ey->toString()."\n";
      $ey_x = floatval( $ey->_tuple->getData()[0] ) ;
      $ey_y = floatval( $ey->_tuple->getData()[1] ) ;
      $ey_z = floatval( $ey->_tuple->getData()[2] ) ;
      $ey = new Math_Vector3(array($ey_x,$ey_y,$ey_z));

      // CALC EZ
      $ez = Math_VectorOp::crossProduct($ex, $ey);
      //echo " ez = ".$ez->toString()."\n";

      // CALC D
      // do it before
      $d = floatval( $d->_tuple->getData()[0] ) ;
      //echo "d = $d\n";

      // CALC J
      $j = Math_VectorOp::dotProduct($ey, $P3minusP1);
      //echo "j = $j\n";

      #from wikipedia
      #plug and chug using above values
      $x = (pow($DistA,2) - pow($DistB,2) + pow($d,2))/(2*$d);
      $y = ((pow($DistA,2) - pow($DistC,2) + pow($i,2) + pow($j,2))/(2*$j)) - (($i/$j)*$x);

      # only one case shown here
      $z = sqrt( pow($DistA,2) - pow($x,2) - pow($y,2) );

      //echo "x = $x - y = $y  - z = $z\n";

      #triPt is an array with ECEF x,y,z of trilateration point
      $xex = Math_VectorOp::scale($x, $ex);
      $yey = Math_VectorOp::scale($y, $ey);
      $zez = Math_VectorOp::scale($z, $ez);

      // CALC $triPt = $P1vector + $xex + $yey + $zez;
      $triPt = Math_VectorOp::add($P1vector, $xex);
      $triPt = Math_VectorOp::add($triPt, $yey);
      $triPt = Math_VectorOp::add($triPt, $zez);
      //echo " triPt = ".$triPt->toString()."\n";
      $triPt_x = floatval( $triPt->_tuple->getData()[0] ) ;
      $triPt_y = floatval( $triPt->_tuple->getData()[1] ) ;
      $triPt_z = floatval( $triPt->_tuple->getData()[2] ) ;

      #convert back to lat/long from ECEF
      #convert to degrees
      $lat = rad2deg(asin($triPt_z / $earthR));
      $lon = rad2deg(atan2($triPt_y,$triPt_x));

      $position=array("position"=>array("x"=>$lon, "y"=>$lat));

      return $position;
}

//vaalidacion de JSON
function json_validate(string $string){
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
      $mensajeError=array("error"=>$error);
      return $mensajeError;
  }

  // everything is OK
  return $result;
}