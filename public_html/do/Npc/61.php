<?php
	$response['name'] = 'Джек Тыквенная Голова';
	switch($npcStep){
		case 1:
			$response['question'] = 'Перемещение...';
			$mysqli->query("UPDATE `users` SET `location`='95' WHERE `id`='".$_SESSION['id']."'");
			$wait = time()+3600;
			$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','60','".$wait."') ");
			$response['action'] = 'updateLocation';
		break;
		default:
				$response['question'] = 'Ты не справился с моим испытанием! Вон отсюда!';
				$response['answer'] = array(
					1 => "Выйти из комнаты"
				);
		break;
	}
?>
