<?
	$response['name'] = 'Оператор Телепортатора';
	switch($npcStep){
		case 1:
      if(item_isset(158,1)){
        $mysqli->query("DELETE FROM  `base_npc_data` WHERE `userID` = ".$_SESSION['id']." AND `npcID` = 32");
        $mysqli->query("DELETE FROM  `base_npc_data` WHERE `userID` = ".$_SESSION['id']." AND `npcID` = 74");
        $mysqli->query("DELETE FROM  `user_quests` WHERE `user_id` = ".$_SESSION['id']." AND `quest_id` = 1000");
        $response['actionQuestMinus'] = '<img src="/img/world/items/little/158.png" class="item"> Телепортатор Канто - Хоэнн (1 шт.)';
        $response['question'] = '...';
        $mysqli->query("UPDATE `users` SET `location`='232' WHERE `id`='".$_SESSION['id']."'"); // Перемещение в Канто
				$response['action'] = 'updateLocation';
        minus_item(158,1);
      }else{
        $response['question'] = 'У тебя нет телепортатора.';
      }
		break;
		default:
			$response['question'] = 'Здравствуй! Наше устройство позволяет мгновенно переместиться из одного места в другое. Мы можем перенести тебя в другой регион, но нужен специальный телепортатор.';
			$response['answer'] = array(
				1 => "Переместиться в Хоэнн"
			);
		break;
	}
?>
