<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';
	$response['name'] = 'Старый маг';
	switch($npcStep){
		case 1:
			$response['question'] = 'Хм.. Иероглифы на нем мне не знакомы. Я даже и не припомню ничего похожего на это <div class="itemIsset" onclick="issetAll(101,\'item\')" style="background-image: url(/img/world/items/little/101.png)"></div> око. Мне нужно время на изучение этого древнего артефакта. Приходи через час и готовь хорошую сумму денег за починку!';
			$response['answer'] = array(
				2 => "Сколько я должен буду за починку?"
			);
		break;
		case 2:
			if(quest_step(9,2)){
				$wait = time()+3600;
				$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
				$response['question'] = '200.000 монет, не меньше! Это древний артефакт, ресурсов на него уйдет много. Приходи через час, <div class="itemIsset" onclick="issetAll(101,\'item\')" style="background-image: url(/img/world/items/little/101.png)"></div> око будет починено.';
				minus_item(101,1);
				quest_update(9,3);
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/101.png" class="item"> Сломанное светящееся око (1 шт.)';
				$response['actionQuest'] = '<img src="/img/quests/9.png" class="quest"> Обновлена информация в задании «Чародейский свет». Загляните в Аквабук.';
				update_zap(9,3,'Маг починит светящееся око за <b>200.000 монет</b>. Нужно быть в его хижине через час.');
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 3:
			if(quest_step(9,3)){
				if(item_isset(1,200000) && !npc_time_check($npcId)){
					minus_item(1,200000);
					itemAdd(102,1);
					update_zap(9,4,'<div class="itemIsset" onclick="issetAll(102,\'item\')" style="background-image: url(/img/world/items/little/102.png)"></div> Око починено. Нужно отдать его девушке в лесу Веридиана.');
					quest_update(9,4);
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (200000 шт.)';
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/102.png" class="item"> Светящееся око (1 шт.)';
					$response['actionQuest'] = '<img src="/img/quests/9.png" class="quest"> Обновлена информация в задании «Чародейский свет». Загляните в Аквабук.';
					$response['question'] = 'Держи этот артефакт и будь осторожней! Удачи тебе.';
				}else{
					$response['question'] = 'Ошибка!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(quest_step(9,2)){
			$response['question'] = 'Привет. Ты по делу? Если нет, то не отвлекай меня.';
			$response['answer'] = array(
				1 => "Мне нужна ваша помощь. Мне нужно починить это око"
			);
		}elseif(quest_step(9,3)){
			if(!npc_time_check($npcId)){
				if(item_isset(1,200000)){
					$response['question'] = 'Я починил <div class="itemIsset" onclick="issetAll(102,\'item\')" style="background-image: url(/img/world/items/little/102.png)"></div> око и вижу, что у тебя достаточно денег, чтобы оплатить починку.';
					$response['answer'] = array(
						3 => "Держите деньги"
					);
				}else{
					$response['question'] = 'Я починил <div class="itemIsset" onclick="issetAll(102,\'item\')" style="background-image: url(/img/world/items/little/102.png)"></div> око, но у тебя не хватает денег, чтобы оплатить починку.';
				}
			}else{
				$response['question'] = '<i>~Изучает светящееся око~</i>';
			}
		}else{
			$response['question'] = '<i>~Рассматривает старые свитки..~</i>';
		}
		break;
	}
?>
