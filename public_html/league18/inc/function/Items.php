<?php
function modif($pokID,$itemID) {
	$pokemon = Work::$sql->query('SELECT * FROM user_pokemons WHERE id = '.$pokID)->fetch_assoc();
	if($pokemon) {
		switch($itemID) {
			case 257:
				$rand = mt_rand(1,26);
				Work::$sql->query("UPDATE `user_pokemons` SET `character` = '".$rand."' WHERE `id` = '".$pokID."'");
				$_SESSION['text'] = 'Покемон успешно изменил характер.';
				$_SESSION['error'] = 0;
				minus_item($itemID,1);
			break;
			case 258:
				$rand = mt_rand(1,3);
				Work::$sql->query("UPDATE `user_pokemons` SET `sparkaNumber` = '".$rand."' WHERE `id` = '".$pokID."'");
				$_SESSION['text'] = 'Покемон успешно изменил группу привлекательности.';
				$_SESSION['error'] = 0;
				minus_item($itemID,1);
			break;
			case 259:
				if($pokemon['lvl'] >= 25) {
					$_SESSION['text'] = 'Невозможно применить данную модификацию этому покемону.';
					$_SESSION['error'] = 1;
				}else{
					$minus = 25 - $pokemon['lvl'];
					$evPlus = ($minus * 3) + $pokemon['ev'];
					Work::$sql->query("UPDATE `user_pokemons` SET `lvl` = '25', `ev` = '".$evPlus."', `exp` = '0', `exp_max` = '1' WHERE `id` = '".$pokID."'");
					$_SESSION['text'] = 'Покемон успешно прокачен до 25 ур. Скобой. ';
					$_SESSION['error'] = 0;
					minus_item($itemID,1);
				}
			break;
			case 260:
				if($pokemon['lvl'] >= 50) {
					$_SESSION['text'] = 'Невозможно применить данную модификацию этому покемону.';
					$_SESSION['error'] = 1;
				}else{
					$minus = 50 - $pokemon['lvl'];
					$evPlus = ($minus * 3) + $pokemon['ev'];
					Work::$sql->query("UPDATE `user_pokemons` SET `lvl` = '50', `ev` = '".$evPlus."', `exp` = '0', `exp_max` = '1' WHERE `id` = '".$pokID."'");
					$_SESSION['text'] = 'Покемон успешно прокачен до 50 ур. Скобой.';
					$_SESSION['error'] = 0;
					minus_item($itemID,1);
				}
			break;
			case 261:
				if($pokemon['lvl'] >= 75) {
					$_SESSION['text'] = 'Невозможно применить данную модификацию этому покемону.';
					$_SESSION['error'] = 1;
				}else{
					$minus = 75 - $pokemon['lvl'];
					$evPlus = ($minus * 3) + $pokemon['ev'];
					Work::$sql->query("UPDATE `user_pokemons` SET `lvl` = '75', `ev` = '".$evPlus."', `exp` = '0', `exp_max` = '1' WHERE `id` = '".$pokID."'");
					$_SESSION['text'] = 'Покемон успешно прокачен до 75 ур. Скобой.';
					$_SESSION['error'] = 0;
					minus_item($itemID,1);
				}
			break;
			case 262:
				if($pokemon['lvl'] >= 100) {
					$_SESSION['text'] = 'Невозможно применить данный курс этому покемону.';
					$_SESSION['error'] = 1;
				}else{
					$minus = 100 - $pokemon['lvl'];
					$evPlus = ($minus * 3) + $pokemon['ev'];
					Work::$sql->query("UPDATE `user_pokemons` SET `lvl` = '100', `ev` = '297', `exp` = '0', `evcounts` = '0,0,0,0,0,0', `exp_max` = '1' WHERE `id` = '".$pokID."'");
					$_SESSION['text'] = 'Покемон успешно прокачен до 100 ур. Скобой.';
					$_SESSION['error'] = 0;
					minus_item($itemID,1);
				}
			break;
			case 263:
				$ev = explode(',',$pokemon['evcounts']);
				$evPlus = $ev['0'] + $ev['1'] + $ev['2'] + $ev['3'] + $ev['4'] + $ev['5'] + $pokemon['ev'];
				$ev['0'] = 0; $ev['1'] = 0; $ev['2'] = 0; $ev['3'] = 0; $ev['4'] = 0; $ev['5'] = 0;
				$evMinus = implode(',',$ev);
				Work::$sql->query("UPDATE `user_pokemons` SET `ev` = '".$evPlus."', `evcounts` = '".$evMinus."' WHERE `id` = '".$pokID."'");
				$_SESSION['text'] = 'Покемон успешно сбросил EV.';
				$_SESSION['error'] = 0;
				minus_item($itemID,1);
			break;
			// case 264:
			// 	$ev = explode(',',$pokemon['evcounts']);
			// 	$lvl = ($pokemon['lvl'] * 3) - 3;
			// 	$ev['0'] = 0; $ev['1'] = 0; $ev['2'] = 0; $ev['3'] = 0; $ev['4'] = 0; $ev['5'] = 0;
			// 	$evMinus = implode(',',$ev);
			// 	Work::$sql->query("UPDATE `user_pokemons` SET `trade` = 'false', `ev` = '".$lvl."', `evcounts` = '".$evMinus."' WHERE `id` = '".$pokID."'");
			// 	$_SESSION['text'] = 'Покемон успешно сбросил EV.';
			// 	$_SESSION['error'] = 0;
			// 	minus_item($itemID,1);
			// break;
			default:
				$_SESSION['text'] = 'Ошибка';
				$_SESSION['error'] = 1;
			break;
		}
	}
}
function drazdo($itemID) {
	$rand = mt_rand(1,30);
	if($rand == 1) {
		$randZnak2 = mt_rand(242,244);
	}else{
		$randZnak2 = mt_rand(245,253);
	}
	$it2 = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$randZnak2)->fetch_assoc();
	$_SESSION['plus'] = '<img src="/img/world/items/little/'.$it2['id'].'.png" class="item"> '.$it2['name'].' (1 шт.)';
	$_SESSION['text'] = 'Комплект успешно открыт.';
	$_SESSION['error'] = 0;
	itemAdd($randZnak2,1);
	minus_item($itemID,1);
}
function korobka_pirozn($itemID) {
	$randPiroz = mt_rand(217,234);
	$it2 = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$randPiroz)->fetch_assoc();
	$_SESSION['plus'] = '<img src="/img/world/items/little/'.$it2['id'].'.png" class="item"> '.$it2['name'].' (5 шт.)';
	$_SESSION['text'] = 'Коробка успешно открыта.';
	$_SESSION['error'] = 0;
	itemAdd($randPiroz,5);
	minus_item($itemID,1);
}
function korobka_banki($itemID) {
	$randBanka = mt_rand(37,42);
	$it2 = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$randBanka)->fetch_assoc();
	$_SESSION['plus'] = '<img src="/img/world/items/little/'.$it2['id'].'.png" class="item"> '.$it2['name'].' (5 шт.)';
	$_SESSION['text'] = 'Коробка успешно открыта.';
	$_SESSION['error'] = 0;
	itemAdd($randBanka,5);
	minus_item($itemID,1);
}
function usili($itemID) {
	$usilItem = Work::$sql->query("SELECT * FROM `base_items` WHERE `id` = '".$itemID."'")->fetch_assoc();
	$usilFunc = explode(',',$usilItem['info']);
	$time = time() + $usilFunc[0];
	$usil = Work::$sql->query("SELECT * FROM `bafs` WHERE `type` = '".$usilFunc[1]."' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
	if($usil) {
		Work::$sql->query("UPDATE `bafs` SET `time` = '".$time."',`baf` = '".$itemID."' WHERE `type` = '".$usilFunc[1]."' AND `user` = '".$_SESSION['id']."'");
	}else{
		Work::$sql->query("INSERT INTO `bafs` (`user`,`baf`,`time`,`type`) VALUES ('".$_SESSION['id']."','".$itemID."', '".$time."', '".$usilFunc[1]."') ");
	}
	minus_item($itemID,1);
	$_SESSION['error'] = 0;
	$_SESSION['text'] = 'Вы удачно активировали предмет.';
}
function tm($pokID,$itemID) {
	$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
	$item = Work::$sql->query("SELECT * FROM `base_items` WHERE `id` = '".$itemID."'")->fetch_assoc();
	$tm = Work::$sql->query("SELECT * FROM `attac_poke_tm` WHERE `tm_id` = '".$item['tm_id']."' AND `poke_base_id` = '".$pokemon['basenum']."'")->fetch_assoc();
	if($tm){
		$tmCheck = Work::$sql->query("SELECT * FROM `user_pokemons_tm` WHERE `pok` = '".$pokID."' AND `attacks` = '".$item['info']."'")->fetch_assoc();
		if($tmCheck){
			$_SESSION['error'] = 1;
			$_SESSION['text'] = 'Покемон уже обучен этой атаке.';
		}else{
			minus_item($itemID,1);
			Work::$sql->query("INSERT INTO `user_pokemons_tm` (`pok`,`attacks`) VALUES ('".$pokID."','".$item['info']."') ");
			$_SESSION['error'] = 0;
			$_SESSION['text'] = 'Вы обучили покемона новой атаке.';
		}
	}else{
		$_SESSION['error'] = 1;
		$_SESSION['text'] = 'Покемон не может быть обучен этой атаке.';
	}
}
function juce($pokID,$count,$itemID) {

		$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
		$lol3 = $pokemon['happy'] + ($count*10);
		if($lol3 > 255){
			$happy = 255;
		}else{
			$happy = $lol3;
		}
		Work::$sql->query("UPDATE `user_pokemons` SET `happy` = '".$happy."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
		minus_item(177,$count);
		$_SESSION['error'] = 0;
		$_SESSION['text'] = 'Счастье покемона повысилось!';
}
function hell_happy($pokID) {
		$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
		$randh = mt_rand(1,2);
		if($randh == 1) {
			$lol3 = $pokemon['happy'] + 5;
			if($lol3 > 255){
				$happy = 255;
			}else{
				$happy = $lol3;
			}
			Work::$sql->query("UPDATE `user_pokemons` SET `happy` = '".$happy."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['error'] = 0;
			$_SESSION['text'] = 'Счастье покемона повысилось на 5 пунктов!';
		}else{
			$lol3 = $pokemon['happy'] - 5;
			if($lol3 < 0){
				$happy = 0;
			}else{
				$happy = $lol3;
			}
			Work::$sql->query("UPDATE `user_pokemons` SET `happy` = '".$happy."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['error'] = 0;
			$_SESSION['text'] = 'Счастье покемона понизилось на 5 пунктов!';
		}
		minus_item(326,1);
}
function hell($itemID) {
	$rand = mt_rand(1,100);
	if($rand == 1) {
		$_SESSION['plus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
		plusEgg(false,false,false,false,false,228,true);
	}elseif($rand >= 2 && $rand <= 91) {
		$rand1 = mt_rand(1,3);
		if($rand1 == 1) {
			itemAdd(324,3);
			$_SESSION['plus'] = '<img src="/img/world/items/little/324.png" class="item"> Просроченная конфета (3 шт.)';
		}elseif($rand1 == 2) {
			itemAdd(325,3);
			$_SESSION['plus'] = '<img src="/img/world/items/little/325.png" class="item"> Жуткая конфета (3 шт.)';
		}else{
			itemAdd(326,3);
			$_SESSION['plus'] = '<img src="/img/world/items/little/326.png" class="item"> Загадочная конфета (3 шт.)';
		}
	}elseif($rand >= 92 && $rand <= 96) {
		itemAdd(22,1);
		$_SESSION['plus'] = '<img src="/img/world/items/little/22.png" class="item"> Порванная ткань (1 шт.)';
	}else{
		itemAdd(1030,1);
		$_SESSION['plus'] = '<img src="/img/world/items/little/1030.png" class="item"> Тренировочная машина (1 шт.)';
	}
	$_SESSION['error'] = 0;
	$_SESSION['text'] = 'Вы открыли сундук!';
	minus_item($itemID,1);
}
function Checkbank($itemID) {
	$rand = mt_rand(1,1);
	if($rand >=1 && $rand <= 1) {
		$rand = mt_rand(1,1);
		if($rand == 1) {
			itemAdd(1,90000);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1.png" class="item"> Монеты (90 000 шт.)';
			}
	}
	$_SESSION['error'] = 0;
	$_SESSION['text'] = 'Вы обналичили чек!';
	minus_item($itemID,1);
}
function MainBox($itemID) {
	$rand = mt_rand(1,1000);
	if($rand >= 1 && $rand <= 4) {
		$rand = mt_rand(1,5);
		if($rand == 1) {
			plusEgg(false,false,false,false,false,529,true);
		}elseif($rand == 2){
			plusEgg(false,false,false,false,false,443,true);
		}elseif($rand == 3){
			plusEgg(false,false,false,false,false,447,true);
		}elseif($rand == 4){
			plusEgg(false,false,false,false,false,669,true);
		}else{
			plusEgg(false,false,false,false,false,610,true);
		}
		$_SESSION['plus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
	}elseif($rand >= 31 && $rand <= 44){
		$rand = mt_rand(1,6);
		if($rand == 1) {
			plusEgg(false,false,false,false,false,543,true);
		}elseif($rand == 2){
			plusEgg(false,false,false,false,false,453,true);
		}elseif($rand == 3){
			plusEgg(false,false,false,false,false,359,true);
		}elseif($rand == 4){
			plusEgg(false,false,false,false,false,123,true);
		}elseif($rand == 5){
			plusEgg(false,false,false,false,false,548,true);
		}else{
			plusEgg(false,false,false,false,false,559,true);
		}
		$_SESSION['plus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
	}elseif($rand >= 91 && $rand <= 110){
		$rand = mt_rand(1,12);
		if($rand == 1) {
			itemAdd(1013,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1013.png" class="item"> TM 13 - Ледяной луч (1 шт.)';
		}elseif($rand == 2){
			itemAdd(1024,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1024.png" class="item"> TM 24 - Молния (1 шт.)';
		}elseif($rand == 3){
			itemAdd(1035,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1035.png" class="item"> TM 35 - Огнемет (1 шт.)';
		}elseif($rand == 4){
			itemAdd(1030,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1030.png" class="item"> TM 30 - Шар тьмы (1 шт.)';
		}elseif($rand == 5){
			itemAdd(1003,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1003.png" class="item"> TM 03 - Психический шок (1 шт.)';
		}elseif($rand == 6){
			itemAdd(1004,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1004.png" class="item"> TM 04 - Чистый Разум (1 шт.)';
		}elseif($rand == 7){
			itemAdd(1006,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1006.png" class="item"> TM 06 - Отравление (1 шт.)';
		}elseif($rand == 8){
			itemAdd(1008,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1008.png" class="item"> TM 08 - Усиление (1 шт.)';
		}elseif($rand == 9){
			itemAdd(1012,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1012.png" class="item"> TM 12 - Насмешка (1 шт.)';
		}elseif($rand == 10){
			itemAdd(1026,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1026.png" class="item"> TM 26 - Землетрясение (1 шт.)';
		}elseif($rand == 11){
			itemAdd(1042,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1042.png" class="item"> TM 42 - Мужество(1 шт.)';
		}else{
			itemAdd(1051,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/1051.png" class="item"> TM 51 - Стальное крыло (1 шт.)';
		}
	}elseif($rand >= 111 && $rand <= 280){
		$rand = mt_rand(1,18);
		if($rand == 1) {
			itemAdd(179,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/179.png" class="item"> Черный пояс (1 шт.)';
		}elseif($rand == 2){
			itemAdd(180,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/180.png" class="item"> Книга сказок (1 шт.)';
		}elseif($rand == 3){
			itemAdd(181,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/181.png" class="item"> Древесный уголь (1 шт.)';
		}elseif($rand == 4){
			itemAdd(182,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/182.png" class="item"> Драконий коготь (1 шт.)';
		}elseif($rand == 5){
			itemAdd(183,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/183.png" class="item"> Твердый камень (1 шт.)';
		}elseif($rand == 6){
			itemAdd(184,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/184.png" class="item"> Магнит (1 шт.)';
		}elseif($rand == 7){
			itemAdd(185,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/185.png" class="item"> Чудесное семя (1 шт.)';
		}elseif($rand == 8){
			itemAdd(186,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/186.png" class="item"> Сухой лед (1 шт.)';
		}elseif($rand == 9){
			itemAdd(187,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/187.png" class="item"> Ядовитый шип (1 шт.)';
		}elseif($rand == 10){
			itemAdd(188,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/188.png" class="item"> Острый клюв (1 шт.)';
		}elseif($rand == 11){
			itemAdd(189,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/189.png" class="item"> Водный амулет (1 шт.)';
		}elseif($rand == 12){
			itemAdd(190,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/190.png" class="item"> Шелковый шарф (1 шт.)';
		}elseif($rand == 13){
			itemAdd(191,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/191.png" class="item"> Серебряный порошок (1 шт.)';
		}elseif($rand == 14){
			itemAdd(192,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/192.png" class="item"> Мелкий песок (1 шт.)';
		}elseif($rand == 15){
			itemAdd(193,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/193.png" class="item"> Обрывок заклинаний (1 шт.)';
		}elseif($rand == 16){
			itemAdd(194,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/194.png" class="item"> Гнутая ложка (1 шт.)';
		}elseif($rand == 17){
			itemAdd(195,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/195.png" class="item"> Темные очки (1 шт.)';
		}else{
			itemAdd(69,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/69.png" class="item"> Часть брони (1 шт.)';
		}
	}elseif($rand >= 281 && $rand <= 305){
		$rand = mt_rand(1,8);
		if($rand == 1) {
			itemAdd(21,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/21.png" class="item"> Рассветный камень (1 шт.)';
		}elseif($rand == 2){
			itemAdd(19,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/19.png" class="item"> Сумрачный камень (1 шт.)';
		}elseif($rand == 3){
			itemAdd(36,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/36.png" class="item"> Сияющий камень (1 шт.)';
		}elseif($rand == 4){
			itemAdd(53,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/53.png" class="item"> Электрайзер (1 шт.)';
		}elseif($rand == 5){
			itemAdd(96,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/96.png" class="item"> Овальный камень (1 шт.)';
		}elseif($rand == 6){
			itemAdd(51,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/51.png" class="item"> Магмарайзер (1 шт.)';
		}elseif($rand == 7){
			itemAdd(275,3);
			$_SESSION['plus'] = '<img src="/img/world/items/little/275.png" class="item"> Инкубатор (3 шт.)';
		//}elseif($rand == 8){
			//itemAdd(95,2);
			//$_SESSION['plus'] = '<img src="/img/world/items/little/95.png" class="item"> Набор классификаций (2 шт.)';
		}else{
			itemAdd(52,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/52.png" class="item"> Протектор (1 шт.)';
		}
	}elseif($rand >= 306 && $rand <= 360){
		$rand = mt_rand(1,4);
		if($rand == 1) {
			itemAdd(65,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/65.png" class="item"> Острый коготь (1 шт.)';
		}elseif($rand == 2){
			itemAdd(66,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/66.png" class="item"> Острый клык (1 шт.)';
		}elseif($rand == 3){
			itemAdd(74,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/74.png" class="item"> Усовершенствованный диск (1 шт.)';
		}else{
			itemAdd(23,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/23.png" class="item"> Перламутровая чешуя (1 шт.)';
		}
	}elseif($rand >= 386 && $rand <= 445){
		$rand = mt_rand(1,4);
		if($rand == 1) {
			itemAdd(22,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/22.png" class="item"> Порванная ткань (1 шт.)';
		}elseif($rand == 2){
			itemAdd(70,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/70.png" class="item"> Сухие духи (1 шт.)';
		}elseif($rand == 3){
			itemAdd(71,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/71.png" class="item"> Сладкая пироженка (1 шт.)';
		}else{
			itemAdd(73,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/73.png" class="item"> Потертый диск (1 шт.)';
		}
	}elseif($rand >= 451 && $rand <= 600){
		$rand = mt_rand(1,6);
		if($rand == 1) {
			itemAdd(37,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/37.png" class="item"> Банка цинка (10 шт.)';
		}elseif($rand == 2){
			itemAdd(38,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/38.png" class="item"> Банка кальция (10 шт.)';
		}elseif($rand == 3){
			itemAdd(39,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/39.png" class="item"> Банка железа (10 шт.)';
		}elseif($rand == 4){
			itemAdd(40,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/40.png" class="item"> Банка йода (10 шт.)';
		}elseif($rand == 5){
			itemAdd(41,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/41.png" class="item"> Банка углеводов (10 шт.)';
		}else{
			itemAdd(42,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/42.png" class="item"> Банка протеина (10 шт.)';
		}
	}elseif($rand >= 601 && $rand <= 700){
		$rand = mt_rand(1,6);
		if($rand == 1) {
			itemAdd(104,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/104.png" class="item"> Лупа (1 шт.)';
		}elseif($rand == 2){
			itemAdd(105,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/105.png" class="item"> Линзы (1 шт.)';
		}elseif($rand == 3){
			itemAdd(103,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/103.png" class="item"> Блестки (1 шт.)';
		}elseif($rand == 4){
			itemAdd(106,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/106.png" class="item"> Объедки (1 шт.)';
		}elseif($rand == 5){
			itemAdd(109,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/109.png" class="item"> Генобол (10 шт.)';
		}else{
			itemAdd(5,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/5.png" class="item"> Мастербол (10 шт.)';
		}
	}elseif($rand >= 701 && $rand <= 800){
		$rand = mt_rand(1,3);
		if($rand == 1) {
			itemAdd(149,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/149.png" class="item"> Любовное ожерелье (10 шт.)';
		}elseif($rand == 2){
			itemAdd(162,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/162.png" class="item"> Набор красок (1 шт.)';
		}else{
			itemAdd(33,10);
			$_SESSION['plus'] = '<img src="/img/world/items/little/33.png" class="item"> Леденец в форме Иви (10 шт.)';
		}
	}elseif($rand >= 801 && $rand <= 802){
		$rand = mt_rand(1,1);
		if($rand == 1) {
			/*$_SESSION['plus'] = '<img src="/img/world/items/little/150.png" class="item"> Яйцо (1 шт.)';
			plusEgg(false,false,false,false,false,150,true);
		}elseif($rand == 2){
			$_SESSION['plus'] = '<img src="/img/world/items/little/491.png" class="item"> Яйцо (1 шт.)';
			plusEgg(false,false,false,false,false,491,true);
		}else{*/
			itemAdd(10002,1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/10002.png" class="item"> Скоба (1 шт.)';
		}
	}else{
		$rand = mt_rand(100000,500000);
		itemAdd(1,$rand);
		$_SESSION['plus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета ('.$rand.' шт.)';
	}
	$_SESSION['error'] = 0;
	$_SESSION['text'] = 'Вы открыли сундук!';
	minus_item($itemID,1);
}
function hell_okras($pokID){
	$pokemon = Work::$sql->query('SELECT
									`type`
								FROM `user_pokemons`
								WHERE
									`id` = '.$pokID.'
								AND
									`user_id` = '.$_SESSION['id'].'
								AND
									`active` = 1')->fetch_assoc();
	if($pokemon['type']){
		if($pokemon['type'] != 'shadow'){
			if(rand(1,100) > 95){
				Work::$sql->query('UPDATE `user_pokemons`
									SET
										`type` = "shadow"
									WHERE
										`id` = '.$pokID);
				$_SESSION['error'] = 0;
				$_SESSION['text'] = 'Конфета покрасила вашего покемона в shadow!';
			}else{
				$_SESSION['error'] = 0;
				$_SESSION['text'] = 'Ничего не произошло... Покемон просто скушал конфетку.';
			}
		minus_item(325,1);
		}else{
			$_SESSION['error'] = 1;
			$_SESSION['text'] = 'Ваш покемон уже '.$pokemon['type'].'!';
		}
	}else{
		$_SESSION['error'] = 1;
		$_SESSION['text'] = 'Ошибка выбора покемона!';
	}
}
function setShinePok($pokID, $itemID){
	$pokemon = Work::$sql->query('SELECT
									`type`
								FROM `user_pokemons`
								WHERE
									`id` = '.$pokID.'
								AND
									`user_id` = '.$_SESSION['id'].'
								AND
									`active` = 1')->fetch_assoc();
	if($pokemon['type']){
		if($pokemon['type'] == 'normal'){
			if(rand(1,100) > 75){
				Work::$sql->query('UPDATE `user_pokemons`
									SET
										`type` = "shine"
									WHERE
										`id` = '.$pokID);
				$_SESSION['error'] = 0;
				$_SESSION['text'] = 'Краски использованы, и покемон изменил свой окрас на shine!';
			}else{
				$_SESSION['error'] = 0;
				$_SESSION['text'] = 'Краски использованы, но Вы так измазюкали ими покемона, что пришлось его потом долго отмывать. В shine он так и не покрасился...';
			}
		minus_item($itemID,1);
		}else{
			$_SESSION['error'] = 1;
			$_SESSION['text'] = 'Ваш покемон уже '.$pokemon['type'].'!';
		}
	}else{
		$_SESSION['error'] = 1;
		$_SESSION['text'] = 'Ошибка выбора покемона!';
	}
}
function genUP($pokID,$itemID){
	$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
	if($pokemon['modification']){
		if($pokemon['sparka'] == 1){
			$mod = json_decode($pokemon['modification']);
			if($mod->genUp == 0){
				$gen = explode(',',$pokemon['gen']);
				if(rand(1,100) > 90){
					$randGen = rand(1,5);
					if($randGen == 1) {
						$t = 'Атаки';
					}elseif($randGen == 2) {
						$t = 'Защиты';
					}elseif($randGen == 3) {
						$t = 'Скорости';
					}elseif($randGen == 4) {
						$t = 'Спец. Атаки';
					}elseif($randGen == 5) {
						$t = 'Спец. Защиты';
					}
					$gen[$randGen] += 5;
				}else{
					$gen[0] += 5;
					$t = 'Здоровья';
				}
				$mod->genUp = 1;
				$modUpd = json_encode($mod);
				$genUpd = implode(',',$gen);
				Work::$sql->query("UPDATE `user_pokemons` SET `gen` = '".$genUpd."',`modification` = '".$modUpd."',`sparka` = 1 WHERE `id` = '".$pokID."'");
				minus_item($itemID,1);
				$_SESSION['error'] = 0;
				$_SESSION['text'] = 'Ген '.$t.' повышен на 5 пунктов данному покемону.';
			}else{
				$_SESSION['error'] = 1;
				$_SESSION['text'] = 'Вы уже поднимали гены данному покемону!';
			}
		}else{
			$_SESSION['error'] = 1;
			$_SESSION['text'] = 'Покемон должен быть спаренным!';
		}
	}else{
		$_SESSION['error'] = 1;
		$_SESSION['text'] = 'Ошибка выбора покемона!';
	}
	return $_SESSION['text'];
}
function setCharacter($pokID,$itemID){
	$pokemon = Work::$sql->query("SELECT `modification`,`character` FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
	if($pokemon['modification']){
		$mod = json_decode($pokemon['modification']);
		if($mod->charEdit == 0){
			if(rand(1,100) > 89){
				$character = rand(1,25);
			}else{
				$character = 13;
			}
			$mod->charEdit = 1;
			$modUpd = json_encode($mod);
			Work::$sql->query("UPDATE `user_pokemons` SET `character` = '".$character."',`modification` = '".$modUpd."' WHERE `id` = '".$pokID."'");
			minus_item($itemID,1);
			$_SESSION['error'] = 0;
			$_SESSION['text'] = 'Покемон изменил свой характер на '.haracter_pokes($character);
		}else{
			$_SESSION['error'] = 1;
			$_SESSION['text'] = 'Вы уже меняли характер данному покемону!';
		}
	}else{
		$_SESSION['error'] = 1;
		$_SESSION['text'] = 'Ошибка выбора покемона!';
	}
}
function zel_apr($pokID){
	if(item_isset(279,1)) {
		$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
		if(isset($pokemon)) {
			$ev = explode(',',$pokemon['evcounts']);
			$evAll = $ev[0] + $ev[1] + $ev[2] + $ev[3] + $ev[4] + $ev[5];
			$evAll = $evAll + $pokemon['ev'];
			Work::$sql->query("UPDATE `user_pokemons` SET `ev` = '".$evAll."', `evcounts` = '0,0,0,0,0,0' WHERE `id` = '".$pokemon['id']."'");
			minus_item(279,1);
			$_SESSION['error'] = 0;
			$_SESSION['text'] = 'Очки EV сброшены.';
		}
	}
}
function recipe($id){
	$recipe = Work::$sql->query("SELECT * FROM `craft_recipe_user` WHERE `user` = '".$_SESSION['id']."' AND `recipe` = ".$id)->fetch_assoc();
	if($recipe){
		$_SESSION['error'] = 1;
		$_SESSION['text'] = 'Вы уже изучили это';
	}else{
		switch($id){
			case 130:
				$_SESSION['error'] = 0;
				$_SESSION['text'] = 'Теперь вы умеете изготавливать Веревку.';
				Work::$sql->query("INSERT INTO `craft_recipe_user` (`user`,`recipe`) VALUES ('".$_SESSION['id']."',130) ");
				minus_item(130,1);
			break;
			case 141:
				$_SESSION['error'] = 0;
				$_SESSION['text'] = 'Теперь вы умеете готовить Вкусные леденцы.';
				Work::$sql->query("INSERT INTO `craft_recipe_user` (`user`,`recipe`) VALUES ('".$_SESSION['id']."',141) ");
				minus_item(141,1);
			break;
			case 144:
				$_SESSION['error'] = 0;
				$_SESSION['text'] = 'Теперь вы умеете изготавливать Априкорновый аппарат.';
				Work::$sql->query("INSERT INTO `craft_recipe_user` (`user`,`recipe`) VALUES ('".$_SESSION['id']."',144) ");
				minus_item(144,1);
			break;
			default:
				$_SESSION['error'] = 1;
				$_SESSION['text'] = 'Ошибка!';
			break;
		}
	}
}
function Cloth($id){
	$user = Work::$sql->query("SELECT `sex` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
	switch($id){
		case 110:
			if($user['sex'] == 'm'){
				update_cloth('slot4',1);
				$_SESSION['text'] = 'Вы одели одежду.';
			}else{
				$_SESSION['text'] = 'Это мужская одежда.';
			}
		break;
		default:
			$_SESSION['text'] = 'Ошибка!';
		break;
	}
	return $_SESSION['text'];
}
function NGBox($id, $count = 1){



    if(isset($_SESSION['text'])){
        if(!is_array($_SESSION['text'])){
            $_SESSION['text'] = [];
        }
    }else{
        $_SESSION['text'] = [];
    }

    if(random_int(1, 100) == random_int(1, 100)){

        if(random_int(1, 100) == random_int(1, 100)){

            Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Набор классификаций (100 шт.) | ".$chance."</b>',3) ");
            $_SESSION['text'][] = 'Получено: Набор классификаций (100 шт.)';
            itemAdd(95,100);

        }else{

            if(random_int(1, 100) <= 80){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Набор классификаций (30 шт.) | ".$chance."</b>',3) ");
                $_SESSION['text'][] = 'Получено: Набор классификаций (30 шт.)';
                itemAdd(95,30);
            }else{
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Амулет прозрения (1 шт.) | ".$chance."</b>',3) ");
                $_SESSION['text'][] = 'Получено: Амулет прозрения (1 шт.)';
                itemAdd(10002,1);
            }

        }

    }else{

        $rand3 = random_int(1, 3);

        if(random_int(0, 100) <= 50){

            if($rand3 == 1){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Яйцо #667 Литлео | ".$chance."</b>',3) ");
                plusEgg(false,false,false,true,false,667);
                $_SESSION['text'][] = 'Получено: Яйцо #667 Литлео';
            }elseif($rand3 == 2){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Яйцо #410 Шелдон | ".$chance."</b>',3) ");
                plusEgg(false,false,false,true,false,410);
                $_SESSION['text'][] = 'Получено: Яйцо #410 Шелдон';
            }else{
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Яйцо #333 Сваблу | ".$chance."</b>',3) ");
                plusEgg(false,false,false,true,false,333);
                $_SESSION['text'][] = 'Получено: Яйцо #333 Сваблу';
            }

        }else{

            if($rand3 == 1){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Аметистовый сундук (1 шт.) | ".$chance."</b>',3) ");
                $_SESSION['text'][] = 'Получено: Аметистовый сундук (1 шт.)';
                itemAdd(119,1);
            }elseif($rand3 == 2){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Сапфировый сундук (1 шт.) | ".$chance."</b>',3) ");
                $_SESSION['text'][] = 'Получено: Сапфировый сундук (1 шт.)';
                itemAdd(117,1);
            }else{
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Рубиновый сундук (1 шт.) | ".$chance."</b>',3) ");
                $_SESSION['text'][] = 'Получено: Рубиновый сундук (1 шт.)';
                itemAdd(118,1);
            }

        }

    }
	/*$count = ($count <= 0 ? 1 : $count);
    $chance = ($count > 0 ? ' Попытка: ['.$count.']' : '');

    if($id == 152){
        $count = (($count > 250 ? 250 : $count) * 2);
    }else{
        $count = ($count > 300 ? 300 : $count);
    }

	if(isset($_SESSION['text'])){
	    if(!is_array($_SESSION['text'])){
            $_SESSION['text'] = [];
        }
    }else{
        $_SESSION['text'] = [];
    }

    //[NUM, COUNT, 'Покебол (1 шт.)', 'Получено: Покебол (1 шт.)']
    $items_prize = [

        [1, 200,        'Монета (200 шт.)'],
        [1, 300,        'Монета (300 шт.)'],
        [1, 400,        'Монета (400 шт.)'],
        [1, 500,        'Монета (500 шт.)'],
        [1, 600,        'Монета (600 шт.)'],
        [1, 700,        'Монета (700 шт.)'],
        [1, 800,        'Монета (800 шт.)'],
        [1, 900,        'Монета (900 шт.)'],
        [1, 3500,       'Монета (3.500 шт.)', 2],

        [3, 1,          'Покебол (1 шт.)'],
        [3, 2,          'Покебол (2 шт.)'],
        [3, 3,          'Покебол (3 шт.)'],
        [3, 4,          'Покебол (4 шт.)'],
        [3, 5,          'Покебол (5 шт.)', 2],

        [4, 1,          'Гритбол (1 шт.)'],
        [4, 2,          'Гритбол (2 шт.)'],

        [5, 1,          'Мастербол (1 шт.)', 2],

        [6, 1,          'Ультрабол (1 шт.)'],
        [6, 2,          'Ультрабол (2 шт.)', 2],

        [17, 1,         'Леденец (Мадкипа) (1 шт.)'],
        [17, 2,         'Леденец (Мадкипа) (2 шт.)'],

        [32, 1,         'Леденец (Пичу) (1 шт.)', 2],

        [37, 1,         'Банка цинка (1 шт.)', 2],
        [38, 1,         'Банка кальция (1 шт.)', 2],
        [39, 1,         'Банка железа (1 шт.)', 2],
        [40, 1,         'Банка йода (1 шт.)', 2],
        [41, 1,         'Банка углеводов (1 шт.)', 2],
        [42, 1,         'Банка протеина (1 шт.)', 2],

        [109, 1,        'Генобол (1 шт.)', 2],

        [150, 1,        'Ком снега (1 шт.)'],
        [150, 2,        'Ком снега (2 шт.)'],

        [151, 1,        'Большой ком снега (1 шт.)'],
        [151, 2,        'Большой ком снега (2 шт.)'],


    ];

    $rand = intval(random_int($count, 1000));

    if($rand === intval(random_int($count, 80000))){

        if(random_int(1, 1000) == random_int(1, 1000)){

            if(random_int(1, 80) == random_int(1, 80)){

                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Набор классификаций (100 шт.) | ".$chance."</b>',3) ");
                $_SESSION['text'][] = 'Получено: Набор классификаций (100 шт.)';
                itemAdd(95,100);

            }else{

                if(random_int(1, 100) <= 80){
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Набор классификаций (30 шт.) | ".$chance."</b>',3) ");
                    $_SESSION['text'][] = 'Получено: Набор классификаций (30 шт.)';
                    itemAdd(95,30);
                }else{
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Амулет прозрения (1 шт.) | ".$chance."</b>',3) ");
                    $_SESSION['text'][] = 'Получено: Амулет прозрения (1 шт.)';
                    itemAdd(10002,1);
                }

            }


        }else{

            $rand3 = random_int(1, 4);

            if(random_int(0, 500) <= 30){

                if($rand3 == 1){
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Яйцо #667 Литлео | ".$chance."</b>',3) ");
                    plusEgg(false,false,false,true,false,667);
                    $_SESSION['text'][] = 'Получено: Яйцо #667 Литлео';
                }elseif($rand3 == 2){
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Яйцо #410 Шелдон | ".$chance."</b>',3) ");
                    plusEgg(false,false,false,true,false,410);
                    $_SESSION['text'][] = 'Получено: Яйцо #410 Шелдон';
                }else{
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Яйцо #333 Сваблу | ".$chance."</b>',3) ");
                    plusEgg(false,false,false,true,false,333);
                    $_SESSION['text'][] = 'Получено: Яйцо #333 Сваблу';
                }

            }else{

                if($rand3 == 1){
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Аметистовый сундук (1 шт.) | ".$chance."</b>',3) ");
                    $_SESSION['text'][] = 'Получено: Аметистовый сундук (1 шт.)';
                    itemAdd(119,1);
                }elseif($rand3 == 2){
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Сапфировый сундук (1 шт.) | ".$chance."</b>',3) ");
                    $_SESSION['text'][] = 'Получено: Сапфировый сундук (1 шт.)';
                    itemAdd(117,1);
                }elseif($rand3 == 3){
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Рубиновый сундук (1 шт.) | ".$chance."</b>',3) ");
                    $_SESSION['text'][] = 'Получено: Рубиновый сундук (1 шт.)';
                    itemAdd(118,1);
                }else{
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Рюкзак «Энтей» (1 шт.) | ".$chance."</b>',3) ");
                    $_SESSION['text'][] = 'Получено: Рюкзак «Энтей» (1 шт.)';
                    itemAdd(90,1);
                }

            }

        }

    }else{

        if(random_int(1, 2000) == random_int(1, 8000)){

            $rand2 = random_int(1, 6);

            if($rand2 == 1){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Генобол (1 шт.) | ".$chance."</b>',2) ");
                $_SESSION['text'][] = 'Получено: Генобол (1 шт.)';
                itemAdd(109,1);
            }elseif($rand2 == 2){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Набор классификаций (1 шт.) | ".$chance."</b>',2) ");
                $_SESSION['text'][] = 'Получено: Набор классификаций (1 шт.)';
                itemAdd(95,1);
            }elseif($rand2 == 3){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Амурит (1 шт.) | ".$chance."</b>',2) ");
                $_SESSION['text'][] = 'Получено: Амурит (1 шт.)';
                itemAdd(149,1);
            }elseif($rand2 == 4){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Загадочный ключ (1 шт.) | ".$chance."</b>',2) ");
                $_SESSION['text'][] = 'Получено: Загадочный ключ (1 шт.)';
                itemAdd(18,1);
            }elseif($rand2 == 5){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Генобол (3 шт.) | ".$chance."</b>',2) ");
                $_SESSION['text'][] = 'Получено: Генобол (3 шт.)';
                itemAdd(109,3);
            }else{
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','<b>Леденец в форме Иви (1 шт.) | ".$chance."</b>',2) ");
                $_SESSION['text'][] = 'Получено: Леденец в форме Иви (1 шт.)';
                itemAdd(33,1);
            }

        }else{

            $rand1 = random_int(1,5);

            if(random_int(1, 5000) < 3){

                $rand = sizeof($items_prize) - 1;
                $rand = random_int(0, ($rand-1));
                if(
                    isset($items_prize[$rand], $items_prize[$rand][0], $items_prize[$rand][1], $items_prize[$rand][2])
                    &&  $items_prize[$rand][0] > 0 && $items_prize[$rand][1] > 0
                ){

                    if(isset($items_prize[$rand][3]) && is_numeric($items_prize[$rand][3]) && $items_prize[$rand][3] > 0){
                        $typeRare = intval($items_prize[$rand][3]);
                        unset($items_prize[$rand][3]);
                    }else{
                        $typeRare = 1;
                    }

                    $titleBase = '<b>'.$items_prize[$rand][2].' | '.$chance.'</b>';
                    Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."','".$titleBase."',".$typeRare.") ");

                    if(isset($items_prize[$rand][3])){
                        $_SESSION['text'][] = 'Получено: '.$items_prize[$rand][3];
                    }else{
                        $_SESSION['text'][] = 'Получено: '.$items_prize[$rand][2];
                    }

                    itemAdd($items_prize[$rand][0], $items_prize[$rand][1]);
                }

            }elseif(random_int(1, 1000) < 10){
                $count = random_int(1, 10);
                $typeRare = 1;
                if(mt_rand(1, 50) == mt_rand(1, 50)){
                    $typeRare = 2;
                    $count = random_int(100, 500);
                }
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`,`type`) VALUES ('".$_SESSION['id']."', '<b>Ком снега (".$count." шт.) | ".$chance."</b>', ".$typeRare.") ");
                $_SESSION['text'][] = 'Получено: Ком снега ('.$count.' шт.)';
                itemAdd(150, $count);
            }elseif($rand1 == 1 || $rand1 == 2){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`) VALUES ('".$_SESSION['id']."','пустую коробку, видимо кто-то уже насладился сюрпризом...') ");
                $_SESSION['text'][] = 'Коробка оказалась пустой, чтож, видимо кто-то уже насладился сюрпризом.';
            }elseif($rand1 == 3){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`) VALUES ('".$_SESSION['id']."','осколки от новогоднего шарика.') ");
                $_SESSION['text'][] = 'В коробке вы обнаружили осколки от новогоднего шарика.';
            }elseif($rand1 == 4){
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`) VALUES ('".$_SESSION['id']."','сломанный покебол.') ");
                $_SESSION['text'][] = 'В коробке вы обнаружили сломанный покебол. Наврядли им можно пользоваться.';
            }else{
                Work::$sql->query("INSERT INTO `ngBox` (`user`,`prize`) VALUES ('".$_SESSION['id']."','горсточку испорченых ягод.') ");
                $_SESSION['text'][] = 'В коробке вы обнаружили горсть испорченных ягод, видимо кто-то решил подшутить.';
            }

        }

    }*/
	return $_SESSION['text'];
}
function easterEgg($id){
	switch($id){
		case 173:
			$rand = rand(1,48);
			if($rand >= 1 && $rand <= 15){
				plusEgg(false,false,false,true,false,511);
				$_SESSION['text'] = 'Вы получили: Яйцо #511 Пансейдж';
			}elseif($rand >= 16 && $rand <= 30){
				plusEgg(false,false,false,true,false,273);
				$_SESSION['text'] = 'Вы получили: Яйцо #273 Сидот';
			}elseif($rand >= 31 && $rand <= 45){
				plusEgg(false,false,false,true,false,585);
				$_SESSION['text'] = 'Вы получили: Яйцо #585 Дирлинг';
			}else{
				plusEgg(false,false,false,true,false,597);
				$_SESSION['text'] = 'Вы получили: Яйцо #597 Ферросид';
			}
			minus_item(173,1);
		break;
		case 174:
			$rand = rand(1,48);
			if($rand >= 1 && $rand <= 15){
				plusEgg(false,false,false,true,false,515);
				$_SESSION['text'] = 'Вы получили: Яйцо #515 Панпур';
			}elseif($rand >= 16 && $rand <= 30){
				plusEgg(false,false,false,true,false,120);
				$_SESSION['text'] = 'Вы получили: Яйцо #120 Старью';
			}elseif($rand >= 31 && $rand <= 45){
				plusEgg(false,false,false,true,false,366);
				$_SESSION['text'] = 'Вы получили: Яйцо #138 Спрутти';
			}else{
				plusEgg(false,false,false,true,false,79);
				$_SESSION['text'] = 'Вы получили: Яйцо #079 Слоупок';
			}
			minus_item(174,1);
		break;
		case 175:
			$rand = rand(1,48);
			if($rand >= 1 && $rand <= 15){
				plusEgg(false,false,false,true,false,179);
				$_SESSION['text'] = 'Вы получили: Яйцо #179 Марип';
			}elseif($rand >= 16 && $rand <= 30){
				plusEgg(false,false,false,true,false,602);
				$_SESSION['text'] = 'Вы получили: Яйцо #602 Тинамо';
			}elseif($rand >= 31 && $rand <= 45){
				plusEgg(false,false,false,true,false,694);
				$_SESSION['text'] = 'Вы получили: Яйцо #694 Гелиоптайл';
			}else{
				plusEgg(false,false,false,true,false,239);
				$_SESSION['text'] = 'Вы получили: Яйцо #239 Эликед';
			}
			minus_item(175,1);
		break;
		case 176:
			$rand = rand(1,48);
			if($rand >= 1 && $rand <= 15){
				plusEgg(false,false,false,true,false,513);
				$_SESSION['text'] = 'Вы получили: Яйцо #513 Пансир';
			}elseif($rand >= 16 && $rand <= 30){
				plusEgg(false,false,false,true,false,667);
				$_SESSION['text'] = 'Вы получили: Яйцо #667 Литлео';
			}elseif($rand >= 31 && $rand <= 45){
				plusEgg(false,false,false,true,false,322);
				$_SESSION['text'] = 'Вы получили: Яйцо #322 Нумел';
			}else{
				plusEgg(false,false,false,true,false,228);
				$_SESSION['text'] = 'Вы получили: Яйцо #228 Дэрдог';
			}
			minus_item(176,1);
		break;
	}
	return $_SESSION['text'];
}
function Box($id){
	if(item_isset(18,1)){
		switch($id){
			case 116:
				$rand = rand(1,100);
				if($rand >= 1 && $rand <= 5){
					$rand1 = rand(1,3);
					if($rand1 == 1){
						plusEgg(false,false,false,true,false,519);
						$_SESSION['text'] = 'Вы получили: Яйцо #519 Пидов';
					}elseif($rand1 == 2){
						plusEgg(false,false,false,true,false,686);
						$_SESSION['text'] = 'Вы получили: Яйцо #686 Инкей';
					}else{
						plusEgg(false,false,false,true,false,570);
						$_SESSION['text'] = 'Вы получили: Яйцо #570 Зоруа';
					}
				}elseif($rand >= 6 && $rand <= 21){
					$rand2 = rand(1,3);
					if($rand2 == 1){
						itemAdd(7,10);
						$_SESSION['text'] = 'Вы получили: Ягода Леппа (10 шт.)';
					}elseif($rand2 == 2){
						itemAdd(8,10);
						$_SESSION['text'] = 'Вы получили: Ягода Оран (10 шт.)';
					}else{
						itemAdd(9,10);
						$_SESSION['text'] = 'Вы получили: Ягода Печа (10 шт.)';
					}
				}elseif($rand >= 22 && $rand <= 36){
					$rand3 = rand(1,2);
					if($rand3 == 1){
						itemAdd(45,10);
						$_SESSION['text'] = 'Вы получили: Фрукт Петунис (10 шт.)';
					}else{
						itemAdd(46,10);
						$_SESSION['text'] = 'Вы получили: Фрукт Паяго (10 шт.)';
					}
				}elseif($rand >= 37 && $rand <= 52){
					$rand4 = rand(1,2);
					if($rand4 == 1){
						itemAdd(40,10);
						$_SESSION['text'] = 'Вы получили: Банка йода (10 шт.)';
					}else{
						itemAdd(42,10);
						$_SESSION['text'] = 'Вы получили: Банка протеина (10 шт.)';
					}
				}elseif($rand >= 53 && $rand <= 68){
					$rand5 = rand(1,2);
					if($rand5 == 1){
						itemAdd(5,5);
						$_SESSION['text'] = 'Вы получили: Мастербол (5 шт.)';
					}else{
						itemAdd(17,10);
						$_SESSION['text'] = 'Вы получили: Леденец в форме Мадкипа (10 шт.)';
					}
				}elseif($rand >= 69 && $rand <= 79){
					$rand6 = rand(1,3);
					if($rand6 == 1){
						itemAdd(52,1);
						$_SESSION['text'] = 'Вы получили: Протектор (1 шт.)';
					}elseif($rand6 == 2){
						//itemAdd(95,3);
						//$_SESSION['text'] = 'Вы получили: Набор классификаций (3 шт.)';
					}else{
						itemAdd(36,1);
						$_SESSION['text'] = 'Вы получили: Сияющий камень (1 шт.)';
					}
				}elseif($rand >= 80 && $rand <= 81){
					$rand7 = rand(3,4);
					if($rand7 == 1){
						plusEgg(false,false,false,true,false,380);
						update_ach(18,1);
						$_SESSION['text'] = 'Вы получили: Яйцо #380 Латиас';
					}elseif($rand7 == 2){
						plusEgg(false,false,false,true,false,381);
						update_ach(18,1);
						$_SESSION['text'] = 'Вы получили: Яйцо #381 Латиос';
					}elseif($rand7 == 3){
						itemAdd(10002,1);
						$_SESSION['text'] = 'Вы получили: Скоба (1 шт.)';
					}else{
						itemAdd(66,1);
						$_SESSION['text'] = 'Вы получили: Острый клык (1 шт.)';
					}
				}elseif($rand >= 82 && $rand <= 85){
					$rand8 = rand(1,2);
					if($rand8 == 1){
						itemAdd(23,1);
						$_SESSION['text'] = 'Вы получили: Перламутровая чешуя (1 шт.)';
					}else{
						itemAdd(65,1);
						$_SESSION['text'] = 'Вы получили: Острый коготь (1 шт.)';
					}
				}else{
					$rand9 = rand(100000,1000000);
					itemAdd(1,$rand9);
					$_SESSION['text'] = 'Вы получили: Монета ('.$rand9.' шт.)';
				}
				minus_item(116,1);
				minus_item(18,1);
				update_ach(10,1);
			break;
			case 117:
				$rand = rand(1,100);
				if($rand >= 1 && $rand <= 5){
					$rand1 = rand(1,3);
					if($rand1 == 1){
						plusEgg(false,false,false,true,false,418);
						$_SESSION['text'] = 'Вы получили: Яйцо #418 Буизель';
					}elseif($rand1 == 2){
						plusEgg(false,false,false,true,false,425);
						$_SESSION['text'] = 'Вы получили: Яйцо #425 Дрифлун';
					}else{
						plusEgg(false,false,false,true,false,228);
						$_SESSION['text'] = 'Вы получили: Яйцо #228 Хондор';
					}
				}elseif($rand >= 6 && $rand <= 21){
					$rand2 = rand(1,3);
					if($rand2 == 1){
						itemAdd(7,10);
						$_SESSION['text'] = 'Вы получили: Ягода Леппа (10 шт.)';
					}elseif($rand2 == 2){
						itemAdd(8,10);
						$_SESSION['text'] = 'Вы получили: Ягода Оран (10 шт.)';
					}else{
						itemAdd(9,10);
						$_SESSION['text'] = 'Вы получили: Ягода Печа (10 шт.)';
					}
				}elseif($rand >= 22 && $rand <= 36){
					$rand3 = rand(1,2);
					if($rand3 == 1){
						itemAdd(47,10);
						$_SESSION['text'] = 'Вы получили: Фрукт Гриня (10 шт.)';
					}else{
						itemAdd(48,10);
						$_SESSION['text'] = 'Вы получили: Фрукт Глусмус (10 шт.)';
					}
				}elseif($rand >= 37 && $rand <= 52){
					$rand4 = rand(1,2);
					if($rand4 == 1){
						itemAdd(37,10);
						$_SESSION['text'] = 'Вы получили: Банка цинка (10 шт.)';
					}else{
						itemAdd(39,10);
						$_SESSION['text'] = 'Вы получили: Банка железа (10 шт.)';
					}
				}elseif($rand >= 53 && $rand <= 68){
					$rand5 = rand(1,2);
					if($rand5 == 1){
						itemAdd(5,5);
						$_SESSION['text'] = 'Вы получили: Мастербол (5 шт.)';
					}else{
						itemAdd(17,10);
						$_SESSION['text'] = 'Вы получили: Леденец в форме Мадкипа (10 шт.)';
					}
				}elseif($rand >= 69 && $rand <= 79){
					$rand6 = rand(1,3);
					if($rand6 == 1){
						itemAdd(51,1);
						$_SESSION['text'] = 'Вы получили: Магмарайзер (1 шт.)';
					}elseif($rand6 == 2){
						itemAdd(95,3);
						$_SESSION['text'] = 'Вы получили: Набор классификаций (3 шт.)';
					}else{
						itemAdd(19,1);
						$_SESSION['text'] = 'Вы получили: Сумрачный камень (1 шт.)';
					}
				}elseif($rand >= 80 && $rand <= 81){
					$rand7 = rand(1,4);
					if($rand7 == 1){
						plusEgg(false,false,false,true,false,380);
						$_SESSION['text'] = 'Вы получили: Яйцо #380 Латиас';
						update_ach(18,1);
					}elseif($rand7 == 2){
						plusEgg(false,false,false,true,false,381);
						$_SESSION['text'] = 'Вы получили: Яйцо #381 Латиос';
						update_ach(18,1);
					}elseif($rand7 == 3){
						itemAdd(10002,1);
						$_SESSION['text'] = 'Вы получили: Амулет прозрения (1 шт.)';
					}else{
						itemAdd(66,1);
						$_SESSION['text'] = 'Вы получили: Острый клык (1 шт.)';
					}
				}elseif($rand >= 82 && $rand <= 85){
					$rand8 = rand(1,2);
					if($rand8 == 1){
						itemAdd(23,1);
						$_SESSION['text'] = 'Вы получили: Перламутровая чешуя (1 шт.)';
					}else{
						itemAdd(65,1);
						$_SESSION['text'] = 'Вы получили: Острый коготь (1 шт.)';
					}
				}else{
					$rand9 = rand(100000,1000000);
					itemAdd(1,$rand9);
					$_SESSION['text'] = 'Вы получили: Монета ('.$rand9.' шт.)';
				}
				minus_item(117,1);
				minus_item(18,1);
				update_ach(10,1);
			break;
			case 118:
				$rand = rand(1,100);
				if($rand >= 1 && $rand <= 5){
					$rand1 = rand(1,3);
					if($rand1 == 1){
						plusEgg(false,false,false,true,false,325);
						$_SESSION['text'] = 'Вы получили: Яйцо #325 Споинк';
					}elseif($rand1 == 2){
						plusEgg(false,false,false,true,false,599);
						$_SESSION['text'] = 'Вы получили: Яйцо #599 Клинк';
					}else{
						plusEgg(false,false,false,true,false,451);
						$_SESSION['text'] = 'Вы получили: Яйцо #451 Скорупи';
					}
				}elseif($rand >= 6 && $rand <= 21){
					$rand2 = rand(1,3);
					if($rand2 == 1){
						itemAdd(7,10);
						$_SESSION['text'] = 'Вы получили: Ягода Леппа (10 шт.)';
					}elseif($rand2 == 2){
						itemAdd(8,10);
						$_SESSION['text'] = 'Вы получили: Ягода Оран (10 шт.)';
					}else{
						itemAdd(9,10);
						$_SESSION['text'] = 'Вы получили: Ягода Печа (10 шт.)';
					}
				}elseif($rand >= 22 && $rand <= 36){
					$rand3 = rand(1,2);
					if($rand3 == 1){
						itemAdd(49,10);
						$_SESSION['text'] = 'Вы получили: Фрукт Шерк (10 шт.)';
					}else{
						itemAdd(50,10);
						$_SESSION['text'] = 'Вы получили: Фрукт Тертий (10 шт.)';
					}
				}elseif($rand >= 37 && $rand <= 52){
					$rand4 = rand(1,2);
					if($rand4 == 1){
						itemAdd(41,10);
						$_SESSION['text'] = 'Вы получили: Банка углеводов (10 шт.)';
					}else{
						itemAdd(38,10);
						$_SESSION['text'] = 'Вы получили: Банка кальция (10 шт.)';
					}
				}elseif($rand >= 53 && $rand <= 68){
					$rand5 = rand(1,2);
					if($rand5 == 1){
						itemAdd(5,5);
						$_SESSION['text'] = 'Вы получили: Мастербол (5 шт.)';
					}else{
						itemAdd(17,10);
						$_SESSION['text'] = 'Вы получили: Леденец в форме Мадкипа (10 шт.)';
					}
				}elseif($rand >= 69 && $rand <= 79){
					$rand6 = rand(1,3);
					if($rand6 == 1){
						itemAdd(53,1);
						$_SESSION['text'] = 'Вы получили: Электрайзер (1 шт.)';
					}elseif($rand6 == 2){
						itemAdd(95,3);
						$_SESSION['text'] = 'Вы получили: Набор классификаций (3 шт.)';
					}else{
						itemAdd(21,1);
						$_SESSION['text'] = 'Вы получили: Рассветный камень (1 шт.)';
					}
				}elseif($rand >= 80 && $rand <= 81){
					$rand7 = rand(1,4);
					if($rand7 == 1){
						plusEgg(false,false,false,true,false,380);
						$_SESSION['text'] = 'Вы получили: Яйцо #380 Латиас';
						update_ach(18,1);
					}elseif($rand7 == 2){
						plusEgg(false,false,false,true,false,381);
						$_SESSION['text'] = 'Вы получили: Яйцо #381 Латиос';
						update_ach(18,1);
					}elseif($rand7 == 3){
						itemAdd(10002,1);
						$_SESSION['text'] = 'Вы получили: Амулет прозрения (1 шт.)';
					}else{
						itemAdd(66,1);
						$_SESSION['text'] = 'Вы получили: Острый клык (1 шт.)';
					}
				}elseif($rand >= 82 && $rand <= 85){
					$rand8 = rand(1,2);
					if($rand8 == 1){
						itemAdd(23,1);
						$_SESSION['text'] = 'Вы получили: Перламутровая чешуя (1 шт.)';
					}else{
						itemAdd(65,1);
						$_SESSION['text'] = 'Вы получили: Острый коготь (1 шт.)';
					}
				}else{
					$rand9 = rand(100000,1000000);
					itemAdd(1,$rand9);
					$_SESSION['text'] = 'Вы получили: Монета ('.$rand9.' шт.)';
				}
				minus_item(118,1);
				minus_item(18,1);
				update_ach(10,1);
			break;
			case 119:
				$rand = rand(1,100);
				if($rand >= 1 && $rand <= 5){
					$rand1 = rand(1,3);
					if($rand1 == 1){
						plusEgg(false,false,false,true,false,127);
						$_SESSION['text'] = 'Вы получили: Яйцо #127 Пинсир';
					}elseif($rand1 == 2){
						plusEgg(false,false,false,true,false,613);
						$_SESSION['text'] = 'Вы получили: Яйцо #613 Кабчу';
					}else{
						plusEgg(false,false,false,true,false,241);
						$_SESSION['text'] = 'Вы получили: Яйцо #241 Милтанк';
					}
				}elseif($rand >= 6 && $rand <= 21){
					$rand2 = rand(1,3);
					if($rand2 == 1){
						itemAdd(7,10);
						$_SESSION['text'] = 'Вы получили: Ягода Леппа (10 шт.)';
					}elseif($rand2 == 2){
						itemAdd(8,10);
						$_SESSION['text'] = 'Вы получили: Ягода Оран (10 шт.)';
					}else{
						itemAdd(9,10);
						$_SESSION['text'] = 'Вы получили: Ягода Печа (10 шт.)';
					}
				}elseif($rand >= 22 && $rand <= 36){
					$rand3 = rand(1,2);
					if($rand3 == 1){
						itemAdd(46,10);
						$_SESSION['text'] = 'Вы получили: Фрукт Паяго (10 шт.)';
					}else{
						itemAdd(48,10);
						$_SESSION['text'] = 'Вы получили: Фрукт Глусмус (10 шт.)';
					}
				}elseif($rand >= 37 && $rand <= 52){
					$rand4 = rand(1,2);
					if($rand4 == 1){
						itemAdd(39,10);
						$_SESSION['text'] = 'Вы получили: Банка железа (10 шт.)';
					}else{
						itemAdd(42,10);
						$_SESSION['text'] = 'Вы получили: Банка протеина (10 шт.)';
					}
				}elseif($rand >= 53 && $rand <= 68){
					$rand5 = rand(1,2);
					if($rand5 == 1){
						itemAdd(5,5);
						$_SESSION['text'] = 'Вы получили: Мастербол (5 шт.)';
					}else{
						itemAdd(17,10);
						$_SESSION['text'] = 'Вы получили: Леденец в форме Мадкипа (10 шт.)';
					}
				}elseif($rand >= 69 && $rand <= 79){
					$rand6 = rand(1,3);
					if($rand6 == 1){
						itemAdd(73,1);
						$_SESSION['text'] = 'Вы получили: Потертый диск (1 шт.)';
					}elseif($rand6 == 2){
						itemAdd(95,3);
						$_SESSION['text'] = 'Вы получили: Набор классификаций (3 шт.)';
					}else{
						itemAdd(96,1);
						$_SESSION['text'] = 'Вы получили: Овальный камень (1 шт.)';
					}
				}elseif($rand >= 80 && $rand <= 81){
					$rand7 = rand(1,4);
					if($rand7 == 1){
						plusEgg(false,false,false,true,false,380);
						$_SESSION['text'] = 'Вы получили: Яйцо #380 Латиас';
						update_ach(18,1);
					}elseif($rand7 == 2){
						plusEgg(false,false,false,true,false,381);
						$_SESSION['text'] = 'Вы получили: Яйцо #381 Латиос';
						update_ach(18,1);
					}elseif($rand7 == 3){
						itemAdd(10002,1);
						$_SESSION['text'] = 'Вы получили: Амулет прозрения (1 шт.)';
					}else{
						itemAdd(66,1);
						$_SESSION['text'] = 'Вы получили: Острый клык (1 шт.)';
					}
				}elseif($rand >= 82 && $rand <= 85){
					$rand8 = rand(1,2);
					if($rand8 == 1){
						itemAdd(23,1);
						$_SESSION['text'] = 'Вы получили: Перламутровая чешуя (1 шт.)';
					}else{
						itemAdd(65,1);
						$_SESSION['text'] = 'Вы получили: Острый коготь (1 шт.)';
					}
				}else{
					$rand9 = rand(100000,1000000);
					itemAdd(1,$rand9);
					$_SESSION['text'] = 'Вы получили: Монета ('.$rand9.' шт.)';
				}
				minus_item(119,1);
				minus_item(18,1);
				update_ach(10,1);
			break;
			default:
				$_SESSION['text'] = 'Ошибка!';
			break;
		}
	}else{
		$_SESSION['text'] = 'У вас нет загадочного ключа';
	}
}
function lollipop($pokID,$count=1,$itemID){

	$pokemon = Work::$sql->query("SELECT `lvl`,`happy`,`basenum` FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
	$pok_base = Work::$sql->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$pokemon['basenum']."'")->fetch_assoc();
	$lvl = $count * 1;
	if($pokemon['lvl']+$lvl < 101){
		if($itemID == 17){
			$ev = 0;
		}elseif($itemID == 31){
			$ev = 1;
		}elseif($itemID == 32){
			$ev = 2;
		}elseif($itemID == 33){
			$ev = 3;
		}elseif($itemID == 229){
			if($pok_base['type'] == 'grass' || $pok_base['type_two'] == 'grass'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 217){
			if($pok_base['type'] == 'dragon' || $pok_base['type_two'] == 'dragon'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 218){
			if($pok_base['type'] == 'electric' || $pok_base['type_two'] == 'electric'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 219){
			if($pok_base['type'] == 'fairy' || $pok_base['type_two'] == 'fairy'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 220){
			if($pok_base['type'] == 'rock' || $pok_base['type_two'] == 'rock'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 221){
			if($pok_base['type'] == 'ice' || $pok_base['type_two'] == 'ice'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 222){
			if($pok_base['type'] == 'fly' || $pok_base['type_two'] == 'fly'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 223){
			if($pok_base['type'] == 'normal' || $pok_base['type_two'] == 'normal'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 224){
			if($pok_base['type'] == 'fire' || $pok_base['type_two'] == 'fire'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 225){
			if($pok_base['type'] == 'ghost' || $pok_base['type_two'] == 'ghost'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 226){
			if($pok_base['type'] == 'psychic' || $pok_base['type_two'] == 'psychic'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 227){
			if($pok_base['type'] == 'steel' || $pok_base['type_two'] == 'steel'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 228){
			if($pok_base['type'] == 'dark' || $pok_base['type_two'] == 'dark'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 230){
			if($pok_base['type'] == 'water' || $pok_base['type_two'] == 'water'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 231){
			if($pok_base['type'] == 'poison' || $pok_base['type_two'] == 'poison'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 232){
			if($pok_base['type'] == 'ground' || $pok_base['type_two'] == 'ground'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 233){
			if($pok_base['type'] == 'bug' || $pok_base['type_two'] == 'bug'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}elseif($itemID == 234){
			if($pok_base['type'] == 'fighting' || $pok_base['type_two'] == 'fighting'){
				$ev = 3;
			}else{
				$ev = 2;
			}
		}
		$ev = $count * $ev;
		minus_item($itemID,$count);
		if($pokemon['happy'] < 253){
			$happyAll = $pokemon['happy']+2;
		}else{
			$happyAll = 255;
		}
		$expirience = Info::_getExp(($pokemon['lvl']+$lvl), $pok_base['exp_group']);
		$expirienceMax = Info::_getExp(($pokemon['lvl']+$lvl+1), $pok_base['exp_group']);
		Work::$sql->query("UPDATE `user_pokemons` SET `exp` = '".$expirience."', `exp_max`='".$expirienceMax."',`lvl` = `lvl`+ '".$lvl."',`ev` = `ev` + '".$ev."',`happy` = '".$happyAll."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
		$_SESSION['error'] = 0;
		$_SESSION['text'] = 'Ваш покемон успешно повысил уровень и получил '.$ev.' EV';
	}else{
		$_SESSION['text'] = 'Ваш покемон достиг максимального уровня!';
		$_SESSION['error'] = 1;
	}

	return $_SESSION['text'];
}
function banka($pokID,$count,$itemID){

	$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
		if($itemID == 37){#SD
			$stat = 5;
		}elseif($itemID == 38){#SA
			$stat = 4;
		}elseif($itemID == 39){#DEF
			$stat = 2;
		}elseif($itemID == 40){#HP
			$stat = 0;
		}elseif($itemID == 41){#SPD
			$stat = 3;
		}elseif($itemID == 42){#ATK
			$stat = 1;
		}
		$ev = explode(',',$pokemon['evcounts']);


		$i = 1;
		$lol = $ev[$stat] + ($count*2);
		$lol2 = $pokemon['vitamines'] + ($count*2);
		if($ev[$stat] >= 125){
			$_SESSION['text'] = 'Количество EV на данном стате достигло максимума.';
			$_SESSION['error'] = 1;
		}elseif($lol > 126){
			$_SESSION['text'] = 'Невозможно использовать столько за один раз.';
			$_SESSION['error'] = 1;
		}elseif($pokemon['vitamines'] >= 99){
			$_SESSION['text'] = 'На данного покемона больше нельзя использовать витамины.';
			$_SESSION['error'] = 1;
		}elseif($lol2 > 100){
			$_SESSION['text'] = 'Невозможно использовать столько за один раз.';
			$_SESSION['error'] = 1;
		}else{
			while ($i <= $count){
					$ev[$stat] = $ev[$stat] + 2;
					$evcounts =  implode(',',$ev);
					$a = 2*$count;
					$vitaminka = $a+$pokemon['vitamines'];
					Work::$sql->query("UPDATE `user_pokemons` SET `evcounts` = '".$evcounts."', `vitamines` = '".$vitaminka."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					$_SESSION['error'] = 0;
					$_SESSION['text'] = 'Очки EV успешно добавлены!';
					minus_item($itemID,1);
					$i++;
			}
			$lol3 = $pokemon['happy'] + ($count*3);
			if($lol3 > 255){
				$happy = 255;
			}else{
				$happy = $lol3;
			}
			Work::$sql->query("UPDATE `user_pokemons` SET `happy` = '".$happy."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
		}


}
function bagUpdate($bagType){

	Work::$sql->query("UPDATE `users` SET `bagType` = '".$bagType."' WHERE `id` = '".$_SESSION['id']."'");
	minus_item($bagType,1);
	$_SESSION['text'] = 'Рюкзак успешно одет!';
	return $_SESSION['text'];
}
function berries($pokID,$count,$itemID){

	$pokemon = Work::$sql->query("SELECT `hp`,`stats` FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
		$stat = explode(',',$pokemon['stats']);
		if($itemID == 7){
			$hp = $pokemon['hp'] + (50*$count);
		}elseif($itemID == 8){
			$hp = $pokemon['hp'] + (100*$count);
		}elseif($itemID == 9){
			$hp = $stat[0];
		}
		if($hp > $stat[0]){
			$hp = $stat[0];
		}
		Work::$sql->query("UPDATE `user_pokemons` SET `hp` = '".$hp."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
		minus_item($itemID,$count);
		$_SESSION['text'] = 'Здоровье успешно восстановлено!';
		$_SESSION['error'] = 0;
}
function trenya($pokID){

	$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
	$pokemon_base = Work::$sql->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$pokemon['basenum']."'")->fetch_assoc();
	$rand = rand(1,100);
	$rand_stat = rand(1,5);
	if($rand_stat == 1){
		$a = 'Атаки';
	}elseif($rand_stat == 2){
		$a = 'Защиты';
	}elseif($rand_stat == 3){
		$a = 'Скорости';
	}elseif($rand_stat == 4){
		$a = 'Спец. Атаки';
	}else{
		$a = 'Спец. Защиты';
	}
	if(item_isset(95,1)){
			if($pokemon['tren'] == 0){
		if($rand <= 80){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 1, `tren_stat` = ".$rand_stat." WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' натренировал стат '.$a.' до класса «Начальный»! Покемону вручается Голубой пояс!';
			$_SESSION['action'] = 'updateTeam';
			$_SESSION['error'] = 0;
			$a = 1;
		}else{
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' не натренировал стат!';
			$a = 2;
			$_SESSION['error'] = 0;
		}
		minus_item(95,1);
	}else if($pokemon['tren'] == 1){
		if($rand <= 55){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 2, `tren_stat` = ".$rand_stat." WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' натренировал стат '.$a.'. Получена «Морская» классификация, покемону вручается Зеленый пояс!';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
			$a = 1;
		}else{
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' не натренировал стат!';
			$_SESSION['error'] = 0;
			$a = 2;
		}
		minus_item(95,1);
	}else if($pokemon['tren'] == 2){
		if($rand <= 15){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 3, `tren_stat` = ".$rand_stat." WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' натренировал стат '.$a.'. Получена «Жемчужная» классификация, покемону вручается Оранжевый пояс!';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
			$a = 1;
		}else{
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' не натренировал стат!';
			$_SESSION['error'] = 0;
			$a = 2;
		}
		minus_item(95,1);
	}else if($pokemon['tren'] == 3){
		if($rand <= 10){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 4, `tren_stat` = ".$rand_stat." WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' натренировал стат '.$a.'. Получена «Престижная» классификация, покемону вручается Фиолетовый пояс!';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
			$a = 1;
		}else{
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' не натренировал стат!';
			$_SESSION['error'] = 0;
			$a = 2;
		}
		minus_item(95,1);
	}else if($pokemon['tren'] == 4){
		if($rand <= 5){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 5, `tren_stat` = ".$rand_stat." WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' натренировал стат '.$a.'. Получена «Величайшная» классификация, покемону вручается Синий пояс!';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
			$a = 1;
		}else{
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' не натренировал стат!';
			$a = 2;
			$_SESSION['error'] = 0;
		}
		minus_item(95,1);
	}else if($pokemon['tren'] == 5){
		if($rand <= 3){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 6, `tren_stat` = ".$rand_stat." WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' натренировал стат '.$a.'. Получена «Легендарная» классификация, покемону вручается Красный пояс!';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
			$a = 1;
		}else{
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' не натренировал стат!';
			$_SESSION['error'] = 0;
			$a = 2;
		}
		minus_item(95,1);
	}else if($pokemon['tren'] == 6){
		if($rand <= 1){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 7, `tren_stat` = ".$rand_stat." WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' натренировал стат '.$a.'. Получена «Королевская» классификация, покемону вручается Золотой пояс!';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
			$a = 1;
		}else{
			$_SESSION['text'] = ''.$pokemon_base['name_rus'].' не натренировал стат!';
			$_SESSION['error'] = 0;
			$a = 2;
		}
		minus_item(95,1);
	}else{
		$_SESSION['text'] = ''.$pokemon_base['name_rus'].' уже полностью натренерован!';
		$rand_stat = 0;
		$_SESSION['error'] = 0;
	}
		$_SESSION['other'] = $rand_stat;
		if($rand_stat == 1){if($a == 1){$_SESSION['other'] = 1;}else{$_SESSION['other'] = 6;} // Анимация классификаций
		}elseif($rand_stat == 2){if($a == 1){$_SESSION['other'] = 2;}else{$_SESSION['other'] = 6;}
		}elseif($rand_stat == 3){if($a == 1){$_SESSION['other'] = 3;}else{$_SESSION['other'] = 6;}
		}elseif($rand_stat == 4){if($a == 1){$_SESSION['other'] = 4;}else{$_SESSION['other'] = 6;}
		}elseif($rand_stat == 5){if($a == 1){$_SESSION['other'] = 5;}else{$_SESSION['other'] = 6;}
		}else{$_SESSION['other'] = 0;}
	}
	return $_SESSION['text'];
}
function anti_trenya($pokID){

	$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
	$pokemon_base = Work::$sql->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$pokemon['basenum']."'")->fetch_assoc();
	$rand = rand(1,100);
	if(item_isset(278,1)){
	if($pokemon['tren'] == 0){
			$_SESSION['text'] = 'У покемона нету классификаций.';
			$_SESSION['error'] = 1;
	}else if($pokemon['tren'] == 1){
		if($rand <= 1){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 0, `tren_stat` = 0 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = 'Классификация понижена.';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
		}else{
			$_SESSION['text'] = 'Классификация не понижена.';
			$_SESSION['error'] = 0;
		}
		minus_item(278,1);
	}else if($pokemon['tren'] == 2){
		if($rand <= 3){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 1 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = 'Классификация понижена.';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
		}else{
			$_SESSION['text'] = 'Классификация не понижена.';
			$_SESSION['error'] = 0;
		}
		minus_item(278,1);
	}else if($pokemon['tren'] == 3){
		if($rand <= 5){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 2 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = 'Классификация понижена.';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
		}else{
			$_SESSION['text'] = 'Классификация не понижена.';
			$_SESSION['error'] = 0;
		}
		minus_item(278,1);
	}else if($pokemon['tren'] == 4){
		if($rand <= 10){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 3 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = 'Классификация понижена.';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
		}else{
			$_SESSION['text'] = 'Классификация не понижена.';
			$_SESSION['error'] = 0;
		}
		minus_item(278,1);
	}else if($pokemon['tren'] == 5){
		if($rand <= 15){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 4 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = 'Классификация понижена.';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
		}else{
			$_SESSION['text'] = 'Классификация не понижена.';
			$_SESSION['error'] = 0;
		}
		minus_item(278,1);
	}else if($pokemon['tren'] == 6){
		if($rand <= 55){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 5 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = 'Классификация понижена.';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
		}else{
			$_SESSION['text'] = 'Классификация не понижена.';
			$_SESSION['error'] = 0;
		}
		minus_item(278,1);
	}else{
		if($rand <= 80){
			Work::$sql->query("UPDATE `user_pokemons` SET `tren` = 6 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			$_SESSION['text'] = 'Классификация понижена.';
			$_SESSION['error'] = 0;
			$_SESSION['action'] = 'updateTeam';
		}else{
			$_SESSION['text'] = 'Классификация не понижена.';
			$_SESSION['error'] = 0;
		}
		minus_item(278,1);
	}
	}
}
function balls($pokID,$itemID){

	$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
	Work::$sql->query("UPDATE `user_pokemons` SET `ball` = ".$itemID." WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
	$_SESSION['text'] = 'Вы успешно пересадили своего покемона в другой покебол.';
	minus_item($itemID,1);
	$_SESSION['error'] = 0;
}
function evol_stones($pokID,$itemID){

	$pokemon = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
	$pokemon_base = Work::$sql->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$pokemon['basenum']."'")->fetch_assoc();
	if($pokemon['id']){
		switch($itemID){
			case 19:
				switch($pokemon['basenum']){
					case 198:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 430;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 430 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 200:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 429;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 429 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 608:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 609;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 609 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 680:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 681;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 681 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
						$_SESSION['other'] = 0;
					break;
				}
			break;
			case 20:
				switch($pokemon['basenum']){
					case 44:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 182;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 182 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 191:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 192;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 192 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 546:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 547;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 547 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 548:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 549;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 549 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 694:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 695;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 695 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 21:
				switch($pokemon['basenum']){
					case 281:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 475;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 475 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 361:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 478;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 478 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 35:
				switch($pokemon['basenum']){
					case 30:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 31;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 31 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 33:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 34;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 34 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 39:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 40;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 40 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 35:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 36;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 36 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 300:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 301;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 301 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 517:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 518;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 518 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 22:
				switch($pokemon['basenum']){
					case 356:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 477;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 477 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 23:
				switch($pokemon['basenum']){
					case 349:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 350;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 350 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 25:
				switch($pokemon['basenum']){
					case 37:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 38;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 38 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 58:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 59;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 59 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 133:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 136;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 136 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 513:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 514;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 514 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 26:
				switch($pokemon['basenum']){
					case 61:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 62;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 62 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 90:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 91;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 91 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 120:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 121;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 121 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 133:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 134;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 134 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 271:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 272;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 272 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 515:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 516;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 516 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 27:
				switch($pokemon['basenum']){
					case 25:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 26;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 26 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 133:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 135;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 135 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 603:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 604;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 604 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 28:
				switch($pokemon['basenum']){
					case 44:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 45;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 45 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 70:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 71;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 71 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 102:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 103;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 103 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 274:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 275;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 275 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 511:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 512;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 512 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 36:
				switch($pokemon['basenum']){
					case 176:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 468;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 468 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 315:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 407;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 407 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 572:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 573;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 573 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 670:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 671;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 671 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
				case 335:
				switch($pokemon['basenum']){
					case 25:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 10026;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 10026 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 102:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 10103;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 10103 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 104:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 10105;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 10105 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 34:
				switch($pokemon['basenum']){
					case 10037:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 10038;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 10038 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 10027:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 10028;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 10028 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 51:
				switch($pokemon['basenum']){
					case 126:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 467;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 467 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 52:
				switch($pokemon['basenum']){
					case 112:
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 464 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 53:
				switch($pokemon['basenum']){
					case 125:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 466;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 466 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 65:
				switch($pokemon['basenum']){
					case 215:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 461;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 461 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 66:
				switch($pokemon['basenum']){
					case 207:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 472;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 472 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 70:
				switch($pokemon['basenum']){
					case 682:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 683;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 683 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 71:
				switch($pokemon['basenum']){
					case 684:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 685;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 685 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 72:
				switch($pokemon['basenum']){
					case 117:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 230;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 230 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 73:
				switch($pokemon['basenum']){
					case 137:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 233;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 233 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 74:
				switch($pokemon['basenum']){
					case 233:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 474;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 474 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 69:
				switch($pokemon['basenum']){
					case 95:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 208;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 208 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 123:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 212;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 212 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 100:
				switch($pokemon['basenum']){
					case 61:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 186;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 186 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					case 79:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 199;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 199 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 96:
				switch($pokemon['basenum']){
					case 440:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 113;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 113 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 98:
				switch($pokemon['basenum']){
					case 366:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 367;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 367 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			case 99:
				switch($pokemon['basenum']){
					case 366:
						$_SESSION['other'] = $pokemon['basenum'];
						$_SESSION['other2'] = 368;
						Work::$sql->query("UPDATE `user_pokemons` SET `basenum` = 368 WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$_SESSION['text'] = ''.$pokemon_base['name_rus'].' удачно эволюционировал!';
$_SESSION['error'] = 0;
						minus_item($itemID,1);
					break;
					default:
						$_SESSION['other'] = 0;
						$_SESSION['text'] = 'На '.$pokemon_base['name_rus'].' нельзя использовать данный предмет.';
$_SESSION['error'] = 1;
					break;
				}
			break;
			default:
				$_SESSION['text'] = 'Ошибка!';
			break;

		}
	}
	$updateName = Work::$sql->query('SELECT `name_rus` FROM `base_pokemons` WHERE `id` = '.$_SESSION['other2'])->fetch_assoc();
	Work::$sql->query("UPDATE `user_pokemons` SET `name_new` = '".$updateName['name_rus']."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
	return $_SESSION['text'];
}
#Наборы рюкзаков
function bagBox(){
	$rand = mt_rand(1,100);
	if($rand < 3){#
		$bagID = 90;
	}elseif($rand > 3 && $rand < 5){
		$bagID = 86;
	}elseif($rand > 4 && $rand < 10){
		$bagID = 89;
	}elseif($rand > 9 && $rand < 20){
		$bagID = 84;
	}elseif($rand > 19 && $rand < 40){
		$bagID = 88;
	}elseif($rand > 39 && $rand < 60){
		$bagID = 85;
	}else{
		$bagID = 87;
	}
	itemAdd($bagID,1);
	minus_item(111,1);
	$_SESSION['text'] = 'Вы получили свой рюкзак!';
	return $_SESSION['text'];
}
function rainbowdust($itemID) {
	$rand = mt_rand(15,15);
		if($rand1 = mt_rand(10,15)) {
			itemAdd(108,$rand1);
			$_SESSION['plus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль ('.$rand1.' шт.)';
		}
	$_SESSION['error'] = 0;
	$_SESSION['text'] = 'Вы открыли сундук!';
	minus_item($itemID,1);
}
?>
