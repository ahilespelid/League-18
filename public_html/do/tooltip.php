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
$user = $mysqli->real_escape_string(clearStr($_POST['user']));
if(!empty($user)){
$userTo = $mysqli->query("SELECT `id`,`login`,`user_group` AS `group` FROM `users` WHERE `id` = '".$user."'")->fetch_assoc();
$userTo1 = $mysqli->query("SELECT * FROM `base_clans_users` WHERE `user_id` = '".$userTo['id']."'")->fetch_assoc();
$userTo2 = $mysqli->query("SELECT * FROM `base_clans_users` WHERE `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
	if(!empty($userTo2)){
		if($userTo2['group'] == 1 && $userTo['id'] != $_SESSION['id']){
			if($userTo2['clan_id'] == $userTo1['clan_id']){
				$userTo['delClan'] = true;
			}else{
				$userTo['addClan'] = true;
			}
		}
	}
    if(!empty($userTo)){
        if($userTo['id'] == $_SESSION['id']){
            $userTo['my'] = true;
        }else{
            $friends = $mysqli->query("SELECT `id` FROM `users_friend` WHERE (`user_id` = '".$_SESSION['id']."' AND `friend_id` = '".$userTo['id']."') OR (`user_id` = '".$userTo['id']."' AND `friend_id` = '".$_SESSION['id']."') ")->fetch_assoc();
            if(!empty($friends['id'])){
                $userTo['friend'] = true;
            }
        }
        Work::_setInfo('userTooltip', $userTo);
    }
    $response['html'] = 1;
/*
    $tpl = '<div id="DivAbout">Информация <b>'.$user.'</b></b></div>';
    $tpl.= '<div class="wrap"><div class="PokList">';
    $tpl.= '<div class="PokBtn" onclick=openTrenCard("'.$user.'");>Тренеркарта</div>';
    if($userTo['id'] != $_SESSION['id']){
        $friends = $mysqli->query("SELECT * FROM `users_friend` WHERE `user_id` = '".$_SESSION['id']."' AND `friend_id` = '".$userTo['id']."' OR `user_id` = '".$userTo['id']."' AND `friend_id` = '".$_SESSION['id']."'")->fetch_assoc();
        $tpl.= '<div class="PokBtn" onclick="setTrade(\'send\','.$userTo['id'].');">Обмен</div>';
        $tpl.= '<div class="PokBtn">Бой</div>';
        if(!$friends['id']){
            $tpl.= '<div class="PokBtn" onclick=userAction("'.$user.'","friend");>Дружить</div>';
        }else{
            $tpl.= '<div class="PokBtn" onclick=userAction("'.$user.'","DeleteFriend");>Удалить из друзей</div>';
        }
        $tpl.= '<div class="PokBtn">Добавить в ЧС</div>';
        $tpl.= '</div></div>';
    }*/

}
Work::_viewOut();
echo json_encode($response);
