<?
	$c = $mysqli->query("SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
	$response['name'] = 'Помощник адмирала';
	switch($npcStep){
		case 1:
			$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1','love_fest') ");
			$mysqli->query("UPDATE `users` SET `location`='214' WHERE `id`='".$_SESSION['id']."'");
			$response['action'] = 'updateLocation';
		break;
		default:
			$response['question'] = 'Здравия желаю! Военный Городок открыт для всех желающих. Хотите пройти?';
			$response['answer'] = array(
				1 => "Пройти в Военный Городок"
			);
		break;
	}
?>