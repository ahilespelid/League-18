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
			case 108:
				if($countMoney['count'] >= 1000000){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '463' WHERE `id` = '".$pokID."'");
					minus_item(1,1000000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег.';
					$response['error'] = 1;
				}
			break;
			case 114:
				if($countMoney['count'] >= 1000000){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '465' WHERE `id` = '".$pokID."'");
					minus_item(1,1000000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег.';
					$response['error'] = 1;
				}
			break;
			case 190:
				if($countMoney['count'] >= 1000000){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '424' WHERE `id` = '".$pokID."'");
					minus_item(1,1000000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег.';
					$response['error'] = 1;
				}
			break;
			case 193:
				if($countMoney['count'] >= 1000000){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '469' WHERE `id` = '".$pokID."'");
					minus_item(1,1000000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег.';
					$response['error'] = 1;
				}
			break;
			case 221:
				if($countMoney['count'] >= 1000000){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '473' WHERE `id` = '".$pokID."'");
					minus_item(1,1000000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег.';
					$response['error'] = 1;
				}
			break;
			case 439:
				if($countMoney['count'] >= 1000000){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '122' WHERE `id` = '".$pokID."'");
					minus_item(1,1000000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег.';
					$response['error'] = 1;
				}
			break;
			case 686:
				if($countMoney['count'] >= 1000000){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '687' WHERE `id` = '".$pokID."'");
					minus_item(1,1000000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег.';
					$response['error'] = 1;
				}
						break;
			case 438:
				if($countMoney['count'] >= 1000000){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '185' WHERE `id` = '".$pokID."'");
					minus_item(1,1000000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег.';
					$response['error'] = 1;
				}
			break;
			case 133:
				if($countMoney['count'] >= 1000000){
					$response['text'] = $pokInfo['name_new'].' успешно эволюционировал!';
					$mysqli->query("UPDATE `user_pokemons` SET `basenum` = '700' WHERE `id` = '".$pokID."'");
					minus_item(1,1000000);
					$response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (1000000 шт.)';
					$response['action'] = 'updateTeam';
				}else{
					$response['text'] = 'У вас недостаточно денег.';
					$response['error'] = 1;
				}
			break;
			default:
				$response['text'] = 'Ошибка!';
			break;
		}
	}else{
		$response['text'] = 'Ошибка!';
		$response['error'] = 1;
	}
	die(json_encode($response));
}
	$response['name'] = 'Марио';
	switch($npcStep){
		case 1:
				$poks = $mysqli->query("SELECT `id`,`name_new`,`basenum` FROM `user_pokemons` WHERE `user_id`='".$_SESSION['id']."' AND `active` = '1'");
				$list = '';
				while($pokList = $poks->fetch_assoc()){
					$list.= '<option value="'.$pokList['id'].'">#'.numbPok($pokList['basenum']).' '.$pokList['name_new'].'</option>';
				}
				$response['question'] = 'Выбери покемона
										<form class="evolNpcForm" onsubmit="evolutionPok(39);return false;"">
										<select id="pokID">'.$list.'
										</select>
											<input class="mn-btn" type="submit" value="Выбрать">
										</form>';
		break;
		case 2:
				$response['question'] = '
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/108.png"> <div>#108 Ликитунг</div> в <img src="/img/pokemons/mini/normal/463.png"> <div>#463 Ликилики</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/133.png"> <div>#133 Иви</div> в <img src="/img/pokemons/mini/normal/700.png"> <div>#700 Сильвеон</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/114.png"> <div>#114 Танжела</div> в <img src="/img/pokemons/mini/normal/465.png"> <div>#465 Тангроус</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/190.png"> <div>#190 Айпом</div> в <img src="/img/pokemons/mini/normal/424.png"> <div>#424 Эмбипом</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/193.png"> <div>#193 Янма</div> в <img src="/img/pokemons/mini/normal/469.png"> <div>#469 Янмега</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/221.png"> <div>#221 Пилосвайн</div> в <img src="/img/pokemons/mini/normal/473.png"> <div>#473 Мамосвайн</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/439.png"> <div>#439 Майм Джуниор</div> в <img src="/img/pokemons/mini/normal/122.png"> <div>#122 Мистер Майм</div></div>
				<div class="questPokemon"><img src="/img/pokemons/mini/normal/686.png"> <div>#686 Инкей</div> в <img src="/img/pokemons/mini/normal/687.png"> <div>#687 Маламар</div></div>
				';
				$response['answer'] = array(
					1 => "Я хочу эволюционировать покемона"
				);
		break;
		default:
				$response['question'] = 'Приветствую тебя! Я могу эволюционировать некоторых твоих покемонов в другую форму. Стоимость эволюции 1.000.000 монет.';
				$response['answer'] = array(
					1 => "Я хочу эволюционировать покемона",
					2 => "Я хочу ознакомиться со списком покемонов, которых я могу эволюционировать"
				);
		break;
	}
?>
