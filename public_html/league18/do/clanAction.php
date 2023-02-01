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
if(strripos($_POST["object"],',')){
	$obj = explode(',',$_POST["object"]);
	$object = $obj[0];
}else{
	$object = $_POST['object'];
}
if($_POST['other']){
	$other = $_POST['other'];
}
$clanName = clearStr($_POST['name']);
$clanEmblem = $_POST['emblem'];
$user = $mysqli->query("SELECT `status`,`login`,`user_group` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
$clans = $mysqli->query("SELECT * FROM `base_clans_users` WHERE `user_id` = '".$_SESSION['id']."'");
if($user['status'] != 'free'){
	$response['text'] = 'В данный момент вы заняты!';
	$response['error'] = 1;
}elseif($clans->num_rows == 0 && $user['user_group'] != 1){
	if($object == 'createClan'){
		if(item_isset(1,1500000)){
			$mysqli->query("INSERT INTO `clan_app` (`user`, `name`, `emblem`) VALUE ('".$_SESSION['id']."','".$clanName."', '".$clanEmblem."') ");
			minus_item(1,1500000);
      $response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1500000 шт.)';
			$response['error'] = 'error';
			$response['text'] = 'Вы успешно подали заявку, ждите ответа от администрации. Денежные средства были сняты.';
		}else{
			$response['error'] = 'error';
			$response['text'] = 'Недостаточно средств.';
		}
	}else{
		$response['error'] = 1;
		$response['text'] = 'Вы не состоите в клане!';
	}
}else{
	switch ($object) {
		case 'okAdminClan':
			if($user['user_group'] == 1){
					$clanCreate = $mysqli->query("SELECT * FROM `clan_app` WHERE `id` = '".$clanName."'")->fetch_assoc();
					if($clanCreate){
						$dateNormal = date("d.m.Y");
						$month = array(1=>'Января',2=>'Февраля',3=>'Марта',4=>'Апреля',5=>'Мая',6=>'Июня',7=>'Июля',8=>'Августа',9=>'Сентября',10=>'Октября',11=>'Ноября',12=>'Декабря');
						$dayToday = date("d");
						$monthToday = $month[date("n")];
						$YearToday = date("Y");
						$date = $dayToday.' '.$monthToday.' '.$YearToday.'г. в '.date("H").':'.date("i");
						$clanCreateUser = $mysqli->query("SELECT `user_group`,`login` FROM `users` WHERE `id` = '".$clanCreate['user']."'")->fetch_assoc();
						$textClan = "<div class=u-1>Администрация League-18</div> прислала вам уведомление: <b>ваш клан \"".$clanCreate['name']."\" был создан. Желаем вам успехов в продвижении вашего клана.</b>";
						Work::$sql->query("INSERT INTO `notification` (`text`,`user`,`img`,`date`) VALUES ('".$textClan."','".$clanCreate['user']."','/img/logo.png','".$date."') ");
						$response['text'] = 'Клан '.$clanCreate['name'].' создан.';
						Work::$sql->query("INSERT INTO `base_clans` (`info`,`position`) VALUES ('{\"name\":\"".$clanCreate['name']."\",\"description\":\"...\",\"Raiting\":\"0\",\"Money\":\"0\",\"dateCreate\":\"".$dateNormal."\",\"countUsers\":\"\",\"Creater\":\"".$clanCreate['user']."\"}','0') ");
						$clanNewSelect = Work::$sql->query("SELECT `id` FROM `base_clans` ORDER BY `id` DESC")->fetch_assoc();
						$insertJson = '{"user_new":"'.$clanCreateUser['login'].'","user_group":"'.$clanCreateUser['user_group'].'","date":"'.$dateNormal.'"}';
						Work::$sql->query("INSERT INTO `base_clans_users` (`user_id`,`clan_id`,`raiting`,`status`,`group`) VALUES ('".$clanCreate['user']."','".$clanNewSelect['id']."','0','Новобранец','1') ");
						Work::$sql->query("INSERT INTO `log_game` (`user_id`,`type`,`title`,`info`) VALUES ('".$clanNewSelect['id']."','clan','CLAN_CREATE','".$insertJson."') ");
						Work::$sql->query("DELETE FROM `clan_app` WHERE `id` = '".$clanName."'");
					}else{
						$response['error'] = 1;
						$response['text'] = 'Заявки не существует.';
					}
				}else{
					$response['error'] = 1;
					$response['text'] = 'Необходимо быть администрацией игры.';
				}
		break;
		case 'noAdminClan':
			if($user['user_group'] == 1){
					$clanCreate = $mysqli->query("SELECT * FROM `clan_app` WHERE `id` = '".$clanName."'")->fetch_assoc();
					if($clanCreate){
						$month = array(1=>'Января',2=>'Февраля',3=>'Марта',4=>'Апреля',5=>'Мая',6=>'Июня',7=>'Июля',8=>'Августа',9=>'Сентября',10=>'Октября',11=>'Ноября',12=>'Декабря');
						$dayToday = date("d");
						$monthToday = $month[date("n")];
						$YearToday = date("Y");
						$date = $dayToday.' '.$monthToday.' '.$YearToday.'г. в '.date("H").':'.date("i");
						$textClan = "<div class=u-1>Администрация League-18</div> прислала вам уведомление: <b>ваш клан \"".$clanCreate['name']."\" не был создан. Причины могут быть разные, начиная от некорректного названия клана, заканчивая неверной ссылкой на эмблему. Советуем вам подать корректную заявку на создание клана. Желаем вам удачной игры.</b>";
						Work::$sql->query("INSERT INTO `notification` (`text`,`user`,`img`,`date`) VALUES ('".$textClan."','".$clanCreate['user']."','/img/logo.png','".$date."') ");
						$response['text'] = 'Клан '.$clanCreate['name'].' не был создан.';
						Work::_itemPlus(1,1500000,$clanCreate['user']);
						Work::$sql->query("DELETE FROM `clan_app` WHERE `id` = '".$clanName."'");
					}else{
						$response['error'] = 1;
						$response['text'] = 'Заявки не существует.';
					}
				}else{
					$response['error'] = 1;
					$response['text'] = 'Необходимо быть администрацией игры.';
				}
		break;
		case 'goNotifyClan':
				$clans = $clans->fetch_assoc();
				if($clans['group'] == 1){
					$insertJson = '{"user_new":"'.$user['login'].'","user_group":"'.$user['user_group'].'","date":"'.date('d.m.Y').'","notice":"'.$clanName.'"}';
					$mysqli->query("INSERT INTO `log_game` (`user_id`, `type`, `title`, `info`) VALUE ('".$clans['clan_id']."','clan', 'ADD_CLAN_NOTICE','".$insertJson."') ");
					$response['text'] = 'Вы сделали объявление.';
				}else{
					$response['error'] = 1;
					$response['text'] = 'Вы не лидер клана.';
				}
		break;
		case 'goStatusClan':
				$clans = $clans->fetch_assoc();
				if($clans['group'] == 1){
					$userLogin = $mysqli->query("SELECT `id`,`user_group` FROM `users` WHERE `login` = '".$clanName."'")->fetch_assoc();
					$userClan = $mysqli->query("SELECT `clan_id`,`group` FROM `base_clans_users` WHERE `user_id` = '".$userLogin['id']."'")->fetch_assoc();
					if($userClan['clan_id'] == $clans['clan_id']){
						$insertJson = '{"user_new":"'.$clanName.'","user_group":"'.$userLogin['user_group'].'","date":"'.date('d.m.Y').'","status":"'.$other.'"}';
						$mysqli->query("INSERT INTO `log_game` (`user_id`, `type`, `title`, `info`) VALUE ('".$clans['clan_id']."','clan', 'ADD_CLAN_STATUS','".$insertJson."') ");
						$mysqli->query("UPDATE `base_clans_users` SET `status` = '".$other."' WHERE  `user_id` = '".$userLogin['id']."'");
						$response['text'] = 'Тренеру '.$clanName.' изменено звание.';
					}else{
						$response['text'] = 'Тренер не в вашем клане.';
					}
				}else{
					$response['error'] = 1;
					$response['text'] = 'Вы не лидер клана.';
				}
		break;
		case 'goDeleteClan':
				$clans = $clans->fetch_assoc();
				if($clans['group'] == 1){
					$userLogin = $mysqli->query("SELECT `id`,`user_group` FROM `users` WHERE `login` = '".$clanName."'")->fetch_assoc();
					$userClan = $mysqli->query("SELECT `clan_id`,`group` FROM `base_clans_users` WHERE `user_id` = '".$userLogin['id']."'")->fetch_assoc();
					if($userClan['clan_id'] == $clans['clan_id']){
						if($userClan['group'] != 1){
							$baseClans = $mysqli->query("SELECT `info` FROM `base_clans` WHERE `id` = '".$clans['clan_id']."'")->fetch_assoc();
							$info = json_decode($baseClans['info']);
							if($userLogin['id'] != $info->Creater){
								$insertJson = '{"user_new":"'.$clanName.'","user_group":"'.$userLogin['user_group'].'","date":"'.date('d.m.Y').'"}';
								$mysqli->query("INSERT INTO `log_game` (`user_id`, `type`, `title`, `info`) VALUE ('".$clans['clan_id']."','clan', 'LEFT_CLAN_ALERT','".$insertJson."') ");
								$mysqli->query("DELETE FROM `base_clans_users` WHERE `user_id` = '".$userLogin['id']."'");
								$response['text'] = 'Тренер '.$clanName.' исключен из клана.';
							}else{
								$response['text'] = 'Нельзя исключить из клана данного тренера. Он является основателем.';
							}
						}else{
							$response['text'] = 'Тренер является лидером. Его нельзя исключить из клана.';
						}
					}else{
						$response['text'] = 'Тренер не в вашем клане.';
					}
				}else{
					$response['error'] = 1;
					$response['text'] = 'Вы не лидер клана.';
				}
		break;
		case 'goUnleaderClan':
				$clans = $clans->fetch_assoc();
				if($clans['group'] == 1){
					$userLogin = $mysqli->query("SELECT `id`,`user_group` FROM `users` WHERE `login` = '".$clanName."'")->fetch_assoc();
					$userClan = $mysqli->query("SELECT `clan_id`,`group` FROM `base_clans_users` WHERE `user_id` = '".$userLogin['id']."'")->fetch_assoc();
					if($userClan['clan_id'] == $clans['clan_id']){
						if($userClan['group'] == 1){
							$baseClans = $mysqli->query("SELECT `info` FROM `base_clans` WHERE `id` = '".$clans['clan_id']."'")->fetch_assoc();
							$info = json_decode($baseClans['info']);
							if($userLogin['id'] != $info->Creater){
								$insertJson = '{"user_new":"'.$clanName.'","user_group":"'.$userLogin['user_group'].'","date":"'.date('d.m.Y').'"}';
								$mysqli->query("INSERT INTO `log_game` (`user_id`, `type`, `title`, `info`) VALUE ('".$clans['clan_id']."','clan', 'DELETE_CLAN_ADMIN','".$insertJson."') ");
								$mysqli->query("UPDATE `base_clans_users` SET `group` = '3' WHERE  `user_id` = '".$userLogin['id']."'");
								$response['text'] = 'Тренер '.$clanName.' исключен из лидеров.';
							}else{
								$response['text'] = 'Нельзя исключить из лидеров данного тренера. Он является основателем.';
							}
						}else{
							$response['text'] = 'Тренер не является лидером.';
						}
					}else{
						$response['text'] = 'Тренер не в вашем клане.';
					}
				}else{
					$response['error'] = 1;
					$response['text'] = 'Вы не лидер клана.';
				}
		break;
		case 'goLeaderClan':
				$clans = $clans->fetch_assoc();
				if($clans['group'] == 1){
					$userLogin = $mysqli->query("SELECT `id`,`user_group` FROM `users` WHERE `login` = '".$clanName."'")->fetch_assoc();
					$userClan = $mysqli->query("SELECT `clan_id`,`group` FROM `base_clans_users` WHERE `user_id` = '".$userLogin['id']."'")->fetch_assoc();
					if($userClan['clan_id'] == $clans['clan_id']){
						if($userClan['group'] == 1){
							$response['text'] = 'Тренер уже является лидером.';
						}else{
							$insertJson = '{"user_new":"'.$clanName.'","user_group":"'.$userLogin['user_group'].'","date":"'.date('d.m.Y').'"}';
							$mysqli->query("INSERT INTO `log_game` (`user_id`, `type`, `title`, `info`) VALUE ('".$clans['clan_id']."','clan', 'ADD_CLAN_ADMIN','".$insertJson."') ");
							$mysqli->query("UPDATE `base_clans_users` SET `group` = '1' WHERE  `user_id` = '".$userLogin['id']."'");
							$response['text'] = 'Тренер '.$clanName.' стал лидером.';
						}
					}else{
						$response['text'] = 'Тренер не в вашем клане.';
					}
				}else{
					$response['error'] = 1;
					$response['text'] = 'Вы не лидер клана.';
				}
		break;
		case 'clanAbout':
				$clans = $clans->fetch_assoc();
				if($clans['group'] == 1){
					$baseClans = $mysqli->query("SELECT `info` FROM `base_clans` WHERE `id` = '".$clans['clan_id']."'")->fetch_assoc();
					$info = json_decode($baseClans['info']);
					$dataJson = '{"name":"'.$info->name.'","description":"'.$obj[1].'","Raiting":"'.$info->Raiting.'","Money":"'.$info->Money.'","dateCreate":"'.$info->dateCreate.'","countUsers":"'.$info->countUsers.'","Creater":"'.$info->Creater.'"}';
					$insertJson = '{"user_new":"'.$user['login'].'","user_group":"'.$user['user_group'].'","date":"'.date('d.m.Y').'"}';
					$mysqli->query("INSERT INTO `log_game` (`user_id`, `type`, `title`, `info`) VALUE ('".$clans['clan_id']."','clan', 'ABOUT_CLAN_ALERT','".$insertJson."') ");
					$mysqli->query("UPDATE `base_clans` SET `info` = '".$dataJson."' WHERE  `id` = '".$clans['clan_id']."'");
					$response['text'] = 'Вы изменили описание клана.';
				}else{
					$response['error'] = 1;
					$response['text'] = 'Вы не лидер клана.';
				}
		break;
		case 'left':
        $clans = $clans->fetch_assoc();
        $baseClans = $mysqli->query("SELECT `info` FROM `base_clans` WHERE `id` = '".$clans['clan_id']."'")->fetch_assoc();
        $info = json_decode($baseClans['info']);
        if($_SESSION['id'] != $info->Creater){
          $insertJson = '{"user_new":"'.$user['login'].'","user_group":"'.$user['user_group'].'","date":"'.date('d.m.Y').'"}';
          $mysqli->query("INSERT INTO `log_game` (`user_id`, `type`, `title`, `info`) VALUE ('".$clans['clan_id']."','clan', 'LEFT_CLAN','".$insertJson."') ");
          $mysqli->query("DELETE FROM `base_clans_users` WHERE `user_id` = '".$_SESSION['id']."'");
          $response['error'] = 0;
          $response['text'] = 'Вы успешно покинули клан!';
        }else{
          $response['error'] = 1;
  				$response['text'] = 'Нельзя покинуть клан. Вы являетесь основателем.';
        }
		break;
		case 'addMoney':
			$count = clearInt($obj[1]);
				$money = $mysqli->query("SELECT `count` FROM `items_users` WHERE `item_id` = 1 AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
				if($money['count'] < $count){
					$response['error'] = 1;
					$response['text'] = 'Недостаточно средств!';
				}else{
					$clans = $clans->fetch_assoc();
					$baseClans = $mysqli->query("SELECT `info` FROM `base_clans` WHERE `id` = '".$clans['clan_id']."'")->fetch_assoc();
					$info = json_decode($baseClans['info']);
					$newMoney = $info->Money + $count;
					$dataJson = '{"name":"'.$info->name.'","description":"'.$info->description.'","Raiting":"'.$info->Raiting.'","Money":"'.$newMoney.'","dateCreate":"'.$info->dateCreate.'","countUsers":"'.$info->countUsers.'","Creater":"'.$info->Creater.'"}';
					$mysqli->query("UPDATE `items_users` SET `count` = `count` - '".$count."' WHERE  `item_id` = 1 AND `user` = '".$_SESSION['id']."'");
					$mysqli->query("UPDATE `base_clans` SET `info` = '".$dataJson."' WHERE  `id` = '".$clans['clan_id']."'");
					$insertJson = '{"user_new":"'.$user['login'].'","user_group":"'.$user['user_group'].'","date":"'.date('d.m.Y').'","count":"'.$count.'"}';
					$mysqli->query("INSERT INTO `log_game` (`user_id`, `type`, `title`, `info`) VALUE ('".$clans['clan_id']."','clan', 'ADD_CLAN_MONEY','".$insertJson."') ");

					$response['text'] = 'Средства успешно добавлены!';
					$response['action'] = 'updateClan';

					$response['id'] = $clans['clan_id'];
				}
		break;
		case 'minusMoney':
		$clans = $clans->fetch_assoc();
		$baseClans = $mysqli->query("SELECT `info` FROM `base_clans` WHERE `id` = '".$clans['clan_id']."'")->fetch_assoc();
		$userClanMy = $mysqli->query("SELECT `group` FROM `base_clans_users` WHERE `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
		if($userClanMy['group'] == 1){
			$count = clearInt($obj[1]);
			$info = json_decode($baseClans['info']);
			if($info->Money < $count){
				$response['error'] = 1;
				$response['text'] = 'Недостаточно средств!';
			}else{
				$money = $mysqli->query("SELECT `count` FROM `items_users` WHERE `item_id` = 1 AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
				if($money['count']){
					$mysqli->query("UPDATE `items_users` SET `count` = `count` + '".$count."' WHERE  `item_id` = 1 AND `user` = '".$_SESSION['id']."'");
				}else{
					$mysqli->query("INSERT INTO `items_users` (`item_id`,`user`,`count`) VALUE ('1','".$_SESSION['id']."','".$count."')");
				}
				$insertJson = '{"user_new":"'.$user['login'].'","user_group":"'.$user['user_group'].'","date":"'.date('d.m.Y').'","count":"'.$count.'"}';
				$mysqli->query("INSERT INTO `log_game` (`user_id`, `type`, `title`, `info`) VALUE ('".$clans['clan_id']."','clan', 'TAKE_CLAN_MONEY','".$insertJson."') ");
				$newMoney = $info->Money - $count;
				$dataJson = '{"name":"'.$info->name.'","description":"'.$info->description.'","Raiting":"'.$info->Raiting.'","Money":"'.$newMoney.'","dateCreate":"'.$info->dateCreate.'","Creater":"'.$info->Creater.'"}';
				$mysqli->query("UPDATE `base_clans` SET `info` = '".$dataJson."' WHERE  `id` = '".$clans['clan_id']."'");
				$response['text'] = 'Средства успешно сняты!';
				$response['action'] = 'updateClan';

				$response['id'] = $clans['clan_id'];
			}
		}else{
			$response['error'] = 1;
			$response['text'] = 'Только лидеры могут снимать деньги с клана.';
		}
		break;
		default:
			$response['text'] = 'Ajax{"error":1,"type":"clanAction"}';
		break;
	}
}
echo json_encode($response);
?>