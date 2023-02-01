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
$type = $_POST["type"];
$user = (isset($_POST['user']) ? clearStr($_POST['user']) : $_SESSION['id']);
$user = $mysqli->real_escape_string($user);
switch ($type) {
	case 'setColor':
		$value = (isset($_POST['color']) ? clearStr($_POST['color']) : '#515151');
		$mysqli->query("UPDATE `users` SET `colorChat` = '".$value."' WHERE `id` = '".$_SESSION['id']."'");
		die($response);
	break;
	case 'status':
		$value = clearStr($_POST['value']);
		$value = $mysqli->real_escape_string($value);
		$mysqli->query("UPDATE `users` SET `about` = '".$value."' WHERE `id` = '".$_SESSION['id']."'");
		$friends = $mysqli->query("SELECT * FROM `users_friend` WHERE (`user_id` = '".$_SESSION['id']."' OR `friend_id` = '".$_SESSION['id']."') AND `status` = '1'");
		$users = $mysqli->query("SELECT `id`,`login`,`user_group` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
		$text = '<div class="user-link u-'.$users['user_group'].'">'.$users['login'].'</div> сменил статус <b>'.$value.'</b>.';
		$img = '/img/avatars/mini/'.$users['id'].'.png';
		$month = array(1=>'Января',2=>'Февраля',3=>'Марта',4=>'Апреля',5=>'Мая',6=>'Июня',7=>'Июля',8=>'Августа',9=>'Сентября',10=>'Октября',11=>'Ноября',12=>'Декабря');
		$dayToday = date("d");
		$monthToday = $month[date("n")];
		$YearToday = date("Y");
		$YearToday = date("Y");
		$YearToday = date("Y");
		$date = $dayToday.' '.$monthToday.' '.$YearToday.'г. в '.date("H").':'.date("i");
		$mysqli->query("INSERT INTO `notification` (`text`,`user`,`img`,`date`) VALUES ('".$text."','".$_SESSION['id']."','".$img."','".$date."')");
		while($friend = $friends->fetch_assoc()){
			$id = ($friend['user_id'] == $_SESSION['id'] ? $friend['friend_id'] : $friend['user_id']);
			$mysqli->query("INSERT INTO `notification` (`text`,`user`,`img`,`date`) VALUES ('".$text."','".$id."','".$img."','".$date."')");
		}
		$response['text'] = $_POST['value'];
	break;
	case 'friend':
		$users = $mysqli->query("SELECT * FROM `users` WHERE `login` = '".$user."'")->fetch_assoc();
		$my = $mysqli->query("SELECT `location`,`id` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
		if($users['location'] != $my['location']){
			$response['error'] = 1;
			$response['text'] = 'Вы слишком далеко друг от друга!';
		}elseif($users['id'] == $my['id']){
			$response['error'] = 1;
			$response['text'] = 'Нельзя добавить себя в друзья!';
		}else{
			$friends = $mysqli->query("SELECT * FROM `users_friend` WHERE (`user_id` = '".$_SESSION['id']."' AND `friend_id` = '".$users['id']."') OR (`user_id` = '".$users['id']."' AND `friend_id` = '".$_SESSION['id']."')");
			if($friends->num_rows > 0){
				$response['error'] = 1;
				$response['text'] = 'Заявка уже отправлена, либо тренер у вас в друзьях!';
			}else{
				$friend = $friends->fetch_assoc();
				$mysqli->query("INSERT INTO `users_friend` (`user_id`,`friend_id`,`status`) VALUES ('".$_SESSION['id']."','".$users['id']."',0)");
				$response['error'] = 0;
				$response['text'] = 'Заявка успешно отправлена!';
			}
		}
	break;
	case 'AddClan':
			$users = $mysqli->query("SELECT * FROM `users` WHERE `login` = '".$user."'")->fetch_assoc();
			$users_clan = $mysqli->query("SELECT * FROM `base_clans_users` WHERE `user_id` = ".$users['id'])->fetch_assoc();
			$clan = $mysqli->query("SELECT * FROM `base_clans_users` WHERE `user_id` = ".$_SESSION['id'])->fetch_assoc();
			if($clan){
				if($users_clan){
					$response['text'] = 'Тренер уже состоит в клане.';
				}else{
					if($clan['group'] == 1){
						$response['error'] = 0;
						$response['text'] = 'Заявка тренеру отправлена.';
						$mysqli->query("INSERT INTO `user_clan_accept` (`user_id`,`clan_id`) VALUES (".$users['id'].",".$clan['clan_id'].")");
					}else{
						$response['error'] = 1;
						$response['text'] = 'Невозможно добавить в клан. Вы не лидер клана.';
					}
				}
			}else{
				$response['text'] = 'Вы не лидер клана.';
			}
	break;
	case 'DeleteClan':
			$users = $mysqli->query("SELECT * FROM `users` WHERE `login` = '".$user."'")->fetch_assoc();
			$users_clan = $mysqli->query("SELECT * FROM `base_clans_users` WHERE `user_id` = ".$users['id'])->fetch_assoc();
			$clan = $mysqli->query("SELECT * FROM `base_clans_users` WHERE `user_id` = ".$_SESSION['id'])->fetch_assoc();
			if($clan){
				if($clan['group'] == 1){
					if($_SESSION['id'] == $users_clan['user_id']){
						$response['error'] = 1;
						$response['text'] = 'Невозможно удалить себя из клана.';
					}else{
						if($users_clan['clan_id'] == $clan['clan_id']){
							$users_clan_gl = $mysqli->query("SELECT * FROM `base_clans` WHERE `id` = ".$users_clan['clan_id'])->fetch_assoc();
							$info = json_decode($users_clan_gl['info']);
							if($info->Creater == $users_clan['user_id']){
								$response['error'] = 1;
								$response['text'] = 'Невозможно удалить из клана. Тренер является основателем.';
							}else{
								$response['error'] = 0;
								$response['text'] = 'Тренер удален из клана.';
								$insertJson = '{"user_new":"'.$users['login'].'","user_group":"'.$users['user_group'].'","date":"'.date('d.m.Y').'"}';
								$mysqli->query("INSERT INTO `log_game` (`user_id`,`type`,`title`,`info`) VALUES ('".$users_clan['clan_id']."','clan','LEFT_CLAN_ALERT','".$insertJson."')");
								$mysqli->query("DELETE FROM `base_clans_users` WHERE `user_id` = ".$users_clan['user_id']);
							}
						}else{
							$response['error'] = 1;
							$response['text'] = 'Невозможно удалить из клана. Тренер не состоит в вашем клане.';
						}
					}
				}else{
					$response['error'] = 1;
					$response['text'] = 'Невозможно удалить из клана. Вы не лидер клана.';
				}
			}else{
				$response['text'] = 'Вы не состоите в клане.';
			}
	break;
	case 'DeleteFriend':
		$users = $mysqli->query("SELECT * FROM `users` WHERE `login` = '".$user."'")->fetch_assoc();
			$friends = $mysqli->query("SELECT * FROM `users_friend` WHERE (`user_id` = '".$_SESSION['id']."' AND `friend_id` = '".$users['id']."') OR (`user_id` = '".$users['id']."' AND `friend_id` = '".$_SESSION['id']."')");
			if($friends->num_rows > 0){
				$friends = $friends->fetch_assoc();
				$mysqli->query("DELETE FROM `users_friend` WHERE `id` = '".$friends['id']."'");
				$response['error'] = 0;
				$response['text'] = 'Дружба с '.$user.' разорвана!';
			}else{
				$response['error'] = 1;
				$response['text'] = 'Тренера нет у вас в друзьях!';
			}
	break;
	case 'trainercard':
		$timeOnline = time() - 300;
		$users = $mysqli->query("SELECT * FROM `users` WHERE `login` = '".$user."'")->fetch_assoc();
		$location = $mysqli->query("SELECT * FROM `base_location` WHERE `id` = '".$users['location']."'")->fetch_assoc();
		$region = $mysqli->query("SELECT * FROM `base_region` WHERE `id` = '".$location['region']."'")->fetch_assoc();
		$cloth = $mysqli->query("SELECT * FROM `cloth` WHERE `user` = '".$users['id']."'")->fetch_assoc();
		$is_online = ($users['online'] >= $timeOnline) ? $onl = array('class'=>'onl','text'=>'В сети') : $onl = array('class'=>'ofl','text'=>'Не в сети');
		$isFriend = $mysqli->query("SELECT `id` FROM `users_friend` WHERE (`user_id` = '".$users['id']."' AND `friend_id` = '".$_SESSION['id']."') OR (`user_id` = '".$_SESSION['id']."' AND `friend_id` = '".$users['id']."') AND `status` = '1'")->num_rows;
		$avatarMini = $users['id'];
		$patch_avatars = $patch_project.'/img/avatars/mini/'.$users['id'].'.png';
		$banInfo = json_decode($users['ban']);
		switch($users['user_group']){
			case 2:
        if($users['id'] != 55) {
          $rang = 'Полиция,';
        }else{
          $rand = '';
        }
			break;
			case 3:
				$rang = 'Модератор,';
			break;
			case 4:
				$rang = 'Наставник,';
			break;
			case 5:
				$rang = 'Гим-лидер,';
			break;
			case 8:
				$rang = 'Заключенный (до '.date( 'd.m.Y', $banInfo->game ).'),';
			break;
            case 100:
				$rang = 'Странник';
			break;
			case 9:
				$rang = 'Редактор,';
			break;
			default:
				$rang;
			break;
		}
		switch($users['id']){
      case 55:
				$gymType = ($users['user_group'] == 2 ? 'Глава полиции,' : '');
			break;
      case 140:
				$gymType = ($users['user_group'] == 5 ? 'Электрический стадион<br>' : '');
			break;
      case 155:
				$gymType = ($users['user_group'] == 5 ? 'Ледяной стадион<br>' : '');
			break;
      case 171:
				$gymType = ($users['user_group'] == 5 ? 'Нормальный стадион<br>' : '');
			break;
      case 126:
				$gymType = ($users['user_group'] == 5 ? 'Земляной стадион<br>' : '');
			break;
      case 617:
				$gymType = ($users['user_group'] == 5 ? 'Воздушный стадион<br>' : '');
			break;
      case 93:
				$gymType = ($users['user_group'] == 5 ? 'Водный стадион<br>' : '');
			break;
      case 210:
				$gymType = ($users['user_group'] == 5 ? 'Стальной стадион<br>' : '');
			break;
      case 36:
				$gymType = ($users['user_group'] == 5 ? 'Огненный стадион<br>' : '');
			break;
			// case 1065:
			// 	$gymType = ($users['user_group'] == 5 ? 'Водный стадион,' : '');
			// break;
			// case 1054:
			// 	$gymType = ($users['user_group'] == 5 ? 'Стадион жуков,' : '');
			// break;
			// case 1715:
			// 	$gymType = ($users['user_group'] == 5 ? 'Боевой стадион,' : '');
			// break;
			// case 1022:
			// $gymType = ($users['user_group'] == 5 ? 'Призрачный стадион,' : '');
			// break;
			// case 1531:
			// 	$gymType = ($users['user_group'] == 5 ? 'Земляной стадион,' : '');
			// break;
			// case 1029:
			// 	$gymType = ($users['user_group'] == 5 ? 'Воздушный стадион,' : '');
			// break;
			// case 1183:
			// 	$gymType = ($users['user_group'] == 5 ? 'Огненный стадион,' : '');
			// break;
			// case 1012:
			// 	$gymType = ($users['user_group'] == 5 ? 'Травяной стадион,' : '');
			// break;
			default:
				$gymType = '';
			break;
		}
		$countPoks = [
						'normal'=>$users['countNormal'],
						'shine'=>$users['countShine']
						];
    $shadow = $mysqli->query("SELECT `type` FROM `user_pokemons` WHERE `user_id` = ".$users['id']." AND type = 'shadow'");
		$friends = $mysqli->query("SELECT * FROM `users_friend` WHERE (`user_id` = '".$users['id']."' OR `friend_id` = '".$users['id']."') AND `status` = '1'")->num_rows;
		if($users['class'] >= 0 && $users['class'] <= 9){
			$classTren = 'C';
		}elseif($users['class'] >= 10 && $users['class'] <= 24){
			$classTren = 'B';
		}else{
			$classTren = 'A';
		}
		$timeReg = time()-$users['dateReg'];
		$timeReg = time()+$timeReg;
    if($users['sex'] == 'f') {
      $qq = 'заходила';
    }else{
      $qq = 'заходил';
    }
		$timeReg = explode(' ',downcounter($timeReg));
		$timeRegistration = $timeReg[0].' '.$timeReg[1];
		$online = date('d.m.Y в H:i', $users['online']);
		$is_online1 = ($users['online'] >= $timeOnline) ? '' : ', '.$qq.' последний раз '.$online;
		$gifts = $mysqli->query('SELECT * FROM `user_gift` WHERE `user` = '.$users['id']);
		$trophyList = [];
		$giftList = [];
		$ballList = [];
		$trophys = $mysqli->query('
		    SELECT
		      `iu`.`item_id`,
		      `bi`.*
		    FROM `items_users` AS `iu`
		    INNER JOIN `base_items` AS `bi`
		      ON `bi`.`id` = `iu`.`item_id`
		    WHERE
		      `iu`.`user` = '.$users['id'].' AND
		      `iu`.`trophy` = 1
		');
		while ($trophy = $trophys->fetch_assoc()){
      if($trophy['item_id'] >= 1000001) {
				$mesto = explode(',',$trophy['info']);
			}
      $imgItem = ($trophy['item_id'] >= 1000001 ? $mesto[0].'.'.$mesto[1] : $trophy['item_id']);
			$trophyList[$trophy['id']] = [
				'trophy' => $imgItem,
        'info' => $trophy['item_id']
			];
		}
		while ($gift = $gifts->fetch_assoc()){
			$giftList[$gift['id']] = [
				'gift' => $gift['id_gift'],
				'user' => $gift['user2']
			];
		}
		$friends1 = $mysqli->query("SELECT * FROM `users_friend` WHERE (`user_id` = '".$users['id']."' OR `friend_id` = '".$users['id']."') AND `status` = '1'");
        $friends_list_id = [];
		while($friend = $friends1->fetch_assoc()){
			$id = ($friend['user_id'] == $users['id'] ? $friend['friend_id'] : $friend['user_id']);
            $friends_list_id[] = intval($id);
		}
		$userListInfo = [];
		if(!empty($friends_list_id)){
            $userList = $mysqli->query('
                SELECT
                  `id`,
                  `login`,
                  `user_group`,
                  `online`,
                  `rang`
                FROM `users`
                WHERE
                  `id` IN ('.implode(',', $friends_list_id).')
            ');
			while($row = $userList->fetch_assoc()){ $userListInfo[] = $row; }
            if(!empty($userListInfo)){
                foreach($userList AS $key=>$value){
                    if(isset($value['login'])){
                        $is_online = ($value['online'] >= time()-300) ? 'onl' : 'ofl';
                        $freindList .= '<div class="User">';
                        $freindList .= '<div class="TrainerBlock">';
                        $freindList .= '<div onclick="showUserTooltip('.$value['id'].')" class="Avatar" style="background-image: url(/img/avatars/mini/'.$value['id'].'.png);">';
                        $freindList .= '<div class="Status '.$is_online.'"></div>';
                        $freindList .= '</div>';
                        $freindList .= ' <div class="Title"><div class="Name"><div class="u-'.$value['user_group'].'">'.$value['login'].'</div></div><div class="Other">'.$value['rang'].'</div></div>';
                        $freindList .= '</div>';
                        $freindList .= '</div>';
                    }
                }
            }
        }
		$achiv = $mysqli->query('
		    SELECT
		      `ba`.*,
		      `ua`.`count`  AS `ua_count`,
		      `ua`.`complete`  AS `ua_complete`
		    FROM `base_achievements` AS `ba`
		    LEFT JOIN `user_achievements` AS `ua`
		      ON `ua`.`id_ach` = `ba`.`id` AND `ua`.`user_id` = '.$users['id'].'
		    ORDER BY `ba`.`id` DESC
		');
		while($ach = $achiv->fetch_assoc()){
		    if($ach['ua_count'] == null){
				$b = '0';
			}else{
				$b = $ach['ua_count'];
			}
			$achivm .= '<div class="achiev">';
			if($ach['ua_complete'] == 1){
				$achivm .= '<div class="check"><i class="fa fa-check"></i></div>';
			}
			$achivm .= '<img src="/img/world/achievments/'.$ach['id'].'.png">';
			$achivm .= '<div class="text">';
			$achivm .= '<div class="name">'.$ach['name'].'</div>';
			$achivm .= '<div class="about">'.$ach['about'].'</div>';
			if($ach['category'] == 1){
				$achivm .= '<div class="count">'.$b.'/'.$ach['need'].'</div>';
			}
			$achivm .= '</div>';
			$achivm .= '</div>';
		}
    $Balls = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `user_id` = '".$users['id']."' AND `active` = '1'");
    if($users['team_open'] == 0) {
  		while($pok = $Balls->fetch_assoc()){
  			$ballList[$pok['id']] = [
  				'ball' => $pok['ball'],
          'styleball' => 'div',
          'typeball' => '/img/world/items/little/'
  			];
  		}
    }else{
  		while($pok = $Balls->fetch_assoc()){
  			$ballList[$pok['id']] = [
  				'ball' => numCheck_basenum($pok['basenum']),
          'styleball' => 'div',
          'typeball' => '/img/pokemons/mini/normal/'
  			];
  		}
    }
    if($users['user_group'] == 100) {
      $rang2 = '';
    }else{
      $rang2 = $users['rang'];
    }
    $pver = json_decode($users['rating']);
		$clanUser = $mysqli->query("SELECT `clan_id` FROM `base_clans_users` WHERE `user_id` = '".$users['id']."'")->fetch_assoc();
		$response = array(
      'bigAva' => ($users['id'] == 5 ? 'https://openclipart.org/image/2400px/svg_to_png/288357/anon-hacker-behind-pc.png' : 'img/logo.png'),
      'id' => $users['id'],
			'clanUserCheck' => ($clanUser ? 1 : 0),
			'clanUser' => $clanUser['clan_id'],
			'ballList' => $ballList,
			'achivmentsList' => $achivm,
			'friendsList' => $freindList,
			'trophyList' => $trophyList,
			'giftList' => $giftList,
			'editStatus' => ($users['id'] == $_SESSION['id'] ? 1 : 0),
			'login' => $user,
			'status' => $users['about'],
			'miniIcon' => $avatarMini,
			'userGroup' => $users['user_group'],
			'rang' => ($users['user_group'] == 1 ? 'Администрация League 18' : $rang.' '.$gymType.' '.$rang2),
			'classOnl' => $onl['class'],
			'textOnl' => $onl['text'],
			'location' => ($isFriend > 0 || $users['id'] == $_SESSION['id'] ? $location['name'] : '...'),
			'region' => $region['name'],
			'model' => $cloth['model'],
			'sex' => $users['sex'],
			'mouth' => $cloth['mouth'],
			'eye' => $cloth['eye'],
			'hair' => $cloth['hair'],
			'eyebrow' => $cloth['eyebrow'],
			'slot1' => $cloth['slot1'],
			'slot2' => $cloth['slot2'],
			'slot3' => $cloth['slot3'],
			'slot4' => $cloth['slot4'],
			'slot5' => $cloth['slot5'],
			'slot6' => $cloth['slot6'],
			'slot7' => $cloth['slot7'],
			'slot8' => $cloth['slot8'],
			'slot9' => $cloth['slot9'],
			'slot10' => $cloth['slot10'],
			'dex' => $countPoks['normal'],
			'shineDex' => $countPoks['shine'],
      'shadowDex' => $shadow->num_rows,
			'friends' => $friends,
			'classCount' => $users['class'],
			'className' => $classTren,
			'inGame' => $timeRegistration,
			'lastGame' => $is_online1,
      'pver' => $pver->pve,
			'error' => 0

		);
	break;
	case 'gift':
		$gift1List = [];
		$gift23List = [];
		$gift8List = [];
		$gift1 = $mysqli->query("SELECT * FROM `base_gift` WHERE `type` = 1 AND `close` = 0"); // Стандартные подарки
		$gift23 = $mysqli->query("SELECT * FROM `base_gift` WHERE `type` = 23 AND `close` = 0"); // Подарки на 23 февраля
		$gift8 = $mysqli->query("SELECT * FROM `base_gift` WHERE `type` = 8 AND `close` = 0"); // Подарки на 8 марта
		while($gift = $gift1->fetch_assoc()){
			$gift1List[$gift['id']] = [
				'price' => $gift['price'],
				'id' => $gift['id']
			];
		}
		while($gift = $gift23->fetch_assoc()){
			$gift23List[$gift['id']] = [
				'price' => $gift['price'],
				'id' => $gift['id']
			];
		}
		while($gift = $gift8->fetch_assoc()){
			$gift8List[$gift['id']] = [
				'price' => $gift['price'],
				'id' => $gift['id']
			];
		}
		$response = array(
			'gift1List' => $gift1List,
			'gift23List' => $gift23List,
			'gift8List' => $gift8List
		);
	break;
	case 'setting':
		$UserQuery = $mysqli->query("SELECT * FROM users WHERE id = ".$_SESSION['id'])->fetch_assoc();
		$server = $mysqli->query("SELECT * FROM `system` WHERE `id`=1")->fetch_assoc();
		$response = array(
			'sound' => $UserQuery['sound'],
			'soundTwo' => $UserQuery == 0 ? 1 : 0,
			'sprite' => (int)$UserQuery['sprite'],
			'version' => $server['version'],
      'team' => $UserQuery['team_open']
		);
	break;
	default:
		echo 'Error';
	break;
}
echo json_encode($response);
