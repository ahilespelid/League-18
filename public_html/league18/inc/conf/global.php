<?php

function closed($text = null, $param = null) {

    if($text) {

        $array = array('error'=>array('type'=>1, 'text'=>$text, 'param'=>$param));
        echo json_encode($array);

    }

    return exit;

}

if(function_exists('closed')) {

    if(!empty($patch_project)) {

        $filePathConst = $patch_project.'/inc/conf/const.php';
	      $filePathFunctions = $patch_project.'/inc/function/Functions.php';
        $filePathConnect = $patch_project.'/inc/conf/connect.php';
        $filePathMakasimka = $patch_project.'/makasimka/inc/conf/global.php';

        if(file_exists($filePathConst) && file_exists($filePathConnect) && file_exists($filePathMakasimka)) {

		        session_start();
            require_once($filePathConst);
            require_once($filePathFunctions);
            require_once($filePathConnect);
            require_once($filePathMakasimka);

	         if(!defined('SHOW_FILE')) {

                closed('The problem with the connection files [Global::1].');

            }

        }else{

            closed('The problem with the connection files [Global::2].');

        }

    }else{

        closed('The problem with the connection files [Global::3].');

    }
}else{

    die('ERROR ON SERVER');

}

$s = $mysqli->query("SELECT * FROM `system` WHERE `id` = 1")->fetch_assoc();
$mainTechWork = $s['closed'];
$versionGame = $s['version'];
$reitsGlobal = $s['reits'];
$reitsGlobalText = $s['reits_text'];