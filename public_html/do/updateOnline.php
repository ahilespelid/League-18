<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
    }
}
$time = time()+300;
	$botID = $mysqli->query("SELECT `botID` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
	$mysqli->query("UPDATE `users` SET `online` = '".$time."' WHERE `id` = '".$_SESSION['id']."'");
	

?>