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
$type = $_POST["category"];
switch ($type) {
		case 'cookery':
			$response['html'] = '<div class="CraftObject '.recipeCheck(141).'" onclick="craftCategory(141,1)">
									<div class="CraftImg" onclick="issetAll(142,\'item\')" style="background-image: url(/img/world/items/little/142.png);"></div>
										<div class="Name">Вкусный леденец</div>
									</div>
                  <div class="CraftCtgText">~ Пирожные ~</div>
                  <div class="CraftObject" onclick="craftCategory(217,1)">
                  <div class="CraftImg" onclick="issetAll(217,\'item\')" style="background-image: url(/img/world/items/little/217.png);"></div>
										<div class="Name">Пирожное «Молодой дракон»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(218,1)">
                  <div class="CraftImg" onclick="issetAll(218,\'item\')" style="background-image: url(/img/world/items/little/218.png);"></div>
										<div class="Name">Пирожное «Разряд молний»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(219,1)">
                  <div class="CraftImg" onclick="issetAll(219,\'item\')" style="background-image: url(/img/world/items/little/219.png);"></div>
										<div class="Name">Пирожное «Волшебные бантики»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(220,1)">
                  <div class="CraftImg" onclick="issetAll(220,\'item\')" style="background-image: url(/img/world/items/little/220.png);"></div>
										<div class="Name">Пирожное «Острые камушки»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(221,1)">
                  <div class="CraftImg" onclick="issetAll(221,\'item\')" style="background-image: url(/img/world/items/little/221.png);"></div>
										<div class="Name">Пирожное «Льдинка»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(222,1)">
                  <div class="CraftImg" onclick="issetAll(222,\'item\')" style="background-image: url(/img/world/items/little/222.png);"></div>
										<div class="Name">Пирожное «Легкое перо»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(223,1)">
                  <div class="CraftImg" onclick="issetAll(223,\'item\')" style="background-image: url(/img/world/items/little/223.png);"></div>
										<div class="Name">Пирожное «Лапка»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(224,1)">
                  <div class="CraftImg" onclick="issetAll(224,\'item\')" style="background-image: url(/img/world/items/little/224.png);"></div>
										<div class="Name">Пирожное «Горячая магма»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(225,1)">
                  <div class="CraftImg" onclick="issetAll(225,\'item\')" style="background-image: url(/img/world/items/little/225.png);"></div>
										<div class="Name">Пирожное «Заблудшие души»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(226,1)">
                  <div class="CraftImg" onclick="issetAll(226,\'item\')" style="background-image: url(/img/world/items/little/226.png);"></div>
										<div class="Name">Пирожное «Психические импульсы»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(227,1)">
                  <div class="CraftImg" onclick="issetAll(227,\'item\')" style="background-image: url(/img/world/items/little/227.png);"></div>
										<div class="Name">Пирожное «Шестеренки»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(228,1)">
                  <div class="CraftImg" onclick="issetAll(228,\'item\')" style="background-image: url(/img/world/items/little/228.png);"></div>
										<div class="Name">Пирожное «Ночной туман»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(229,1)">
                  <div class="CraftImg" onclick="issetAll(229,\'item\')" style="background-image: url(/img/world/items/little/229.png);"></div>
										<div class="Name">Пирожное «Зеленый лист»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(230,1)">
                  <div class="CraftImg" onclick="issetAll(230,\'item\')" style="background-image: url(/img/world/items/little/230.png);"></div>
										<div class="Name">Пирожное «Водное течение»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(231,1)">
                  <div class="CraftImg" onclick="issetAll(231,\'item\')" style="background-image: url(/img/world/items/little/231.png);"></div>
										<div class="Name">Пирожное «Чума»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(232,1)">
                  <div class="CraftImg" onclick="issetAll(232,\'item\')" style="background-image: url(/img/world/items/little/232.png);"></div>
										<div class="Name">Пирожное «Подземелье»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(233,1)">
                  <div class="CraftImg" onclick="issetAll(233,\'item\')" style="background-image: url(/img/world/items/little/233.png);"></div>
										<div class="Name">Пирожное «Жужжание»</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(234,1)">
                  <div class="CraftImg" onclick="issetAll(234,\'item\')" style="background-image: url(/img/world/items/little/234.png);"></div>
										<div class="Name">Пирожное «Уличная драка»</div>
									</div>';
		break;
		case 'alchemy':
			$response['html'] = '<div class="CraftObject" onclick="craftCategory(165,1)">
									<div class="CraftImg" onclick="issetAll(165,\'item\')" style="background-image: url(/img/world/items/little/165.png);"></div>
										<div class="Name">Сок из листьев Туртвига</div>
									</div>
									<div class="CraftObject" onclick="craftCategory(170,1)">
									<div class="CraftImg" onclick="issetAll(170,\'item\')" style="background-image: url(/img/world/items/little/170.png);"></div>
										<div class="Name">Отвар от негативного состояния</div>
									</div>
                  <div class="CraftCtgText">~ Зелья ~</div>
                  <div class="CraftObject '.recipeCheck(278).'" onclick="craftCategory(278,1)">
									<div class="CraftImg" onclick="issetAll(278,\'item\')" style="background-image: url(/img/world/items/little/278.png);"></div>
										<div class="Name">Зелье понижения классификации</div>
									</div>
                  <div class="CraftObject '.recipeCheck(279).'" onclick="craftCategory(279,1)">
									<div class="CraftImg" onclick="issetAll(279,\'item\')" style="background-image: url(/img/world/items/little/279.png);"></div>
										<div class="Name">Зелье из априкорнов</div>
									</div>
                  <div class="CraftCtgText">~ Духи ~</div>
                  ';
		break;
		case 'sewing':
			$response['html'] = '<div class="CraftObject '.recipeCheck(130).'" onclick="craftCategory(130,1)">
									<div class="CraftImg" onclick="issetAll(93,\'item\')" style="background-image: url(/img/world/items/little/93.png);"></div>
										<div class="Name">Веревка</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(163,1)">
									<div class="CraftImg" onclick="issetAll(163,\'item\')" style="background-image: url(/img/world/items/little/163.png);"></div>
										<div class="Name">Прочные нитки</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(265,1)">
									<div class="CraftImg" onclick="issetAll(265,\'item\')" style="background-image: url(/img/world/items/little/265.png);"></div>
										<div class="Name">Игрушка Пиджеот</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(29,1)">
									<div class="CraftImg" onclick="issetAll(29,\'item\')" style="background-image: url(/img/world/items/little/29.png);"></div>
										<div class="Name">Зеленый шарф</div>
									</div>
									';
		break;
		case 'engineering':
			$response['html'] = '<div class="CraftObject '.recipeCheck(144).'" onclick="craftCategory(144,1)">
									<div class="CraftImg" onclick="issetAll(143,\'item\')" style="background-image: url(/img/world/items/little/143.png);"></div>
										<div class="Name">Априкорновый аппарат</div>
									</div>
									<br>
									<div class="CraftObject" onclick="craftCategory(127,1)">
									<div class="CraftImg" onclick="issetAll(127,\'item\')" style="background-image: url(/img/world/items/little/127.png);"></div>
										<div class="Name">Железный слиток</div>
									</div>
                  <div class="CraftObject '.recipeCheck(126).'" onclick="craftCategory(126,1)">
									<div class="CraftImg" onclick="issetAll(126,\'item\')" style="background-image: url(/img/world/items/little/126.png);"></div>
										<div class="Name">Оловянный слиток</div>
									</div>
                  <div class="CraftObject '.recipeCheck(120).'" onclick="craftCategory(120,1)">
									<div class="CraftImg" onclick="issetAll(120,\'item\')" style="background-image: url(/img/world/items/little/120.png);"></div>
										<div class="Name">Обсидиановый слиток</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(69,1)">
									<div class="CraftImg" onclick="issetAll(69,\'item\')" style="background-image: url(/img/world/items/little/69.png);"></div>
										<div class="Name">Часть брони</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(107,1)">
				                    <div class="CraftImg" onclick="issetAll(107,\'item\')" style="background-image: url(/img/world/items/little/107.png);"></div>
										<div class="Name">Скобовое кольцо</div>
									</div>
                  <div class="CraftObject" onclick="craftCategory(276,1)">
									<div class="CraftImg" onclick="issetAll(276,\'item\')" style="background-image: url(/img/world/items/little/276.png);"></div>
										<div class="Name">Каркас тренировочной машины</div>
									</div>
                  <div class="CraftCtgText">~ Тренировочные машины ~</div>
                  <div class="CraftObject" onclick="craftCategory(1099,1)">
									<div class="CraftImg" onclick="issetAll(1099,\'item\')" style="background-image: url(/img/world/items/little/1099.png);"></div>
										<div class="Name">TM 99 - Ослепительный свет</div>
									</div>
			';
		break;
		case 'pokeballs':
			$response['html'] = '<div class="CraftObject" onclick="craftCategory(3,1)">
							<div class="CraftImg" onclick="issetAll(3,\'item\')" style="background-image: url(/img/world/items/little/3.png);"></div>
								<div class="Name">Покебол</div>
							</div>
              <div class="CraftObject '.recipeCheck(4).'" onclick="craftCategory(4,1)">
								<div class="CraftImg" onclick="issetAll(4,\'item\')" style="background-image: url(/img/world/items/little/4.png);"></div>
									<div class="Name">Гритбол</div>
								</div>
                <div class="CraftObject '.recipeCheck(6).'" onclick="craftCategory(6,1)">
									<div class="CraftImg" onclick="issetAll(6,\'item\')" style="background-image: url(/img/world/items/little/6.png);"></div>
										<div class="Name">Ультрабол</div>
									</div>';
		break;
		case 'medicine':
    $response['html'] = '<div class="CraftObject" onclick="craftCategory(196,1)">
                <div class="CraftImg" onclick="issetAll(196,\'item\')" style="background-image: url(/img/world/items/little/196.png);"></div>
                  <div class="Name">Фруктовая смесь</div>
                </div>';
		break;
		case 'magic':
			$response['html'] = '<div class="CraftObject '.recipeCheck(154).'" onclick="craftCategory(154,1)">
									<div class="CraftImg" onclick="issetAll(154,\'item\')" style="background-image: url(/img/world/items/little/154.png);"></div>
										<div class="Name">Заколдованный кислый леденец</div>
									</div>
									<div class="CraftObject '.recipeCheck(155).'" onclick="craftCategory(155,1)">
									<div class="CraftImg" onclick="issetAll(155,\'item\')" style="background-image: url(/img/world/items/little/155.png);"></div>
										<div class="Name">Заколдованный горький леденец</div>
									</div>';
		break;
		//Тут идет уже вывод айтемов вниз, по айди рецепта и т.п.
    case 3:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/3.png);" onclick="issetAll(3,\'item\')"></div>
				<div class="Name">Покебол</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(127,\'item\')" style="background-image: url(/img/world/items/little/127.png);">
						<div class="Count">1</div>
					</div>
					<div class="NeedItem" onclick="issetAll(12,\'item\')" style="background-image: url(/img/world/items/little/12.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>В инвентаре необходимо иметь <div class="itemIsset" style="background-image: url(/img/world/items/little/143.png)" onclick="issetAll(143,\'item\')"></div> Априкорновый аппарат.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(3)">Создать предмет</div>
				</div>';
		break;
    case 6:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/6.png);" onclick="issetAll(6,\'item\')"></div>
				<div class="Name">Ультрабол</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(127,\'item\')" style="background-image: url(/img/world/items/little/127.png);">
						<div class="Count">1</div>
					</div>
          <div class="NeedItem" onclick="issetAll(16,\'item\')" style="background-image: url(/img/world/items/little/16.png);">
						<div class="Count">1</div>
					</div>
          <div class="NeedItem" onclick="issetAll(11,\'item\')" style="background-image: url(/img/world/items/little/11.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>В инвентаре необходимо иметь <div class="itemIsset" style="background-image: url(/img/world/items/little/143.png)" onclick="issetAll(143,\'item\')"></div> Априкорновый аппарат.<br>Необходимо создать некоторое количество Гритболов, чтобы узнать схему Ультрабола.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(6)">Создать предмет</div>
				</div>';
		break;
    case 163:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/163.png);" onclick="issetAll(163,\'item\')"></div>
				<div class="Name">Прочные нитки</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(165,\'item\')" style="background-image: url(/img/world/items/little/165.png);">
						<div class="Count">1</div>
					</div>
					<div class="NeedItem" onclick="issetAll(55,\'item\')" style="background-image: url(/img/world/items/little/55.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(163)">Создать предмет</div>
				</div>';
		break;
    case 265:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/265.png);" onclick="issetAll(265,\'item\')"></div>
				<div class="Name">Игрушка Пиджеот</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(163,\'item\')" style="background-image: url(/img/world/items/little/163.png);">
						<div class="Count">3</div>
					</div>
          <div class="NeedItem" onclick="issetAll(199,\'item\')" style="background-image: url(/img/world/items/little/199.png);">
						<div class="Count">5</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(265)">Создать предмет</div>
				</div>';
		break;
    case 29:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/29.png);" onclick="issetAll(29,\'item\')"></div>
				<div class="Name">Зеленый шарф</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(163,\'item\')" style="background-image: url(/img/world/items/little/163.png);">
						<div class="Count">5</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(29)">Создать предмет</div>
				</div>';
		break;
		case 170:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/170.png);" onclick="issetAll(170,\'item\')"></div>
				<div class="Name">Отвар от негативного состояния</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(169,\'item\')" style="background-image: url(/img/world/items/little/169.png);">
						<div class="Count">3</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(170)">Создать предмет</div>
				</div>';
		break;
    case 196:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/196.png);" onclick="issetAll(196,\'item\')"></div>
				<div class="Name">Фруктовая смесь</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(45,\'item\')" style="background-image: url(/img/world/items/little/45.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(46,\'item\')" style="background-image: url(/img/world/items/little/46.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(47,\'item\')" style="background-image: url(/img/world/items/little/47.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(48,\'item\')" style="background-image: url(/img/world/items/little/48.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(49,\'item\')" style="background-image: url(/img/world/items/little/49.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(50,\'item\')" style="background-image: url(/img/world/items/little/50.png);">
          <div class="Count">1</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(196)">Создать предмет</div>
				</div>';
		break;
		case 4:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/4.png);" onclick="issetAll(4,\'item\')"></div>
				<div class="Name">Гритбол</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(127,\'item\')" style="background-image: url(/img/world/items/little/127.png);">
						<div class="Count">1</div>
					</div>
					<div class="NeedItem" onclick="issetAll(14,\'item\')" style="background-image: url(/img/world/items/little/14.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>В инвентаре необходимо иметь <div class="itemIsset" style="background-image: url(/img/world/items/little/143.png)" onclick="issetAll(143,\'item\')"></div> Априкорновый аппарат.<br>Необходимо создать некоторое количество Покеболов, чтобы узнать схему Гритбола.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(4)">Создать предмет</div>
				</div>';
		break;
    case 120:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/120.png);" onclick="issetAll(120,\'item\')"></div>
				<div class="Name">Обсидиановый слиток</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(56,\'item\')" style="background-image: url(/img/world/items/little/56.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо находиться в Плавильной комнате.<br>Необходимо создать некоторое количество Оловянных слитков, чтобы узнать схему Обсидианового слитка.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(120)">Создать предмет</div>
				</div>';
		break;
    case 126:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/126.png);" onclick="issetAll(126,\'item\')"></div>
				<div class="Name">Оловянный слиток</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(62,\'item\')" style="background-image: url(/img/world/items/little/62.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо находиться в Плавильной комнате.<br>Необходимо создать некоторое количество Железных слитков, чтобы узнать схему Оловянного слитка.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(126)">Создать предмет</div>
				</div>';
		break;
    case 276:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/276.png);" onclick="issetAll(276,\'item\')"></div>
				<div class="Name">Каркас тренировочной машины</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(126,\'item\')" style="background-image: url(/img/world/items/little/126.png);">
						<div class="Count">10</div>
					</div>
          <div class="NeedItem" onclick="issetAll(127,\'item\')" style="background-image: url(/img/world/items/little/127.png);">
						<div class="Count">10</div>
					</div>
          <div class="NeedItem" onclick="issetAll(120,\'item\')" style="background-image: url(/img/world/items/little/120.png);">
						<div class="Count">1</div>
					</div>
          <div class="NeedItem" onclick="issetAll(163,\'item\')" style="background-image: url(/img/world/items/little/163.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо находиться в Плавильной комнате.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(276)">Создать предмет</div>
				</div>';
		break;
    case 1099:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/1099.png);" onclick="issetAll(1099,\'item\')"></div>
				<div class="Name">TM 99 - Ослепительный свет</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(276,\'item\')" style="background-image: url(/img/world/items/little/276.png);">
						<div class="Count">1</div>
					</div>
          <div class="NeedItem" onclick="issetAll(215,\'item\')" style="background-image: url(/img/world/items/little/215.png);">
						<div class="Count">20</div>
					</div>
          <div class="NeedItem" onclick="issetAll(277,\'item\')" style="background-image: url(/img/world/items/little/277.png);">
						<div class="Count">15</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо находиться в Плавильной комнате.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(1099)">Создать предмет</div>
				</div>';
		break;
		case 69:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/69.png);" onclick="issetAll(69,\'item\')"></div>
				<div class="Name">Часть брони</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(126,\'item\')" style="background-image: url(/img/world/items/little/126.png);">
						<div class="Count">3</div>
					</div>
					<div class="NeedItem" onclick="issetAll(127,\'item\')" style="background-image: url(/img/world/items/little/127.png);">
						<div class="Count">10</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо находиться в Плавильной комнате.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(69)">Создать предмет</div>
				</div>';
		break;
		case 107:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/107.png);" onclick="issetAll(107,\'item\')"></div>
				<div class="Name">Скобовое кольцо</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(333,\'item\')" style="background-image: url(/img/world/items/little/333.png);">
						<div class="Count">1</div>
					</div>
					<div class="NeedItem" onclick="issetAll(69,\'item\')" style="background-image: url(/img/world/items/little/69.png);">
						<div class="Count">1</div>
					</div>
					<div class="NeedItem" onclick="issetAll(120,\'item\')" style="background-image: url(/img/world/items/little/120.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо находиться в Плавильной комнате.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(107)">Создать предмет</div>
				</div>';
		break;
		case 127:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/127.png);" onclick="issetAll(127,\'item\')"></div>
				<div class="Name">Железный слиток</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(63,\'item\')" style="background-image: url(/img/world/items/little/63.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо находиться в Плавильной комнате.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(127)">Создать предмет</div>
				</div>';
		break;
		case 130:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/93.png);" onclick="issetAll(93,\'item\')"></div>
				<div class="Name">Веревка</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(55,\'item\')" style="background-image: url(/img/world/items/little/55.png);">
						<div class="Count">10</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо выучить схему. <br>В инвентаре необходимо иметь <div class="itemIsset" style="background-image: url(/img/world/items/little/133.png)" onclick="issetAll(133,\'item\')"></div> Иглу.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(130)">Создать предмет</div>
				</div>';
		break;
    case 278:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/278.png);" onclick="issetAll(278,\'item\')"></div>
				<div class="Name">Зелье понижения классификации</div>
				<div class="CraftNeedItem">
          <div class="NeedItem" onclick="issetAll(196,\'item\')" style="background-image: url(/img/world/items/little/196.png);">
            <div class="Count">3</div>
          </div>
          <div class="NeedItem" onclick="issetAll(68,\'item\')" style="background-image: url(/img/world/items/little/68.png);">
            <div class="Count">5</div>
          </div>
				</div>
				<div class="CraftRules">
					<div>Необходимо выучить рецепт.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(278)">Создать предмет</div>
				</div>';
		break;
    case 279:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/279.png);" onclick="issetAll(279,\'item\')"></div>
				<div class="Name">Зелье из априкорнов</div>
				<div class="CraftNeedItem">
          <div class="NeedItem" onclick="issetAll(11,\'item\')" style="background-image: url(/img/world/items/little/11.png);">
            <div class="Count">10</div>
          </div>
          <div class="NeedItem" onclick="issetAll(12,\'item\')" style="background-image: url(/img/world/items/little/12.png);">
            <div class="Count">10</div>
          </div>
          <div class="NeedItem" onclick="issetAll(10,\'item\')" style="background-image: url(/img/world/items/little/10.png);">
            <div class="Count">10</div>
          </div>
				</div>
				<div class="CraftRules">
					<div>Необходимо выучить рецепт.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(279)">Создать предмет</div>
				</div>';
		break;
		case 154:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/154.png);" onclick="issetAll(154,\'item\')"></div>
				<div class="Name">Заколдованный кислый леденец</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(140,\'item\')" style="background-image: url(/img/world/items/little/140.png);">
						<div class="Count">1</div>
					</div>
					<div class="NeedItem" onclick="issetAll(91,\'item\')" style="background-image: url(/img/world/items/little/91.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо пройти задание "Посылка для...". <br>Нужно находиться возле Каролины.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(154)">Создать предмет</div>
				</div>';
		break;
		case 155:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/155.png);" onclick="issetAll(155,\'item\')"></div>
				<div class="Name">Заколдованный горький леденец</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(139,\'item\')" style="background-image: url(/img/world/items/little/139.png);">
						<div class="Count">1</div>
					</div>
					<div class="NeedItem" onclick="issetAll(91,\'item\')" style="background-image: url(/img/world/items/little/91.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо пройти задание "Посылка для...". <br>Нужно находиться возле Каролины.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(155)">Создать предмет</div>
				</div>';
		break;
    case 217:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/217.png);" onclick="issetAll(217,\'item\')"></div>
				<div class="Name">Пирожное «Молодой дракон»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(212,\'item\')" style="background-image: url(/img/world/items/little/212.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(217)">Создать предмет</div>
				</div>';
		break;
    case 218:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/218.png);" onclick="issetAll(218,\'item\')"></div>
				<div class="Name">Пирожное «Разряд молний»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(202,\'item\')" style="background-image: url(/img/world/items/little/202.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(218)">Создать предмет</div>
				</div>';
		break;
    case 219:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/219.png);" onclick="issetAll(219,\'item\')"></div>
				<div class="Name">Пирожное «Волшебные бантики»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(215,\'item\')" style="background-image: url(/img/world/items/little/215.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(219)">Создать предмет</div>
				</div>';
		break;
    case 220:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/220.png);" onclick="issetAll(220,\'item\')"></div>
				<div class="Name">Пирожное «Острые камушки»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(216,\'item\')" style="background-image: url(/img/world/items/little/216.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(220)">Создать предмет</div>
				</div>';
		break;
    case 221:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/221.png);" onclick="issetAll(221,\'item\')"></div>
				<div class="Name">Пирожное «Льдинка»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(206,\'item\')" style="background-image: url(/img/world/items/little/206.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(221)">Создать предмет</div>
				</div>';
		break;
    case 222:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/222.png);" onclick="issetAll(222,\'item\')"></div>
				<div class="Name">Пирожное «Легкое перо»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(208,\'item\')" style="background-image: url(/img/world/items/little/208.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(222)">Создать предмет</div>
				</div>';
		break;
    case 223:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/223.png);" onclick="issetAll(223,\'item\')"></div>
				<div class="Name">Пирожное «Лапка»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(199,\'item\')" style="background-image: url(/img/world/items/little/199.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(223)">Создать предмет</div>
				</div>';
		break;
    case 224:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/224.png);" onclick="issetAll(224,\'item\')"></div>
				<div class="Name">Пирожное «Горячая магма»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(200,\'item\')" style="background-image: url(/img/world/items/little/200.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(224)">Создать предмет</div>
				</div>';
		break;
    case 225:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/225.png);" onclick="issetAll(225,\'item\')"></div>
				<div class="Name">Пирожное «Заблудшие души»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(211,\'item\')" style="background-image: url(/img/world/items/little/211.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(225)">Создать предмет</div>
				</div>';
		break;
    case 226:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/226.png);" onclick="issetAll(226,\'item\')"></div>
				<div class="Name">Пирожное «Психические импульсы»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(209,\'item\')" style="background-image: url(/img/world/items/little/209.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(226)">Создать предмет</div>
				</div>';
		break;
    case 227:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/227.png);" onclick="issetAll(227,\'item\')"></div>
				<div class="Name">Пирожное «Шестеренки»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(214,\'item\')" style="background-image: url(/img/world/items/little/214.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(227)">Создать предмет</div>
				</div>';
		break;
    case 228:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/228.png);" onclick="issetAll(228,\'item\')"></div>
				<div class="Name">Пирожное «Ночной туман»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(213,\'item\')" style="background-image: url(/img/world/items/little/213.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(228)">Создать предмет</div>
				</div>';
		break;
    case 229:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/229.png);" onclick="issetAll(229,\'item\')"></div>
				<div class="Name">Пирожное «Зеленый лист»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(203,\'item\')" style="background-image: url(/img/world/items/little/203.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(229)">Создать предмет</div>
				</div>';
		break;
    case 230:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/230.png);" onclick="issetAll(230,\'item\')"></div>
				<div class="Name">Пирожное «Водное течение»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(201,\'item\')" style="background-image: url(/img/world/items/little/201.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(230)">Создать предмет</div>
				</div>';
		break;
    case 231:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/231.png);" onclick="issetAll(231,\'item\')"></div>
				<div class="Name">Пирожное «Чума»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(207,\'item\')" style="background-image: url(/img/world/items/little/207.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(231)">Создать предмет</div>
				</div>';
		break;
    case 232:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/232.png);" onclick="issetAll(232,\'item\')"></div>
				<div class="Name">Пирожное «Подземелье»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(205,\'item\')" style="background-image: url(/img/world/items/little/205.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(232)">Создать предмет</div>
				</div>';
		break;
    case 233:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/233.png);" onclick="issetAll(233,\'item\')"></div>
				<div class="Name">Пирожное «Жужжание»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(210,\'item\')" style="background-image: url(/img/world/items/little/210.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(233)">Создать предмет</div>
				</div>';
		break;
    case 234:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/234.png);" onclick="issetAll(234,\'item\')"></div>
				<div class="Name">Пирожное «Уличная драка»</div>
				<div class="CraftNeedItem">
        <div class="NeedItem" onclick="issetAll(235,\'item\')" style="background-image: url(/img/world/items/little/235.png);">
          <div class="Count">1</div>
        </div>
        <div class="NeedItem" onclick="issetAll(204,\'item\')" style="background-image: url(/img/world/items/little/204.png);">
          <div class="Count">10</div>
        </div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(234)">Создать предмет</div>
				</div>';
		break;
		case 165:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/165.png);" onclick="issetAll(165,\'item\')"></div>
				<div class="Name">Сок из листьев Туртвига</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(164,\'item\')" style="background-image: url(/img/world/items/little/164.png);">
						<div class="Count">5</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Нет дополнительных условий.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(165)">Создать предмет</div>
				</div>';
		break;
		case 141:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/142.png);" onclick="issetAll(142,\'item\')"></div>
				<div class="Name">Вкусный леденец</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(31,\'item\')" style="background-image: url(/img/world/items/little/31.png);">
						<div class="Count">1</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо выучить рецепт. <br>Необходимо находиться в Кондитерской.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(141)">Создать предмет</div>
				</div>';
		break;
		case 144:
			$response['html'] = '
				<div class="CraftMainItem" style="background-image: url(/img/world/items/little/143.png);" onclick="issetAll(143,\'item\')"></div>
				<div class="Name">Априкорновый аппарат</div>
				<div class="CraftNeedItem">
					<div class="NeedItem" onclick="issetAll(127,\'item\')" style="background-image: url(/img/world/items/little/127.png);">
						<div class="Count">10</div>
					</div>
				</div>
				<div class="CraftRules">
					<div>Необходимо выучить схему. <br>Необходимо находиться в Мастерской.</div>
				</div>
				<div class="CreateButton">
					<input id="CountCraft" type="number" value="1" placeholder="Количество">
				</div>
				<div class="CreateButton">
					<div onclick="craftItem(144)">Создать предмет</div>
				</div>';
		break;
		default:
			echo "Unknown error";
		break;
	}
echo json_encode($response);
?>
