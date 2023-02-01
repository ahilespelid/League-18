<?
	$clans = Work::$sql->query("SELECT * FROM `clan_app`");
	$kenesis = explode(',',$pokemon['attacks']);
	$response['name'] = 'Создать клан';
	switch($npcStep){
		default:
			$response['question'] .= 'Заявки на создание клана:';
			while($clan = $clans->fetch_assoc()){
				$user = Work::$sql->query("SELECT `login`,`user_group` FROM `users` WHERE `id` = '".$clan['user']."'")->fetch_assoc();
				$response['question'] .= '<br><br>Клан <b>'.$clan['name'].'</b> от тренера <div class="user-link u-'.$user['user_group'].'">'.$user['login'].'</div> (id '.$clan['user'].'). <a href="'.$clan['emblem'].'" target="_blank">Эмблема</a>. <br><a onclick="clanAdmin(\'okAdminClan\','.$clan['id'].')">Одобрить</a> или <a onclick="clanAdmin(\'noAdminClan\','.$clan['id'].')">Отклонить</a>';
			}
		break;
	}
?>