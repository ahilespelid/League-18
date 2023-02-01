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

$user = $mysqli->query('SELECT `LastPrize` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();

	$gifts = $mysqli->query('SELECT * FROM `dayGift`');

	$giftsList = []; 
	if(!empty($gifts)){
		while ($gift = $gifts->fetch_assoc()){ 
			$giftsList[] = [ 
				'id'	=>$gift['item'], 
				'count'	=>$gift['count'] 
			]; 
		}
	}
	if($user['LastPrize'] < date('Y-m-d')){
		$carusel = array_merge($giftsList, $giftsList); 
		shuffle($carusel);
	}else{
		$carusel = 0;
	}

	$return = [
				'list'=>$giftsList,
				'carusel'=>$carusel
			];

echo json_encode($return);
?>