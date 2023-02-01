<?
	$response['name'] = 'Столп Огня';
	switch($npcStep){
		case 1:
			if(quest_step(6,15)){
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/130.png" class="item"> Схема веревки (1 шт.)';
				itemAdd(130,1);
				quest_update(6,16);
				$response['question'] = 'Перемещение..';
				update_zap(6,16,'Похоже, я переместился к следующему испытанию.. На полу я нашел Схему веревки.');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$mysqli->query("UPDATE `users` SET `location`= 192 WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			if(quest_step(6,16)){
				$mysqli->query("UPDATE `users` SET `location`= 192 WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(!quest_isset(6)){
			$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
			$response['question'] = 'Язык слишком древний. Нужно попробовать найти кого-то, кто мог бы расшифровать.';
			quest_update(6,1);
			update_zap(6,1,'Я нашел несколько столпов в Круглом зале. На них изображены непонятные мне символы. Так же возле этих сооружений стоит какой-то мужчина. Я не буду рисковать подходить к нему. Может, стоит вернуться обратно?');
		}else if(quest_step(6,15)){
			$response['question'] = '<i>~Издает непонятные звуки~</i>';
			$response['answer'] = array(
				1 => "Вне сего мира, вне сего времени, огненные врата, отопритесь!"
			);
		}else if(quest_step(6,16)){
			$response['question'] = '<i>~Издает непонятные звуки~</i>';
			$response['answer'] = array(
				2 => "Вне сего мира, вне сего времени, огненные врата, отопритесь!"
			);
		}else{
			$response['question'] = '<i>~Издает непонятные звуки~</i>';
		}
		break;
	}
?>
