<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';
	$response['name'] = 'Снорлакс';
	switch($npcStep){
		case 1:
			$response['question'] = 'Снорлакс.. Снорл..';
			$response['answer'] = array(
				2 => "Похоже ты съел что-то не то, погоди минутку, принесу тебе лекарств"
			);
		break;
		case 2:
			if(quest_step(6,3)){
				quest_update(6,4);
				$response['question'] = 'Снорлакс! Снорлакс!';
				update_zap(6,4,'Бедный Снорлакс.. Ему стало плохо, он отравился едой. Ему необходима помощь. Нужно сходить к этому старику и попробовать поговорить с ним насчет Снорлакса. Все равно пока что я никак не могу выбраться отсюда.');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 3:
			if(quest_step(6,7)){
				update_zap(6,8,'Снорлаксу стало лучше. Нужно уведомить старика об этом.');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/92.png" class="item"> Лечебное снадобье (1 шт.)';
				quest_update(6,8);
				minus_item(92,1);
				$response['question'] = '<b>СНОРЛАКС! ^^</b>';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(quest_step(6,2)){
			$response['question'] = 'Сно-о-орл.. Снорлакс..';
		}else if(quest_step(6,3)){
			$response['question'] = 'Сно-о-орл.. Снорлакс..';
			$response['answer'] = array(
				1 => "Эй, приятель, что с тобой?"
			);
		}else if(quest_step(6,4)){
			$response['question'] = 'Снорл..';
		}else if(quest_step(6,7)){
			$response['question'] = 'Снорл..';
			$response['answer'] = array(
				3 => "Держи! После этого тебе станет лучше"
			);
		}else{
			$response['question'] = '^^';
		}
		break;
	}
?>
