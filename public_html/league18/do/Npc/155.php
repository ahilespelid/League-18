<?php
 //$chekquest = $mysqli->query("SELECT * FROM `npc_more_quest` WHERE `user_id`='".$_SESSION['id']."' AND quest_id = 5002")->fetch_assoc();
	$response['name'] = 'Хозяин башни испытаний';
	 switch($npcStep){
		 case 1:
      $response['question'] = '
			1. <b>Комната трюков</b> - покемоны в этой в комнате обладают уникальной атакой, которая повышает Ловкость на +6.<br>
			2. <b>Комната боли</b> - покемоны в этой комнате обладают KO атаками (Гильотина, Абсолютный холод и т.п.) и способны снять все Здоровье с противника одной атакой.
			';
		 break;
		 case 2:
      $response['question'] = 'За прохождение одной комнаты вы получите 1 случайную награду из списка.<br>
			1. <b>Комната трюков</b>, награды: <div class="itemIsset" onclick="issetAll(109,\'item\')" style="background-image: url(/img/world/items/little/109.png)"></div>x5 <div class="itemIsset" onclick="issetAll(195,\'item\')" style="background-image: url(/img/world/items/little/195.png)"></div> <div class="itemIsset" onclick="issetAll(35,\'item\')" style="background-image: url(/img/world/items/little/35.png)"></div> <div class="itemIsset" onclick="issetAll(255,\'item\')" style="background-image: url(/img/world/items/little/255.png)"></div> <div class="itemIsset" onclick="issetAll(256,\'item\')" style="background-image: url(/img/world/items/little/256.png)"></div><br>
			2. <b>Комната боли</b>, награды: <div class="itemIsset" onclick="issetAll(109,\'item\')" style="background-image: url(/img/world/items/little/109.png)"></div>x5 <div class="itemIsset" onclick="issetAll(181,\'item\')" style="background-image: url(/img/world/items/little/181.png)"></div> <div class="itemIsset" onclick="issetAll(35,\'item\')" style="background-image: url(/img/world/items/little/35.png)"></div> <div class="itemIsset" onclick="issetAll(255,\'item\')" style="background-image: url(/img/world/items/little/255.png)"></div> <div class="itemIsset" onclick="issetAll(256,\'item\')" style="background-image: url(/img/world/items/little/256.png)"></div>
			';
		 break;
		 case 3:
      $response['question'] = 'Какую комнату ты выберешь?';
			$response['answer'] = array(
       101 => "Комната трюков",
			 102 => "Комната боли"
      );
		 break;
		 case 4:
		 	$response['question'] = 'Да? И какую же?';
			$response['answer'] = array(
       201 => "Комнату трюков",
			 202 => "Комнату боли"
      );
		 break;
		 case 101:
		 	if(!npc_time_check(17001)){
				$mysqli->query("UPDATE `users` SET `location`='236' WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Сегодня ты уже проходил эту комнату. Приходи позже.';
			}
		 break;
		 case 102:
		 	if(!npc_time_check(17002)){
				$mysqli->query("UPDATE `users` SET `location`='237' WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Сегодня ты уже проходил эту комнату. Приходи позже.';
			}
		 break;
		 case 201:
		 	if(item_isset(266,1)) {
				$wait = time()+86400;
				$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 17001 AND `userID` = '".$_SESSION['id']."'");
			  $mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','17001','".$wait."') ");
				$rand = mt_rand(1,5);
				if($rand == 1) {
					itemAdd(109,5);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
				}elseif($rand == 2) {
					itemAdd(195,1);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/195.png" class="item"> Темные очки (1 шт.)';
				}elseif($rand == 3) {
					itemAdd(35,1);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/35.png" class="item"> Лунный камень (1 шт.)';
				}elseif($rand == 4) {
					itemAdd(255,1);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/255.png" class="item"> Коробка с пирожными (1 шт.)';
				}else{
					itemAdd(256,1);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/256.png" class="item"> Коробка с витаминами (1 шт.)';
				}
				minus_item(266,1);
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/266.png" class="item"> Брелок комнаты трюков (1 шт.)';
				$response['question'] = 'Удивительно. И правда прошел. Вижу у тебя брелок. Держи награду. Эту комнату можно будет пройти еще раз, но уже завтра.';
			}else{
				$response['question'] = 'Я не вижу у тебя нужного предмета. Ты не прошел комнату.';
			}
		 break;
		 case 202:
		 	if(item_isset(267,1)) {
				$wait = time()+86400;
				$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 17002 AND `userID` = '".$_SESSION['id']."'");
			  $mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','17002','".$wait."') ");
				$rand = mt_rand(1,5);
				if($rand == 1) {
					itemAdd(109,5);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
				}elseif($rand == 2) {
					itemAdd(181,1);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/181.png" class="item"> Древесный уголь (1 шт.)';
				}elseif($rand == 3) {
					itemAdd(35,1);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/35.png" class="item"> Лунный камень (1 шт.)';
				}elseif($rand == 4) {
					itemAdd(255,1);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/255.png" class="item"> Коробка с пирожными (1 шт.)';
				}else{
					itemAdd(256,1);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/256.png" class="item"> Коробка с витаминами (1 шт.)';
				}
				minus_item(267,1);
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/267.png" class="item"> Брелок комнаты боли (1 шт.)';
				$response['question'] = 'Удивительно. И правда прошел. Вижу у тебя брелок. Держи награду. Эту комнату можно будет пройти еще раз, но уже завтра.';
			}else{
				$response['question'] = 'Я не вижу у тебя нужного предмета. Ты не прошел комнату.';
			}
		 break;
		 default:
     $response['question'] = 'Здравствуй, путник! Я тут недавно башню соорудил. Башня непростая. В ней можно проверить свои силы, да и призы получить от меня. Каждая комната этой башни - это испытание для тебя. Все комнаты отличаются между собой, они уникальны, но все они равны по силе.<br>В каждой комнате есть свой предмет, который выпадает с покемонов, находящихся в этой комнате. Если ты принесешь мне этот предмет, я пойму, что ты справился с испытанием и вручу тебе обещанную награду.<br>Одну комнату можно проходить один раз в день. Готов ли ты проверить свои силы?';
     $response['answer'] = array(
      1 => "Расскажите мне о каждой комнате этой башни",
      2 => "Какие награды можно получить за каждую комнату?",
      3 => "Я готов пройти испытание",
      4 => "Я прошел одну из комнат, и у меня есть предмет, подтверждающий это"
     );
		 break;
   }
?>
