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
function quest_step($id, $step){
  global $mysqli;
  if($step == 0)  $a = true;
   else{
      $q = $mysqli->query("SELECT `step` FROM `user_quests` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '".$id."'")->fetch_assoc();
      $a = ($q['step'] == $step?true:false);
  }
 return $a;
}
#Проверка на начало квеста
function quest_isset($id){
  global $mysqli;
  $quest = $mysqli->query("SELECT `quest_id` FROM `user_quests` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '".$id."'")->fetch_assoc();
  $a = ($quest['quest_id']?true:false);
  return $a;
}
#Обновление данных о квесте
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

#Проверка на начало ивента
function events_isset($id){
	global $mysqli;
	$event = $mysqli->query("SELECT id FROM base_events WHERE user = ".$_SESSION['id']." AND event = ".$id)->fetch_assoc();
	return $event['id'] ? true : false;
}
#Обновление данных об ивенте
function events_update($id, $step){
	global $mysqli;
	if(events_isset($id)){
		$a = $mysqli->query("UPDATE base_events SET step = ".$step." WHERE user = ".$_SESSION['id']." AND event = ".$id);
	}else{
		$a = $mysqli->query("INSERT INTO base_events(event,user,step) VALUES(".$id.",".$_SESSION['id'].",".$step.")");
	}
	return $a;
}
#Проверка стадии ивента
function events_step($id, $step){
	global $mysqli;
	if($step == 0){
		$a = true;
	}else{
		$q = $mysqli->query("SELECT step FROM base_events WHERE user = ".$_SESSION['id']." AND event = ".$id)->fetch_assoc();
		$a = ($q['step'] == $step ? true : false);
	}
	return $a;
}
#Обновление принесённого кол-ва предметов на ивенте
function events_count($id, $count){
	global $mysqli;
	if(events_isset($id)){
		$mysqli->query("UPDATE base_events SET count = count + ".$count." WHERE user = ".$_SESSION['id']." AND event = ".$id);
	}
}
#Определяет наличие ивент предмета
function events_count_item($id){
	$i = Work::$sql->query("SELECT count FROM base_events WHERE user = ".$_SESSION['id']." AND event = ".$id)->fetch_assoc();
	if(!empty($i['count']) && $i['count'] > 0){
		return $i['count'];
	}else{
		return false;
	}
}

#Проверка на время нпс
function npc_time_check($id){
	global $mysqli;
	$q = $mysqli->query("SELECT `time` FROM `base_npc_data` WHERE `userID` = '".$_SESSION['id']."' AND `npcID` = '".$id."'")->fetch_assoc();
	$a = ($q['time'] > time() ? true : false);
return $a;
}
#Данные из квеста
function info_quest($id,$tip){
  global $mysqli;
  $quest = $mysqli->query("SELECT * FROM `user_quests` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '".$id."'")->fetch_assoc();
  $a = ($quest[$tip]?$quest[$tip]:false);
  return $a;
}

if(isset($_POST['type'])){
	$checkUserLoc = $mysqli->query("SELECT `location`,`status` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
	if($checkUserLoc['status'] != 'free'){
		$response['error'] = 2;
		die(json_encode($response));
	}
	$type = $_POST['type'];
	if($type == 'nursery'){
		$checkLocName = $mysqli->query("SELECT `name` FROM `base_location` WHERE `id`='".$checkUserLoc['location']."'")->fetch_assoc();
		if($checkLocName['name'] == 'Пляжное кафе' || $checkLocName['name'] == 'Покецентр' || $checkLocName['name'] == 'Поле для тренировок' || $checkLocName['name'] == 'Небольшая деревня' || $checkLocName['name'] == 'Склад магазина' || $checkLocName['name'] == 'Арена'){
			$patch_Npc = $patch_project.'/do/Npc/nursery.php';
			require_once($patch_Npc);
		}else{
			$response['error'] = 2;
		}
	}elseif($type == 'fabian'){
		$patch_Npc = $patch_project.'/do/Npc/fabian.php';
		require_once($patch_Npc);
	}elseif($type == 'jess'){
		$patch_Npc = $patch_project.'/do/Npc/jess.php';
		require_once($patch_Npc);
	}elseif($type == 'reproduction'){
		$patch_Npc = $patch_project.'/do/Npc/reproduction.php';
		require_once($patch_Npc);
	}elseif($type == 'lombard'){
		$patch_Npc = $patch_project.'/do/Npc/lombard.php';
		require_once($patch_Npc);
	}
}elseif(isset($_POST['npc'])){
	$npcId = clearInt($_POST['npc']);
	$npcStep = $_POST['step'];
	$patch_Npc = $patch_project.'/do/Npc/'.$npcId.'.php';

	if(file_exists($patch_Npc)){
		$checkLoc = $mysqli->query("SELECT `loc_id` FROM `base_npc` WHERE `id`='".$npcId."'")->fetch_assoc();
		$checkUserLoc = $mysqli->query("SELECT `location` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
		if($checkLoc['loc_id'] != $checkUserLoc['location']){
			$response['error'] = 2;
		}else{
			require_once($patch_Npc);
		}
	}else{
		$response['error'] = 1;
	}
}
	echo json_encode($response);
?>
