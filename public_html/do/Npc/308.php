<?
	$a = $mysqli->query("SELECT * FROM `teleport_user` WHERE `user` = '".$_SESSION['id']."' AND `go` = 'ng_snowy'")->fetch_assoc();
	$response['name'] = 'Телепорт';
	switch($npcStep){
		case 1:
			$mysqli->query("UPDATE `users` SET `location`='".$a['location']."' WHERE `id`='".$_SESSION['id']."'");
			$response['action'] = 'updateLocation';
			$mysqli->query("DELETE FROM `teleport_user` WHERE `user` = '".$_SESSION['id']."' AND `go` = 'ng_snowy'");
		break;
		default:
			$response['question'] = 'Телепортирующее оборудование, возвращает вас в то место, откуда вы попали сюда.';
			$response['answer'] = array(
				1 => "Я хочу вернуться"
			);
		break;
	}
?>