<?
	$response['name'] = 'Говорящая Дельфокс';
	$ng = $mysqli->query("SELECT * FROM `ng` WHERE `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
	$a = $ng['branches'];
	$b = $ng['decoration1'];
	$c = $ng['decoration2'];
	$d = $ng['decoration3'];
	$e = $b+$c+$d;
	switch($npcStep){
		case 1:
			if($ng){
				if(!quest_isset(2018)){
					if($a >= 1 && $a <= 5){
					itemAdd(37,5);
					$prize .= 'Банка цинка (5 шт.)';
				}elseif($a >= 6 && $a <= 15){
					itemAdd(37,5);
					itemAdd(33,5);
					$prize .= 'Банка цинка (5 шт.) <br> Леденец в форме Иви (5 шт.)';
				}elseif($a >= 16 && $a <= 25){
					itemAdd(52,1);
					$prize .= 'Протектор (1 шт.)';
				}elseif($a >= 26 && $a <= 40){
					itemAdd(52,1);
					itemAdd(105,1);
					itemAdd(5,5);
					$prize .= 'Протектор (1 шт.)<br> Линзы (1 шт.)<br> Мастербол (5 шт.)';
				}elseif($a >= 41 && $a <= 50){
					itemAdd(105,1);
					itemAdd(64,1);
					$prize .= 'Алмазная руда (1 шт.)<br> Линзы (1 шт.)';
				}elseif($a >= 51 && $a <= 80){
					itemAdd(64,1);
					itemAdd(35,1);
					itemAdd(36,1);
					$prize .= 'Алмазная руда (1 шт.)<br> Лунный камень (1 шт.)<br> Сияющий камень (1 шт.)';
				}elseif($a >= 81 && $a <= 100){
					itemAdd(5,5);
					itemAdd(105,1);
					itemAdd(99,1);
					itemAdd(36,1);
					itemAdd(109,5);
					$prize .= 'Сияющий камень (1 шт.)<br> Глубоководная чешуя (1 шт.)<br> Линзы (1 шт.)<br> Мастербол (5 шт.)<br> Генобол (5 шт.)';
				}elseif($a >= 101 && $a <= 129){
					itemAdd(105,1);
					itemAdd(111,1);
					itemAdd(21,1);
					itemAdd(109,5);
					itemAdd(118,1);
					$prize .= 'Набор рюкзаков (1 шт.)<br> Рубиновый загадочный сундук (1 шт.)<br> Рассветный камень (1 шт.)<br> Генобол (5 шт.)<br> Линзы (1 шт.)';
				}elseif($a >= 130 && $a <= 200){
					itemAdd(118,1);
					itemAdd(20,1);
					itemAdd(23,1);
					itemAdd(109,5);
					plusEgg(false,false,false,true,false,539);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Солнечный камень (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Яйцо #539 Соук<br> Генобол (5 шт.)';
				}elseif($a >= 201 && $a <= 211){
					itemAdd(23,1);
					itemAdd(118,1);
					plusEgg(false,false,false,true,false,442);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Яйцо #442 Спиритомб';
				}elseif($a >= 212 && $a <= 230){
					itemAdd(23,1);
					itemAdd(118,1);
					itemAdd(36,1);
					plusEgg(false,false,false,true,false,442);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Яйцо #442 Спиритомб<br> Сияющий камень (1 шт.)';
				}elseif($a >= 231 && $a <= 303){
					itemAdd(23,1);
					itemAdd(118,1);
					plusEgg(false,false,false,true,false,442);
					itemAdd(36,1);
					itemAdd(21,1);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Яйцо #442 Спиритомб<br> Сияющий камень (1 шт.)<br> Камень рассвета (1 шт.)';
				}elseif($a >= 304 && $a <= 350){
					itemAdd(23,1);
					itemAdd(118,1);
					plusEgg(false,false,false,true,false,582);
					itemAdd(109,5);
					itemAdd(22,1);
					itemAdd(51,1);
					itemAdd(99,1);
					itemAdd(52,1);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Глубоководная чешуя<br> Порванная ткань<br> Магмарайзер<br> Протектор<br> Яйцо #582 Ваниллита<br> Генобол (5 шт.)';
				}elseif($a >= 351 && $a <= 400){
					itemAdd(23,1);
					itemAdd(118,1);
					plusEgg(false,false,false,true,false,551);
					itemAdd(105,1);
					itemAdd(109,5);
					itemAdd(96,1);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Глубоководная чешуя<br> Яйцо #551 Сандайл<br> Линзы (1 шт.)<br>Генобол (5 шт.)<br> Овальный камень (1 шт.)';
				}elseif($a >= 401 && $a <= 529){
					itemAdd(23,1);
					itemAdd(118,1);
					plusEgg(false,false,false,true,false,551);
					plusEgg(false,false,false,true,false,613);
					itemAdd(105,1);
					itemAdd(109,5);
					itemAdd(96,1);
					itemAdd(36,1);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Глубоководная чешуя<br> Яйцо #551 Сандайл<br> Линзы (1 шт.)<br> Генобол (5 шт.)<br> Овальный камень (1 шт.)<br> Сияющий камень (1 шт.)<br> Яйцо #613 Кабчу';
				}elseif($a >= 530 && $a <= 700){
					itemAdd(23,1);
					itemAdd(66,1);
					itemAdd(118,1);
					plusEgg(false,false,false,true,false,551);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Острый клык (1 шт.)<br> Яйцо #551 Сандайл';
				}elseif($a >= 701 && $a <= 803){
					itemAdd(23,1);
					itemAdd(118,1);
					plusEgg(false,false,false,true,false,551);
					itemAdd(105,1);
					itemAdd(109,5);
					itemAdd(66,1);
					itemAdd(98,1);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Острый клык (1 шт.)<br> Яйцо #551 Сандайл<br> Генобол (5 шт.)<br> Глубоководный зуб (1 шт.)<br> Линзы (1 шт.)';
				}elseif($a >= 804 && $a <= 955){
					itemAdd(23,1);
					itemAdd(118,1);
					plusEgg(false,false,false,true,false,551);
					plusEgg(false,false,false,true,false,592);
					plusEgg(false,false,false,true,false,582);
					itemAdd(66,1);
					itemAdd(19,1);
					$prize .= 'Рубиновый загадочный сундук (1 шт.)<br> Перламутровая чешуя (1 шт.)<br> Острый клык (1 шт.)<br> Яйцо #551 Сандайл<br> Яйцо #592 Фриллиш<br> Сумрачный камень (1 шт.)<br> Яйцо #582 Ваниллита';
				}
				
				if($e >= 1 && $e <= 100){
					plusEgg(false,false,false,true,false,366);
					$prize2 .= 'Яйцо #366 Кламперл';
				}elseif($e >= 101 && $e <= 200){
					plusEgg(false,false,false,true,false,349);
					$prize2 .= 'Яйцо #349 Фибас';
				}elseif($e >= 201 && $e <= 250){
					plusEgg(false,false,false,true,false,698);
					$prize2 .= 'Яйцо #698 Амаура';
				}elseif($e >= 201 && $e <= 250){
					plusEgg(false,false,false,true,false,239);
					$prize2 .= 'Яйцо #239 Эликед';
				}elseif($e >= 251 && $e <= 300){
					plusEgg(false,false,false,true,false,574);
					$prize2 .= 'Яйцо #574 Готита';
				}elseif($e >= 301 && $e <= 400){
					plusEgg(false,false,false,true,false,355);
					$prize2 .= 'Яйцо #355 Даскул';
				}elseif($e >= 401 && $e <= 600){
					plusEgg(false,false,false,true,false,451);
					$prize2 .= 'Яйцо #451 Скорупи';
				}elseif($e >= 601 && $e <= 800){
					plusEgg(false,false,false,true,false,712);
					$prize2 .= 'Яйцо #712 Бергмит';
				}elseif($e >= 800 && $e <= 10000){
					plusEgg(false,false,false,true,false,228);
					$prize2 .= 'Яйцо #228 Хондор';
				}
				plusEgg(false,false,false,true,false,506);
				$response['question'] .= 'Держи свой подарок за собранные Еловые ветки:<br> <b>'.$prize.'</b>. <br><br> И подарок за собранные украшения для Елки: <br> <b>'.$prize2.'</b><br><br>Всем помощникам вне зависимости от кол-ва веток и украшений выдается <b>#506 Лилипап</b>';
				quest_update(2018,1);
				}else{
					$response['question'] .= 'Ты уже получил подарок.';
				}
			}else{
				$response['question'] .= 'Вы не принимали участия в подготовке.';
			}
		break;
		default:
			$response['question'] = 'Спасибо за помощь в организации новогоднего мероприятия.. Ты только на эту елку погляди! Очаровательная. После Нового Года жди от меня подарочек за свои труды. <br> Ты сдал: <br>Украшение Шишка: <b>'.$ng['decoration1'].'</b><br>Украшение Сосулька: <b>'.$ng['decoration2'].'</b><br>Украшение Рокрафф: <b>'.$ng['decoration3'].'</b><br><br>Еловые ветки: <b>'.$ng['branches'].'</b>';
			$response['answer'] = array(
				1 => "Забрать подарок"
			);
		break;
	}
?>