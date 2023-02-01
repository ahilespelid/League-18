<?php
#Функция прибавления PVE очков
function plus_learn_pve($count) {
  $user = Work::$sql->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
  $pve = json_decode($user['rating']);
  $winnerRatingUpd = '{"pve": '.($pve->pve+$count).', "pvp": '.$pve->pvp.', "battleCount": '.$pve->battleCount.'}';
  Work::$sql->query("UPDATE `users` SET `rating` = '".$winnerRatingUpd."' WHERE `id` = '".$_SESSION['id']."'");
}
#Функция отнимания PVE очков
function minus_learn_pve($count) {
  $user = Work::$sql->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
  $pve = json_decode($user['rating']);
  $winnerRatingUpd = '{"pve": '.($pve->pve-$count).', "pvp": '.$pve->pvp.', "battleCount": '.$pve->battleCount.'}';
  Work::$sql->query("UPDATE `users` SET `rating` = '".$winnerRatingUpd."' WHERE `id` = '".$_SESSION['id']."'");
}
#Функция проверки на количество PVE очков
function learn_pve() {
  $user = Work::$sql->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
  $pve = json_decode($user['rating']);
  return $pve->pve;
}
#Функция обновления статов
function stat_updates($infoPoke){
    if($infoPoke) {
      $baseEvolutionsPoks = Work::$sql->query('
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
          $a = Work::$sql->query('SELECT * FROM `user_pokemons` WHERE id = '.$baseEvolutions['id'])->fetch_assoc();
          Work::$sql->query('UPDATE `user_pokemons`
      						SET
      							`basenum` = '.$baseEvolutions['evol_basenum'].',
      							`name_new` = "'.$baseEvolutions['name_rus'].'",
      							`exp` = '.Info::_getExp($baseEvolutions['lvl'], $baseEvolutions['exp_group']).',
      							`exp_max` = '.Info::_getExp(($baseEvolutions['lvl']+1), $baseEvolutions['exp_group']).'
      						WHERE
      							`id` = '.$baseEvolutions['id']);
      	}
      }

    }
    if(!is_array($infoPoke)){

        $infoPoke = Work::$sql->query('
        SELECT
          `up`.* ,

          `bp`.`hp` AS `base_hp`,
          `bp`.`atk` AS `base_atk`,
          `bp`.`def` AS `base_def`,
          `bp`.`spd` AS `base_spd`,
          `bp`.`satk` AS `base_satk`,
          `bp`.`sdef` AS `base_sdef`

        FROM `user_pokemons` AS `up`
        INNER JOIN `base_pokemons` AS `bp`
          ON `bp`.`id` = `up`.`basenum`
        WHERE
          `up`.`id` = '.intval($infoPoke).'
      ')->fetch_assoc();

    }else{

        $basePoke = Work::$sql->query('
            SELECT

            `hp` AS `base_hp`,
            `atk` AS `base_atk`,
            `def` AS `base_def`,
            `spd` AS `base_spd`,
            `satk` AS `base_satk`,
            `sdef` AS `base_sdef`

            FROM `base_pokemons`
            WHERE
              `id` = '.$infoPoke['basenum'].'
        ')->fetch_assoc();

        $infoPoke = array_merge($infoPoke, $basePoke);
    }
    if(isset($infoPoke['base_hp'])){

        $hp    = stats($infoPoke,0);
        $atk   = stats($infoPoke,1);
        $def   = stats($infoPoke,2);
        $speed = stats($infoPoke,3);
        $spAtk = stats($infoPoke,4);
        $spDef = stats($infoPoke,5);

        $stats = $hp.','.$atk.','.$def.','.$speed.','.$spAtk.','.$spDef;
        Work::$sql->query("UPDATE `user_pokemons` SET `stats`='".$stats."' WHERE `user_id` = '".$_SESSION['id']."' AND `id` = '".$infoPoke['id']."'");

    }

}
#Формула статов
function stats($infoPoke, $tip){
    if($infoPoke && isset($infoPoke['base_hp'])){

        $gens = explode(',', $infoPoke['gen']);
        $ev   = explode(',', $infoPoke['evcounts']);
        $har  = Work::$sql->query("SELECT * FROM `har` WHERE `id_har` = '".$infoPoke['character']."'")->fetch_assoc();

        if($tip == 0){

            $stat = (($infoPoke['base_hp'] * 2) + $gens[0] + ($ev[0]/2)) * ($infoPoke['lvl']/100) + 10 + $infoPoke['lvl'];

        }elseif($tip == 1){

            $stat = ((($infoPoke['base_atk'] * 2 + $gens[1] + ($ev[1]/2)) * $infoPoke['lvl']/100 + 5) * $har['atk']);

            if($infoPoke['tren_stat'] == 1){
                $stat = $stat*classific($infoPoke['tren']);
            }

        }elseif($tip == 2){
            $stat = (($infoPoke['base_def'] * 2 + $gens[2] + ($ev[2]/2)) * $infoPoke['lvl']/100 + 5) * $har['def'];

            if($infoPoke['tren_stat'] == 2){
                $stat = $stat*classific($infoPoke['tren']);
            }

        }elseif($tip == 3){

            $stat = (($infoPoke['base_spd'] * 2 + $gens[3] + ($ev[3]/2)) * $infoPoke['lvl']/100 + 5) * $har['speed'];

            if($infoPoke['tren_stat'] == 3){
                $stat = $stat*classific($infoPoke['tren']);
            }

        }elseif($tip == 4){

            $stat = (($infoPoke['base_satk'] * 2 + $gens[4] + ($ev[4]/2)) * $infoPoke['lvl']/100 + 5) * $har['satk'];

            if($infoPoke['tren_stat'] == 4){
                $stat = $stat*classific($infoPoke['tren']);
            }

        }elseif($tip == 5){

            $stat = (($infoPoke['base_sdef'] * 2 + $gens[5] + ($ev[5]/2)) * $infoPoke['lvl']/100 + 5) * $har['sdef'];

            if($infoPoke['tren_stat'] == 5){
                $stat = $stat*classific($infoPoke['tren']);
            }

        }else{
            $stat = 0;
        }
        return intval(round($stat));
    }

    return 0;
}
#Формула тренировок
function classific($class){
    switch($class){
        case 1:
            $stat = 1.06;
            break;
        case 2:
            $stat = 1.09;
            break;
        case 3:
            $stat = 1.13;
            break;
        case 4:
            $stat = 1.18;
            break;
        case 5:
            $stat = 1.22;
            break;
        case 6:
            $stat = 1.26;
            break;
        case 7:
            $stat = 1.3;
            break;
        default:
            $stat = 1;
            break;
    }

    return $stat;
}
#Закрыть уведомление администрации
function closeNotify($id){
	Work::$sql->query("INSERT INTO `adminNotifyCheck` (`user_id`,`id_notify`) VALUES ('".$_SESSION['id']."','".$id."') ");
}
#Проверяет время добычи
function discoveryTime($loc,$type){

	$q = Work::$sql->query("SELECT * FROM `discovery` WHERE `user` = '".$_SESSION['id']."' AND `id_loc` = '".$loc."' AND `type` = '".$type."' ORDER BY `id` DESC")->fetch_assoc();
	$a = ($q['time'] > time() ? true : false);
	return $a;
}
#Проверяет, изучен ли рецепт
function recipeCheck($id){

	$a = Work::$sql->query("SELECT * FROM `craft_recipe_user` WHERE `recipe` = '".$id."' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
	if(!$a){
		$b = 'no-active';
	}else{
		$b = '';
	}
	return $b;
}
#Добавляет нули в номере к покемону по айди
function numCheck($id){

	$a = Work::$sql->query("SELECT `basenum` FROM `user_pokemons` WHERE `id` = '".$id."'")->fetch_assoc();
	if($a['basenum'] >= 1 && $a['basenum'] <= 9){
		$b = '00'.$a['basenum'];
	}elseif($a['basenum'] >= 10 && $a['basenum'] <= 99){
		$b = '0'.$a['basenum'];
	}else{
		$b = $a['basenum'];
	}
	return $b;
}
function numCheck_basenum($id){

	if($id >= 1 && $id <= 9){
		$b = '00'.$id;
	}elseif($id >= 10 && $id <= 99){
		$b = '0'.$id;
	}else{
		$b = $id;
	}
	return $b;

}
#Апдейт элементов одежды
function update_cloth($slot, $id){
	Work::$sql->query("UPDATE `cloth` SET `".$slot."` = '".$id."' WHERE `user` = '".$_SESSION['id']."'");
}
#Апдейт записей квестов в дневнике
function update_zap($id, $step, $text){
	Work::$sql->query("INSERT INTO `quest_steps` (`id_user`,`text`,`quest_id`,`quest_step`) VALUES ('".$_SESSION['id']."','".$text."','".$id."','".$step."') ");
}
#Апдейт ачивок.
function update_ach($id, $count){

  $ach = Work::$sql->query("SELECT * FROM `base_achievements` WHERE `id` = '".$id."'")->fetch_assoc();
  $ach_user = Work::$sql->query("SELECT * FROM `user_achievements` WHERE `user_id` = '".$_SESSION['id']."' AND `id_ach` = '".$id."'")->fetch_assoc();
  if($ach_user){
	  if($ach['category'] == 1){
		  $cnt = ($count + $ach_user['count']);
		  Work::$sql->query("UPDATE `user_achievements` SET `count` = '".$cnt."' WHERE `id_ach` = '".$id."' AND `user_id` = '".$_SESSION['id']."'");
		  if($cnt == $ach['need']){
			  Work::$sql->query("UPDATE `user_achievements` SET `complete` = 1 WHERE `id_ach` = '".$id."' AND `user_id` = '".$_SESSION['id']."'");
		  }
	  }else{
		  Work::$sql->query("UPDATE `user_achievements` SET `complete` = 1 WHERE `id_ach` = '".$id."' AND `user_id` = '".$_SESSION['id']."'");
	  }
  }else{
	  if($ach['category'] == 1){
		  Work::$sql->query("INSERT INTO `user_achievements` (`user_id`,`id_ach`,`complete`,`count`) VALUES ('".$_SESSION['id']."','".$id."',0,'".$count."') ");
	  }else{
		  Work::$sql->query("INSERT INTO `user_achievements` (`user_id`,`id_ach`,`complete`,`count`) VALUES ('".$_SESSION['id']."','".$id."',1,0) ");
	  }
  }
}
#Найти что-либо о Юзере по его ID.
function info_user($id, $type){

  $user = Work::$sql->query("SELECT * FROM `users` WHERE `id` = '".$id."'")->fetch_assoc();
  if($user){
	  $b = $user[$type];
  }else{
	  $b = 'error';
  }
  return $b;
}
#Проверка на начало квеста в дневнике.
function quest_isset_book($id){

  $quest = Work::$sql->query("SELECT * FROM `user_quests` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '".$id."'")->fetch_assoc();
  if($quest){
	  if($quest['end'] == 1){
		 $b = '<div class="Progress type2">Пройдено</div>';
	  }else{
		 $b = '<div class="Progress type3">Выполняется</div>';
	  }
  }else{
	  $b = '<div class="Progress type1">Не пройдено</div>';
  }
  return $b;
}
function quest_info($id,$type){

	$quest = Work::$sql->query("SELECT * FROM `base_quest` WHERE `id` = ".$id."")->fetch_assoc();
	$a = $quest[$type];
	return $a;
}
#Добавления предмета
function itemAdd($itemID, $count, $user = false){

	if($itemID > 0){
		$user = (!$user ? $_SESSION['id'] : $user);
    $base = Work::$sql->query("SELECT `str` FROM `base_items` WHERE `id`= '".$itemID."'")->fetch_assoc();
		$items = Work::$sql->query("SELECT * FROM `items_users` WHERE `user`= '".$user."' AND `item_id` = '".$itemID."'")->fetch_assoc();
		if(!empty($items['count']) && $base['str'] == '0'){
			$itemsCount = $items['count'] + $count;
			Work::$sql->query("UPDATE `items_users` SET `count` = '".$itemsCount."' WHERE `item_id` = '".$itemID."' AND `user` = '".$user."'");
		}else{
      if($base['str'] == '0') {
        Work::$sql->query("INSERT INTO `items_users` (`user`,`item_id`,`count`) VALUES ('".$user."','".$itemID."','".$count."') ");
      }else{
        $i = 1;
        $str = explode(',',$base['str']);
        while($i <= $count) {
          $rand_str = mt_rand($str[0],$str[1]);
          Work::$sql->query("INSERT INTO `items_users` (`user`,`item_id`,`count`,`str`) VALUES ('".$user."','".$itemID."','1','".$rand_str.','.$rand_str."') ");
          $i++;
        }
      }
		}
	}else{
		return false;
	}
}
#Определяет наличие предмета
function item_isset($item_id, $count, $user = false){
	if(empty($user)){
		$user = $_SESSION['id'];
	}
	$i = Work::$sql->query("SELECT `count` FROM `items_users` WHERE `user` = '".$user."' AND `item_id` = '".$item_id."' AND `count` >= '".$count."'")->fetch_assoc();
	if(!empty($i['count']) && $i['count'] > 0){
		return $i['count'];
	}else{
		return false;
	}
}
#Отнимает предмет
function minus_item($item_id, $count, $user = false){

	if($user == false){
		$user = $_SESSION['id'];
	}
	$item = Work::$sql->query("SELECT * FROM `items_users` WHERE `user` = '".$user."' AND `item_id` = '".$item_id."' AND `count` >= '".$count."'");
	if($item->num_rows > 0){
		$items = $item->fetch_assoc();
		if($items['count'] > $count){
			$x = $items['count'] - $count;
			Work::$sql->query("UPDATE `items_users` SET `count` = '".$x."' WHERE `item_id` = '".$item_id."' AND `user` = '".$user."'");
		}else{
			Work::$sql->query("DELETE FROM `items_users` WHERE `item_id` = '".$item_id."' AND `user` = '".$user."'");
		}
  }
}
#Отнимает предмет по ID
function minus_item_id($item_id, $count, $user=false){

    if($user == false) $user = $_SESSION['id'];
    $item = Work::$sql->query("SELECT * FROM `items_users` WHERE `user` = '".$user."' AND `id` = '".$item_id."' AND `count` >= '".$count."'");
    if($item->num_rows > 0){
        $items = $item->fetch_assoc();
        if($items['count'] > $count){
            $x = $items['count'] - $count;
            Work::$sql->query("UPDATE `items_users` SET `count` = '".$x."' WHERE `id` = '".$item_id."' AND `user` = '".$user."'");
        }else{
            Work::$sql->query("DELETE FROM `items_users` WHERE `id` = '".$item_id."' AND `user` = '".$user."'");
        }
    }
}
#Функция распознования характера
function haracter_pokes($a){
    $harakter['1'] = "Веселый";
    $harakter['2'] = "Выносливый";
    $harakter['3'] = "Застенчивый";
    $harakter['4'] = "Кроткий";
    $harakter['5'] = "Мирный";
    $harakter['6'] = "Мягкий";
    $harakter['7'] = "Наглый";
    $harakter['8'] = "Наивный";
    $harakter['9'] = "Нахальный";
    $harakter['10'] = "Нежный";
    $harakter['11'] = "Непослушный";
    $harakter['12'] = "Непреклонный";
    $harakter['13'] = "Обычный";
    $harakter['14'] = "Одинокий";
    $harakter['15'] = "Озорной";
    $harakter['16'] = "Осторожный";
    $harakter['17'] = "Поспешный";
    $harakter['18'] = "Причудливый";
    $harakter['19'] = "Распущенный";
    $harakter['20'] = "Робкий";
    $harakter['21'] = "Серьезный";
    $harakter['22'] = "Скромный";
    $harakter['23'] = "Смелый";
    $harakter['24'] = "Спокойный";
    $harakter['25'] = "Стремительный";
    $harakter['26'] = "Тихий";
  $b = $harakter[$a];
  if(!$b) $b = 'UNDEFINED';
 return $b;
}

function tren_name($a){
    $info = [];
    $info['1'] = "Атака";
    $info['2'] = "Защита";
    $info['3'] = "Скорость";
    $info['4'] = "Спец. Атака";
    $info['5'] = "Спец. Защита";

    if(isset($info[$a])){
        return $info[$a];
    }

    return 'Отсутствует';
}

#Функция добавления нового покемона
function newPokemon($pok,$user_new=false,$lvl=false,$gen=false,$startGame=false,$trade,$sparka,$event=false,$shine=false,$character=false,$ev=false,$eggThis=false) {
	global $mysqli;
  if($trade == 'false'){
    $trade = 'false';
  }else{
    $trade = 'true';
  }
	$pok_base = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$pok."'")->fetch_assoc();
	$event = ($event?$event:0);
	$lvl = ($lvl?$lvl:1);
	$startGame = ($startGame?$startGame:0);
	$user_new = ($user_new?$user_new:$_SESSION['id']);

    $users =  $mysqli->query("SELECT `user_group`,`login` FROM `users` WHERE `id`='".$user_new."'")->fetch_assoc();
	$usersPokemon =  $mysqli->query("SELECT `active` FROM `user_pokemons` WHERE `user_id`='".$_SESSION['id']."' AND `active` = 1");
  if($userPokemon->num_rows < 6){
		if($eggThis == false){
			$active = 0;
		}else{
			$active = 1;
		}
	}else{
		$active = 0;
	}
	$month = array(1=>'Января',2=>'Февраля',3=>'Марта',4=>'Апреля',5=>'Мая',6=>'Июня',7=>'Июля',8=>'Августа',9=>'Сентября',10=>'Октября',11=>'Ноября',12=>'Декабря');
	$dateGet = '{"user_id":"'.$user_new.'","date": "'.time().'"}';
	#Яйцевая атака
	$eggAttacks = $mysqli->query("SELECT `attacks` FROM `base_attacks_pokemons` WHERE `pok` = '".$pok."' AND `type` = 'sex'")->fetch_assoc();
	$arrayAttacks = explode(',',$eggAttacks['attacks']);
	if(rand(1,100) < 25){
		$numberAttack = mt_rand(0, count($arrayAttacks) - 1);
		if($eggThis == false){
			if(!empty($arrayAttacks[$numberAttack])){
				$attacksList = $arrayAttacks[$numberAttack].',0,0,0';
			}else{
				$attacksList = '0,0,0,0';
			}
		}else{
			$attacksList = '0,0,0,0';
		}
	}else{
		$attacksList = '0,0,0,0';
	}
	if($shine == 1){
		if(date("G") == 0 || date("G") == 1 || date("G") == 3 || date("G") == 4 || date("G") == 5){
			$shine = "shadow";
		}else{
			$shine = "shine";
		}
	}else{
    if($shine == 2) {
      $shine = 'zombie';
    }elseif($shine == 101){
      $shine = 'birthday';
    }else{
      if(mt_rand(1, 11000) > 10){
  			$shine = "normal";
  		}else{
        $shineTimeRand = mt_rand(1,2);
        if($shineTimeRand == 1) {
          $shine = 'shadow';
        }else{
          $shine = 'shine';
        }
  		}
    }
	}
  if($pok_base['sex_m'] == 0 && $pok_base['sex_f'] == 0) {
    $gender = 'Бесполый';
  }else{
    $gender = ($pok_base['sex_f'] > 0 ? ( $pok_base['sex_f'] >= mt_rand(0, 100) ? 'Девочка' : 'Мальчик' ) : 'Мальчик');
  }
	$character = ($character?$character:rand(1,26));
	$har = $mysqli->query("SELECT * FROM `har` WHERE `id_har` = '".$hr."' ")->fetch_assoc();
	$hg = rand(25,30);
	$ag = rand(25,30);
	$dg = rand(25,30);
	$sg = rand(25,30);
	$sag = rand(25,30);
	$sdg = rand(25,30);
	$gens = ($gen?$gen:$hg.','.$ag.','.$dg.','.$sg.','.$sag.','.$sdg);

	$s1 = round((($pok_base['hp'] * 2) + $hg) * (1/100) + 10 + 1);
	$s2 = round((($pok_base['atk'] * 2 + $ag) * 1/100 + 5) * $har['atk']);
	$s3 = round((($pok_base['def'] * 2 + $dg) * 1/100 + 5) * $har['def']);
	$s4 = round((($pok_base['spd'] * 2 + $sg) * 1/100 + 5) * $har['speed']);
	$s5 = round((($pok_base['satk'] * 2 + $sag) * 1/100 + 5) * $har['satk']);
	$s6 = round((($pok_base['sdef'] * 2 + $sdg) * 1/100 + 5) * $har['sdef']);

  	$ev = ($ev?$ev:0);
	$sparkNumber = mt_rand(1, 3);
    $stats = $s1.','.$s2.','.$s3.','.$s4.','.$s5.','.$s6;
	$expirience = Info::_getExp($lvl, $pok_base['exp_group']);
	$expirienceMax = Info::_getExp(($lvl+1), $pok_base['exp_group']);
	$mysqli->query("INSERT INTO `user_pokemons` (`user_id`,`basenum`,`name_new`,`character`,`lvl`,`birthday`,`active`,`type`,`gender`,`exp`,`exp_max`,`ev`,`hp`,`stats`,`gen`,`owner`,`master`,`startGame`,`sparka`,`attacks`,`sparkaNumber`,`trade`,`event`) VALUES ('".$user_new."','".$pok_base['id']."','".$pok_base['name_rus']."','".$character."','".$lvl."','".$dateGet."','".$active."','".$shine."','".$gender."','".$expirience."','".$expirienceMax."','".$ev."','".$s1."','".$stats."','".$gens."','".$user_new."','".$user_new."','".$startGame."','".$sparka."','".$attacksList."','".$sparkNumber."','".$trade."','".$event."') ");
	if($eggThis == false){
		$month = array(1=>'Января',2=>'Февраля',3=>'Марта',4=>'Апреля',5=>'Мая',6=>'Июня',7=>'Июля',8=>'Августа',9=>'Сентября',10=>'Октября',11=>'Ноября',12=>'Декабря');
	$dayToday = date("d");
	$monthToday = $month[date("n")];
	$YearToday = date("Y");
	$date = $dayToday.' '.$monthToday.' '.$YearToday.'г. в '.date("H").':'.date("i");
	$text = 'С пополнением! Вылупилось яйцо <b>'.$pok_base['name_rus'].'</b>. Проверьте свой питомник.';
	$mysqli->query("INSERT INTO `notification` (`text`,`user`,`img`,`date`) VALUES ('".$text."','".$_SESSION['id']."','/img/world/items/little/54.png','".$date."')");
	update_ach(4,1);
	}
	}
#Функция добавления яйца
function plusEgg($gens=false,$character=false,$shine=false,$trade=false,$reborn=false,$basenum=false,$sparka=false,$userEgg=false){
  $user = ($userEgg == false ? $_SESSION['id'] : $userEgg);
	$sprk = ($sparka == false ? 0 : 1);
	$character = ($character?$character:rand(1,26));
	$hg = rand(25,30);
	$ag = rand(25,30);
	$dg = rand(25,30);
	$sg = rand(25,30);
	$sag = rand(25,30);
	$sdg = rand(25,30);
	$gens = ($gens?$gens:$hg.','.$ag.','.$dg.','.$sg.','.$sag.','.$sdg);
  if($shine == 101) {
    $shine = 101;
  }elseif($shine == 1){
		$shine = 1;
	}else{
		if(mt_rand(1, 11000) < 10){
			$shine = 1;
		}else{
			$shine = 0;
		}
	}
	$trade = ($trade == false ? 'false' : 'true');
	$countDay = rand(8,11);
	$reborn = ($reborn?$reborn:time()+(3600*24*$countDay));
	$basenum = ($basenum?$basenum:rand(1,722));
	$baseGet = Work::$sql->query("SELECT `eggBasenum` FROM `base_pokemons` WHERE `id` = '".$basenum."'")->fetch_assoc();
	$a = Work::$sql->query("INSERT INTO `user_egg` (`gens`,`character`,`shine`,`trade`,`reborn`,`user`,`basenum`,`sparka`) VALUES('".$gens."','".$character."','".$shine."','".$trade."','".$reborn."','".$user."','".$baseGet['eggBasenum']."','".$sprk."') ");
}
