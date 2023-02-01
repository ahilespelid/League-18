<?
	$response['name'] = 'Столп Воды';
	switch($npcStep){
		case 1:
			if(quest_step(6,10)){
				quest_update(6,11);
				update_zap(6,11,'Мне необходимо пройти испытание. Для этого я и шагнул в портал. Мне интересно узнать все об этих духах..');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$response['question'] = 'Перемещение..';
				$mysqli->query("UPDATE `users` SET `location`= 80 WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			if(quest_step(6,12)){
				$mysqli->query("UPDATE `users` SET `location`= 80 WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(!quest_isset(6)){
			$response['question'] = 'Язык слишком древний. Нужно попробовать найти кого-то, кто мог бы расшифровать.';
			quest_update(6,1);
			update_zap(6,1,'Я нашел несколько столпов в Круглом зале. На них изображены непонятные мне символы. Так же возле этих сооружений стоит какой-то мужчина. Я не буду рисковать подходить к нему. Может, стоит вернуться обратно?');
			$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
		}else if(quest_step(6,10)){
			$response['question'] = 'Ты хочешь узнать правду о нас? Так пройди наше испытание. Познай всю силу духов! Зайди в портал и узнай правду..';
			$response['answer'] = array(
				1 => "Я готов пройти испытание"
			);
		}else if(quest_step(6,12)){
			$response['question'] = 'Ты не справился с моим испытанием..';
			$response['answer'] = array(
				2 => "Я хочу начать испытание заново"
			);
		}else{
			$response['question'] = '<i>~Издает непонятные звуки~</i>';
		}
		break;
	}
?>
