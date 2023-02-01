<?
	$response['name'] = 'Адмирал Сайкуновский';
	switch($npcStep){
		case 1:
		$a = $mysqli->query("SELECT * FROM `users` WHERE `id`= ".$_SESSION['id'])->fetch_assoc();
		if($a['admiral'] >= 1 && $a['admiral'] <= 5){
			$mysqli->query("UPDATE `users` SET `admiral` = 999 WHERE `id` = '".$_SESSION['id']."'");
			itemAdd(85,1);
			itemAdd(1,50000);
			$response['question'] = 'Твои призы:
			<br><div class="itemIsset" onclick="issetAll(85,\'item\')" style="background-image: url(/img/world/items/little/85.png)"></div> Рюкзак «Пурлоин» (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(1,\'item\')" style="background-image: url(/img/world/items/little/1.png)"></div> Монета (50000 шт.)
			';
		}elseif($a['admiral'] >= 6 && $a['admiral'] <= 15){
			$mysqli->query("UPDATE `users` SET `admiral` = 999 WHERE `id` = '".$_SESSION['id']."'");
			itemAdd(111,1);
			itemAdd(1,50000);
			itemAdd(95,1);
			$response['question'] = 'Твои призы:
			<br><div class="itemIsset" onclick="issetAll(111,\'item\')" style="background-image: url(/img/world/items/little/111.png)"></div> Набор рюкзаков (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(1,\'item\')" style="background-image: url(/img/world/items/little/1.png)"></div> Монета (50000 шт.)
			<br><div class="itemIsset" onclick="issetAll(95,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> Набор классификаций (1 шт.)
			';
		}elseif($a['admiral'] >= 16 && $a['admiral'] <= 25){
			$mysqli->query("UPDATE `users` SET `admiral` = 999 WHERE `id` = '".$_SESSION['id']."'");
			itemAdd(1,100000);
			itemAdd(95,1);
			itemAdd(119,1);
			$response['question'] = 'Твои призы:
			<br><div class="itemIsset" onclick="issetAll(1,\'item\')" style="background-image: url(/img/world/items/little/1.png)"></div> Монета (100000 шт.)
			<br><div class="itemIsset" onclick="issetAll(95,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> Набор классификаций (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(119,\'item\')" style="background-image: url(/img/world/items/little/119.png)"></div> Аметистовый загадочный сундук (1 шт.)
			';
		}elseif($a['admiral'] >= 26 && $a['admiral'] <= 35){
			$mysqli->query("UPDATE `users` SET `admiral` = 999 WHERE `id` = '".$_SESSION['id']."'");
			itemAdd(1,200000);
			itemAdd(95,2);
			itemAdd(119,1);
			$response['question'] = 'Твои призы:
			<br><div class="itemIsset" onclick="issetAll(1,\'item\')" style="background-image: url(/img/world/items/little/1.png)"></div> Монета (200000 шт.)
			<br><div class="itemIsset" onclick="issetAll(2,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> Набор классификаций (2 шт.)
			<br><div class="itemIsset" onclick="issetAll(119,\'item\')" style="background-image: url(/img/world/items/little/119.png)"></div> Аметистовый загадочный сундук (1 шт.)
			';
		}elseif($a['admiral'] >= 36 && $a['admiral'] <= 40){
			$mysqli->query("UPDATE `users` SET `admiral` = 999 WHERE `id` = '".$_SESSION['id']."'");
			itemAdd(1,200000);
			itemAdd(95,2);
			itemAdd(117,1);
			itemAdd(52,1);
			$response['question'] = 'Твои призы:
			<br><div class="itemIsset" onclick="issetAll(1,\'item\')" style="background-image: url(/img/world/items/little/1.png)"></div> Монета (200000 шт.)
			<br><div class="itemIsset" onclick="issetAll(2,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> Набор классификаций (2 шт.)
			<br><div class="itemIsset" onclick="issetAll(117,\'item\')" style="background-image: url(/img/world/items/little/117.png)"></div> Сапфировый загадочный сундук (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(52,\'item\')" style="background-image: url(/img/world/items/little/52.png)"></div> Протектор (1 шт.)
			';
		}elseif($a['admiral'] >= 41 && $a['admiral'] <= 60){
			$mysqli->query("UPDATE `users` SET `admiral` = 999 WHERE `id` = '".$_SESSION['id']."'");
			itemAdd(1,250000);
			itemAdd(95,3);
			itemAdd(117,1);
			itemAdd(52,1);
			$response['question'] = 'Твои призы:
			<br><div class="itemIsset" onclick="issetAll(1,\'item\')" style="background-image: url(/img/world/items/little/1.png)"></div> Монета (250000 шт.)
			<br><div class="itemIsset" onclick="issetAll(2,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> Набор классификаций (3 шт.)
			<br><div class="itemIsset" onclick="issetAll(117,\'item\')" style="background-image: url(/img/world/items/little/117.png)"></div> Сапфировый загадочный сундук (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(52,\'item\')" style="background-image: url(/img/world/items/little/52.png)"></div> Протектор (1 шт.)
			';
		}elseif($a['admiral'] >= 61 && $a['admiral'] <= 90){
			$mysqli->query("UPDATE `users` SET `admiral` = 999 WHERE `id` = '".$_SESSION['id']."'");
			itemAdd(1,250000);
			itemAdd(95,3);
			itemAdd(117,1);
			itemAdd(118,1);
			itemAdd(52,1);
			$response['question'] = 'Твои призы:
			<br><div class="itemIsset" onclick="issetAll(1,\'item\')" style="background-image: url(/img/world/items/little/1.png)"></div> Монета (250000 шт.)
			<br><div class="itemIsset" onclick="issetAll(2,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> Набор классификаций (3 шт.)
			<br><div class="itemIsset" onclick="issetAll(117,\'item\')" style="background-image: url(/img/world/items/little/117.png)"></div> Сапфировый загадочный сундук (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(118,\'item\')" style="background-image: url(/img/world/items/little/118.png)"></div> Рубиновый загадочный сундук (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(52,\'item\')" style="background-image: url(/img/world/items/little/52.png)"></div> Протектор (1 шт.)
			';
		}elseif($a['admiral'] >= 91 && $a['admiral'] <= 100){
			$mysqli->query("UPDATE `users` SET `admiral` = 999 WHERE `id` = '".$_SESSION['id']."'");
			itemAdd(1,250000);
			itemAdd(95,5);
			itemAdd(117,1);
			itemAdd(118,1);
			itemAdd(52,1);
			$response['question'] = 'Твои призы:
			<br><div class="itemIsset" onclick="issetAll(1,\'item\')" style="background-image: url(/img/world/items/little/1.png)"></div> Монета (250000 шт.)
			<br><div class="itemIsset" onclick="issetAll(2,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> Набор классификаций (5 шт.)
			<br><div class="itemIsset" onclick="issetAll(117,\'item\')" style="background-image: url(/img/world/items/little/117.png)"></div> Сапфировый загадочный сундук (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(118,\'item\')" style="background-image: url(/img/world/items/little/118.png)"></div> Рубиновый загадочный сундук (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(52,\'item\')" style="background-image: url(/img/world/items/little/52.png)"></div> Протектор (1 шт.)
			';
		}elseif($a['admiral'] >= 121 && $a['admiral'] <= 124){
			$mysqli->query("UPDATE `users` SET `admiral` = 999 WHERE `id` = '".$_SESSION['id']."'");
			itemAdd(1,300000);
			itemAdd(95,5);
			itemAdd(117,1);
			itemAdd(116,1);
			itemAdd(118,1);
			itemAdd(36,1);
			itemAdd(52,1);
			$response['question'] = 'Твои призы:
			<br><div class="itemIsset" onclick="issetAll(1,\'item\')" style="background-image: url(/img/world/items/little/1.png)"></div> Монета (300000 шт.)
			<br><div class="itemIsset" onclick="issetAll(2,\'item\')" style="background-image: url(/img/world/items/little/95.png)"></div> Набор классификаций (5 шт.)
			<br><div class="itemIsset" onclick="issetAll(117,\'item\')" style="background-image: url(/img/world/items/little/117.png)"></div> Сапфировый загадочный сундук (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(118,\'item\')" style="background-image: url(/img/world/items/little/118.png)"></div> Рубиновый загадочный сундук (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(116,\'item\')" style="background-image: url(/img/world/items/little/116.png)"></div> Нефритовый загадочный сундук (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(52,\'item\')" style="background-image: url(/img/world/items/little/52.png)"></div> Протектор (1 шт.)
			<br><div class="itemIsset" onclick="issetAll(36,\'item\')" style="background-image: url(/img/world/items/little/36.png)"></div> Сияющий камень (1 шт.)
			';
		}elseif($a['admiral'] == 999){
			$response['question'] = 'Ты уже получил свои призы.';
		}else{
			$response['question'] = 'Для тебя ничего нет.';
		}
		break;
		default:
		$response['question'] = 'Всем огромное спасибо за вашу помощь! Команда Аква разгромлена, и мы готовы выдать призы нашим защитникам!';
		$response['answer'] = array(
			 1 => "Получить приз",
			 'by' => ['title'=>'Обменять Души Чаризарда', 'npc_id'=>54]
		);
		break;
	}
?>