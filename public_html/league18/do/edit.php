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
if(isset($_POST['type'])){
	switch($_POST['type']){
    case 'editTeam':
      $user = $mysqli->query("SELECT `team_open` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
      if($user['team_open'] == 0) {
        $mysqli->query("UPDATE `users` SET `team_open` = '1' WHERE `id` = '".$_SESSION['id']."'");
      }else{
        $mysqli->query("UPDATE `users` SET `team_open` = '0' WHERE `id` = '".$_SESSION['id']."'");
      }
			$response['error'] = 0;
		break;
    case 'editColor':
      if($_POST['set'] == 1) {
        $mysqli->query("UPDATE `users` SET `colorChat` = '1' WHERE `id` = '".$userID."'");
      }elseif($_POST['set'] == 2){
        $mysqli->query("UPDATE `users` SET `colorChat` = '2' WHERE `id` = '".$userID."'");
      }elseif($_POST['set'] == 3){
        $mysqli->query("UPDATE `users` SET `colorChat` = '3' WHERE `id` = '".$userID."'");
      }elseif($_POST['set'] == 4){
        $mysqli->query("UPDATE `users` SET `colorChat` = '4' WHERE `id` = '".$userID."'");
      }elseif($_POST['set'] == 5){
        $mysqli->query("UPDATE `users` SET `colorChat` = '5' WHERE `id` = '".$userID."'");
      }elseif($_POST['set'] == 6){
        $mysqli->query("UPDATE `users` SET `colorChat` = '6' WHERE `id` = '".$userID."'");
      }else{
        $mysqli->query("UPDATE `users` SET `colorChat` = '1' WHERE `id` = '".$userID."'");
      }
			$response['error'] = 0;
		break;
		case 'pass':
			$user = $mysqli->query("SELECT `password` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
      $new_pass = $mysqli->query("SELECT * FROM `new_pass` WHERE `user` = '".$_SESSION['id']."'")->fetch_assoc();
			if($user['password'] == md5($_POST['pass']) || $new_pass && $_POST['pass'] == $new_pass['pass']){
        $password = $mysqli->real_escape_string($_POST['newPass']);
				$password = htmlspecialchars($password);
				$password = trim($password);
				$password = md5($password);
				$mysqli->query("UPDATE `users` SET `password` = '".$password."' WHERE `id` = '".$userID."'");
        $mysqli->query("DELETE FROM `new_pass` WHERE `user` = ".$_SESSION['id']);
				$response['error'] = 0;
			}else{
        $response['error'] = 1;
				$response['text'] = 'Неверно введён старый пароль!';
			}
		break;
		// case 'team_open':
			// $user = $mysqli->query('SELECT `team_open` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
			// if($user['team_open'] == 0){
				// $mysqli->query('UPDATE `users` SET `team_open` = 1 WHERE `id` = '.$_SESSION['id']);
			// }else{
				// $mysqli->query('UPDATE `users` SET `team_open` = 0 WHERE `id` = '.$_SESSION['id']);
			// }
		// break;
		case 'closeNotifyAdmin':
			$idNotify = clearInt($_POST['idNotify']);
			$mysqli->query('INSERT INTO `adminNotifyCheck` (`user_id`,`id_notify`) VALUES ('.$_SESSION['id'].','.$idNotify.') ');
		break;
		case 'editSound':
			$user = $mysqli->query('SELECT `sound` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
			if($user['sound'] == 0){
				$mysqli->query('UPDATE `users` SET `sound` = 1 WHERE `id` = '.$_SESSION['id']);
			}else{
				$mysqli->query('UPDATE `users` SET `sound` = 0 WHERE `id` = '.$_SESSION['id']);
			}
    break;
		//case 'editSprite':
			//$user = $mysqli->query('SELECT `sprite` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
			//if((int)$user['sprite'] == 0){
			//	$mysqli->query('UPDATE `users` SET `sprite` = 1 WHERE `id` = '.$_SESSION['id']);
			//}else{
			//	$mysqli->query('UPDATE `users` SET `sprite` = 0 WHERE `id` = '.$_SESSION['id']);
			//}
		//break;
		case 'LangRu':
			$mysqli->query('UPDATE `users` SET `lang` = "ru" WHERE `id` = '.$_SESSION['id']);
		break;
		case 'LangUa':
			$mysqli->query('UPDATE `users` SET `lang` = "ua" WHERE `id` = '.$_SESSION['id']);
		break;
		default:
				$response['error'] = 1;
				$response['text'] = 'Ошибка запроса!';
		break;
	}
}
echo json_encode($response);
?>
