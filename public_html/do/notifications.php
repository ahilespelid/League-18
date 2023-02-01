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
$notes = '';
switch ($type) {
	case 'load':
    case 'update':
		$trades = $mysqli->query('
		    SELECT 
		        `ut`.*,
		        
		        `u`.`login`,
		        `u`.`user_group`
		    FROM `users_trade` AS `ut`
		    INNER JOIN `users` AS `u`
		      ON `u`.`id` = `ut`.`user1`
		    WHERE 
		      `ut`.`user2` = '.intval($_SESSION['id']).' AND 
		      `ut`.`status` = 0
		');

		while($trade = $trades->fetch_assoc()){
			$notes .= '<div class="DivNotify"><img src="/img/avatars/mini/'.$trade['user1'].'.png"><div class="Text">';
			$notes .= '<div class="Words"><div class="user-link u-'.$trade['user_group'].'">'.$trade['login'].'</div> предлогает обмен.</div>';
			$notes .= '<div class="buttons"><div class="btn" onclick=submitResponse("'.$trade['user1'].'","trade",1);>Принять</div><div class="btn" onclick=submitResponse("'.$trade['user1'].'","trade",2);>Отклонить</div></div>';
			$notes .= '</div></div>';
		}

		$clans = $mysqli->query('SELECT * FROM `user_clan_accept` WHERE user_id = '.intval($_SESSION['id']));
		while($clan = $clans->fetch_assoc()){
			$a = $mysqli->query('SELECT `info` FROM `base_clans` WHERE id = '.$clan['clan_id'].'')->fetch_assoc();
			$info = json_decode($a['info']);
			$notes .= '<div class="DivNotify"><img src="/img/world/clans/'.$clan['clan_id'].'.png"><div class="Text">';
			$notes .= '<div class="Words">Лидеры клана <b>'.$info->name.'</b> приглашают вас вступить в его ряды. Принять приглашение?</div>';
			$notes .= '<div class="buttons"><div class="btn" onclick=submitResponse("'.$clan['user_id'].'","clan",1);>Принять</div><div class="btn" onclick=submitResponse("'.$clan['user_id'].'","clan",2);>Отклонить</div></div>';
			$notes .= '</div></div>';
		}
		$friends = $mysqli->query('
		    SELECT 
		      `uf`.*,
		      
		      `u`.`login`,
		      `u`.`user_group`
		    FROM `users_friend` AS `uf`
		    INNER JOIN `users` AS `u`
		      ON `u`.`id` = `uf`.`user_id`
		    WHERE 
		      `uf`.`friend_id` = '.intval($_SESSION['id']).' AND
		      `uf`.`status` = 0
		');
		while($friend = $friends->fetch_assoc()){
			$notes .= '<div class="DivNotify"><img src="/img/avatars/mini/'.$friend['user_id'].'.png"><div class="Text">';
			$notes .= '<div class="Words"><div class="user-link u-'.$friend['user_group'].'">'.$friend['login'].'</div> хочет добавить вас в друзья.</div>';
			$notes .= '<div class="buttons"><div class="btn" onclick=submitResponse("'.$friend['user_id'].'","friend",1);>Принять</div><div class="btn" onclick=submitResponse("'.$friend['user_id'].'","friend",2);>Отклонить</div></div>';
			$notes .= '</div></div>';
		}
		$notifications = $mysqli->query("SELECT * FROM `notification` WHERE (`user` = '".$_SESSION['id']."' OR `user` = '2') ORDER BY `id` DESC LIMIT 100");
		while($noty = $notifications->fetch_assoc()){
			$notes .= '<div class="DivNotify"><img src="'.$noty['img'].'"><div class="Text">';
			$notes .= '<div class="Words">'.$noty['text'].'</div>';
			$notes .= '<div class="Data">'.$noty['date'].'</div></div></div>';
		}
		$mysqli->query("UPDATE `notification` SET `checked` = '1' WHERE (`user` = '".$_SESSION['id']."' OR `user` = '2') AND `checked` = '0'");

		$response = $notes;

	break;
	case 'count':
		$notifications = $mysqli->query("SELECT * FROM `notification` WHERE (`user` = '".$_SESSION['id']."' OR `user` = '2') AND `checked` = '0'")->num_rows;
		$friends = $mysqli->query("SELECT * FROM `users_friend` WHERE `friend_id` = '".$_SESSION['id']."' AND `status` = 0")->num_rows;
		$trades = $mysqli->query("SELECT * FROM `users_trade` WHERE `user2` = '".$_SESSION['id']."' AND `status` = 0")->num_rows;
		$clans = $mysqli->query("SELECT * FROM `user_clan_accept` WHERE `user_id` = '".$_SESSION['id']."' AND `status` = 0")->num_rows;
		$response = $notifications + $friends + $trades + $clans;
	break;
	default:
		echo "Unknown error";
	break;
}
echo (empty($response) ? 0 : $response);