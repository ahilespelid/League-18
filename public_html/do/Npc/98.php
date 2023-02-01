<?
	$response['name'] = 'Дух Огня';
	switch($npcStep){
		case 1:
			if(quest_step(6,16)){
				$mysqli->query("UPDATE `users` SET `location`= 71 WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}
		break;
		default:
		if(quest_step(6,16)){
			$response['question'] = 'Подбери ключ к тому помещению <i>~Показывает в сторону Закрытой комнаты~</i>, если хочешь узнать истину..';
			$response['answer'] = array(
				1 => "Я хочу вернуться назад"
			);
		}else if(quest_step(6,17)){
			$response['question'] = 'Дверь открыта, вперед!';
		}else{
			$response['question'] = '<i>~Издает непонятные звуки~</i>';
		}
		break;
	}
?>