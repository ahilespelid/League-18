<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$patch_func = $patch_project.'/inc/function/Functions.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
		require_once($patch_func);
    }
}
$type = clearInt($_POST["item"]);
$count = clearInt($_POST["count"]);
$recipe = $mysqli->query("SELECT * FROM `craft_recipe_user` WHERE `recipe` = '".$type."' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
$user = $mysqli->query("SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
switch ($type) {
		case 3:
			if(item_isset(143,1) && item_isset(127,$count) && item_isset(12,$count)){
				minus_item(127,$count);
				minus_item(12,$count);
				itemAdd(3,$count);
        $response['plus'] = '<img src="/img/world/items/little/3.png" class="item"> Покебол ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/127.png" class="item"> Железный слиток ('.$count.' шт.)<br><img src="/img/world/items/little/12.png" class="item"> Красный априкорн ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$i = 1;
				while ($i <= $count){
					$recipe1 = $mysqli->query('SELECT * FROM `craft_recipe_user` WHERE `recipe` = "4" AND `user` = '.$_SESSION['id'])->fetch_assoc();
					if(!$recipe1){
						$rand = rand(1,5);
						if($rand == 1){
							$mysqli->query("INSERT INTO `craft_recipe_user` (`user`,`recipe`) VALUES ('".$_SESSION['id']."',4) ");
							$response['html'] .= ' Вы выучили схему Гритбола.';
						}
					}
					$i++;
				}
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 196:
			if(item_isset(45,$count) && item_isset(46,$count) && item_isset(47,$count) && item_isset(48,$count) && item_isset(49,$count) && item_isset(50,$count)){
				minus_item(45,$count);
        minus_item(46,$count);
        minus_item(47,$count);
        minus_item(48,$count);
        minus_item(49,$count);
        minus_item(50,$count);
				itemAdd(196,$count);
        $response['plus'] = '<img src="/img/world/items/little/196.png" class="item"> Фруктовая смесь ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/45.png" class="item"> Фрукт Петунис ('.$count.' шт.)<br><img src="/img/world/items/little/46.png" class="item"> Фрукт Паяго ('.$count.' шт.)<br><img src="/img/world/items/little/47.png" class="item"> Фрукт Гриня ('.$count.' шт.)<br><img src="/img/world/items/little/48.png" class="item"> Фрукт Глусмус ('.$count.' шт.)<br><img src="/img/world/items/little/49.png" class="item"> Фрукт Шерк ('.$count.' шт.)<br><img src="/img/world/items/little/50.png" class="item"> Фрукт Тертий ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 4:
			if($recipe && item_isset(143,1) && item_isset(127,$count) && item_isset(14,$count)){
        minus_item(127,$count);
				minus_item(14,$count);
				itemAdd(4,$count);
        $response['plus'] = '<img src="/img/world/items/little/4.png" class="item"> Гритбол ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/127.png" class="item"> Железный слиток ('.$count.' шт.)<br><img src="/img/world/items/little/14.png" class="item"> Синий априкорн ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$i = 1;
				while ($i <= $count){
					$recipe1 = $mysqli->query('SELECT * FROM `craft_recipe_user` WHERE `recipe` = "6" AND `user` = '.$_SESSION['id'])->fetch_assoc();
					if(!$recipe1){
						$rand = rand(1,10);
						if($rand == 1){
							$mysqli->query("INSERT INTO `craft_recipe_user` (`user`,`recipe`) VALUES ('".$_SESSION['id']."',6) ");
							$response['html'] .= ' Вы выучили схему Ультрабола.';
						}
					}
					$i++;
				}
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 6:
			if($recipe && item_isset(143,1) && item_isset(127,$count) && item_isset(16,$count) && item_isset(11,$count)){
        minus_item(127,$count);
				minus_item(16,$count);
        minus_item(11,$count);
				itemAdd(6,$count);
        $response['plus'] = '<img src="/img/world/items/little/6.png" class="item"> Ультрабол ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/127.png" class="item"> Железный слиток ('.$count.' шт.)<br><img src="/img/world/items/little/11.png" class="item"> Черный априкорн ('.$count.' шт.)<br><img src="/img/world/items/little/16.png" class="item"> Желтый априкорн ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 217:
			if(item_isset(235,$count) && item_isset(212,$count)){
				minus_item(235,$count);
				minus_item(212,$count);
				itemAdd(217,$count);
        $response['plus'] = '<img src="/img/world/items/little/217.png" class="item"> Пирожное «Молодой дракон» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/212.png" class="item"> Пыль покемона дракона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 218:
			if(item_isset(235,$count) && item_isset(202,$count)){
				minus_item(235,$count);
				minus_item(202,$count);
				itemAdd(218,$count);
        $response['plus'] = '<img src="/img/world/items/little/218.png" class="item"> Пирожное «Разряд молний» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/202.png" class="item"> Пыль электрического покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 219:
			if(item_isset(235,$count) && item_isset(215,$count)){
				minus_item(235,$count);
				minus_item(215,$count);
				itemAdd(219,$count);
        $response['plus'] = '<img src="/img/world/items/little/219.png" class="item"> Пирожное «Волшебные бантики» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/215.png" class="item"> Пыль волшебного покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 220:
			if(item_isset(235,$count) && item_isset(216,$count)){
				minus_item(235,$count);
				minus_item(216,$count);
				itemAdd(220,$count);
        $response['plus'] = '<img src="/img/world/items/little/220.png" class="item"> Пирожное «Острые камушки» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/216.png" class="item"> Пыль каменного покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 221:
			if(item_isset(235,$count) && item_isset(206,$count)){
				minus_item(235,$count);
				minus_item(206,$count);
				itemAdd(221,$count);
        $response['plus'] = '<img src="/img/world/items/little/221.png" class="item"> Пирожное Пирожное «Льдинка» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/206.png" class="item"> Пыль ледяного покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 222:
			if(item_isset(235,$count) && item_isset(208,$count)){
				minus_item(235,$count);
				minus_item(208,$count);
				itemAdd(222,$count);
        $response['plus'] = '<img src="/img/world/items/little/222.png" class="item"> Пирожное «Легкое перо» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/208.png" class="item"> Пыль летающего покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 223:
			if(item_isset(235,$count) && item_isset(199,$count)){
				minus_item(235,$count);
				minus_item(199,$count);
				itemAdd(223,$count);
        $response['plus'] = '<img src="/img/world/items/little/223.png" class="item"> Пирожное «Лапка» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/199.png" class="item"> Пыль нормального покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 224:
			if(item_isset(235,$count) && item_isset(200,$count)){
				minus_item(235,$count);
				minus_item(200,$count);
				itemAdd(224,$count);
        $response['plus'] = '<img src="/img/world/items/little/224.png" class="item"> Пирожное «Горячая магма» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/200.png" class="item"> Пыль огненного покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 225:
			if(item_isset(235,$count) && item_isset(211,$count)){
				minus_item(235,$count);
				minus_item(211,$count);
				itemAdd(225,$count);
        $response['plus'] = '<img src="/img/world/items/little/225.png" class="item"> Пирожное «Заблудшие души» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/211.png" class="item"> Пыль призрачного покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 226:
			if(item_isset(235,$count) && item_isset(209,$count)){
				minus_item(235,$count);
				minus_item(209,$count);
				itemAdd(226,$count);
        $response['plus'] = '<img src="/img/world/items/little/226.png" class="item"> Пирожное «Психические импульсы» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/209.png" class="item"> Пыль психического покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 227:
			if(item_isset(235,$count) && item_isset(214,$count)){
				minus_item(235,$count);
				minus_item(214,$count);
				itemAdd(227,$count);
        $response['plus'] = '<img src="/img/world/items/little/227.png" class="item"> Пирожное «Шестеренки» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/214.png" class="item"> Пыль стального покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 228:
			if(item_isset(235,$count) && item_isset(213,$count)){
				minus_item(235,$count);
				minus_item(213,$count);
				itemAdd(228,$count);
        $response['plus'] = '<img src="/img/world/items/little/228.png" class="item"> Пирожное «Ночной туман» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/213.png" class="item"> Пыль темного покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 229:
			if(item_isset(235,$count) && item_isset(203,$count)){
				minus_item(235,$count);
				minus_item(203,$count);
				itemAdd(229,$count);
        $response['plus'] = '<img src="/img/world/items/little/229.png" class="item"> Пирожное «Зеленый лист» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/203.png" class="item"> Пыль травяного покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 230:
			if(item_isset(235,$count) && item_isset(201,$count)){
				minus_item(235,$count);
				minus_item(201,$count);
				itemAdd(230,$count);
        $response['plus'] = '<img src="/img/world/items/little/230.png" class="item"> Пирожное «Водное течение» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/201.png" class="item"> Пыль водного покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 231:
			if(item_isset(235,$count) && item_isset(207,$count)){
				minus_item(235,$count);
				minus_item(207,$count);
				itemAdd(231,$count);
        $response['plus'] = '<img src="/img/world/items/little/231.png" class="item"> Пирожное «Чума» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/207.png" class="item"> Пыль ядовитого покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 232:
			if(item_isset(235,$count) && item_isset(205,$count)){
				minus_item(235,$count);
				minus_item(205,$count);
				itemAdd(232,$count);
        $response['plus'] = '<img src="/img/world/items/little/232.png" class="item"> Пирожное «Подземелье» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/205.png" class="item"> Пыль земляного покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 233:
			if(item_isset(235,$count) && item_isset(210,$count)){
				minus_item(235,$count);
				minus_item(210,$count);
				itemAdd(233,$count);
        $response['plus'] = '<img src="/img/world/items/little/233.png" class="item"> Пирожное «Жужжание» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/210.png" class="item"> Пыль покемона жука ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 234:
			if(item_isset(235,$count) && item_isset(204,$count)){
				minus_item(235,$count);
				minus_item(204,$count);
				itemAdd(234,$count);
        $response['plus'] = '<img src="/img/world/items/little/234.png" class="item"> Пирожное «Уличная драка» ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/204.png" class="item"> Пыль боевого покемона ('.$count.' шт.)<br><img src="/img/world/items/little/235.png" class="item"> Мука ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 130:
			$count55 = $count * 10;
			if($recipe && item_isset(55,$count55) && item_isset(133,$count)){
				minus_item(55,$count55);
				itemAdd(93,$count);
        $response['plus'] = '<img src="/img/world/items/little/93.png" class="item"> Веревка ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/55.png" class="item"> Нитки ('.$count55.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 163:
			if(item_isset(165,$count) && item_isset(55,$count)){
				minus_item(165,$count);
				minus_item(55,$count);
				itemAdd(163,$count);
        $response['plus'] = '<img src="/img/world/items/little/163.png" class="item"> Прочные нитки ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/55.png" class="item"> Нитки ('.$count.' шт.)<br><img src="/img/world/items/little/165.png" class="item"> Сок из листьев Туртвига ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 29:
      $count13123 = $count * 5;
			if(item_isset(163,$count13123)){
				minus_item(163,$count13123);
				itemAdd(29,$count);
        $response['plus'] = '<img src="/img/world/items/little/29.png" class="item"> Зеленый шарф ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/163.png" class="item"> Прочные нитки ('.$count13123.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 265:
      $count13123 = $count * 3;
      $count13124 = $count * 5;
			if(item_isset(163,$count13123) && item_isset(199,$count13124)){
				minus_item(163,$count13123);
				minus_item(199,$count13124);
				itemAdd(265,$count);
        $response['plus'] = '<img src="/img/world/items/little/265.png" class="item"> Игрушка Пиджеот ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/163.png" class="item"> Прочные нитки ('.$count13123.' шт.)<br><img src="/img/world/items/little/199.png" class="item"> Пыль нормального покемона ('.$count13124.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 165:
			$count164 = $count * 5;
			if(item_isset(164,$count164)){
				minus_item(164,$count164);
				itemAdd(165,$count);
        $response['plus'] = '<img src="/img/world/items/little/165.png" class="item"> Сок из листьев Туртвига ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/164.png" class="item"> Лист Туртвига ('.$count164.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 144:
			$count127 = $count * 10;
			if($recipe && $user['location'] == 202 && item_isset(127,$count127)){
				minus_item(127,$count127);
				itemAdd(143,$count);
        $response['plus'] = '<img src="/img/world/items/little/143.png" class="item"> Априкорновый аппарат ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/127.png" class="item"> Железный слиток ('.$count127.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 154:
			if($recipe && $user['location'] == 15 && item_isset(91,$count) && item_isset(140,$count)){
				minus_item(91,$count);
				minus_item(140,$count);
				itemAdd(154,$count);
        $response['plus'] = '<img src="/img/world/items/little/154.png" class="item"> Заколдованный кислый леденец ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/140.png" class="item"> Кислый леденец ('.$count.' шт.)<br><img src="/img/world/items/little/91.png" class="item"> Призрачный цветок ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 155:
			if($recipe && $user['location'] == 15 && item_isset(91,$count) && item_isset(139,$count)){
				minus_item(91,$count);
				minus_item(139,$count);
				itemAdd(155,$count);
        $response['plus'] = '<img src="/img/world/items/little/155.png" class="item"> Заколдованный горький леденец ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/139.png" class="item"> Горький леденец ('.$count.' шт.)<br><img src="/img/world/items/little/91.png" class="item"> Призрачный цветок ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 127:
			if(item_isset(63,$count) && $user['location'] == 203){
				minus_item(63,$count);
				itemAdd(127,$count);
        $response['plus'] = '<img src="/img/world/items/little/127.png" class="item"> Железный слиток ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/63.png" class="item"> Железная руда ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$i = 1;
				while ($i <= $count){
					$recipe1 = $mysqli->query("SELECT * FROM `craft_recipe_user` WHERE `recipe` = '126' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
					if(!$recipe1){
						$rand = rand(1,20);
						if($rand == 1){
							$mysqli->query("INSERT INTO `craft_recipe_user` (`user`,`recipe`) VALUES ('".$_SESSION['id']."',126) ");
							$response['html'] .= ' Вы выучили схему Оловянного слитка.';
						}
					}
					$i++;
				}
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 120:
			if($recipe && item_isset(56,$count) && $user['location'] == 203){
				minus_item(56,$count);
				itemAdd(120,$count);
        $response['plus'] = '<img src="/img/world/items/little/120.png" class="item"> Обсидиановый слиток ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/56.png" class="item"> Обсидиановая руда ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 278:
      $count196 = $count * 3;
      $count68 = $count * 5;
			if($recipe && item_isset(196,$count196) && item_isset(68,$count68)){
				minus_item(196,$count196);
        minus_item(68,$count68);
				itemAdd(278,$count);
        $response['minus'] = '<img src="/img/world/items/little/68.png" class="item"> Острый перец ('.$count68.' шт.)<br><img src="/img/world/items/little/196.png" class="item"> Фруктовая смесь ('.$count196.' шт.)';
        $response['plus'] = '<img src="/img/world/items/little/278.png" class="item"> Зелье понижения классификации ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 279:
      $count11 = $count * 10;
      $count12 = $count * 10;
      $count10 = $count * 10;
			if($recipe && item_isset(10,$count10) && item_isset(11,$count11) && item_isset(12,$count12)){
        minus_item(10,$count10);
        minus_item(11,$count11);
        minus_item(12,$count12);
				itemAdd(279,$count);
        $response['minus'] = '<img src="/img/world/items/little/10.png" class="item"> Белый априкорн ('.$count10.' шт.)<br><img src="/img/world/items/little/11.png" class="item"> Черный априкорн ('.$count11.' шт.)<br><img src="/img/world/items/little/12.png" class="item"> Красный априкорн ('.$count12.' шт.)';
        $response['plus'] = '<img src="/img/world/items/little/279.png" class="item"> Зелье из априкорнов ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 126:
			if($recipe && item_isset(62,$count) && $user['location'] == 203){
				minus_item(62,$count);
				itemAdd(126,$count);
        $response['plus'] = '<img src="/img/world/items/little/126.png" class="item"> Оловяный слиток ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/62.png" class="item"> Оловяная руда ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
        $i = 1;
				while ($i <= $count){
					$recipe1 = $mysqli->query("SELECT * FROM `craft_recipe_user` WHERE `recipe` = '120' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
					if(!$recipe1){
						$rand = rand(1,20);
						if($rand == 1){
							$mysqli->query("INSERT INTO `craft_recipe_user` (`user`,`recipe`) VALUES ('".$_SESSION['id']."',120) ");
							$response['html'] .= ' Вы выучили схему Обсидианового слитка.';
						}
					}
					$i++;
				}
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 170:
			$count169 = $count * 3;
			if(item_isset(169,$count169)){
				minus_item(169,$count169);
				itemAdd(170,$count);
        $response['plus'] = '<img src="/img/world/items/little/170.png" class="item"> Отвар от негативного состояния ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/169.png" class="item"> Красная лилия ('.$count169.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 1099:
      $count215 = $count * 20;
      $count277 = $count * 15;
			if(item_isset(276, $count) && item_isset(215,$count215) && item_isset(277,$count277) && $user['location'] == 203){
				minus_item(276,$count);
        minus_item(215,$count215);
        minus_item(277,$count277);
				itemAdd(1099,$count);
        $response['plus'] = '<img src="/img/world/items/little/170.png" class="item"> Отвар от негативного состояния ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/276.png" class="item"> Каркас тренировочной машины ('.$count.' шт.)<br><img src="/img/world/items/little/215.png" class="item"> Пыль волшебного покемона ('.$count215.' шт.)<br><img src="/img/world/items/little/277.png" class="item"> Гайка Магнимайта ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
    case 276:
			$count140 = $count * 10;
			$count126 = $count * 10;
			if(item_isset(126, $count126) && item_isset(127,$count140) && item_isset(120,$count) && item_isset(163,$count) && $user['location'] == 203){
				minus_item(126,$count126);
				minus_item(127,$count140);
        minus_item(120,$count);
        minus_item(163,$count);
				itemAdd(276,$count);
        $response['plus'] = '<img src="/img/world/items/little/276.png" class="item"> Каркас тренировочный машины ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/126.png" class="item"> Оловянный слиток ('.$count126.' шт.)<br><img src="/img/world/items/little/127.png" class="item"> Железный слиток ('.$count140.' шт.)<br><img src="/img/world/items/little/120.png" class="item"> Обсидиановый слиток ('.$count.' шт.)<br><img src="/img/world/items/little/163.png" class="item"> Прочные нитки ('.$count.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 69:
			$count140 = $count * 10;
			$count126 = $count * 3;
			if(item_isset(126, $count126) && item_isset(127,$count140) && $user['location'] == 203){
				minus_item(126,$count126);
				minus_item(127,$count140);
				itemAdd(69,$count);
        $response['plus'] = '<img src="/img/world/items/little/69.png" class="item"> Часть брони ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/126.png" class="item"> Оловянный слиток ('.$count126.' шт.)<br><img src="/img/world/items/little/127.png" class="item"> Железный слиток ('.$count140.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 107:
			$count333 = $count * 1;
			$count69 = $count * 1;
			$count120 = $count * 1;
			if(item_isset(120, $count120) && item_isset(69,$count69) && item_isset(333,$count333) && $user['location'] == 203){
				minus_item(120,$count120);
				minus_item(69,$count69);
				minus_item(333,$count333);
				itemAdd(107,$count);
        $response['plus'] = '<img src="/img/world/items/little/107.png" class="item"> Скобовое кольцо ('.$count.' шт.)';
        $response['minus'] = '<img src="/img/world/items/little/120.png" class="item"> Обсидиановый слиток ('.$count120.' шт.)<br><img src="/img/world/items/little/69.png" class="item"> Часть брони ('.$count69.' шт.)<br><img src="/img/world/items/little/333.png" class="item"> Сломанное скобовое кольцо ('.$count333.' шт.)';
				$response['html'] .= 'Вы удачно скрафтили предмет.';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		case 141:
			if($recipe && item_isset(31,$count) && $user['location'] == 200){
				minus_item(31, $count);
				$response['html'] .= 'Вы удачно скрафтили предмет.';
        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
        $e = 0;
				$i = 1;
				while ($i <= $count){
					$rand = rand(1,5);
					if($rand == 1){
            $a = $a + 1;
						itemAdd(136,1);
					}elseif($rand == 2){
						itemAdd(137,1);
            $b = $b + 1;
					}elseif($rand == 3){
						itemAdd(138,1);
            $c = $c + 1;
					}elseif($rand == 4){
						itemAdd(139,1);
            $d = $d + 1;
					}elseif($rand == 5){
						itemAdd(140,1);
            $e = $e + 1;
					}
					$i++;
				}
        $response['plus'] .= ($a > 0 ? '<img src="/img/world/items/little/136.png" class="item"> Мятный леденец ('.$a.' шт.)<br>' : '');
        $response['plus'] .= ($b > 0 ? '<img src="/img/world/items/little/137.png" class="item"> Шоколадный леденец ('.$b.' шт.)<br>' : '');
        $response['plus'] .= ($c > 0 ? '<img src="/img/world/items/little/138.png" class="item"> Карамельный леденец ('.$c.' шт.)<br>' : '');
        $response['plus'] .= ($d > 0 ? '<img src="/img/world/items/little/139.png" class="item"> Горький леденец ('.$d.' шт.)<br>' : '');
        $response['plus'] .= ($e > 0 ? '<img src="/img/world/items/little/140.png" class="item"> Кислый леденец ('.$e.' шт.)<br>' : '');
        $response['minus'] = '<img src="/img/world/items/little/31.png" class="item"> Леденец в форме Торчика ('.$count.' шт.)';
				$response['error'] = 'success';
			}else{
				$response['html'] = 'Условия крафта не соблюдены.';
				$response['error'] = 'error';
			}
		break;
		default:
			echo "Unknown error";
		break;
	}
echo json_encode($response);
?>
