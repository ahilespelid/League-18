<?php
$response['name'] = 'Владелец магазина';
switch($npcStep){
	case 1:
		if(events_step(1, 1)){
			$response['question'] = 'Представляешь, накануне праздника у меня украли часть памятных сувениров. Особой ценности для меня они не имеют, но вернуть их - это уже вопрос принципа.<br> Так что, если тебе интересно, я собираю команду из таких, как ты.';
			$response['answer'] = [
				2	=> 'Я готов'
			];
		}else{
			$response['question'] = '<i>~Прогуливается по окрестности~</i>';
		}
	break;
	case 2:
		if(events_step(1, 1)){
			$response['question'] = 'Мне нравятся трудолюбивые люди. Вот только трудолюбие - понятие растяжимое. Кто-то готов интенсивно работать всего лишь час, а у кого-то еще остаются силы после десяти часов работы.<br> Но к какому бы из этих типов людей ты не относился, мне нужна твоя помощь.<br> Сейчас очень сложно говорить о размере гонорара, который я готов тебе предложить. Будем смотреть по твоему конечному результату.';
			$response['answer'] = [
				3	=> 'Я думаю, что это справедливо'
			];
		}else{
			$response['question'] = '<i>~Прогуливается по окрестности~</i>';
		}
	break;
	case 3:
		if(events_step(1, 1)){
			$response['question'] = 'Понимаешь, каждый год у меня возникает одна и та же проблема. Мелкие засранцы в лице <b>покемонов призрачного типа</b> появляются на 9 мая и начинают веселиться прямо в моем магазине, создавая всем неудобства.<br> Если в предыдущий раз все закончилось только беспорядком, а также традиционным распугиванием моих покупателей и продавцов, в этот раз они перешли все границы моего терпения.';
			$response['answer'] = [
				4	=> 'Это ужасно'
			];
		}else{
			$response['question'] = '<i>~Прогуливается по окрестности~</i>';
		}
	break;
	case 4:
		if(events_step(1, 1)){
			$response['question'] = 'Думаю, мне не надо указывать пальцем на тех, кто посягнул на партию коробок с <b>праздничными медальками</b>. Ты и сам это понял, верно?';
			$response['answer'] = [
				5	=> 'Да, это были покемоны-призраки'
			];
		}else{
			$response['question'] = '<i>~Прогуливается по окрестности~</i>';
		}
	break;
	case 5:
		if(events_step(1, 1)){
			events_update(1, 2);
			$response['question'] = 'А раз ты все понял, то присоединяйся к другим тренерам, которые помогают мне. Сражайся с покемонами, собирай падающие <b>медальки</b> и отдавай их мне. Потом сядем и вместе посчитаем, сколько ты выбил. Я уже знаю, что буду делать с сувенирами после праздника, но это уже не твоя забота.';
			$response['answer'] = [
				1	=> 'До скорого'
			];
		}else{
			$response['question'] = '<i>~Прогуливается по окрестности~</i>';
		}
	break;
	case 6:
		$count = item_isset(10003, 1);
		if(events_step(1, 2) && isset($_SESSION['id']) && $count && (int)$count > 0){
			minus_item(10003, $count);
			events_count(1, $count);
			$response['question'] = 'Как добудешь ещё, приноси. Ты принёс <b>'. events_count_item(1) .'</b> Медалей';
			$response['answer'] = [
				8	=> 'До скорого'
			];
		}else if(events_step(1, 2) && isset($_SESSION['id']) && !$count){
			$response['question'] = 'У тебя нет с собой <b>Медалей</b>. Приходи когда добудешь их.';
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
		if(events_step(1, 4) && isset($_SESSION['id'])){
			$count = events_count_item(1);
			events_update(1, 5);
			if($count > 0){
				$response['question'] = 'Ты принёс <b>'. $count .'</b> Медалей, за это ты получаешь:<br>';
				newPokemon(353, false, 1, '26,26,26,26,26,26', 0, false, true, true, false, false, false, false);
				$response['question'] .= '<b>#353 Шупет</b><br>';
				if($count >= 1 && $count <= 199){
					plusEgg('26,26,26,26,26,26', false, false, false, false, 425, true);
					itemAdd(107, 1);
					itemAdd(1, 250000);
					$response['question'] .= '<b>Яйцо #425 Дрифлун</b><br>';
					$response['question'] .= '<b>Одноразовый амулет прозрения x1</b><br>';
					$response['question'] .= '<b>250.000 Монет</b><br>';
				}else if($count >= 200 && $count <= 299){
					plusEgg('28,28,28,28,28,28', false, false, false, false, 562, true);
					itemAdd(107, 1);
					itemAdd(162, 1);
					itemAdd(1, 500000);
					$response['question'] .= '<b>Яйцо #562 Ямаск</b><br>';
					$response['question'] .= '<b>Одноразовый амулет прозрения x1</b><br>';
					$response['question'] .= '<b>Набор красок x1</b><br>';
					$response['question'] .= '<b>500.000 Монет</b><br>';
				}else if($count >= 300 && $count <= 500){
					plusEgg('30,30,30,30,30,30', false, false, false, false, 355, true);
					itemAdd(107, 1);
					itemAdd(162, 1);
					itemAdd(95, 1);
					itemAdd(1, 1000000);
					$response['question'] .= '<b>Яйцо #355 Даскул</b><br>';
					$response['question'] .= '<b>Одноразовый амулет прозрения x1</b><br>';
					$response['question'] .= '<b>Набор красок x1</b><br>';
					$response['question'] .= '<b>Набор классификаций x1</b><br>';
					$response['question'] .= '<b>1.000.000 Монет</b><br>';
				}else if($count > 500){
					plusEgg('30,30,30,30,30,30', false, false, false, false, 355, true);
					itemAdd(10002, 1);
					itemAdd(162, 1);
					itemAdd(95, 1);
					itemAdd(1, 1000000);
					$response['question'] .= '<b>Яйцо #355 Даскул</b><br>';
					$response['question'] .= '<b>Амулет прозрения x1</b><br>';
					$response['question'] .= '<b>Набор красок x1</b><br>';
					$response['question'] .= '<b>Набор классификаций x1</b><br>';
					$response['question'] .= '<b>1.000.000 Монет</b><br>';
				}
			}else{
				$response['question'] = 'Ты не принёс мне Медалей';
			}
		}
	break;
	default:
		if(events_step(1, 1)){
			$response['question'] = 'Привет. Рад тебя видеть. Ты тоже поке-тренер?';
			$response['answer'] = [
				1	=> 'Да, это так'
			];
		}else if(events_step(1, 2)){
			$response['question'] = 'Ты принёс, что я просил?';
			$response['answer'] = [
				6	=> 'Отдать медали',
				7	=> 'Отправиться на склад'
			];
		}else if(events_step(1, 3)){
			$response['question'] = 'Благодарю за помощь. Твои старания не останутся незамеченными. Приходи через пару дней. Ты принёс мне <b>'. events_count_item(1) .'</b> Медалей';
		}else if(events_step(1, 4)){
			$response['question'] = 'Спасибо за помощь, тренер.<br> Чем я смог, тем и отблагодарил тебя. Надеюсь, что не продешевил с твоим вкладом в общее дело.<br> А праздничные медальки, которые вы все вместе собрали, уже отправлены почтой даже в самые отдаленные уголки Канто и Хоэнна нашим дедушкам и бабушкам. Я хоть и бизнесмен, но раз в год стоит просто сделать кому-то небольшой, но приятный подарок.';
			$response['answer'] = [
				8	=> '<i>~Получить подарок~</i>',
			];
		}else if(events_step(1, 5)){
			$response['question'] = 'Ты уже получил свой подарок.';
		}else{
			$response['question'] = '<i>~Прогуливается по окрестности~</i>';
		}
	break;
}