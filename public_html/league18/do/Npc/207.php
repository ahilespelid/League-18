<?
	$response['name'] = 'Исследователь Велор';
	switch($npcStep){
		case 1:
      $user = $mysqli->query("SELECT * FROM users WHERE id = ".$_SESSION['id'])->fetch_assoc();
      if($user['status'] == 'free') {
        $mysqli->query("UPDATE `users` SET `status`='battle' WHERE `id`='".$_SESSION['id']."'");
        $response['question'] = 'Он уже очень близко! Дерись с ним!';
        $location_id = $mysqli->query("SELECT `id`,`login`,`user_group`,`region`,`location`,`sex`,`ban`,`status`,`status_id`,`rating`,`rang`,`botID`,`sprite` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
        quest_update(10000001,1);
        Info::_generatePve($location_id, $location_id['location']);
      }else{
        $response['question'] = 'Вы заняты.';
      }
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
    if(!quest_isset(10000001)) {
      $response['question'] = 'Похоже, мы попали в логово Дагтрио! Это можно заметить по отличительным следам. А где же сам владелец логова? Эм... А что это движется на нас? Не уж то... ЭТО ОН!';
      $response['answer'] = array(
        100 => "Покинуть рейд",
        1 => "Я вас защищу!"
      );
    }else{
      $response['question'] = 'Уходим-уходим! Пока он снова на нас не напал!';
      $response['answer'] = array(
        100 => "Покинуть рейд"
      );
    }
		break;
	}
?>
