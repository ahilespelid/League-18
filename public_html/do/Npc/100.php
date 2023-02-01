<?
	$response['name'] = 'Сундук с сокровищем';
	switch($npcStep){
		case 1:
			if(quest_step(6,17)){
				itemAdd(22,1);
				quest_update(6,18);
				update_zap(6,18,'Сундук с порванной тканью - вот, что меня ждало за дверью. Приятный подарок от Огненного духа, никак иначе. Но, что же ждет меня дальше? Думаю, нужно как-нибудь внимательнее изучить третий столп.');
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/22.png" class="item"> Порванная ткань (1 шт.)';
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$mysqli->query("UPDATE `users` SET `location`= 71 WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(quest_step(6,17)){
			$response['question'] = '<i>~В сундуке вы нашли странную <div class="itemIsset" style="background-image: url(/img/world/items/little/22.png)" onclick="issetAll(22,\'item\')"></div>~</i>';
			$response['answer'] = array(
				1 => "Забрать ткань"
			);
		}else{
			$response['question'] = '<i>~Издает непонятные звуки~</i>';
		}
		break;
	}
?>
