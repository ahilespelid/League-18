<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
    }
}
function npc_time_check($id){
	global $mysqli;
	$q = $mysqli->query("SELECT `time` FROM `base_npc_data` WHERE `userID` = '".$_SESSION['id']."' AND `npcID` = '".$id."'")->fetch_assoc();
	$a = ($q['time'] > time() ? true : false);
	return $a;
}
function info_quest($id,$tip){
  global $mysqli;
  $quest = $mysqli->query("SELECT * FROM `user_quests` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '".$id."'")->fetch_assoc();
  $a = ($quest[$tip]?$quest[$tip]:false);
  return $a;
}
function quest_update($id, $step, $end=false){
	global $mysqli;
	if($end == false){$end = '0';}
	if(quest_isset($id)){
		$a = $mysqli->query("UPDATE `user_quests` SET `step` = '".$step."', `end` = '".$end."' WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '".$id."'");
	}else{
		$a = $mysqli->query("INSERT INTO `user_quests` (`quest_id`,`user_id`,`step`,`end`) VALUES('".$id."','".$_SESSION['id']."','".$step."','".$end."') ");
	}
return $a;
}
function quest_isset($id){
  global $mysqli;
  $quest = $mysqli->query("SELECT `quest_id` FROM `user_quests` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '".$id."'")->fetch_assoc();
  $a = ($quest['quest_id']?true:false);
  return $a;
}
function quest_step($id, $step){
  global $mysqli;
  if($step == 0)  $a = true;
   else{
      $q = $mysqli->query("SELECT `step` FROM `user_quests` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '".$id."'")->fetch_assoc();
      $a = ($q['step'] == $step?true:false);
  }
 return $a;
}
$location_id = clearInt($_POST["location_id"]);
$quest_id6_pokemon = item_isset(29,1); // Тут должен быть покемон, а не итем.
$pokemon_event_dr_aqua = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `event` = 1 AND `active` = 1")->fetch_assoc(); //Ивент, др игры
$locationID = $mysqli->query("SELECT `location`,`status`,`botID`,`weight`,`bagType` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
$typePokemon = $mysqli->query('
                SELECT
                  `up`.`id`,
                  `bp`.`type`
                FROM `user_pokemons` AS `up`
                INNER JOIN `base_pokemons` AS `bp`
                  ON `bp`.`id` = `up`.`basenum`
                WHERE
                    `up`.`user_id` = '.intval($_SESSION['id']).' AND
                    `up`.`active` = 1 AND (`bp`.`type` = "fire" OR `bp`.`type_two` = "fire")
            ')->fetch_assoc();
if(rand(1,100) > 20){
	if($locationID['botID'] != 0){
		$locationList = $mysqli->query('SELECT `id` FROM `base_location` WHERE `id` != 0 AND `region` = 1 ORDER BY RAND() LIMIT 1')->fetch_assoc();
		$mysqli->query('UPDATE `users` SET `location` = '.$locationList['id'].' WHERE `id` = '.$locationID['botID']);
	}
}
if($location_id == 1 && !quest_step(1,6)){
	$response['error'] = 1;
	$response['text'] = 'Необходимо пройти обучающее задание!';
}elseif($location_id == 37 && empty($typePokemon['type'])){
	$response['error'] = 1;
	$response['text'] = 'Слишком темно! Может быть стоит попробовать взять с собой Огненного покемона?';
}else if($location_id == 105 || $location_id == 106 || $location_id == 107 || $location_id == 111 || $location_id == 103){
	if(!npc_time_check(60)){
		$ra = rand(1,10);
	if($ra <= 7){
		$ran = rand(1,3);
		if($ran == 1){
			$mysqli->query("UPDATE `users` SET `location`='104' WHERE `id`='".$_SESSION['id']."'");
		}elseif($ran == 2){
			$mysqli->query("UPDATE `users` SET `location`='109' WHERE `id`='".$_SESSION['id']."'");
		}elseif($ran == 3){
			$mysqli->query("UPDATE `users` SET `location`='110' WHERE `id`='".$_SESSION['id']."'");
		}
	}else{
		$rand = rand(1,3);
		if($rand == 1){
			$mysqli->query("UPDATE `users` SET `location`='108' WHERE `id`='".$_SESSION['id']."'");
		}else{
			$mysqli->query("UPDATE `users` SET `location`='112' WHERE `id`='".$_SESSION['id']."'");
		}
	}
	}else{
		$response['text'] = 'Невозможно попасть в локацию!';
	}
	$response['action'] = 'updateLocation';
}else if($location_id == 101){
	$response['error'] = 1;
	$response['text'] = 'Злой ученый не пускает вас туда!';
}else if($location_id == 999){
	if ($_SESSION['id'] != 1 && $_SESSION['id'] != 2 && $_SESSION['id'] != 3){
	$response['error'] = 1;
	$response['text'] = 'Кажется Вы не Администратор!';
	}

//}else if($location_id == 202 && $timeday == 4 || $location_id == 202 && $timeday == 1){
 // if($locationID['location'] != 203) {
   // $response['error'] = 1;
  //	$response['text'] = 'Невозможно попасть в локацию. Мастерская закрыта. Она открыта лишь утром и днем.';
  //}
}else if($location_id == 199){
  if(item_isset(93,1)){
    $rand = rand(1,100);
    if($rand <= 2) {
      minus_item(93,1);
      $response['error'] = 1;
  		$response['text'] = 'Пытаясь спуститься вниз, ваша веревка оборвалась. Вниз вы так и не спустились.';
    }
  }else{
    $response['error'] = 1;
  	$response['text'] = 'Невозможно попасть в локацию. Необходима прочная веревка.';
  }
}elseif($location_id == 309){
  $usil = $mysqli->query("SELECT * FROM `bafs` WHERE `type` = '4' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
  if(isset($usil) && $usil['time'] > time()) {

  }else{
    $response['error'] = 1;
    $response['text'] = 'Злой голодный Снорлакс не пускает вас туда.';
  }
}else if($location_id == 193 && !item_isset(132,1) && info_quest(6,'step') <= 16){
	$response['error'] = 1;
	$response['text'] = 'У вас нет Огненного ключа';
}else if($location_id == 218 && info_quest(12,'step') <= 3){
	$response['error'] = 1;
	$response['text'] = 'Невозможно попасть в локацию.';
}else if($location_id == 222 && info_quest(11,'step') <= 1){
	$response['error'] = 1;
	$response['text'] = 'Невозможно попасть в локацию.';
}else if($location_id == 193 && item_isset(132,1) && info_quest(6,'step') <= 16){
	$rand = rand(1,3);
	if($rand != 1){
		$response['error'] = 1;
		$response['text'] = 'Ключ сломался. Необходим еще один.';
		minus_item(132,1);
	}else{
		quest_update(6,17);
		update_zap(6,17,'Дверь в закрытую комнату открыта. Что же там внутри меня ждет?');
		$response['error'] = 0;
		$mysqli->query("UPDATE `users` SET `location`='".$location_id."' WHERE `id`='".$_SESSION['id']."'");
		$mysqli->query("DELETE FROM `items_users` WHERE `item_id` = '132' AND `user` = '".$_SESSION['id']."'");
	}
}else if($location_id == 115 && $locationID['location'] == 51){
	if(item_isset(134,1)){
		$mysqli->query("UPDATE `users` SET `location`='".$location_id."' WHERE `id`='".$_SESSION['id']."'");
		minus_item(134,1);
		$response['error'] = 0;
	}else{
		$response['error'] = 1;
		$response['text'] = 'Невозможно попасть в локацию. У вас нет пропуска.';
	}
}else if($location_id == 74 && info_quest(6,'step') >= 1 && info_quest(6,'step') <= 4){
	$response['error'] = 1;
	$response['text'] = 'Невозможно попасть в локацию. Проход завален камнями.';
}else if($location_id == 206 && info_quest(10,'step') < 1){
	$response['error'] = 1;
	$response['text'] = 'Невозможно попасть в локацию. Незачем идти туда.';
}else if($location_id == 207 && !quest_step(10,3)){
	$response['error'] = 1;
	$response['text'] = 'Невозможно попасть в локацию. Незачем идти туда.';
}else if($location_id == 89){
	$response['error'] = 1;
	$response['text'] = 'Невозможно попасть в локацию. Турнир Кубок Морских Глубин еще не начался.';
}else if($location_id == 6 && info_quest(1,'step') < 1){
	$response['error'] = 1;
	$response['text'] = 'Поговорите с Профессором Оланом.';
}else if($location_id == 5 && info_quest(1,'step') < 3){
	$response['error'] = 1;
	$response['text'] = 'Невозможно попасть в локацию.';
}else if($location_id == 72 && !quest_isset(6)){
	$response['error'] = 1;
	$response['text'] = 'Из-за любопытства к руинам, уходить дальше пока что нет желания.';
}else if($location_id == 72 && quest_step(6,1)){
	$mysqli->query("UPDATE `users` SET `location`='73' WHERE `id`='".$_SESSION['id']."'");
	$response['action'] = 'updateLocation';
	update_zap(6,2,'Лестница сломалась, я упал вниз. Было больно. Надо выбираться отсюда.');
	quest_update(6,2);
}else if($location_id == 87){
	$response['error'] = 1;
	$response['text'] = 'Невозможно попасть в локацию. В праздничные дни Игровой центр закрыт.';
}else if($location_id == 79 && info_quest(6,'step') <= 4){
	$response['error'] = 1;
	$response['text'] = 'Невозможно попасть в локацию.';
}
	if($locationID['status'] != 'free'){
		$response['error'] = 1;
		$response['text'] = 'В данный момент вы не можете передвигаться!';
		die(json_encode($response));
	}elseif($response['error'] == 1){
		die(json_encode($response));
	}else{
		$response['error'] = 0;
		$getUserLocationInfo = $mysqli->query("SELECT `roads` FROM `loc_to` WHERE `loc_id`='".$locationID['location']."'")->fetch_assoc();
		$getUserLocationInfo1 = json_decode($getUserLocationInfo['roads']);
		if(in_array($location_id, $getUserLocationInfo1)){
			$mysqli->query("UPDATE `users` SET `location`='".$location_id."' WHERE `id`='".$_SESSION['id']."'");
		}
	}

echo json_encode($response);
?>
