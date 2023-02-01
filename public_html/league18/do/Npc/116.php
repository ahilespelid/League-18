<?
	$response['name'] = 'Тетушка Арина';
	$a = $mysqli->query("SELECT `countPok` FROM `user_quest_info` WHERE `questID` = 10 AND `questStep` = 3 AND `userID` = '".$_SESSION['id']."'")->fetch_assoc();
	$b = (101 - $a['countPok']);
	$c = $mysqli->query("SELECT `need` FROM `npc_more_quest` WHERE `quest_id` = 10 AND `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
	$d = $mysqli->query("SELECT * FROM `user_egg` WHERE `basenum` = '".$c['need']."' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
	$e = $mysqli->query("SELECT `name_rus` FROM `base_pokemons` WHERE `id` = '".$d['basenum']."'")->fetch_assoc();
	$checkUserLoc = $mysqli->query("SELECT `location` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
	$z = $mysqli->query("SELECT `quest_step` FROM `quest_steps` WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 10 AND `quest_step` = 6")->fetch_assoc();
	$rand = rand(1,10);
	if($rand == 1){
		$needText = '#690 Скрельпа';
		$needEgg = 690;
	}elseif($rand == 2){
		$needText = '#440 Хеппини';
		$needEgg = 440;
	}elseif($rand == 3){
		$needText = '#572 Миншино';
		$needEgg = 572;
	}elseif($rand == 4){
		$needText = '#220 Свинуба';
		$needEgg = 220;
	}elseif($rand == 5){
		$needText = '#618 Станфиска';
		$needEgg = 618;
	}elseif($rand == 6){
		$needText = '#173 Клеффы';
		$needEgg = 173;
	}elseif($rand == 7){
		$needText = '#456 Финеон';
		$needEgg = 456;
	}elseif($rand == 8){
		$needText = '#198 Муркроу';
		$needEgg = 198;
	}elseif($rand == 9){
		$needText = '#360 Вайнаут';
		$needEgg = 360;
	}else{
		$needText = '#216 Теддиурса';
		$needEgg = 216;
	}
	switch($npcStep){
		case 1:
			if(!quest_isset(10)){
				quest_update(10,1);
				$response['actionQuest'] = '<img src="/img/quests/10.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
				update_zap(10,1,'Было интересно зайти в Поке-ясли. Необычное место. В одной из комнат нашел женщину, судя по надписи на бейджике, ее зовут Арина. Она попросила меня принести переносную кроватку из спальни. Не буду ей отказывать.');
				$response['question'] = 'Интересно говоришь? <i>~Улыбнулась~</i>. Подай переносную кроватку, раз уж ты тут! Я уложу в нее этого милаху. Она в спальне.. небольшая такая.. кроватка.<i></i>';
			}
		break;
		case 2:
			$response['question'] = 'Что за манеры? Что за слова? Не при детях же..';
			$response['answer'] = array(
				3 => "Меня укусил Ратикейт"
			);
		break;
		case 3:
			if(quest_step(10,2)){
				quest_update(10,3);
				$response['actionQuest'] = '<img src="/img/quests/10.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
				update_zap(10,3,'Эти Ратикейты лезут из подвала. Нужно прогнать их.');
				$response['question'] = 'Ратикейт? Нет! Похоже, они опять пробрались в дом.. Хоть трави их, не трави! Толку ноль. Может ты поможешь? Пойди в подвал и разберись с ними, прошу тебя, пока они детишек моих не покусали! Побей их штук <b>100</b>.. Дальше, думаю, я уже сама справлюсь.';
				$mysqli->query("INSERT INTO `user_quest_info` (`userID`,`questID`,`questStep`,`countPok`) VALUES('".$_SESSION['id']."','10','3','1') ");
			}
		break;
		case 4:
			if(quest_step(10,3) && $a['countPok'] >= 101){
				quest_update(10,4);
				itemAdd(177,3);
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/177.png" class="item"> Ягодный сок (3 шт.)';
				$response['actionQuest'] = '<img src="/img/quests/10.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
				update_zap(10,4,'Большую часть крысенышей я прогнал. Арина дала мне рюкзак Ягодный сок за помощь.');
				$response['question'] = 'Я не думаю, что они вообще больше сюда полезут. Большую часть из них ты прогнал. Еще раз спасибо, возьми этот <div class="itemIsset" onclick="issetAll(177,\'item\')" style="background-image: url(/img/world/items/little/177.png)"></div> сок в подарок от меня.';
				$response['answer'] = array(
					5 => "Спасибо за сок. Вам нужна еще какая-либо помощь?"
				);
			}
		break;
		case 5:
			if(quest_step(10,4)){
				quest_update(10,5);
				update_zap(10,5,'Поке-ясли помимо ухаживания за покемонами занимаются еще и продажей покемонов. Засчет этого у них хватает средств на содержание малюток. Можно будет помочь Арине с заказами на яйца покемонов.');
				$response['actionQuest'] = '<img src="/img/quests/10.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
				$response['question'] = 'Да, нам нужна помощь. И я ведь не рассказала чем занимаются наши ясли помимо ухаживания покемона-малютки. Мы занимаемся еще и продажей яиц покемонов. Но в последнее время мы не успеваем выводить нужных покемонов для заказов. Если бы ты только помог нам с яйцами.. Заказов много.';
				$response['answer'] = array(
					6 => "Да, конечно, я могу помочь вам. Какое яйцо покемона вам нужно?"
				);
			}
		break;
		case 6:
			if(quest_step(10,5)){
				if(!npc_time_check($npcId)){
					if($z){
						$mysqli->query("UPDATE `quest_steps` SET `text` = 'Получен заказ от Арины. Ей необходимо отдать яйцо ".$needText."' WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 10 AND `quest_step` = 6");
					}else{
						update_zap(10,6,'Получен заказ от Арины. Ей необходимо отдать яйцо '.$needText.'.');
					}
					$response['actionQuest'] = '<img src="/img/quests/10.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
					quest_update(10,6);
					$mysqli->query("DELETE FROM `npc_more_quest` WHERE `quest_id` = 10 AND `user_id` = '".$_SESSION['id']."'");
					$response['question'] = 'Спасибо тебе большое. Вознаграждать за каждое яйцо, конечно, я не буду забывать. Сейчас у нас заказали <b>яйцо '.$needText.'</b>.';
					$mysqli->query("INSERT INTO `npc_more_quest` (`user_id`,`quest_id`,`need`) VALUES('".$_SESSION['id']."',10,'".$needEgg."') ");
				}else{
					$response['question'] = 'Ошибка #2.';
				}
			}
		break;
		case 7:
			if(quest_step(10,6)){
				if(!npc_time_check(895)){
					if($z){
						$mysqli->query("UPDATE `quest_steps` SET `text` = 'Получен заказ от Арины. Ей необходимо отдать яйцо ".$needText."' WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 10 AND `quest_step` = 6");
					}else{
						update_zap(10,6,'Получен заказ от Арины. Ей необходимо отдать яйцо '.$needText.'.');
					}
					$response['actionQuest'] = '<img src="/img/quests/10.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
					$wait = time()+86400;
					$mysqli->query("DELETE FROM `npc_more_quest` WHERE `quest_id` = 10 AND `user_id` = '".$_SESSION['id']."'");
					$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 895 AND `userID` = '".$_SESSION['id']."'");
					$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','895','".$wait."') ");
					$response['question'] = 'Да, конечно. Сейчас у нас еще заказали <b>яйцо '.$needText.'</b>.';
					$mysqli->query("INSERT INTO `npc_more_quest` (`user_id`,`quest_id`,`need`) VALUES('".$_SESSION['id']."',10,'".$needEgg."') ");
				}else{
					$response['question'] = 'Ошибка #3.';
				}
			}
		break;
		default:
			if(quest_step(10,1)){
				$response['question'] = 'Принес кроватку? Мне нужно уложить Панчама.';
			}elseif(quest_step(10,2)){
				$response['question'] = 'Принес кроватку? Мне нужно уложить Панчама.';
				$response['answer'] = array(
					2 => "Да, принес, но, черт возьми, больно!"
				);
			}elseif(quest_step(10,3) && $a['countPok'] < 101){
				$response['question'] = 'Бей их! Бей! Еще штук <b>'.$b.'</b> хотя бы!!';
			}elseif(quest_step(10,3) && $a['countPok'] >= 101){
				$response['question'] = 'Спасибо тебе огромное. Остальных я как нибудь сама, не буду тебя нагружать.';
				$response['answer'] = array(
					4 => "Это те еще грызуны.. Было сложновато, не думаю, что вы одна сможете прогнать их всех"
				);
			}elseif(quest_step(10,4)){
				$response['question'] = 'Привет.';
				$response['answer'] = array(
					5 => "Здравствуйте, вам нужна помощь?"
				);
			}elseif(quest_step(10,5)){
				if(!npc_time_check($npcId)){
					$response['question'] = 'Привет. Есть один заказ на яйцо покемона.';
					$response['answer'] = array(
						6 => "Здравствуйте, я готов вам помочь"
					);
				}else{
					$response['question'] = 'Привет. Заказов нет, пока что.';
				}
			}elseif(quest_step(10,6)){
				$response['question'] = 'Привет. Принес яйцо?<br><i>~Выберите яйцо через инвентарь~</i>';
				if(!npc_time_check(895)){
					$response['answer'] = array(
						7 => "Я не смогу справиться с этим заказом. Можно мне другой?"
					);
				}
			}else{
				$response['question'] = '<i>~Укачивает маленького Панчама~</i> Тсс! Разговаривай шепотом! Он только уснул <i>~Косо смотрит на Панчама~</i>. Ты что-то хотел?';
				$response['answer'] = array(
					1 => "Нет, я просто проходил мимо и увидел это здание. Мне было интересно зайти сюда"
				);
			}
		break;
	}
?>
