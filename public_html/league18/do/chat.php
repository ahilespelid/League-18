<?php
/* ~ Global Include ~ */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
        require_once($patch_global);
    }
}

if(isset($_POST['chat'])){
    $response = [];
    $chet = new GameChat($mysqli, $_POST, $response);
    print $response;
    die();
}