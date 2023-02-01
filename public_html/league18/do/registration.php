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
if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['mail'])){
		$login = $mysqli->real_escape_string($_POST['login']);
		$login = htmlspecialchars($login);
		$login = trim($login);
		$login = addslashes($login);
		$checkLogin = $mysqli->query("SELECT * FROM `users` WHERE `login` = '".$login."'");

		if($checkLogin->num_rows > 0){
			$response['error'] = 1;
			$response['text'] = 'Данный логин занят!';
		}else{
			$mail = $mysqli->real_escape_string($_POST['mail']);
			$mail = htmlspecialchars($mail);
			$mail = trim($mail);
			$mail = addslashes($mail);
			$checkMail = $mysqli->query("SELECT * FROM `users` WHERE `email` = '".$mail."'");
			if($checkMail->num_rows > 0){
				$response['error'] = 1;
				$response['text'] = 'Данная почта занята!';
			}else{
				$ip = $_SERVER['REMOTE_ADDR'];
				$checkIP = $mysqli->query("SELECT `login` FROM `users` WHERE `ip` = '".$ip."'");
				if($checkIP->num_rows > 0 && 1 != 1){
					$a = $checkIP->fetch_assoc();
					$response['error'] = 1;
					$response['text'] = 'На данном IP уже имеется аккаунт! Ник: '.$a['login'];
				}else{
					$sex = ($_POST['gender'] == 'm' ? 'm' : 'f');
					$password = $mysqli->real_escape_string($_POST['password']);
					$password = htmlspecialchars($password);
					$password = trim($password);
					$password = md5($password);
					$rating = '{"pve": 0, "pvp": 0, "battleCount": 0}';
					$countPoks = '{"shine": 0, "normal": 0}';
					$dateReg = time();
					$mysqli->query("INSERT INTO `users` (`login`,`password`,`email`,`sex`,`rating`,`countPoks`,`dateReg`,`ip`) VALUES ('".$login."','".$password."','".$mail."','".$sex."','".$rating."','".$countPoks."','".$dateReg."','".$ip."')");
					$userID = $mysqli->insert_id;
					if($sex != 'f'){
						$mysqli->query("INSERT INTO `cloth` (`user`,`model`,`mouth`,`eye`,`hair`,`eyebrow`,`slot1`,`slot2`,`slot3`,`slot4`,`slot5`,`slot6`,`slot7`,`slot8`,`slot9`,`slot10`) VALUES ('".$userID."',1,1,1,1,1,1,1,1,1,1,1,1,1,1,1)");
					}else{
						$mysqli->query("INSERT INTO `cloth` (`user`,`model`,`mouth`,`eye`,`hair`,`eyebrow`,`slot1`,`slot2`,`slot3`,`slot4`,`slot5`,`slot6`,`slot7`,`slot8`,`slot9`,`slot10`) VALUES ('".$userID."',3,1,1,7,1,1,1,1,1,0,1,1,1,1,1)");
					}
					$response['error'] = 0;
					$response['text'] = $login;
				}
			}
		}
		echo json_encode($response);
}
?>
