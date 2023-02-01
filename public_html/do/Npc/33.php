<?
	$response['name'] = 'Капитан';
	switch($npcStep){
		case 1:
			if(quest_step(1000,1) && !npc_time_check($npcId) || quest_step(1000,2) && !npc_time_check($npcId)){
				if(quest_step(1000,1)){
					quest_update(1000,101);
				}elseif(quest_step(1000,2)){
					quest_update(1000,102);
				}
				$wait = time()+5400;
				$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
				$response['question'] = 'Приятного пути! Мы приплывем через 1 час 30 минут.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			if(!npc_time_check($npcId)){
				$response['question'] = 'Прибыли!';
				$response['answer'] = array(
					3 => "Покинуть корабль"
				);
			}else{
				$response['question'] = 'Еще нет. Имейте терпение ^^';
			}
		break;
		case 3:
			if(!npc_time_check($npcId)){
				if(quest_step(1000,101) || quest_step(1000,102)){
					if(quest_step(1000,101)){
						$mysqli->query("UPDATE `users` SET `location`='83' WHERE `id`='".$_SESSION['id']."'"); // Перемещение в Порт Растборо
					}elseif(quest_step(1000,102)){
						$mysqli->query("UPDATE `users` SET `location`='81' WHERE `id`='".$_SESSION['id']."'"); // Перемещение в Порт Вермилиона
					}
					$response['action'] = 'updateLocation';
					$mysqli->query("DELETE FROM `user_quests` WHERE `quest_id` = 1000 AND `user_id` = '".$_SESSION['id']."'");
					$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 32 AND `userID` = '".$_SESSION['id']."'");
					$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 33 AND `userID` = '".$_SESSION['id']."'");
					$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 74 AND `userID` = '".$_SESSION['id']."'");
				}else{
					$response['question'] = 'Ошибка!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
			if(info_quest(1000,'step') >= 101){
				$response['question'] = 'Не знаете чем заняться? Посетите специальную комнату для того, чтобы потренеровать своих покемонов. Отличное место.';
				$response['answer'] = array(
					2 => "Мы уже прибыли?"
				);
			}else{
				$response['question'] = 'Чудесная погодка сегодня! Ну, что, отчаливаем?';
				$response['answer'] = array(
					1 => "Да"
				);
			}
		break;
	}
?>