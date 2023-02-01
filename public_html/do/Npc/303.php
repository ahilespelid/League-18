<?
	$response['name'] = 'Портниха';
	switch($npcStep){
		case 1:
			if(quest_step(21,7)){
				$response['question'] = 'Кажется, я поняла вас... Вы тот самый помощник Деда Мороза?';
			    $response['answer'] = array(
				2 => "Да, это я. Вы поможете мне?"
			);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			if(quest_step(21,7)){
				$response['question'] = 'Конечно, я сделаю все, что смогу. Для того, чтобы я могла сшить мешок, понадобится собрать некоторые материалы со всех уголков Канто. Либо, если времени на поиски у вас нет, мы можем отправить собрать всё необходимое моего помошника. Его работа стоит 5 жемчужин.';
			    $response['answer'] = array(
				3 => "Я соберу всё сам. Давайте список!",
				4 => "Вы знаете, я готов заплатить."
			);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 3:
			if(quest_step(21,7)){
				quest_update(21,8);
				$response['question'] = 'Записывай! <br> Мне нужны:<br> - Чудесное семя (1 шт) <br> - Лоскут от мешка (10 шт). Они разбросаны где-то на моём заднем дворе, дорогу я покажу <br> - Монеты (5000 шт) <br> Когда всё это будет у тебя, приходи.';
			$response['answer'] = array(
				6 => "Я хочу попасть на задний двор."
			);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 4:
		     if(item_isset(43,5)) {
			if(quest_step(21,7)){
				quest_update(21,9);
				$response['question'] = 'Да, конечно, давай жемчуг.  Приходи через 12 часов, все будет готово.';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг (5 шт.) ';
				minus_item(43,5);
				$wait = time()+43200;
				$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
			}
		     }else{
				$response['question'] = 'Ошибка!';
			}
		break;		
		case 5:
		     if(item_isset(185,1) && item_isset(1,5000) &&  item_isset(339,10)) {
			if(quest_step(21,8)){
				quest_update(21,9);
				$response['question'] = 'Да, конечно, давай их сюда.  Приходи через час, все будет готово.';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/339.png" class="item"> Лоскут(10 шт.) <br> <img src="/img/world/items/little/185.png" class="item"> Чудесное семя (1 шт) <br> <img src="/img/world/items/little/1.png" class="item"> Монета(5000 шт) ';
				minus_item(185,1);
				minus_item(1,5000);
				minus_item(339,10);
				$wait = time()+3600;
				$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
			}
		     }else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 6:
			if(quest_step(21,8)){
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1001','ng_quest_mehok') ");
		$mysqli->query("UPDATE `users` SET `location`='1004' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
				$response['question'] = 'Предмет уже в твоём инвентаре. Удачи, и помни, что завершить все необходимо до 12:00 31-12-2022.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		
		default:
		if(quest_step(21,7)){
			$response['question'] = 'Здравстуйте! Что привело вас в мою мастерскую?';
			$response['answer'] = array(
				1 => "Здравствуйте, мне нужен мешок, в которые можно было бы сложить большое количество подарков."
			);
		}else if(quest_step(21,8)){
			$response['question'] = 'Все нужные материалы у тебя? <br> Мне нужны:<br> - Чудесное семя (1 шт) <br> - Лоскут от мешка (10 шт). Они разбросаны где-то на моём заднем дворе, дорогу я покажу <br> - Монеты (5000 шт) <br>';
			$response['answer'] = array(
				5 => "Да, все собрано.",
				6 => "Я хочу попасть на задний двор."
			);
		}else if(quest_step(21,9) && !npc_time_check(303)){
				quest_update(21,10);
				itemAdd(340,1);
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/340.png" class="item"> Мешок';
				$response['question'] = 'Все готово. Держи!';
				
				$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 303 AND `userID` = '".$_SESSION['id']."'");
		}else{
			if(npc_time_check(303)){
				$response['question'] = 'Я еще занята починкой мешка.. Приходи позже.';
			}else{
				$response['question'] = 'Я немного занята.';
			}
		}
		break;
	}
?>