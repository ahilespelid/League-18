<?
	$response['name'] = 'Столп Начала';
	switch($npcStep){
		case 1:
			if(quest_step(6,18)){
				quest_update(6,19);
				update_zap(6,19,'Третий столп переместил меня в некий мир через портал. Похоже, меня ждет последнее испытание..');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$mysqli->query("UPDATE `users` SET `location`= 194 WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			if(quest_step(6,20)){
				$mysqli->query("UPDATE `users` SET `location`= 194 WHERE `id`='".$_SESSION['id']."'");
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
		}else if(quest_step(6,18)){
			$response['question'] = 'Не может быть, никто из смертных не проходил испытания от Водного и Огненного духа! Вижу, что ты силен! Чтож, прошу в мой мир, человек!';
			$response['answer'] = array(
				1 => "Зайти в портал"
			);
		}else if(quest_step(6,20)){
			$response['question'] = 'Ты хочешь продолжить испытание?';
			$response['answer'] = array(
				2 => "Зайти в портал"
			);
		}else{
			$response['question'] = '<i>~Издает непонятные звуки~</i>';
		}
		break;
	}
?>
