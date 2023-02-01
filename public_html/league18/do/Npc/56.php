<?
	$response['name'] = 'Парень в разноцветной шляпе';
	$pil = $mysqli->query("SELECT `count` FROM `items_users` WHERE `item_id` = 108 AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
	switch($npcStep){
		case 10:
			if(!quest_isset(5001)){
				if($pil['count'] >= 1 && $pil['count'] <= 5){
					itemAdd(25,1);
				}elseif($pil['count'] >= 6 && $pil['count'] <= 15){
					itemAdd(25,1);
					itemAdd(95,1);
				}elseif($pil['count'] >= 16 && $pil['count'] <= 25){
					itemAdd(25,1);
					itemAdd(95,1);
					itemAdd(9,5);
				}elseif($pil['count'] >= 26 && $pil['count'] <= 50){
					itemAdd(25,1);
					itemAdd(95,1);
					itemAdd(9,5);
					itemAdd(5,3);
				}elseif($pil['count'] >= 51 && $pil['count'] <= 100){
					itemAdd(25,1);
					itemAdd(95,1);
					itemAdd(9,5);
					itemAdd(5,3);
					itemAdd(111,1);
				}elseif($pil['count'] >= 101 && $pil['count'] <= 140){
					itemAdd(25,1);
					itemAdd(95,1);
					itemAdd(9,10);
					itemAdd(5,6);
					itemAdd(111,1);
				}elseif($pil['count'] >= 141 && $pil['count'] <= 250){
					itemAdd(25,1);
					itemAdd(95,2);
					itemAdd(9,10);
					itemAdd(5,6);
					itemAdd(111,1);
				}elseif($pil['count'] >= 251 && $pil['count'] <= 350){
					itemAdd(25,1);
					itemAdd(95,2);
					itemAdd(5,6);
					itemAdd(111,1);
					plusEgg(false,false,false,false,false,418);
				}elseif($pil['count'] >= 351 && $pil['count'] <= 500){
					itemAdd(95,1);
					itemAdd(5,6);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,599);
				}elseif($pil['count'] >= 501 && $pil['count'] <= 800){
					itemAdd(95,2);
					itemAdd(5,6);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,599);
				}elseif($pil['count'] >= 801 && $pil['count'] <= 1000){
					itemAdd(95,1);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,227);
					plusEgg(false,false,false,false,false,418);
				}elseif($pil['count'] >= 1001 && $pil['count'] <= 1300){
					itemAdd(95,1);
					itemAdd(29,1);
					itemAdd(21,1);
					plusEgg(false,false,false,false,false,453);
				}elseif($pil['count'] >= 1301 && $pil['count'] <= 2000){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					plusEgg(false,false,false,false,false,418);
				}elseif($pil['count'] >= 2001 && $pil['count'] <= 2600){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					plusEgg(false,false,false,false,false,359);
				}elseif($pil['count'] >= 2601 && $pil['count'] <= 3200){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(21,1);
					plusEgg(false,false,false,false,false,599);
				}elseif($pil['count'] >= 3201 && $pil['count'] <= 4500){
					itemAdd(95,3);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,359);
				}elseif($pil['count'] >= 4501 && $pil['count'] <= 5200){
					itemAdd(95,5);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,359);
					plusEgg(false,false,false,false,false,674);
				}elseif($pil['count'] >= 5201 && $pil['count'] <= 10000){
					itemAdd(95,5);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,359);
					plusEgg(false,false,false,false,false,674);
					plusEgg(false,false,false,false,false,280);
				}
				$response['question'] = 'Держи подарок!';
				minus_item(108,$pil['count']);
				quest_update(5001,1);
			}else{
				$response['question'] = 'Ты уже получил подарок.';
			}
		break;
		case 20:
			if(!quest_isset(5001)){
				if($pil['count'] >= 1 && $pil['count'] <= 5){
					itemAdd(26,1);
				}elseif($pil['count'] >= 6 && $pil['count'] <= 15){
					itemAdd(26,1);
					itemAdd(95,1);
				}elseif($pil['count'] >= 16 && $pil['count'] <= 25){
					itemAdd(26,1);
					itemAdd(95,1);
					itemAdd(9,5);
				}elseif($pil['count'] >= 26 && $pil['count'] <= 50){
					itemAdd(26,1);
					itemAdd(95,1);
					itemAdd(9,5);
					itemAdd(5,3);
				}elseif($pil['count'] >= 51 && $pil['count'] <= 100){
					itemAdd(26,1);
					itemAdd(95,1);
					itemAdd(9,5);
					itemAdd(5,3);
					itemAdd(111,1);
				}elseif($pil['count'] >= 101 && $pil['count'] <= 140){
					itemAdd(26,1);
					itemAdd(95,1);
					itemAdd(9,10);
					itemAdd(5,6);
					itemAdd(111,1);
				}elseif($pil['count'] >= 141 && $pil['count'] <= 250){
					itemAdd(26,1);
					itemAdd(95,2);
					itemAdd(9,10);
					itemAdd(5,6);
					itemAdd(111,1);
				}elseif($pil['count'] >= 251 && $pil['count'] <= 350){
					itemAdd(26,1);
					itemAdd(95,2);
					itemAdd(5,6);
					itemAdd(111,1);
					plusEgg(false,false,false,false,false,418);
				}elseif($pil['count'] >= 351 && $pil['count'] <= 500){
					itemAdd(95,1);
					itemAdd(5,6);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,270);
				}elseif($pil['count'] >= 501 && $pil['count'] <= 800){
					itemAdd(95,2);
					itemAdd(5,6);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,270);
				}elseif($pil['count'] >= 801 && $pil['count'] <= 1000){
					itemAdd(95,1);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,359);
					plusEgg(false,false,false,false,false,418);
				}elseif($pil['count'] >= 1001 && $pil['count'] <= 1300){
					itemAdd(95,1);
					itemAdd(29,1);
					itemAdd(21,1);
					plusEgg(false,false,false,false,false,434);
				}elseif($pil['count'] >= 1301 && $pil['count'] <= 2000){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					plusEgg(false,false,false,false,false,127);
				}elseif($pil['count'] >= 2001 && $pil['count'] <= 2600){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					plusEgg(false,false,false,false,false,449);
				}elseif($pil['count'] >= 2601 && $pil['count'] <= 3200){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,270);
				}elseif($pil['count'] >= 3201 && $pil['count'] <= 4500){
					itemAdd(95,3);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,449);
				}elseif($pil['count'] >= 4501 && $pil['count'] <= 5200){
					itemAdd(95,5);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(21,1);
					plusEgg(false,false,false,false,false,449);
					plusEgg(false,false,false,false,false,674);
				}elseif($pil['count'] >= 5201 && $pil['count'] <= 10000){
					itemAdd(95,5);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,449);
					plusEgg(false,false,false,false,false,674);
					plusEgg(false,false,false,false,false,280);
				}
				$response['question'] = 'Держи подарок!';
				minus_item(108,$pil['count']);
				quest_update(5001,1);
			}else{
				$response['question'] = 'Ты уже получил подарок.';
			}
		break;
		case 30:
			if(!quest_isset(5001)){
				if($pil['count'] >= 1 && $pil['count'] <= 5){
					itemAdd(28,1);
				}elseif($pil['count'] >= 6 && $pil['count'] <= 15){
					itemAdd(28,1);
					itemAdd(95,1);
				}elseif($pil['count'] >= 16 && $pil['count'] <= 25){
					itemAdd(28,1);
					itemAdd(95,1);
					itemAdd(9,5);
				}elseif($pil['count'] >= 26 && $pil['count'] <= 50){
					itemAdd(28,1);
					itemAdd(95,1);
					itemAdd(9,5);
					itemAdd(5,3);
				}elseif($pil['count'] >= 51 && $pil['count'] <= 100){
					itemAdd(28,1);
					itemAdd(95,1);
					itemAdd(9,5);
					itemAdd(5,3);
					itemAdd(111,1);
				}elseif($pil['count'] >= 101 && $pil['count'] <= 140){
					itemAdd(28,1);
					itemAdd(95,1);
					itemAdd(9,10);
					itemAdd(5,6);
					itemAdd(111,1);
				}elseif($pil['count'] >= 141 && $pil['count'] <= 250){
					itemAdd(28,1);
					itemAdd(95,2);
					itemAdd(9,10);
					itemAdd(5,6);
					itemAdd(111,1);
				}elseif($pil['count'] >= 251 && $pil['count'] <= 350){
					itemAdd(28,1);
					itemAdd(95,2);
					itemAdd(5,6);
					itemAdd(111,1);
					plusEgg(false,false,false,false,false,418);
				}elseif($pil['count'] >= 351 && $pil['count'] <= 500){
					itemAdd(95,1);
					itemAdd(5,6);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,453);
				}elseif($pil['count'] >= 501 && $pil['count'] <= 800){
					itemAdd(95,2);
					itemAdd(5,6);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,453);
				}elseif($pil['count'] >= 801 && $pil['count'] <= 1000){
					itemAdd(95,1);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,449);
					plusEgg(false,false,false,false,false,418);
				}elseif($pil['count'] >= 1001 && $pil['count'] <= 1300){
					itemAdd(95,1);
					itemAdd(29,1);
					itemAdd(21,1);
					plusEgg(false,false,false,false,false,140);
				}elseif($pil['count'] >= 1301 && $pil['count'] <= 2000){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					plusEgg(false,false,false,false,false,590);
				}elseif($pil['count'] >= 2001 && $pil['count'] <= 2600){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					plusEgg(false,false,false,false,false,594);
				}elseif($pil['count'] >= 2601 && $pil['count'] <= 3200){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(21,1);
					plusEgg(false,false,false,false,false,453);
				}elseif($pil['count'] >= 3201 && $pil['count'] <= 4500){
					itemAdd(95,3);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,594);
				}elseif($pil['count'] >= 4501 && $pil['count'] <= 5200){
					itemAdd(95,5);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(21,1);
					plusEgg(false,false,false,false,false,594);
					plusEgg(false,false,false,false,false,674);
				}elseif($pil['count'] >= 5201 && $pil['count'] <= 10000){
					itemAdd(95,5);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,594);
					plusEgg(false,false,false,false,false,674);
					plusEgg(false,false,false,false,false,280);
				}
				$response['question'] = 'Держи подарок!';
				minus_item(108,$pil['count']);
				quest_update(5001,1);
			}else{
				$response['question'] = 'Ты уже получил подарок.';
			}
		break;
		case 40:
			if(!quest_isset(5001)){
				if($pil['count'] >= 1 && $pil['count'] <= 5){
					itemAdd(27,1);
				}elseif($pil['count'] >= 6 && $pil['count'] <= 15){
					itemAdd(27,1);
					itemAdd(95,1);
				}elseif($pil['count'] >= 16 && $pil['count'] <= 25){
					itemAdd(27,1);
					itemAdd(95,1);
					itemAdd(9,5);
				}elseif($pil['count'] >= 26 && $pil['count'] <= 50){
					itemAdd(27,1);
					itemAdd(95,1);
					itemAdd(9,5);
					itemAdd(5,3);
				}elseif($pil['count'] >= 51 && $pil['count'] <= 100){
					itemAdd(27,1);
					itemAdd(95,1);
					itemAdd(9,5);
					itemAdd(5,3);
					itemAdd(111,1);
				}elseif($pil['count'] >= 101 && $pil['count'] <= 140){
					itemAdd(27,1);
					itemAdd(95,1);
					itemAdd(9,10);
					itemAdd(5,6);
					itemAdd(111,1);
				}elseif($pil['count'] >= 141 && $pil['count'] <= 250){
					itemAdd(27,1);
					itemAdd(95,2);
					itemAdd(9,10);
					itemAdd(5,6);
					itemAdd(111,1);
				}elseif($pil['count'] >= 251 && $pil['count'] <= 350){
					itemAdd(27,1);
					itemAdd(95,2);
					itemAdd(5,6);
					itemAdd(111,1);
					plusEgg(false,false,false,false,false,418);
				}elseif($pil['count'] >= 351 && $pil['count'] <= 500){
					itemAdd(95,1);
					itemAdd(5,6);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,140);
				}elseif($pil['count'] >= 501 && $pil['count'] <= 800){
					itemAdd(95,2);
					itemAdd(5,6);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,140);
				}elseif($pil['count'] >= 801 && $pil['count'] <= 1000){
					itemAdd(95,1);
					itemAdd(29,1);
					plusEgg(false,false,false,false,false,594);
					plusEgg(false,false,false,false,false,418);
				}elseif($pil['count'] >= 1001 && $pil['count'] <= 1300){
					itemAdd(95,1);
					itemAdd(29,1);
					itemAdd(21,1);
					plusEgg(false,false,false,false,false,270);
				}elseif($pil['count'] >= 1301 && $pil['count'] <= 2000){
					itemAdd(95,4);
					itemAdd(29,1);
					itemAdd(23,1);
				}elseif($pil['count'] >= 2001 && $pil['count'] <= 2600){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					plusEgg(false,false,false,false,false,227);
				}elseif($pil['count'] >= 2601 && $pil['count'] <= 3200){
					itemAdd(95,2);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,140);
				}elseif($pil['count'] >= 3201 && $pil['count'] <= 4500){
					itemAdd(95,3);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,227);
				}elseif($pil['count'] >= 4501 && $pil['count'] <= 5200){
					itemAdd(95,5);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,227);
					plusEgg(false,false,false,false,false,674);
				}elseif($pil['count'] >= 5201 && $pil['count'] <= 10000){
					itemAdd(95,5);
					itemAdd(29,1);
					itemAdd(23,1);
					itemAdd(96,1);
					plusEgg(false,false,false,false,false,227);
					plusEgg(false,false,false,false,false,674);
					plusEgg(false,false,false,false,false,280);
				}
				$response['question'] = 'Держи подарок!';
				minus_item(108,$pil['count']);
				quest_update(5001,1);
			}else{
				$response['question'] = 'Ты уже получил подарок.';
			}
		break;
		case 2:
			if($pil){
				if($pil['count'] >= 1 && $pil['count'] <= 5){
					$prize1 = 'Огненный камень';
					$prize2 = 'Водный камень';
					$prize3 = 'Травяной камень';
					$prize4 = 'Громовой камень';
				}elseif($pil['count'] >= 6 && $pil['count'] <= 15){
					$prize1 = 'Огненный камень<br>Набор классификаций';
					$prize2 = 'Водный камень<br>Набор классификаций';
					$prize3 = 'Травяной камень<br>Набор классификаций';
					$prize4 = 'Громовой камень<br>Набор классификаций';
				}elseif($pil['count'] >= 16 && $pil['count'] <= 25){
					$prize1 = 'Огненный камень<br>Набор классификаций<br>Ягода Печа (5 шт.)';
					$prize2 = 'Водный камень<br>Набор классификаций<br>Ягода Печа (5 шт.)';
					$prize3 = 'Травяной камень<br>Набор классификаций<br>Ягода Печа (5 шт.)';
					$prize4 = 'Громовой камень<br>Набор классификаций<br>Ягода Печа (5 шт.)';
				}elseif($pil['count'] >= 26 && $pil['count'] <= 50){
					$prize1 = 'Огненный камень<br>Набор классификаций<br>Ягода Печа (5 шт.)<br>Мастербол (3 шт.)';
					$prize2 = 'Водный камень<br>Набор классификаций<br>Ягода Печа (5 шт.)<br>Мастербол (3 шт.)';
					$prize3 = 'Травяной камень<br>Набор классификаций<br>Ягода Печа (5 шт.)<br>Мастербол (3 шт.)';
					$prize4 = 'Громовой камень<br>Набор классификаций<br>Ягода Печа (5 шт.)<br>Мастербол (3 шт.)';
				}elseif($pil['count'] >= 51 && $pil['count'] <= 100){
					$prize1 = 'Огненный камень<br>Набор рюкзаков<br>Набор классификаций<br>Ягода Печа (5 шт.)<br>Мастербол (3 шт.)';
					$prize2 = 'Водный камень<br>Набор рюкзаков<br>Набор классификаций<br>Ягода Печа (5 шт.)<br>Мастербол (3 шт.)';
					$prize3 = 'Травяной камень<br>Набор рюкзаков<br>Набор классификаций<br>Ягода Печа (5 шт.)<br>Мастербол (3 шт.)';
					$prize4 = 'Громовой камень<br>Набор рюкзаков<br>Набор классификаций<br>Ягода Печа (5 шт.)<br>Мастербол (3 шт.)';
				}elseif($pil['count'] >= 101 && $pil['count'] <= 140){
					$prize1 = 'Огненный камень<br>Набор рюкзаков<br>Набор классификаций<br>Ягода Печа (10 шт.)<br>Мастербол (6 шт.)';
					$prize2 = 'Водный камень<br>Набор рюкзаков<br>Набор классификаций<br>Ягода Печа (10 шт.)<br>Мастербол (6 шт.)';
					$prize3 = 'Травяной камень<br>Набор рюкзаков<br>Набор классификаций<br>Ягода Печа (10 шт.)<br>Мастербол (6 шт.)';
					$prize4 = 'Громовой камень<br>Набор рюкзаков<br>Набор классификаций<br>Ягода Печа (10 шт.)<br>Мастербол (6 шт.)';
				}elseif($pil['count'] >= 141 && $pil['count'] <= 250){
					$prize1 = 'Огненный камень<br>Набор рюкзаков<br>Набор классификаций (2 шт.)<br>Ягода Печа (10 шт.)<br>Мастербол (6 шт.)';
					$prize2 = 'Водный камень<br>Набор рюкзаков<br>Загадочный сундук<br>Ягода Печа (10 шт.)<br>Мастербол (6 шт.)';
					$prize3 = 'Травяной камень<br>Набор рюкзаков<br>Загадочный сундук<br>Ягода Печа (10 шт.)<br>Мастербол (6 шт.)';
					$prize4 = 'Громовой камень<br>Набор рюкзаков<br>Набор классификаций (2 шт.)<br>Ягода Печа (10 шт.)<br>Мастербол (6 шт.)';
				}elseif($pil['count'] >= 251 && $pil['count'] <= 350){
					$prize1 = 'Огненный камень<br>Набор рюкзаков<br>Набор классификаций (2 шт.)<br>Мастербол (6 шт.)<br>Яйцо #418 Буизель';
					$prize2 = 'Водный камень<br>Набор рюкзаков<br>Набор классификаций (2 шт.)<br>Мастербол (6 шт.)<br>Яйцо #418 Буизель';
					$prize3 = 'Травяной камень<br>Набор рюкзаков<br>Набор классификаций (2 шт.)<br>Мастербол (6 шт.)<br>Яйцо #418 Буизель';
					$prize4 = 'Громовой камень<br>Набор рюкзаков<br>Набор классификаций (2 шт.)<br>Мастербол (6 шт.)<br>Яйцо #418 Буизель';
				}elseif($pil['count'] >= 351 && $pil['count'] <= 500){
					$prize1 = 'Загадочный сундук<br>Набор классификаций<br>Мастербол (6 шт.)<br>Яйцо #599 Клинк';
					$prize2 = 'Загадочный сундук<br>Набор классификаций<br>Мастербол (6 шт.)<br>Яйцо #270 Лотад';
					$prize3 = 'Загадочный сундук<br>Набор классификаций<br>Мастербол (6 шт.)<br>Яйцо #453 Кроуганк';
					$prize4 = 'Загадочный сундук<br>Набор классификаций<br>Мастербол (6 шт.)<br>Яйцо #140 Кабуто';
				}elseif($pil['count'] >= 501 && $pil['count'] <= 800){
					$prize1 = 'Загадочный сундук<br>Набор классификаций (2 шт.)<br>Мастербол (6 шт.)<br>Яйцо #599 Клинк';
					$prize2 = 'Загадочный сундук<br>Набор классификаций (2 шт.)<br>Мастербол (6 шт.)<br>Яйцо #270 Лотад';
					$prize3 = 'Загадочный сундук<br>Набор классификаций (2 шт.)<br>Мастербол (6 шт.)<br>Яйцо #453 Кроуганк';
					$prize4 = 'Загадочный сундук<br>Набор классификаций (2 шт.)<br>Мастербол (6 шт.)<br>Яйцо #140 Кабуто';
				}elseif($pil['count'] >= 801 && $pil['count'] <= 1000){
					$prize1 = 'Загадочный сундук<br>Набор классификаций<br>Яйцо #227 Скармори<br>Яйцо #418 Буизель';
					$prize2 = 'Загадочный сундук<br>Набор классификаций<br>Яйцо #359 Абсол<br>Яйцо #418 Буизель';
					$prize3 = 'Загадочный сундук<br>Набор классификаций<br>Яйцо #449 Гиппопотас<br>Яйцо #418 Буизель';
					$prize4 = 'Загадочный сундук<br>Набор классификаций<br>Яйцо #594 Аломомола<br>Яйцо #418 Буизель';
				}elseif($pil['count'] >= 1001 && $pil['count'] <= 1300){
					$prize1 = 'Загадочный сундук<br>Набор классификаций<br>Яйцо #453 Кроуганк<br>Рассветный камень';
					$prize2 = 'Загадочный сундук<br>Набор классификаций<br>Яйцо #434 Станки<br>Рассветный камень';
					$prize3 = 'Загадочный сундук<br>Набор классификаций<br>Яйцо #140 Кабуто<br>Рассветный камень';
					$prize4 = 'Загадочный сундук<br>Набор классификаций<br>Яйцо #270 Лотад<br>Рассветный камень';
				}elseif($pil['count'] >= 1301 && $pil['count'] <= 2000){
					$prize1 = 'Набор классификаций (2 шт.)<br>Яйцо #418 Буизель<br>Загадочный сундук<br>Перламутровая чешуя';
					$prize2 = 'Набор классификаций (2 шт.)<br>Яйцо #127 Пинсир<br>Загадочный сундук<br>Перламутровая чешуя';
					$prize3 = 'Набор классификаций (2 шт.)<br>Яйцо #590 Фунгус<br>Загадочный сундук<br>Перламутровая чешуя';
					$prize4 = 'Набор классификаций (4 шт.)<br>Загадочный сундук<br>Перламутровая чешуя';
				}elseif($pil['count'] >= 2001 && $pil['count'] <= 2600){
					$prize1 = 'Загадочный сундук<br>Набор классификаций (2 шт.)<br>Перламутровая чешуя<br>Яйцо #359 Абсол';
					$prize2 = 'Загадочный сундук<br>Набор классификаций (2 шт.)<br>Перламутровая чешуя<br>Яйцо #449 Гиппопотас';
					$prize3 = 'Загадочный сундук<br>Набор классификаций (2 шт.)<br>Перламутровая чешуя<br>Яйцо #594 Аломомола';
					$prize4 = 'Загадочный сундук<br>Набор классификаций (2 шт.)<br>Перламутровая чешуя<br>Яйцо #227 Скармори';
				}elseif($pil['count'] >= 2601 && $pil['count'] <= 3200){
					$prize1 = 'Загадочный сундук<br>Рассветный камень<br>Набор классификаций (2 шт.)<br>Перламутровая чешуя<br>Яйцо #599 Клинк';
					$prize2 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (2 шт.)<br>Перламутровая чешуя<br>Яйцо #270 Лотад';
					$prize3 = 'Загадочный сундук<br>Рассветный камень<br>Набор классификаций (2 шт.)<br>Перламутровая чешуя<br>Яйцо #453 Кроуганк';
					$prize4 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (2 шт.)<br>Перламутровая чешуя<br>Яйцо #140 Кабуто';
				}elseif($pil['count'] >= 3201 && $pil['count'] <= 4500){
					$prize1 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (3 шт.)<br>Перламутровая чешуя<br>Яйцо #359 Абсол';
					$prize2 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (3 шт.)<br>Перламутровая чешуя<br>Яйцо #449 Гиппопотас';
					$prize3 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (3 шт.)<br>Перламутровая чешуя<br>Яйцо #594 Аломомола';
					$prize4 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (3 шт.)<br>Перламутровая чешуя<br>Яйцо #227 Скармори';
				}elseif($pil['count'] >= 4501 && $pil['count'] <= 5200){
					$prize1 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (5 шт.)<br>Перламутровая чешуя<br>Яйцо #359 Абсол<br>Яйцо #674 Панчам';
					$prize2 = 'Загадочный сундук<br>Рассветный камень<br>Набор классификаций (5 шт.)<br>Перламутровая чешуя<br>Яйцо #449 Гиппопотас<br>Яйцо #674 Панчам';
					$prize3 = 'Загадочный сундук<br>Рассветный камень<br>Набор классификаций (5 шт.)<br>Перламутровая чешуя<br>Яйцо #594 Аломомола<br>Яйцо #674 Панчам';
					$prize4 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (5 шт.)<br>Перламутровая чешуя<br>Яйцо #227 Скармори<br>Яйцо #674 Панчам';
				}elseif($pil['count'] >= 5201 && $pil['count'] <= 10000){
					$prize1 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (5 шт.)<br>Перламутровая чешуя<br>Яйцо #359 Абсол<br>Яйцо #674 Панчам<br>Яйцо #280 Ралтс';
					$prize2 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (5 шт.)<br>Перламутровая чешуя<br>Яйцо #449 Гиппопотас<br>Яйцо #674 Панчам<br>Яйцо #280 Ралтс';
					$prize3 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (5 шт.)<br>Перламутровая чешуя<br>Яйцо #594 Аломомола<br>Яйцо #674 Панчам<br>Яйцо #280 Ралтс';
					$prize4 = 'Загадочный сундук<br>Овальный камень<br>Набор классификаций (5 шт.)<br>Перламутровая чешуя<br>Яйцо #227 Скармори<br>Яйцо #674 Панчам<br>Яйцо #280 Ралтс';
				}
				$response['question'] = 'Ты добыл <b>Разноцветная пыль ('.$pil['count'].' шт.)</b>. У меня несколько сундуков с подарками. Можешь выбрать только один. Какой сундук выбираешь?
				<div class="eventBox">
					<div onclick="NpcDialog(56,10);" class="Box Red">'.$prize1.'</div>
					<div onclick="NpcDialog(56,20);" class="Box Blue">'.$prize2.'</div>
					<div onclick="NpcDialog(56,30);" class="Box Green">'.$prize3.'</div>
					<div onclick="NpcDialog(56,40);" class="Box Black">'.$prize4.'</div>
				</div>
				';
			}else{
				$response['question'] = 'У тебя нет ни одной разноцветной пыли.';
			}
		break;
		default:
		$response['question'] = 'Привет. Ярмарка была потрясающая. Спасибо тебе за праздничное настроение! У меня для тебя есть подарок за твою Разноцветную пыль, если она конечно же у тебя есть.';
		$response['answer'] = array(
			2 => "Забрать подарок"
		);
		break;
	}
?>