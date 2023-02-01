<?php

	$response['name'] = 'Паренек в разноцветной шляпе';
	 switch($npcStep){
		 case 1:
		 	$response['question'] = '{{makasimka}}';
		 	$response['npc_id'] = 152;
		 break;
		 case 2:
		 $response['question'] = 'Выберите стоимость яйца.';
		 $response['answer'] = array(
			 3 => 'От 1 до 300 пыли',
			 4 => 'От 301 до 600 пыли',
			 5 => 'От 601 до 1000 пыли',
			 6 => 'От 1001 до 1500 пыли',
			 7 => 'Более 1500 пыли'
		 );
		 break;
		 case 3:
		 $response['question'] = 'Выбирай! Кстати, покемоны вылупятся спаренными, непередаваемыми.<br><i>~Вы сразу купите покемона, если нажмете на кнопку. Не промахнитесь и подумайте тщательно, что вам нужно.~</i>';
		 $response['answer'] = array(
			 114 => 'Купить #114 Танжела за 100 пыли',
			 170 => 'Купить #170 Чинчоу за 150 пыли',
			 522 => 'Купить #522 Блитзл за 150 пыли',
			 527 => 'Купить #527 Вубат за 200 пыли',
			 590 => 'Купить #590 Фунгус за 200 пыли',
			 2 => 'Назад к выбору цен'
		 );
		 break;
		 case 4:
		 $response['question'] = 'Выбирай! Кстати, покемоны вылупятся спаренными, непередаваемыми.<br><i>~Вы сразу купите покемона, если нажмете на кнопку. Не промахнитесь и подумайте тщательно, что вам нужно.~</i>';
		 $response['answer'] = array(
			 123 => 'Купить #123 Сайтер за 350 пыли',
			 410 => 'Купить #410 Шелдон за 400 пыли',
			 408 => 'Купить #408 Кранидос за 450 пыли',
			 538 => 'Купить #538 Тро за 500 пыли',
			 539 => 'Купить #539 Соук за 500 пыли',
			 108 => 'Купить #108 Ликитунг за 550 пыли',
			 667 => 'Купить #667 Литлео за 600 пыли',
			 2 => 'Назад к выбору цен'
		 );
		 break;
		 case 5:
		 $response['question'] = 'Выбирай! Кстати, покемоны вылупятся спаренными, непередаваемыми.<br><i>~Вы сразу купите покемона, если нажмете на кнопку. Не промахнитесь и подумайте тщательно, что вам нужно.~</i>';
		 $response['answer'] = array(
			 133 => 'Купить #133 Иви за 800 пыли',
			 79 => 'Купить #079 Слоупок за 700 пыли',
			 227 => 'Купить #227 Скармори за 650 пыли',
			 442 => 'Купить #442 Спиритомб за 650 пыли',
			 355 => 'Купить #355 Даскул за 650 пыли',
			 241 => 'Купить #241 Милтанк за 700 пыли',
			 2 => 'Назад к выбору цен'
		 );
		 break;
		 case 6:
		 $response['question'] = 'Выбирай! Кстати, покемоны вылупятся спаренными, непередаваемыми.<br><i>~Вы сразу купите покемона, если нажмете на кнопку. Не промахнитесь и подумайте тщательно, что вам нужно.~</i>';
		 $response['answer'] = array(
			 669 => 'Купить #669 Флабэбэ за 1200 пыли',
			 228 => 'Купить #228 Хондор за 1200 пыли',
			 551 => 'Купить #551 Сандайл за 1200 пыли',
			 529 => 'Купить #529 Дриллбур за 1400 пыли',
			 2 => 'Назад к выбору цен'
		 );
		 break;
		 case 7:
		 $response['question'] = 'Выбирай! Кстати, покемоны вылупятся спаренными, непередаваемыми.<br><i>~Вы сразу купите покемона, если нажмете на кнопку. Не промахнитесь и подумайте тщательно, что вам нужно.~</i>';
		 $response['answer'] = array(
			 371 => 'Купить #371 Багон за 1700 пыли',
			 2 => 'Назад к выбору цен'
		 );
		 break;
		 case 114:
		 	if(item_isset(108,100)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (100 шт.)';
				plusEgg(false,false,false,false,false,114,true);
				minus_item(108,100);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 170:
		 	if(item_isset(108,150)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (150 шт.)';
				plusEgg(false,false,false,false,false,170,true);
				minus_item(108,150);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 522:
		 	if(item_isset(108,150)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (150 шт.)';
				plusEgg(false,false,false,false,false,522,true);
				minus_item(108,150);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 108:
		 	if(item_isset(108,550)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (550 шт.)';
				plusEgg(false,false,false,false,false,108,true);
				minus_item(108,550);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 123:
		 	if(item_isset(108,350)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (350 шт.)';
				plusEgg(false,false,false,false,false,123,true);
				minus_item(108,350);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 410:
		 	if(item_isset(108,400)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (400 шт.)';
				plusEgg(false,false,false,false,false,410,true);
				minus_item(108,400);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 538:
		 	if(item_isset(108,500)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (500 шт.)';
				plusEgg(false,false,false,false,false,538,true);
				minus_item(108,500);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 539:
		 	if(item_isset(108,500)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (500 шт.)';
				plusEgg(false,false,false,false,false,539,true);
				minus_item(108,500);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 667:
		 	if(item_isset(108,600)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (600 шт.)';
				plusEgg(false,false,false,false,false,667,true);
				minus_item(108,600);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 79:
		 	if(item_isset(108,700)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (700 шт.)';
				plusEgg(false,false,false,false,false,79,true);
				minus_item(108,700);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 133:
		 	if(item_isset(108,800)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (800 шт.)';
				plusEgg(false,false,false,false,false,133,true);
				minus_item(108,800);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 227:
		 	if(item_isset(108,650)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (650 шт.)';
				plusEgg(false,false,false,false,false,227,true);
				minus_item(108,650);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 241:
		 	if(item_isset(108,700)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (700 шт.)';
				plusEgg(false,false,false,false,false,241,true);
				minus_item(108,700);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 355:
		 	if(item_isset(108,650)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (650 шт.)';
				plusEgg(false,false,false,false,false,355,true);
				minus_item(108,650);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 442:
		 	if(item_isset(108,650)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (650 шт.)';
				plusEgg(false,false,false,false,false,442,true);
				minus_item(108,650);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 228:
		 	if(item_isset(108,1200)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (1200 шт.)';
				plusEgg(false,false,false,false,false,228,true);
				minus_item(108,1200);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 529:
		 	if(item_isset(108,1400)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (1400 шт.)';
				plusEgg(false,false,false,false,false,529,true);
				minus_item(108,1400);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 551:
		 	if(item_isset(108,1200)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (1200 шт.)';
				plusEgg(false,false,false,false,false,551,true);
				minus_item(108,1200);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 669:
		 	if(item_isset(108,1200)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (1200 шт.)';
				plusEgg(false,false,false,false,false,669,true);
				minus_item(108,1200);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 371:
		 	if(item_isset(108,1700)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (1700 шт.)';
				plusEgg(false,false,false,false,false,371,true);
				minus_item(108,1700);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 408:
		 	if(item_isset(108,450)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (450 шт.)';
				plusEgg(false,false,false,false,false,408,true);
				minus_item(108,450);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 527:
		 	if(item_isset(108,200)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (200 шт.)';
				plusEgg(false,false,false,false,false,527,true);
				minus_item(108,200);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 case 590:
		 	if(item_isset(108,200)) {
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (200 шт.)';
				plusEgg(false,false,false,false,false,590,true);
				minus_item(108,200);
				$response['question'] = 'Держи свою награду!';
			}else{
				$response['question'] = 'Не хватает разноцветной пыли.';
			}
		 break;
		 default:
			 $response['question'] = 'Добро пожаловать на ярмарку! Веселись! У меня можно обменять разноцветную пыль на различные товары. Эту пыль можно достать почти везде - на ярмарке, вне ярмарки. Так что собирай больше пыли, чтобы получить больше призов!';
			 $response['answer'] = array(
				 'by' => ['title'=>'Купить предметы', 'npc_id'=>152],
				 2 => 'Купить яйца покемонов'
			 );
		 break;
   }
?>
