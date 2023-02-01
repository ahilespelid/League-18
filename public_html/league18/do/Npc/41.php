<?
	$response['name'] = 'Разноцветный компьютер';
	switch($npcStep){
		case 1:
			$rand1 = rand(100,250);
			$rand2 = rand(251,400);
			$rand3 = rand(401,700);
			$pokA = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$rand1."'")->fetch_assoc();
			$pokB = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$rand2."'")->fetch_assoc();
			$pokC = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$rand3."'")->fetch_assoc();
			$response['question'] = '
			Кого из них я выбрал? Как ты думаешь?<br>
			1. <img src="/img/pokemons/mini/normal/'.$rand1.'.png" style="vertical-align: middle; width: 50px;"> '.$pokA['name_rus'].'<br>
			2. <img src="/img/pokemons/mini/normal/'.$rand2.'.png" style="vertical-align: middle; width: 50px;"> '.$pokB['name_rus'].'<br>
			3. <img src="/img/pokemons/mini/normal/'.$rand3.'.png" style="vertical-align: middle; width: 50px;"> '.$pokC['name_rus'].'
			';
			$response['answer'] = array(
				 2 => $pokA['name_rus'],
				 3 => $pokB['name_rus'],
				 4 => $pokC['name_rus']
			);
		break;
		case 2:
			$rand = rand(1,5);
			if(item_isset(1,20000)){
				if($rand == 1){
					$response['question'] = 'Правильно! Держи свои <div class="itemIsset" onclick="issetAll(108,\'item\')" style="background-image: url(/img/world/items/little/108.png)"></div> 5 Пыли. Сыграй еще! Может повезет вновь.';
					itemAdd(108,5);
					minus_item(1,20000);
				}else{
					$response['question'] = 'Не угадал.. Ты не получишь пыль, но у тебя всегда есть шанс отыграться!';
					minus_item(1,20000);
				}
			}else{
				$response['question'] = 'Недостаточно средств!';
			}
		break;
		case 3:
			$rand = rand(1,5);
			if(item_isset(1,20000)){
				if($rand == 1){
					$response['question'] = 'Правильно! Держи свои <div class="itemIsset" onclick="issetAll(108,\'item\')" style="background-image: url(/img/world/items/little/108.png)"></div> 5 Пыли. Сыграй еще! Может повезет вновь.';
					itemAdd(108,5);
					minus_item(1,20000);
				}else{
					$response['question'] = 'Не угадал.. Ты не получаешь Пыль, но у тебя всегда есть шанс отыграться!';
					minus_item(1,20000);
				}
			}else{
				$response['question'] = 'Недостаточно средств!';
			}
		break;
		case 4:
			$rand = rand(1,5);
			if(item_isset(1,20000)){
				if($rand == 1){
					$response['question'] = 'Правильно! Держи свои <div class="itemIsset" onclick="issetAll(108,\'item\')" style="background-image: url(/img/world/items/little/108.png)"></div> 5 Пыли. Сыграй еще! Может повезет вновь.';
					itemAdd(108,5);
					minus_item(1,20000);
				}else{
					$response['question'] = 'Не угадал.. Ты не получаешь жетонов, но у тебя всегда есть шанс отыграться!';
					minus_item(1,20000);
				}
			}else{
				$response['question'] = 'Недостаточно средств!';
			}
		break;
		default:
			$response['question'] = 'Угадай какого из трех покемонов я выбрал. Угадаешь - получишь <div class="itemIsset" onclick="issetAll(108,\'item\')" style="background-image: url(/img/world/items/little/108.png)"></div> 5 Разноцветной пыли!<br>Стоимость: <b>20.000 монет</b>.';
			$response['answer'] = array(
				 1 => "Давай начнем!"
			);
		break;
	}
?>