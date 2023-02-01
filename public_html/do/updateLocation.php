<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$patch_makasimka = $patch_project.'/makasimka/';
$userFunction = $patch_project.'/inc/function/Users.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
        require_once($patch_global);
		require_once($userFunction);
    }
}
$location_id = $mysqli->query("SELECT `id`,`login`,`user_group`,`region`,`location`,`sex`,`ban`,`status`,`status_id`,`rating`,`rang`,`botID`,`sprite` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
if($location_id['botID'] != 0){
	$timeUpdate = time() + 300;
	$mysqli->query('UPDATE `users` SET `online` = '.$timeUpdate.' WHERE `id` = '.$location_id['botID']);
}
$time = time();
$rand = rand(1,5);
$weatherTime = $time+1800;
$weatherID = $mysqli->query('SELECT id FROM base_region WHERE weather_time < '.$time)->fetch_assoc();
if($weatherID){
	$mysqli->query('UPDATE `base_region` SET weather = '.$rand.', weather_time = '.$weatherTime.' WHERE id = '.$weatherID['id']);
}
$ratings = json_decode($location_id['rating']);
$rang = population($ratings->pve).' '.reputation($ratings->pvp,$ratings->battleCount);
if($rang != $location_id['rang']){
	$mysqli->query('UPDATE `users` SET `rang` = "'.$rang.'" WHERE `id` = '.$_SESSION['id']);
}
$timeOnline = time() - 300;
$userNotice = $mysqli->query('SELECT * FROM `user_notice` WHERE `touser_id` = '.intval($_SESSION['id']).' ');
if(empty($response)){
    $response = [];
}
$userNoticeArr = [];
$userNoticeDefArr = [];
$userNoticeDell = [];
$noticeHash = '';

if($userNotice){
    while($userNoticeList = $userNotice->fetch_assoc()){

        if($userNoticeList['type'] == 'default'){
            $userNoticeDell[] = $userNoticeList['id'];
            $userNoticeDefArr[] = [
                'text'=>$userNoticeList['info']
            ];
        }else{
            $noticeHash .= 'id'.$userNoticeList['id'];
            if(!isset($userNoticeArr['u'.$userNoticeList['user_id']])){
                $userNoticeArr['u'.$userNoticeList['user_id']] = [];
            }
            $userNoticeArr['u'.$userNoticeList['user_id']][] = [
                'id'=>$userNoticeList['id'],
                'hash'=>$userNoticeList['hash'],
                'type'=>$userNoticeList['type'],
                'info'=>$userNoticeList['info'],
            ];
        }

    }
}

if(!empty($userNoticeDell)){
    $mysqli->query("DELETE FROM `user_notice` WHERE `id` IN (".implode(',', $userNoticeDell).")");
}

if($userNoticeArr){
    $response["usersAtNotice"] = $userNoticeArr;
}
if($userNoticeDefArr){
    $response["usersDefNotice"] = $userNoticeDefArr;
}

if($location_id['status'] != 'free'){

    switch($location_id['status']){
        case 'battle':
            new ActionBattle($location_id, [], $response);
            break;
        case 'trade':
            new Trade($mysqli, $location_id, $response);
            break;
    }

    $_SESSION['battle_refresh'] = time() + mt_rand(20, 30);

}else{

    if(isset($_SESSION['battle_refresh'])){

        if($_SESSION['battle_refresh'] <= time()){

            $getUserLocationInfo = $mysqli->query("SELECT `pve` FROM `base_location` WHERE `id`='".$location_id['location']."'")->fetch_assoc();

            if($getUserLocationInfo['pve'] > 0){

                if((!empty($_POST['userAssault']) && $_POST['userAssault'] != 'false') || $getUserLocationInfo['pve'] == 2){
                    Info::_generatePve($location_id, $location_id['location']);
                }

            }

            //$_SESSION['battle_refresh'] = time() + mt_rand(20, 30);
        }

    }else{
        $_SESSION['battle_refresh'] = time() + mt_rand(20, 30);
    }

}


if(isset($_POST['updateUsers'])){
    $countUsersAtLocation = $mysqli->query("SELECT `sex`,`id`,`user_group`,`login` FROM `users` WHERE `location`='".$location_id['location']."' AND `online` >= '".$timeOnline."' ORDER BY `id`");
    $response["countUsersAtLocation"] = $countUsersAtLocation->num_rows;
    $usersLoc = [];
    $userHash = '';

    while($usersInfo = $countUsersAtLocation->fetch_assoc()){
        $userHash .= 'id'.$usersInfo['id'];

        //$usersLoc.='<div id="_list_user_id_'.$usersInfo['id'].'"  class="user"><div class="user-link u-'.$usersInfo['user_group'].'">'.$usersInfo['login'].'</div></div> ';

        $usersLoc[] = [
            'id'=>$usersInfo['id'],
            'login'=>$usersInfo['login'],
            'group'=>$usersInfo['user_group'],
            'sex'=>$usersInfo['sex'],
            'isOffer'=>(isset($userNoticeArr['u'.$usersInfo['id']]) ? true : false)
        ];
    }
  $bafsSelect = $mysqli->query("SELECT * FROM `bafs` WHERE `user`=".$_SESSION['id']);
  while($baf = $bafsSelect->fetch_assoc()){
    if(time() < $baf['time']) {
      $bafs .= '<div class="Baf" onclick=issetAll('.$baf['baf'].',"baf") style="background-image: url(/img/world/items/little/'.$baf['baf'].'.png);"></div>';
    }
  }
  if($bafs) {
    $bafs = $bafs;
  }else{
    $bafs = '';
  }

  //$pokemonMove = $mysqli->query("SELECT * FROM `adminNotify` WHERE `author`=1")->fetch_assoc();
  //if(isset($pokemonMove)) {
  //  $response['pmove'] = 1;
  //}else{
  //  $response['pmove'] = 0;
  //}

	$server = $mysqli->query("SELECT * FROM `system` WHERE `id`=1")->fetch_assoc();
  $response['bafs'] = $bafs;
  $response['tw'] = $server['closed'];
	$response["ver"] = $server['version'];
    $response["usersAtLocation"] = $usersLoc;
    $response["usersAtLocationHash"] = md5($userHash.$noticeHash);
    $response["serverTime"] = date('H:i');
	$myUser = $mysqli->query("SELECT location, id, opros FROM users WHERE id = ".$_SESSION['id'])->fetch_assoc();
	$locaReg = $mysqli->query("SELECT region FROM base_location WHERE id = ".$myUser['location'])->fetch_assoc();
	$weather = $mysqli->query("SELECT * FROM base_region WHERE id = ".$locaReg['region'])->fetch_assoc();
	$weatherName = $mysqli->query("SELECT name FROM weather WHERE id = ".$weather['weather'])->fetch_assoc();
	$response['WeatherName'] = $weatherName['name'];
	$response['WeatherId'] = $weather['weather'];
    if(!empty($server_ver)){
        $response['server_ver'] = $server_ver;
    }
    new GameChat($mysqli, ['type'=>'read'], $response, $location_id);
    print (is_array($response) ? Info::_parseData($response) : $response);

    die();
}

$getUserLocationInfo = $mysqli->query("SELECT * FROM `loc_to` WHERE `loc_id`='".$location_id['location']."'")->fetch_assoc();
$getLocationRoads = json_decode($getUserLocationInfo["roads"]);
$getUserLocationInfo = $mysqli->query("SELECT * FROM `base_location` WHERE `id`='".$location_id['location']."'")->fetch_assoc();
$getLocationNPCActive = $mysqli->query("SELECT * FROM `npc_active` WHERE `user_id`='".$_SESSION['id']."'");
$getLocationNPC = $mysqli->query("SELECT * FROM `base_npc` WHERE `loc_id`='".$location_id['location']."'");

$locations = [];
$npc = [];
if (count($getLocationRoads) > 0) {
    for ($i=0; $i < count($getLocationRoads); $i++) {
        $locId = $getLocationRoads[$i];
        $getLocInfo = $mysqli->query("SELECT * FROM `base_location` WHERE `id`='".$locId."'")->fetch_assoc();
		$imgLocMini = (!file_exists($patch_project.'/img/world/location/'.$getLocInfo['id'].'.png') ? 0 : $getLocInfo['id']);
		$dopClass = (!file_exists($patch_project.'/img/world/location/'.$getLocInfo['id'].'.png') ? 'background-size: 1000%;background-size: center;' : '');
        $locations[] = [
							'id'		=>$getLocInfo["id"],
							'img'		=>$imgLocMini,
							'dopClass'	=>$dopClass,
							'name'		=>$getLocInfo["name"],
              'event'		=>$getLocInfo["event"]
				];
    }
}
while($baseNpc = $getLocationNPC->fetch_assoc()){
    if($baseNpc['id'] == 187) {
      $q19 = $mysqli->query("SELECT * FROM `user_quests` WHERE `user_id`='".$_SESSION['id']."' AND `quest_id` = '19'")->fetch_assoc();
      if($q19) {
        $baseNpc['name'] = '';
      }
    }
    if($baseNpc['id'] == 193) {
      $q19 = $mysqli->query("SELECT * FROM `user_quests` WHERE `user_id`='".$_SESSION['id']."' AND `quest_id` = '19'")->fetch_assoc();
      if(!$q19) {
        $baseNpc['name'] = '';
      }
    }
    if($baseNpc['id'] == 194) {
      $q19 = $mysqli->query("SELECT * FROM `user_quests` WHERE `user_id`='".$_SESSION['id']."' AND `quest_id` = '19'")->fetch_assoc();
      if($q19) {
        if($q19['step'] >= 2 && $timeday == 2) {
          $baseNpc['name'] = $baseNpc['name'];
        }else{
          $baseNpc['name'] = '';
        }
      }else{
        $baseNpc['name'] = '';
      }
    }
		$npc[] = [
      'id'	=> $baseNpc['id'],
      'name'	=> $baseNpc['name'],
      'event'	=> $baseNpc['event']
    ];
}

$patch_img = $patch_project.'/img/world/location/'.$location_id['location'].'.png';

if(!empty($patch_img)){
    if(!file_exists($patch_img)){
        $img = 0;
    }else{
        $img = $location_id['location'];
    }
}
$npcJoy = $mysqli->query("SELECT * FROM `base_npc` WHERE `loc_id`='".$location_id['location']."' AND `name` = 'Сестра Джой'")->fetch_assoc();
if(isset($npcJoy)) {
  $pc = '<span class="Addon" onclick="NpcDialog('.$npcJoy['id'].',1,event);"><i class="fa fa-plus"></i></span><span class="Addon" onclick="NpcDialog('.$npcJoy['id'].',2,event);"><i class="fa fa-hospital"></i></span><span class="Addon" onclick="NpcDialog('.$npcJoy['id'].',3,event);"><i class="fa fa-heart"></i></span>';
}else{
  $pc = '';
}
$response['pc'] = $pc;
$response["description"] = $getUserLocationInfo["description"];
$response["name"] = $getUserLocationInfo["name"];
$response["pokAtLocation"] = ($getUserLocationInfo["pve"] == 0 ? 0 : 1);
if(!empty($locations)){
    $response["roads"] = $locations;
}
if(!empty($npc)){
    $response["npc"] = $npc;
}
$response["img"] = $img;

$countUsersAtLocation = $mysqli->query("SELECT `sex`,`id`,`user_group`,`login` FROM `users` WHERE `location`='".$location_id['location']."' AND `online` >= '".$timeOnline."' ORDER BY `id`");
$response["countUsersAtLocation"]= $countUsersAtLocation->num_rows;


$usersLoc = [];
while($usersInfo = $countUsersAtLocation->fetch_assoc()){
    $userHash .= 'id'.$usersInfo['id'];

    //$usersLoc.='<div id="_list_user_id_'.$usersInfo['id'].'"  class="user"><div class="user-link u-'.$usersInfo['user_group'].'">'.$usersInfo['login'].'</div></div> ';

    $usersLoc[] = [
        'id'=>$usersInfo['id'],
        'login'=>$usersInfo['login'],
        'group'=>$usersInfo['user_group'],
        'sex'=>$usersInfo['sex'],
        'isOffer'=>(isset($userNoticeArr['u'.$usersInfo['id']]) ? true : false)
    ];
}
$response["usersAtLocation"] = $usersLoc;
echo (is_array($response) ? json_encode($response, true) : $response);
