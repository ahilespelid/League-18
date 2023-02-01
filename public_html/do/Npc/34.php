<?php
if(isset($_POST['pokID'])){
	$patch_project = $_SERVER['DOCUMENT_ROOT'];
	$patch_global = $patch_project.'/inc/conf/global.php';
	if(!empty($patch_global)){
	    if(!file_exists($patch_global)){
	        die('The problem with the connection files.');
	    }else{
			require_once($patch_global);
	    }
	}
	$checkUserLoc = $mysqli->query("SELECT `location` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
	if($checkUserLoc['location'] == 86){
		$pokID = clearInt($_POST['pokID']);
		$pokInfo = $mysqli->query("SELECT `basenum`,`happy`,`name_new` FROM `user_pokemons` WHERE `id`='".$pokID."'")->fetch_assoc();
		$countMoney = $mysqli->query("SELECT `count` FROM `items_users` WHERE `user`= '".$_SESSION['id']."' AND `item_id` = '1'")->fetch_assoc();
		switch($pokInfo['basenum']){
			case 42:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '169' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 113:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '242' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 172:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '25' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 173:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '35' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 174:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '39' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 175:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '176' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 298:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '183' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 406:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '315' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 427:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '428' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 433:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '358' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 446:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '143' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 447:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '448' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 527:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '528' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (250000 шт.)';
					minus_item(1,250000);
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 541:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '542' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					minus_item(1,250000);
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			case 133:
				if($countMoney['count'] >= 250000 && $pokInfo['happy'] >= 250){
					if($timeday == 1 || $timeday == 4){
						$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '197' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					}else{
						$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '196' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					}
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					minus_item(1,250000);
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег или у покемона недостаточно счастья!';
					$response['error'] = 1;
				}
			break;
			default:
				$response['text'] = 'Ошибка!';
				$response['error'] = 1;
			break;
		}
	}else{
		$response['text'] = 'Ошибка!';
		$response['error'] = 1;
	}
	die(json_encode($response));
}
	$response['name'] = 'Мюллер';
	switch($npcStep){
		case 1:
				$poks = $mysqli->query("SELECT `id`,`name_new`,`basenum` FROM `user_pokemons` WHERE `user_id`='".$_SESSION['id']."' AND `active` = '1'");
				$list = '';
				while($pokList = $poks->fetch_assoc()){
					$list.= '<option value="'.$pokList['id'].'">#'.numbPok($pokList['basenum']).' '.$pokList['name_new'].'</option>';
				}
				$response['question'] = 'Выбери покемона
										<form class="evolNpcForm" onsubmit="evolutionPok(34);return false;"">
										<select id="pokID">'.$list.'
										</select>
											<input class="mn-btn" type="submit" value="Выбрать">
										</form>';
		break;
		case 2:
				$response['question'] = '
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/133.png"> <div>#133 Иви</div> в <img src="/img/pokemons/mini/normal/196.png"> <div>#196 Эспеон</div> утром и днем</div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/133.png"> <div>#133 Иви</div> в <img src="/img/pokemons/mini/normal/197.png"> <div>#197 Умбреон</div> вечером и ночью</div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/042.png"> <div>#042 Голбат</div> в <img src="/img/pokemons/mini/normal/169.png"> <div>#169 Кробат</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/173.png"> <div>#173 Клеффа</div> в <img src="/img/pokemons/mini/normal/035.png"> <div>#035 Клефейри</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/172.png"> <div>#172 Пичу</div> в <img src="/img/pokemons/mini/normal/025.png"> <div>#025 Пикачу</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/113.png"> <div>#113 Ченси</div> в <img src="/img/pokemons/mini/normal/242.png"> <div>#242 Блисси</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/174.png"> <div>#174 Иглибафф</div> в <img src="/img/pokemons/mini/normal/039.png"> <div>#039 Джиглипафф</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/175.png"> <div>#175 Тогепи</div> в <img src="/img/pokemons/mini/normal/176.png"> <div>#176 Тогетик</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/298.png"> <div>#298 Азурил</div> в <img src="/img/pokemons/mini/normal/183.png"> <div>#183 Марил</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/406.png"> <div>#406 Бадью</div> в <img src="/img/pokemons/mini/normal/315.png"> <div>#315 Розелия</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/427.png"> <div>#427 Банири</div> в <img src="/img/pokemons/mini/normal/428.png"> <div>#428 Лапани</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/433.png"> <div>#433 Чинлинг</div> в <img src="/img/pokemons/mini/normal/358.png"> <div>#358 Чимечо</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/446.png"> <div>#446 Манчлакс</div> в <img src="/img/pokemons/mini/normal/143.png"> <div>#143 Снорлакс</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/447.png"> <div>#447 Риолу</div> в <img src="/img/pokemons/mini/normal/448.png"> <div>#448 Лукарио</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/527.png"> <div>#527 Вубат</div> в <img src="/img/pokemons/mini/normal/528.png"> <div>#528 Свубат</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/541.png"> <div>#541 Свадлун</div> в <img src="/img/pokemons/mini/normal/542.png"> <div>#542 Ливанни</div></div>
				';
				$response['answer'] = array(
					1 => "Я хочу эволюционировать покемона"
				);
		break;
		default:
				$response['question'] = 'Приветствую тебя! Я могу эволюционировать некоторых твоих покемонов в другую форму. Стоимость эволюции 250.000 монет. У покемона должно быть 250 и более счастья.';
				$response['answer'] = array(
					1 => "Я хочу эволюционировать покемона",
					2 => "Я хочу ознакомиться со списком покемонов, которых я могу эволюционировать"
				);
		break;
	}
?>
