<?
	$response['name'] = 'Охранник';
	switch($npcStep){
		case 1:
			if(item_isset(1,6000)){
				$response['question'] = 'Удачной охоты.. Может, еще один пропуск купишь? Ну, на всякий пожарный..';
				$response['answer'] = array(
					1 => "Купить еще пропуск"
				);
				itemAdd(134,1);
				minus_item(1,6000);
			}else{
				$response['question'] = 'У тебя не хватает монет.';
			}
		break;
		default:
			$response['question'] = 'Здравствуй, посетитель. У меня можно получить доступ к Поляне,чтобы поймать редких покемонов и получить вещи убивая.Я продаю пропуск в вольер. Но учти, что ни питомника, ни пункта лечения покемонов там нет. Каждый вход в вольер будет стоить тебе один пропуск. Брать пропуск будешь? <br> Цена <div class="itemIsset" onclick="issetAll(134,\'item\')" style="background-image: url(/img/world/items/little/134.png)"></div> пропуска - <b>10.000 монет</b>.';
			$response['answer'] = array(
				1 => "Купить пропуск"
			);
		break;
	}
?>