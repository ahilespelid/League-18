<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';
	$response['name'] = 'Дух Воды';
	switch($npcStep){
		case 1:
			if(quest_step(6,11)){
				quest_update(6,12);
				update_zap(6,12,'Необходимо собрать 25 обрывков древнего заклинания в зале испытания. Если покинуть его, то весь прогресс сбросится и все надо будет проходить заново.');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$response['question'] = 'Удачи тебе.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			if(quest_step(6,12)){
				if(item_isset(129,25)){
					quest_update(6,13);
					update_zap(6,13,'25 обрывков древнего заклинания я собрал, теперь необходимо отнести их Горгу.');
					$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
					$mysqli->query("UPDATE `users` SET `location`= 71 WHERE `id`='".$_SESSION['id']."'");
					$response['action'] = 'updateLocation';
				}else{
					$response['question'] = 'Не ври мне!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 3:
			if(quest_step(6,12)){
				$mysqli->query("DELETE FROM `items_users` WHERE `item_id` = '129' AND `user` = '".$_SESSION['id']."'");
				$mysqli->query("UPDATE `users` SET `location`= 71 WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
			if(quest_step(6,11)){
				$response['question'] = 'Приветствую тебя! Это я разговаривал с тобой через столп воды.. Это первое испытание, первый шаг к истине.. Бей врагов - собирай награду! В любой момент ты можешь покинуть испытание, но все твои награды - исчезнут.. Собери для меня <b>25 Обрывков древних зклинаний</b>, и я выпущу тебя отсюда! Твой друг переведет тебе весь текст, написанный на обрывках..';
				$response['answer'] = array(
					1 => "Я справлюсь"
				);
			}else{
				$response['question'] = 'Ты принес <div class="itemIsset" onclick="issetAll(129,\'item\')" style="background-image: url(/img/world/items/little/129.png)"></div> 25 обрывков древнего заклинания?';
				$response['answer'] = array(
					2 => "Я принес 25 обрывков",
					3 => "Я хочу покинуть испытание"
				);
			}
		break;
	}
?>
