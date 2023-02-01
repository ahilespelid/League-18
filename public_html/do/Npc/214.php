<?php
$response['name'] = 'Съюзен';
switch($npcStep){
	case 1:
		if(events_step(1, 1)){
			$response['question'] = 'Если ты хотел купить цветы, то,их больше нет.... Совсем нет...';
			$response['answer'] = [
				2	=> 'Я могу вам как-то помочь ? '
			];
		}else{
			$response['question'] = '<i>~Грустит~</i>';
		}
	break;
	case 2:
		if(events_step(1, 1)){
			$response['question'] = 'Возможно, я не знаю.... Сегодня утром, я проснулась, пришла в оранжерею и вижу всё это *указывает на пустые земли* я не знаю как такое случилось и решила оглядеть окрестности...';
			$response['answer'] = [
				3	=> '.....'
			];
		}else{
			$response['question'] = '<i>~Грустит~</i>';
		}
	break;
	case 3:
		if(events_step(1, 1)){
			$response['question'] = 'Я не обнаружила ничего, что могло бы подтвердить вероятность причастия злой банды, воров... Я видела лишь лепестки своих цветов, они повсюду, везде, куда бы я не пошла, в Фуксии был самый большой завал, невероятное количество цветов было брошено прямо на улице...';
			$response['answer'] = [
				4	=> '~Слушать~'
			];
		}else{
			$response['question'] = '<i>~Грустит~</i>';
		}
	break;
	case 4:
		if(events_step(1, 1)){
			$response['question'] = 'Понимаешь, я каждый год на 8-е марта, даю добрым людям свои цветы, отдаю их в торговые магазины, да много что я с ними делаю, а в этот раз у меня ничего нет. Я... Я не могу поверить что такое случилось...';
			$response['answer'] = [
				5	=> '~Успокаивает~ Я готов вам помочь! Я помогу вернуть вам часть ваших цветов. '
			];
		}else{
			$response['question'] = '<i>~Эх~</i>';
		}
	break;
	case 5:
		if(events_step(1, 1)){
			events_update(1, 2);
			$response['question'] = 'Ох, большое спасибо.... Я так рада, не мог бы ты сказать об этом и другим тренерам покемонов ? Может быть тогда, я смогу вернуть свой прекрасный сад и одарить город своими цветами снова. ';
			$response['answer'] = [
				1	=> 'Конечно, всё будет хорошо, я скоро вернусь!'
			];
		}else{
			$response['question'] = '<i>~Что-то ищет в земле~</i>';
		}
	break;
	case 6:
		$count = item_isset(10003, 1);
		if(events_step(1, 2) && isset($_SESSION['id']) && $count && (int)$count > 0){
			minus_item(10003, $count);
			events_count(1, $count);
			events_update(1, 3);
			$response['question'] = 'Если вдруг, ты найдёшь ещё, неси их скорее мне, я буду ждать тебя здесь. Вы принесли: <b>'. events_count_item(1) .'</b> Цветов';
			$response['answer'] = [
				8	=> 'Конечно'
			];
		}else if(events_step(1, 2) && isset($_SESSION['id']) && !$count){
		    events_update(1, 3);
			$response['question'] = 'Странно, но у вас нет цветов, возможно вы меня обманываете.';
		}
	break;
	case 7:
		if(events_step(1, 2) && isset($_SESSION['id'])){
			$u = $mysqli->query("SELECT location FROM users WHERE id = ".$_SESSION['id'])->fetch_assoc();
			$mysqli->query("INSERT INTO teleport_user (user, location, go) VALUES(".$_SESSION['id'].", ".$u['location'].", '9may')");
			$mysqli->query("UPDATE users SET location=220 WHERE id=".$_SESSION['id']);
			$response['action'] = 'updateLocation';
		}
	break;
	case 8:
		if(events_step(1, 3) && isset($_SESSION['id'])){
			$count = events_count_item(1);
			events_update(1, 5);
			if($count > 0){
				$response['question'] = 'Ты принёс <b>'. $count .'</b> цветов, ваша награда:<br>';
				newPokemon(187, false, 1, '25,25,25,25,25,25', 0, false, false, false, false, false, false, false);
				$response['question'] .= '<b>#187 Хоппип</b><br>';
				if($count >= 1 && $count <= 100){
			    	itemAdd(37, 5);
			    	itemAdd(38, 5);
			    	itemAdd(39, 5);
			    	itemAdd(40, 5);
			    	itemAdd(41, 5);
			    	itemAdd(42, 5);
					itemAdd(43, 1);
					itemAdd(1, 100000);
					newPokemon(231, false, 1, '26,26,26,26,26,26', 0, false, true, true, false, false, false, false);
					$response['question'] .= '<b>Набор витоминов по 5 банок.</b><br>';
					$response['question'] .= '<b>100.000 Монет</b><br>';
					$response['question'] .= '<b>Покемон Фанфи!</b><br>';
				}else if($count >= 101 && $count <= 200){
					itemAdd(257, 2);
					itemAdd(275, 1);
					itemAdd(109, 3);
					itemAdd(1, 200000);
					newPokemon(438, false, 1, '26,26,26,26,26,26', 0, false, true, true, false, false, false, false);
					$response['question'] .= '<b>Печенье с изюмом х2</b><br>';
					$response['question'] .= '<b>Инкубатор х1</b><br>';
					$response['question'] .= '<b>Генобол х3</b><br>';
					$response['question'] .= '<b>200.000 Монет</b><br>';
					$response['question'] .= '<b>Покемон Бонсли!</b><br>';
				}else if($count >= 201 && $count <= 300){
					itemAdd(262, 1);
					itemAdd(109, 5);
					itemAdd(162, 3);
					itemAdd(1, 300000);
					newPokemon(574, false, 1, '26,26,26,26,26,26', 0, false, true, true, false, false, false, false);
					$response['question'] .= '<b>Курс боевой подготовки х1</b><br>';
					$response['question'] .= '<b>Генобол х5</b><br>';
					$response['question'] .= '<b>Набор красок x3</b><br>';
					$response['question'] .= '<b>300.000 Монет</b><br>';
					$response['question'] .= '<b>Покемон Готита!</b><br>';
				}else if($count >= 301 && $count <= 400){
					itemAdd(21, 1);
					itemAdd(53, 1);
					itemAdd(1, 400000);
					newPokemon(626, false, 1, '26,26,26,26,26,26', 0, false, true, true, false, false, false, false);
					$response['question'] .= '<b>Рассветный камень х1</b><br>';
					$response['question'] .= '<b>Электрайзер х1</b><br>';
					$response['question'] .= '<b>400.000 Монет</b><br>';
					$response['question'] .= '<b>Покемон Буфалант!</b><br>';
				}else if($count >= 401 && $count <= 500){
				    itemAdd(66, 1);
				    itemAdd(262, 1);
				    itemAdd(33, 30);
				    itemAdd(1, 500000);
					newPokemon(669, false, 1, '26,26,26,26,26,26', 0, false, true, true, false, false, false, false);
					$response['question'] .= '<b>Острый клык х1</b><br>';
					$response['question'] .= '<b>Курс боевой подготовки</b><br>';
					$response['question'] .= '<b>Конфеты в форме Иви х30</b><br>';
					$response['question'] .= '<b>500.000 Монет</b><br>';
					$response['question'] .= '<b>Покемон Флабэбэ!</b><br>';
				}else if($count > 501){
					itemAdd(262, 1);
					itemAdd(43, 20);
					itemAdd(1, 600000);
					newPokemon(328, false, 1, '26,26,26,26,26,26', 0, false, true, true, false, false, false, false);
					$response['question'] .= '<b>600.000 Монет</b><br>';
					$response['question'] .= '<b>Курс боевой подготовки</b><br>';
					$response['question'] .= '<b>Жемчуг х20</b><br>';
					$response['question'] .= '<b>Покемон Трапинч!</b><br>';
				}
			}else{
				$response['question'] = 'Эх, тебя что-то я не припомню..';
			}
		}
	break;
	default:
		if(events_step(1, 1)){
			$response['question'] = 'Привет! Тоже проходил(а) мимо ? ';
			$response['answer'] = [
				1	=> 'Да я собственно к вам..'
			];
		}else if(events_step(1, 2)){
		  
			$response['question'] = 'Ух-ты! Ты нашёл(шла) их для меня? *удивление* ';
			$response['answer'] = [
				6	=> 'Отдать цветы'
			];
		}else if(events_step(1, 9)){
			$response['question'] = 'Большое тебе спасибо! Я отблагодарю тебя, но приходи чуточку позже, мне нужно кое-что подсчитать. Ты принёс мне целых: «Цветы»: х<b>'. events_count_item(1) .'</b>.';
		}else if(events_step(1, 3)){
			$response['question'] = 'Ещё раз спасибо!<br> Я закончила подсчёты и думаю у меня есть для тебя подходящая награда. <br> Столько цветов, даже не верится. Большинство из них, были доставлены во все возможные лавки, всем кому только можно. О боже, я так рада. <br> Надеюсь тебя порадует мой подарок. ';
			$response['answer'] = [
				8	=> '<i>Всегда рад помочь.</i>',
			];
		}else if(events_step(1, 5)){
			$response['question'] = '~Напевает мелодию~';
		}else{
			$response['question'] = '~Напевает мелодию~';
		}
	break;
}