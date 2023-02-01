<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$patch_func = $patch_project.'/inc/function/Functions.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
		require_once($patch_func);
    }
}

#GET USER INFO @START
$user = $mysqli->query('SELECT `login`,`user_group`,`rang`,`location` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
#GET USER INFO @END

#EVOLUTION USER POKS @START
$baseEvolutionsPoks = $mysqli->query('
								SELECT 
								`up`.`id`,
								`up`.`lvl`,
								`up`.`basenum`,
								`bp`.`evol_type`,
								`bp`.`evol_basenum`,
								`bp`.`evol_lvl`,
								`bp`.`exp_group`,
								`bp`.`name_rus`
								FROM `user_pokemons` AS `up`
								LEFT JOIN `base_pokemons` AS `bp`
									ON `up`.`basenum` = `bp`.`id`
								WHERE 
									`up`.`active` = 1 
								AND `up`.`user_id` = '.$_SESSION['id']);
while($baseEvolutions = $baseEvolutionsPoks->fetch_assoc()){
	if($baseEvolutions['evol_type'] == 'lvl' && $baseEvolutions['evol_lvl'] <= $baseEvolutions['lvl'] && !empty($baseEvolutions['evol_basenum'])){
		$mysqli->query('UPDATE `user_pokemons`
						SET
							`basenum` = '.$baseEvolutions['evol_basenum'].',
							`name_new` = "'.$baseEvolutions['name_rus'].'",
							`exp` = '.Info::_getExp($baseEvolutions['lvl'], $baseEvolutions['exp_group']).',
							`exp_max` = '.Info::_getExp(($baseEvolutions['lvl']+1), $baseEvolutions['exp_group']).' 
						WHERE
							`id` = '.$baseEvolutions['id']);
	}
}
#EVOLUTION USER POKS @END

#EGG @START
$eggQuery = $mysqli->query("SELECT * FROM `user_egg` WHERE `reborn` < '".$time."' AND `user` = '".$_SESSION['id']."'");
if($eggQuery->num_rows > 0){
	while($egg = $eggQuery->fetch_assoc()){
		newPokemon($egg['basenum'],$egg['user'],1,$egg['gens'],0,$egg['trade'],$egg['sparka'],false,$egg['shine'],$egg['character'], false, false);
		$mysqli->query('DELETE FROM `user_egg` WHERE `user` = '.$_SESSION['id'].' AND `reborn` < '.$time);
	}
}
#EGG @END

#UPDATE USER COUNT POKS INFO @START
$countPoks = $mysqli->query("SELECT COUNT(DISTINCT `basenum`) as count FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `type` = 'normal'")->fetch_assoc();
$countPoksShine = $mysqli->query("SELECT COUNT(DISTINCT `basenum`) as count FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `type` != 'normal'")->fetch_assoc();
$mysqli->query('UPDATE `users`
					SET
						`countShine` = '.$countPoksShine['count'].', 
						`countNormal` = '.$countPoks['count'].'
					WHERE 
						`id` = '.$_SESSION['id']
				);
#UPDATE USER COUNT POKS INFO @END

#SENT ALL DATA AJAX @START
$patch_avatars = $patch_project.'/img/avatars/mini/'.$_SESSION['id'].'.png';
$BonusTime = $mysqli->query("SELECT * FROM bonus_time WHERE id = 1")->fetch_assoc();
$BonusTimeReits = $mysqli->query("SELECT * FROM system WHERE id = 1")->fetch_assoc();
$response['data'] = [
						'login'			=>mb_strimwidth($user['login'],0,15,"..."),
						'rang'			=>mb_strimwidth($user['rang'],0,15,"..."),
						'user_group'	=>$user['user_group'],
						'img'			=>(!file_exists($patch_avatars) ? "no-user-img" : $_SESSION['id']),
						'newPrize'		=>($user['LastPrize'] < date('Y-m-d') ? true : false),
						'prize'			=>(isset($prizeList[$rand]) ? $prizeList[$rand] : 0),
						'dayTrophy'		=>$user['countDays'],
						'bonusMoney'    =>$BonusTime['money'],
						'bonusMoneyReit'=>$BonusTimeReits['money'],
						'bonusUnik'=>$BonusTime['unik'],
						'bonusUnikReit'=>$BonusTimeReits['shine'],
						'bonusVolera'=>$BonusTime['volera'],
						'bonusVoleraReit'=>$BonusTimeReits['volera'],
						'bonusDrop'=>$BonusTime['dropItem'],
						'bonusDropReit'=>$BonusTimeReits['drop'],
						'bonusExp'=>$BonusTime['exp'],
						'bonusExpReit'=>$BonusTimeReits['exp']
					];

echo json_encode($response);
#SENT ALL DATA AJAX @END