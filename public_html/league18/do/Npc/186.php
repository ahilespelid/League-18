<?php
	$response['name'] = 'Лотерейщик';
	switch($npcStep){
		case 1:
		// if(item_isset(1,20000)) {
		// 	$response['question'] = 'Вы купили 1 билет. Удачи!';
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	minus_item(1,20000);
		// 	$response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (20000 шт.)';
		// }else{
		// 	$response['question'] = 'Недостаточно средств.';
		// }
		// $response['answer'] = [
		// 						1=>'Купить 1 билет',
		// 						2=>'Купить 5 билетов',
		// 						3=>'Купить 10 билетов',
		// 						4=>'Посмотреть список призов',
		// 						5=>'Какие номера билетов у меня?'
		// 					];
		$response['question'] = 'Продажа билетов окончена.';
		break;
		case 2:
		// if(item_isset(1,100000)) {
		// 	$response['question'] = 'Вы купили 5 билетов. Удачи!';
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	minus_item(1,100000);
		// 	$response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (100000 шт.)';
		// }else{
		// 	$response['question'] = 'Недостаточно средств.';
		// }
		// $response['answer'] = [
		// 						1=>'Купить 1 билет',
		// 						2=>'Купить 5 билетов',
		// 						3=>'Купить 10 билетов',
		// 						4=>'Посмотреть список призов',
		// 						5=>'Какие номера билетов у меня?'
		// 					];
		$response['question'] = 'Продажа билетов окончена.';
		break;
		case 3:
		// if(item_isset(1,200000)) {
		// 	$response['question'] = 'Вы купили 10 билетов. Удачи!';
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	$mysqli->query("INSERT INTO `lotery` (`user`) VALUES ('".$_SESSION['id']."') ");
		// 	minus_item(1,200000);
		// 	$response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (200000 шт.)';
		// }else{
		// 	$response['question'] = 'Недостаточно средств.';
		// }
		// $response['answer'] = [
		// 						1=>'Купить 1 билет',
		// 						2=>'Купить 5 билетов',
		// 						3=>'Купить 10 билетов',
		// 						4=>'Посмотреть список призов',
		// 						5=>'Какие номера билетов у меня?'
		// 					];
		$response['question'] = 'Продажа билетов окончена.';
		break;
		case 5:
			$countAll = $mysqli->query('SELECT * FROM `lotery` WHERE `user` = '.$_SESSION['id']);
			if(!empty($countAll)) {
				$response['question'] .= 'Ваши билеты с номерами:';
				while($lot = $countAll->fetch_assoc()) {
					$response['question'] .= ' <span class="bgPok">'.$lot['id'].'</span> ';
				}
			}else{
				$response['question'] = 'Вы еще не покупали билетов.';
			}
			$response['answer'] = [
									//1=>'Купить 1 билет',
									//2=>'Купить 5 билетов',
									//3=>'Купить 10 билетов',
									4=>'Посмотреть список призов',
									5=>'Какие номера билетов у меня?',
									6=>'Список победителей'
								];
		break;
		case 6:
			$response['question'] = 'Победители:<br>
Генобол (5 шт.) - 9<br>
#519 Пидов - 11<br>
#656 Фроаки - 32<br>
#393 Пиплап - 50<br>
Тм 25 - Гроза - 56<br>
#498 Тепиг - 63<br>
#004 Чармандер - 116<br>
Блестки - 168<br>
#007 Сквиртл - 169<br>
#333 Сваблу - 132<br>
Набор классификаций (3 шт.) - 134<br>
#650 Чеспин - 150<br>
Солнечный камень - 156<br>
#193 Янма - 161<br>
Электрайзер - 192<br>
#369 Реликант - 197<br>
#682 Спритзи - 211<br>
#175 Тогепи - 212<br>
Лупа - 213<br>
#501 Ошавот - 218<br>
#390 Чимчар - 246<br>
Глубоководная чешуя - 294<br>
#258 Мадкип - 321<br>
Корона - 333<br>
Инкубатор - 349<br>
Магмарайзер - 357<br>
Тм 12 - Насмешка - 377<br>
Протектор - 381<br>
Инкубатор - 390<br>
Объедки - 440<br>
#152 Чикорита - 444<br>
#574 Готита - 451<br>
#252 Трико - 499<br>
Тм 03 - Психический шок - 508<br>
Линзы - 512<br>
#495 Снайви - 525<br>
#280 Ралтс - 548<br>
#158 Тотодайл - 559<br>
Чешуя дракона - 564<br>
#653 Феннекин - 581<br>
Тм 06 - Отравление - 604<br>
#328 Трапинч - 623<br>
#001 Бульбазавр - 631<br>
#540 Сивадл - 668<br>
#170 Чинчоу - 682<br>
#613 Кабчу - 701<br>
Мастербол (5 шт.) - 714<br>
#231 Фанпи - 793<br>
#441 Чатот - 810<br>
#387 Туртвиг - 814<br>
#255 Торчик - 827<br>
#155 Синтаквил - 832<br>
Расветный камень - 837<br>
#079 Слоупок - 861<br>
#427 Банири - 876<br>
Загадочная флейта - 894<br>
			';
		break;
		case 4:
			$response['question'] .= 'Все покемоны выдаются в яйцах. После вылупления спаренные, с уникальным окрасом, случайным характером, непередаваемые, с генами 25 - 30. Список призов:<br>
			<span class="bgPok" onclick="openDex(1)"><img src="/img/pokemons/anim/normal/1.gif"> #001 Бульбазавр</span>
			<span class="bgPok" onclick="openDex(4)"><img src="/img/pokemons/anim/normal/4.gif"> #004 Чармандер</span>
			<span class="bgPok" onclick="openDex(7)"><img src="/img/pokemons/anim/normal/7.gif"> #007 Сквиртл</span>
			<span class="bgPok" onclick="openDex(152)"><img src="/img/pokemons/anim/normal/152.gif"> #152 Чикорита</span>
			<span class="bgPok" onclick="openDex(155)"><img src="/img/pokemons/anim/normal/155.gif"> #155 Синтаквил</span>
			<span class="bgPok" onclick="openDex(158)"><img src="/img/pokemons/anim/normal/158.gif"> #158 Тотодайл</span>
			<span class="bgPok" onclick="openDex(252)"><img src="/img/pokemons/anim/normal/252.gif"> #252 Трико</span>
			<span class="bgPok" onclick="openDex(255)"><img src="/img/pokemons/anim/normal/255.gif"> #255 Торчик</span>
			<span class="bgPok" onclick="openDex(258)"><img src="/img/pokemons/anim/normal/258.gif"> #258 Мадкип</span>
			<span class="bgPok" onclick="openDex(328)"><img src="/img/pokemons/anim/normal/328.gif"> #328 Трапинч</span>
			<span class="bgPok" onclick="openDex(393)"><img src="/img/pokemons/anim/normal/393.gif"> #393 Пиплап</span>
			<span class="bgPok" onclick="openDex(390)"><img src="/img/pokemons/anim/normal/390.gif"> #390 Чимчар</span>
			<span class="bgPok" onclick="openDex(387)"><img src="/img/pokemons/anim/normal/387.gif"> #387 Туртвиг</span>
			<span class="bgPok" onclick="openDex(495)"><img src="/img/pokemons/anim/normal/495.gif"> #495 Снайви</span>
			<span class="bgPok" onclick="openDex(498)"><img src="/img/pokemons/anim/normal/498.gif"> #498 Тепиг</span>
			<span class="bgPok" onclick="openDex(501)"><img src="/img/pokemons/anim/normal/501.gif"> #501 Ошавот</span>
			<span class="bgPok" onclick="openDex(656)"><img src="/img/pokemons/anim/normal/656.gif"> #656 Фроаки</span>
			<span class="bgPok" onclick="openDex(653)"><img src="/img/pokemons/anim/normal/653.gif"> #653 Феннекин</span>
			<span class="bgPok" onclick="openDex(650)"><img src="/img/pokemons/anim/normal/650.gif"> #650 Чеспин</span>
			<span class="bgPok" onclick="openDex(427)"><img src="/img/pokemons/anim/normal/427.gif"> #427 Банири</span>
			<span class="bgPok" onclick="openDex(193)"><img src="/img/pokemons/anim/normal/193.gif"> #193 Янма</span>
			<span class="bgPok" onclick="openDex(682)"><img src="/img/pokemons/anim/normal/682.gif"> #682 Спритзи</span>
			<span class="bgPok" onclick="openDex(369)"><img src="/img/pokemons/anim/normal/369.gif"> #369 Реликант</span>
			<span class="bgPok" onclick="openDex(170)"><img src="/img/pokemons/anim/normal/170.gif"> #170 Чинчоу</span>
			<span class="bgPok" onclick="openDex(574)"><img src="/img/pokemons/anim/normal/574.gif"> #574 Готита</span>
			<span class="bgPok" onclick="openDex(333)"><img src="/img/pokemons/anim/normal/333.gif"> #333 Сваблу</span>
			<span class="bgPok" onclick="openDex(540)"><img src="/img/pokemons/anim/normal/540.gif"> #540 Сивадл</span>
			<span class="bgPok" onclick="openDex(441)"><img src="/img/pokemons/anim/normal/441.gif"> #441 Чатот</span>
			<span class="bgPok" onclick="openDex(519)"><img src="/img/pokemons/anim/normal/519.gif"> #519 Пидов</span>
			<span class="bgPok" onclick="openDex(613)"><img src="/img/pokemons/anim/normal/613.gif"> #613 Кабчу</span>
			<span class="bgPok" onclick="openDex(231)"><img src="/img/pokemons/anim/normal/231.gif"> #231 Фанпи</span>
			<span class="bgPok" onclick="openDex(175)"><img src="/img/pokemons/anim/normal/175.gif"> #175 Тогепи</span>
			<span class="bgPok" onclick="openDex(79)"><img src="/img/pokemons/anim/normal/79.gif"> #079 Слоупок</span>
			<span class="bgPok" onclick="openDex(280)"><img src="/img/pokemons/anim/normal/280.gif"> #280 Ралтс</span>
			<br><br>
			<div class="itemIsset" onclick=issetAll(21,"item") style="background-image: url(/img/world/items/little/21.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(20,"item") style="background-image: url(/img/world/items/little/20.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(5,"item") style="background-image: url(/img/world/items/little/5.png)"></div> x5,
			<div class="itemIsset" onclick=issetAll(2,"item") style="background-image: url(/img/world/items/little/2.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(51,"item") style="background-image: url(/img/world/items/little/51.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(52,"item") style="background-image: url(/img/world/items/little/52.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(53,"item") style="background-image: url(/img/world/items/little/53.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(72,"item") style="background-image: url(/img/world/items/little/72.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(95,"item") style="background-image: url(/img/world/items/little/95.png)"></div> x3,
			<div class="itemIsset" onclick=issetAll(99,"item") style="background-image: url(/img/world/items/little/99.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(100,"item") style="background-image: url(/img/world/items/little/100.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(103,"item") style="background-image: url(/img/world/items/little/103.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(104,"item") style="background-image: url(/img/world/items/little/104.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(105,"item") style="background-image: url(/img/world/items/little/105.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(106,"item") style="background-image: url(/img/world/items/little/106.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(109,"item") style="background-image: url(/img/world/items/little/109.png)"></div> x5,
			<div class="itemIsset" onclick=issetAll(275,"item") style="background-image: url(/img/world/items/little/275.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(1006,"item") style="background-image: url(/img/world/items/little/1006.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(1012,"item") style="background-image: url(/img/world/items/little/1012.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(1003,"item") style="background-image: url(/img/world/items/little/1003.png)"></div> x1,
			<div class="itemIsset" onclick=issetAll(1025,"item") style="background-image: url(/img/world/items/little/1025.png)"></div> x1
			';
			$response['answer'] = [
									//1=>'Купить 1 билет',
									//2=>'Купить 5 билетов',
									//3=>'Купить 10 билетов',
									4=>'Посмотреть список призов',
									5=>'Какие номера билетов у меня?',
									6=>'Список победителей'
								];
		break;
		default:
				$response['question'] = 'Доброго времени суток, тренер! Мы проводим лотерею, где даем всем тренерам шанс получить интересные призы! Один лотерейный билет стоит <b>20.000</b> монет. Лотерея будет проведена 30 сентября Администрацией проекта.';
				 $response['answer'] = [
										 //1=>'Купить 1 билет',
										 //2=>'Купить 5 билетов',
										 //3=>'Купить 10 билетов',
										 4=>'Посмотреть список призов',
										 5=>'Какие номера билетов у меня?',
										 6=>'Список победителей'
									 ];
		break;
	}
?>
