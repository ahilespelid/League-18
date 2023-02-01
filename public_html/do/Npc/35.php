<?
	$response['name'] = 'Мистер Горг';
	switch($npcStep){
		case 1:
			$response['question'] = 'Я частично перевел их. Они связаны с какими-то духами.';
			$response['answer'] = array(
				2 => "С духами? Немного жутко стало.."
			);
		break;
		case 2:
			$response['question'] = 'Не стоит бояться. Надписи гласят, что они более, чем безобидны. Но, тут есть строчки, которые мне до сих пор непонятны.';
			$response['answer'] = array(
				3 => "Можно немного подробней?"
			);
		break;
		case 3:
			$response['question'] = 'Тут написано что-то про порталы в другие миры. Или что-то в этом роде.. Путешествие во времени, возможно..';
			$response['answer'] = array(
				4 => "Очень интересно. И где найти этот порталы в другие миры?"
			);
		break;
		case 4:
			if(quest_step(6,9)){
				quest_update(6,10);
				update_zap(6,10,'Водный столп засветился. Нужно понять в чем дело.');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$response['question'] = 'Я не зна.. ЧТО? Смотри! Один из столпов загорелся ярким светом! Кажется, это водный столп..';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 5:
			if(quest_step(6,13)){
				quest_update(6,14);
				update_zap(6,14,'Через час нужно быть в Круглом зале. Горг расшифровывает обрывки.');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$response['question'] = 'Да, конечно, давай их сюда. Символы мне понятны.. Приходи через час, все будет готово.';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/129.png" class="item"> Обрывок древнего заклинания (25 шт.)';
				minus_item(129,25);
				$wait = time()+3600;
				$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(quest_step(6,9)){
			$response['question'] = 'Привет. Мне про тебя рассказали. Тебе ведь интересно, что скрывают эти столпы?';
			$response['answer'] = array(
				1 => "Здравствуйте, да"
			);
		}else if(quest_step(6,13)){
			$response['question'] = 'Как прошло испытание? Я надеюсь, что все хорошо?';
			$response['answer'] = array(
				5 => "Да, все хорошо. Мне нужно, чтобы вы расшифровали заклинание на этих обрывках"
			);
		}else if(quest_step(6,14) && !npc_time_check(35)){
				quest_update(6,15);
				update_zap(6,15,'Заклинание, которое перевел Горг, звучит так: <b>"Вне сего мира, вне сего времени, огненные врата, отопритесь!"</b>. Горг считает, что его нужно произнести возле огненного столпа.');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$response['question'] = 'Я расшифровал заклинание. Оно звучит так: <b>"Вне сего мира, вне сего времени, огненные врата, отопритесь!"</b>. Думаю, эти строчки нужно произнести возле огненного столпа.';
				$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 35 AND `userID` = '".$_SESSION['id']."'");
		}else{
			if(npc_time_check(35)){
				$response['question'] = 'Я еще перевожу текст.. Приходи позже.';
			}else{
				$response['question'] = 'Я немного занят.';
			}
		}
		break;
	}
?>
