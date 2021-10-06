<?php
class topSecretController{

    function topSecretIn($satellites){
        require_once "../models/topSecret.php";
        $topSecret = new topSecret();
        $position = $topSecret->buscarNave($satellites);
        return $position;
    }
}