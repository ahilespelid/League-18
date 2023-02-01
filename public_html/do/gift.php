<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$patch_func = $patch_project.'/inc/function/Functions.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
		require_once($patch_func);
    }
}
$user = clearStr($_POST["user"]);
$id = clearInt($_POST["id"]);
$gift = $mysqli->query('SELECT * FROM `base_gift` WHERE `id` = '.$id)->fetch_assoc();
$userIam = $mysqli->query('SELECT `login` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
$userHer = $mysqli->query('SELECT `id` FROM `users` WHERE `login` = "'.$user.'"')->fetch_assoc();
if($gift['close'] == 0){
	if(item_isset(43,$gift['price'])){
		$mysqli->query("INSERT INTO `user_gift` (`user`,`id_gift`,`user2`) VALUES('".$userHer['id']."','".$id."','".$userIam['login']."') ");
		minus_item(43,$gift['price']);
		$response['errorText'] = 0;
		$response['error'] = 'success';
	}else{
		$response['errorText'] = 1;
		$response['error'] = 'error';
	}
}
echo json_encode($response);
?>