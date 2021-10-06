<?php
class topSecretSplitController{

    function topSecretSplitParameters($satellites){
        require_once "../models/topSecretSplit.php";
        $topSecretSplit = new topSecretSplit();
        $position = $topSecretSplit->buscarNaveParameters($satellites);
        return $position;
    }

    function topSecretSplitRaw($satellites){
        require_once "../models/topSecretSplit.php";
        $topSecretSplit = new topSecretSplit();
        $position = $topSecretSplit->buscarNaveRaw($satellites);
        return $position;
    }
}