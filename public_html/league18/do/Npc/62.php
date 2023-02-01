<?php
	$response['name'] = 'Джек Тыквенная Голова';
	switch($npcStep){
		case 1:
			itemAdd(108,20);
			$response['question'] = 'Перемещение...';
			$mysqli->query("UPDATE `users` SET `location`='95' WHERE `id`='".$_SESSION['id']."'");
			$wait = time()+3600;
			$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','60','".$wait."') ");
			$response['action'] = 'updateLocation';
		break;
		default:
				$response['question'] = 'Молодец! Ты нашел выход. Держи от меня награду! Разноцветная пыль (20 шт.)!';
				$response['answer'] = array(
					1 => "Забрать награду и выйти из комнаты"
				);
		break;
	}
?>
