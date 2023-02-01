<?
	$a = $mysqli->query("SELECT * FROM `teleport_user` WHERE `user` = '".$_SESSION['id']."' AND `go` = 'akvalandia2'")->fetch_assoc();
	$response['name'] = 'Могучая колдунья острова Акваландии';
	switch($npcStep){
		case 1:
			$mysqli->query("UPDATE `users` SET `location`='".$a['location']."' WHERE `id`='".$_SESSION['id']."'");
			$response['action'] = 'updateLocation';
			$mysqli->query("DELETE FROM `teleport_user` WHERE `user` = '".$_SESSION['id']."' AND `go` = 'akvalandia2'");
		break;
		default:
			$response['question'] = 'Привет, тренер! Остров уже ждет тебя! Развлекайся и будь осторожен!';
			$response['answer'] = array(
				1 => "Я хочу покинуть остров"
			);
		break;
	}
?>
