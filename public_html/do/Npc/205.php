<?
	$response['name'] = 'Исследователь Велор';
  $countPokDig = $mysqli->query('SELECT * FROM `user_raid` WHERE `user` = '.$_SESSION['id'])->fetch_assoc();
	switch($npcStep){
		case 1:
      if(mt_rand(1,100) <= 3) {
        itemAdd(178,1);
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/178.png" class="item"> Загадочный сундук (1 шт.)';
      }
			$response['question'] = 'Перемещение...';
			$mysqli->query("UPDATE `users` SET `location`='314' WHERE `id`='".$_SESSION['id']."'");
			$response['action'] = 'updateLocation';
		break;
    case 100:
      $mysqli->query("DELETE FROM user_raid WHERE user = '".$_SESSION['id']."' AND `raid` = 1");
      $mysqli->query("DELETE FROM items_users WHERE user = '".$_SESSION['id']."' AND `item_id` = 329");
      $mysqli->query("DELETE FROM user_quests WHERE user_id = '".$_SESSION['id']."' AND `quest_id` = 10000001");
      $time = time() + 259200;
      $mysqli->query("INSERT INTO base_npc_data (userID,npcID,time) VALUES (".$_SESSION['id'].",10000001,".$time.")");
      $response['question'] = 'Перемещение...';
      $mysqli->query("UPDATE `users` SET `location`='44' WHERE `id`='".$_SESSION['id']."'");
      $response['action'] = 'updateLocation';
    break;
		default:
    if($countPokDig['count'] < $countPokDig['need']) {
      $response['question'] = 'Диглетты! Нужно отбиться от них! Бей их, бей!';
  		$response['answer'] = array(
  			100 => "Покинуть рейд"
  		);
    }else{
      $response['question'] = 'Диглеттов стало гораздо меньше. Мы сможем пройти дальше. Кстати, ниже я заметил какой-то предмет, ценный предмет. Не уверен, что нам получитя его оттуда вытащить, но мы попытаемся!';
  		$response['answer'] = array(
  			100 => "Покинуть рейд",
        1 => "Идем дальше!"
  		);
    }
		break;
	}
?>
