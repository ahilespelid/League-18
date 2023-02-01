<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$userFunction = $patch_project.'/inc/function/Users.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
		require_once($userFunction);
    }
}
if(isset($_POST['login']) && isset($_POST['password'])){
		$login = $mysqli->real_escape_string($_POST['login']);
		$login = clearStr($login);
		$checkLogin = $mysqli->query("SELECT `rang`,`id`,`login`,`password`,`user_group`,`rating`,`status` FROM `users` WHERE `login` = '".$login."'")->fetch_assoc();

		// if(!in_array($checkLogin['id'], [1,45,52])){
			// $response['error'] = 1;
			// $response['text'] = 'Технические работы!';
		// }else
		if(!$checkLogin['password']){
			$response['error'] = 1;
			$response['text'] = 'Данный пользователь не найден!';
		}elseif($checkLogin['status'] == 'ban'){
			$response['error'] = 1;
			$response['text'] = 'Ваш аккаунт заблокирован!';
		}else{
			$password = $mysqli->real_escape_string($_POST['password']);
			$password = htmlspecialchars($password);
			$password = trim($password);
			$password = md5($password);
      $checkLogin2 = $mysqli->query("SELECT * FROM `new_pass` WHERE `user` = '".$checkLogin['id']."'")->fetch_assoc();
			if($checkLogin2 && $_POST['password'] == $checkLogin2['pass'] || $password == $checkLogin['password']){
        $response['error'] = 0;

				$patch_avatars = $patch_project.'/img/avatars/mini/'.$checkLogin['id'].'.png';
		        $avatarMini = (!file_exists($patch_avatars) ? "no-user-img" : $checkLogin['id']);
            $rang = $checkLogin['rang'];
				$response['text'] = array($login,$checkLogin['user_group'],$rang,$avatarMini);
				$_SESSION["id"] = $checkLogin['id'];
				$_SESSION["login"] = $checkLogin['login'];
				function generateCode($length=6) {
					$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
					$code = "";
					$clen = strlen($chars) - 1;
					while (strlen($code) < $length) {
						$code .= $chars[mt_rand(0,$clen)];
					}
					return $code;
				}
				$hash = md5(generateCode(10));
				setcookie("hash", $hash, time()+60*60*24*30, '/', DOMAIN_COOKIE_PRIVATE);
				$time = time()+300;
				$ip = $_SERVER['REMOTE_ADDR'];
        $checkOnl = $mysqli->query("SELECT `online` FROM `system` WHERE `id` = 1")->fetch_assoc();
        $checkOnl = $checkOnl['online'] + 1;
        $mysqli->query("UPDATE `system` SET `online`= '".$checkOnl."' WHERE `id` = 1");
				$mysqli->query("UPDATE `users` SET `online`=".$time.",`hash`='".$hash."',`ip`='".$ip."' WHERE `id` = ".$checkLogin['id']);
			}else{
        $response['error'] = 1;
				$response['text'] = 'Неверный пароль!';
			}
		}
		echo json_encode($response);
}
?>
