<?
	$response['name'] = 'Исследователь Велор';
	switch($npcStep){
		case 1:
      $randGrib = mt_rand(2,3);
      minus_item(329,1);
      itemAdd(330,$randGrib);
      $response['actionQuestPlus'] = '<img src="/img/world/items/little/330.png" class="item"> Подземный гриб ('.$randGrib.' шт.)';
      $response['actionQuestMinus'] = '<img src="/img/world/items/little/329.png" class="item"> Рычаг (1 шт.)';
			$response['question'] = 'Перемещение...';
			$mysqli->query("UPDATE `users` SET `location`='315' WHERE `id`='".$_SESSION['id']."'");
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
    if(!item_isset(329,1)) {
      $response['question'] = 'Видишь дверь? Похоже, ее не открыть без рычага. Рычага нет, он потерлся. Возможно, он у одного из этих Диглеттов! Давай, помогай выбить рычаг.';
      $response['answer'] = array(
        100 => "Покинуть рейд"
      );
    }else{
      $response['question'] = 'Вижу ты рычаг нашел? Давай его сюда, я вставлю его, и мы сможем пройти дальше. И, если ты не заметил, тут грибы какие-то странные растут. Сорви пару штучек, может пригодятся.';
      $response['answer'] = array(
        100 => "Покинуть рейд",
        1 => "Идем дальше!"
      );
    }
		break;
	}
?>
