<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';
	$response['name'] = 'Дед мороз';
	switch($npcStep){
		case 1:
			$response['question'] = 'Думаю, это не столь важно. Сейчас нельзя терять не минуты! Новый год под угрозой срыва, и ты можешь помочь мне вернуть все на свои места.';
			$response['answer'] = array(
				2 => "Новый год в опасности? Чем я могу помочь?"
			);
		break;
		case 2:
			if(quest_step(21,1)){
				$response['question'] = 'Для начала нам нужно раздобыть 10 волшебной руды в пещере тайн. Я перемещу тебя в специальную локацию и дам специальный предмет, чтобы ты смог ее разглядеть среди всей остальной ерунды.';
				$response['answer'] = array(
					3 => "Хорошо! Скоро вернусь."
				);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 3:
			if(quest_step(21,1)){
				itemAdd(334,1);
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1001','ng_quest_ruda') ");
		$mysqli->query("UPDATE `users` SET `location`='1002' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/334.png" class="item"> Небольшой кристалл';
				$response['question'] = 'Предмет уже в твоём инвентаре. Удачи, и помни, что завершить все необходимо до 12:00 31-12-2022.';
				quest_update(21,2);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 19:
			if(quest_step(21,2)){
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1001','ng_quest_ruda') ");
		$mysqli->query("UPDATE `users` SET `location`='1002' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
				$response['question'] = 'Предмет уже в твоём инвентаре. Удачи, и помни, что завершить все необходимо до 12:00 31-12-2022.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 20:
			if(quest_step(21,3)){
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1001','ng_quest_drevo') ");
		$mysqli->query("UPDATE `users` SET `location`='1003' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
				$response['question'] = 'Предмет уже в твоём инвентаре. Удачи, и помни, что завершить все необходимо до 12:00 31-12-2022.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		case 21:
			if(quest_step(21,14)){
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1001','ng_quest_boss') ");
		$mysqli->query("UPDATE `users` SET `location`='1005' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
				$response['question'] = ' Удачи, и помни, что завершить все необходимо до 12:00 31-12-2022.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
			
		case 4:
			if(item_isset(337,10)){
				if(quest_step(21,2)){
					quest_update(21,3);
					minus_item(337,10);
					minus_item(334,1);
					itemAdd(5,5);
					itemAdd(109,20);
				    $response['actionQuestPlus'] = '<img src="/img/world/items/little/109.png" class="item"> Генобол (20 шт.) <br><img src="/img/world/items/little/5.png" class="item"> Мастербол (5 шт.) ';				    
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/337.png" class="item"> Волшебная руда (10 шт.)';
					
					$response['question'] = 'Вот спасибочки! Держи небольшую награду! Теперь нам нужно добыть 5 штук древесины из #185 Судовудо. Но будь осторожен, они крайне сильны! Удачи!';
				}else{
					$response['question'] = 'Ошибка';
				}
			}else{
				$response['question'] = 'У тебя ее нет!';
			}
		break;
		case 5:
			if(item_isset(338,5)){
				if(quest_step(21,3)){
					quest_update(21,4);
					minus_item(338,5);
					itemAdd(256,1);
				    $response['actionQuestPlus'] = '<img src="/img/world/items/little/256.png" class="item"> Коробка с витаминами (1 шт.)';
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/338.png" class="item"> Древесина (5 шт.)';
					
					$response['question'] = 'Спасибо, возьми эту коробку. Пока я буду чинить сани, обратись к моему помошнику, Эльфу, он расскажет тебе следующее задание';
				}else{
					$response['question'] = 'У тебя ее нет!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 6:
			if(quest_step(21,6)){
				$response['question'] = 'Удачи, и помни, что завершить все необходимо до 12:00 31-12-2022.';
				quest_update(21,7);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 7:
      if(item_isset(340,1)) {
        $rand = mt_rand(1,4);
        minus_item(340,1);
        quest_update(21,11);
        if($rand == 1) {
          itemAdd(36,1);
        }elseif($rand == 2) {
          itemAdd(36,1);
        }elseif($rand == 3) {
          itemAdd(19,1);
        }else{
          itemAdd(21,1);
        }
          $response['actionQuestMinus'] = '<img src="/img/world/items/little/340.png" class="item"> Мешок (1 шт.)';        
          $response['actionQuestPlus'] = '<img src="/img/world/items/little/0.png" class="item"> Эвольвер (1 шт.)';
          $response['question'] = 'Замечательно! Держи награду! Готов  к следующему заданию?';
		  $response['answer'] = array(
			    8 => "Да!"
			);          
      }else{
        $response['question'] = 'У тебя нет мешка!';
      }
		break;
		case 8:
			if(quest_step(21,11)){
				$response['question'] = 'Мои помошники нашли почти все подарки, которые выпали по пути. Вот только последние 3 никак не может раздобыть. <br><br> Нам нужны покемоны ОДНОГО ПОЛА, чтобы открыть портал и забрать эти подарки!  У меня есть описания нужных покемонов Записывай: <br> - Первый подарок у покемона тёмного типа, для устрашения врага использует свои клыки, но при этом убегает, поджав хвост, когда атакуют его самого <br> - Пол второго покемона всегда одинаков, обладает очень хорошим слухом, ведь своими ушами он может двигать в любом направлении. <br> - Самый высокий базовый стат этого покемона - атака, что многое говорит о нем. При весе менее 20 кг, он с легкостью может поднять довольно тяжелого человека. <br><br> Приходи, когда у тебя будет каждый из этих покемонов!';
				/* 261 Пучина, 032 Нидоран, 066 Мачоп */
				quest_update(21,12);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 9:
			$allPokemons = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			if($allPokemons->num_rows < 4){
				$response['question'] = 'Если я заберу этих покемонов, у тебя не останется покемонов с собой!';
			}else{
				if(quest_step(21,12)){
					$p261 = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = 261 AND `gender` = 'Мальчик'")->num_rows;
					$p032 = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = 32 || `basenum` = 33 AND `gender` = 'Мальчик'")->num_rows;
					$p066 = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = 66 AND `gender` = 'Мальчик'")->num_rows;
					if($p261 > 0 && $p032 > 0 && $p066 > 0){
						quest_update(21,13);
						$response['actionQuestMinus'] = '<img src="/img/pokemons/anim/normal/261.gif"> #261 Пучина<br><img src="/img/pokemons/anim/normal/32.gif"> #032 Нидоран<br><img src="/img/pokemons/anim/normal/66.gif"> #066 Мачоп';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/95.png" class="item"> Набор классификаций (2 шт.)';
						$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = 261 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = 32 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = 33 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");						
						$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = 66 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$response['action'] = 'updateTeam';
						
						$response['question'] = 'Супер, теперь мы добудем подарки. Осталось последнее - небоходимо убить несколько покемонов-боссов и получить и них волшебную пыль. Подготовься и приходи ко мне!';
					}else{
						$response['question'] = 'У тебя их нет!';
					}
				}else{
					$response['question'] = 'Ошибка!';
				}
			}
		break;
		case 10:
			if(quest_step(21,13)){
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1001','ng_quest_boss') ");
		$mysqli->query("UPDATE `users` SET `location`='1005' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
			    
				$response['question'] = 'Вот же он!';
				quest_update(21,14);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 11:
			if(item_isset(344,1)){
				if(quest_step(21,14)){
					quest_update(21,15);
					minus_item(344,1);
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/344.png" class="item"> Волшебный порошок (1 шт.)';
					$response['question'] = 'Спасибо тебе! Спасибо огромное! Без тебя мы бы не справились! Новый год спасён! В награду можешь выбрать одну из ТМ атак.';
					$response['answer'] = array(
				12 => "Покажите варианты, пожалуйста"
				);
				}else{
					$response['question'] = 'Ошибка';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 12:
			if(quest_step(21,15)){
				$response['question'] = 'Вот все, что есть.';
					$response['answer'] = array(
				13 => "Ледяной луч",
				14 => "Молния",
				15 => "Огнемёт",
				16 => "Кипяток",
				17 => "Блуждающие огни",
				18 => "Электрошок"
				);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 13:
			if(quest_step(21,15)){
				$response['question'] = 'С Новым Годом!!';
				quest_update(21,16,1);
					itemAdd(1013,1);
				    $response['actionQuestPlus'] = '<img src="/img/world/items/little/1013.png" class="item"> ТМ-атака';				    
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 14:
			if(quest_step(21,15)){
				$response['question'] = 'С Новым Годом!!';
				quest_update(21,16,1);
					itemAdd(1024,1);
				    $response['actionQuestPlus'] = '<img src="/img/world/items/little/1013.png" class="item"> ТМ-атака';				    
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 15:
			if(quest_step(21,15)){
				$response['question'] = 'С Новым Годом!!';
				quest_update(21,16,1);
					itemAdd(1035,1);
				    $response['actionQuestPlus'] = '<img src="/img/world/items/little/1013.png" class="item"> ТМ-атака';				    
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 16:
			if(quest_step(21,15)){
				$response['question'] = 'С Новым Годом!!';
				quest_update(21,16,1);
					itemAdd(1055,1);
				    $response['actionQuestPlus'] = '<img src="/img/world/items/little/1013.png" class="item"> ТМ-атака';				    
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 17:
			if(quest_step(21,15)){
				$response['question'] = 'С Новым Годом!!';
				quest_update(21,16,1);
					itemAdd(1061,1);
				    $response['actionQuestPlus'] = '<img src="/img/world/items/little/1013.png" class="item"> ТМ-атака';				    
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 18:
			if(quest_step(21,15)){
				$response['question'] = 'С Новым Годом!!';
				quest_update(21,16,1);
					itemAdd(1073,1);
				    $response['actionQuestPlus'] = '<img src="/img/world/items/little/1013.png" class="item"> ТМ-атака';				    
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(quest_step(21,1)){
			$response['question'] = 'Привет. '.$_SESSION['login'].', верно? Я так ждал нашей встречи.';
			$response['answer'] = array(
				1 => "Откуда вы знаете моё имя?"
			);
		}else if(quest_step(21,2)){
			$response['question'] = 'Ты принес 10 штук руды?';
			$response['answer'] = array(
				4 => "Да, вот она!",
				19 => "Я бы хотел вернуться в шахту"
			);
		}else if(quest_step(21,3)){
			$response['question'] = 'Напоминаю, тебе нужно найти 5 штук древесины из #185 Судовудо. ';
			$response['answer'] = array(
				5 => "Древесина у меня!",
				20 => "Хочу вернуться в лес"
			);
		}else if(quest_step(21,6)){
			$response['question'] = 'Продолжим спасать новый год? Я растерял все подарки, а мой мешок порвался. Нужен новый. Возможно, швея Лавендера сможет нам помочь?';
			$response['answer'] = array(
				6 => "Понял вас! Бегу всё узнавать"
			);
		}else if(quest_step(21,10)){
			$response['question'] = 'Мешок у тебя?';
			$response['answer'] = array(
				7 => "Да, вот он!"
			);	
		}else if(quest_step(21,11)){
			$response['question'] = 'Продолжим?';
			$response['answer'] = array(
				8 => "Да!"
			);
		}else if(quest_step(21,12)){
			$response['question'] = 'Вот описания покемонов, которые нам нужны: <br> - Первый подарок у покемона тёмного типа, для устрашения врага использует свои клыки, но при этом убегает, поджав хвост, когда атакуют его самого <br> - Пол второго покемона всегда одинаков, обладает очень хорошим слухом, ведь своими ушами он может двигать в любом направлении. <br> - Самый высокий базовый стат этого покемона - атака, что многое говорит о нем. При весе менее 20 кг, он с легкостью может поднять довольно тяжелого человека. <br><br> Приходи, как достанешь каждого из этих покемонов! И помни, что все они должны быть ОДНОГО пола, иначе ничего не выйдет';
			$response['answer'] = array(
				9 => "Покемоны у меня!"
			);	
		}else if(quest_step(21,13)){
			$response['question'] = 'Ты готов сразиться с боссом?';
			$response['answer'] = array(
				10 => "Да!"
			);				
		}else if(quest_step(21,14)){
			$response['question'] = 'Получилось забрать нужную нам вещь?';
			$response['answer'] = array(
				11 => "Да!",
				21 => "Мне нужна еще одна попытка"
			);	
		}else if(quest_step(21,15)){
			$response['question'] = 'Новый год спасён! В награду можешь выбрать одну из ТМ атак.';
			$response['answer'] = array(
				12 => "Покажите, пожалуйста, варианты"
			);
		}else{
			$response['question'] = 'Привет, тренер!';
		}
		break;
	}
?>