<?
	$response['name'] = 'Кладоискатель';
	switch($npcStep){
		case 1:
			if(!quest_isset(14)){
				$response['question'] = 'Тебя это заинтересовало? Хм.. Ну, в особенности нам нужны <div class="itemIsset" onclick="issetAll(56,\'item\')" style="background-image: url(/img/world/items/little/56.png)"></div> Если раздобудешь 10 таких руд, то наградой не обижу.';
				update_zap(14,1,'Кладоискателю из Пещеры Тайн нужна <b>Обсидиановая руда</b> 10 шт. За эту руду он даст мне какую-то награду. Где же мне раздобыть эту руду?');
				quest_update(14,1);
				$response['actionQuest'] = '<img src="/img/quests/14.png" class="quest"> Обновлена информация в задании «Собиратель сокровищ». Загляните в Аквабук.';
			}else{
				$response['question'] = 'Ошибка';
			}
		break;
		case 2:
			if(quest_step(14,1)){
				if(item_isset(56,10)){
					$response['actionQuest'] = '<img src="/img/quests/14.png" class="quest"> Обновлена информация в задании «Собиратель сокровищ». Загляните в Аквабук.';
					update_zap(14,2,'Я отдал 10 обсидиановой руды кладоискателю. В награду мне дали Острый клык.');
					$response['question'] = 'Отлично. Держи обещанную награду. Недавно нашел тут. Очень ценная вещь.';
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/56.png" class="item"> Обсидиановая руда (10 шт.)';
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/65.png" class="item"> Острый коготь (1 шт.)';
					quest_update(14,2,1);
					minus_item(56,10);
					itemAdd(65,1);
					plus_learn_pve(1000);
				}else{
					$response['question'] = 'У тебя их нет.';
				}
			}else{
				$response['question'] = 'Ошибка';
			}
		break;
		default:
		if(!quest_isset(14)){
			$response['question'] = 'Здравствуй. Тоже ищешь всякие ценности? Лучше не стоит.. Это наша пещера.. Наши ресурсы. Но.. Если уж и добудешь каким-либо образом ценные ресурсы, то можешь их отдавать нам..';
			$response['answer'] = array(
				1 => "Хорошо-хорошо. А какие вам ценные ресурсы нужны?"
			);
		}else if(quest_step(14,1)){
			$response['question'] = 'Раздобыл <div class="itemIsset" onclick="issetAll(56,\'item\')" style="background-image: url(/img/world/items/little/56.png)"></div> 10 шт?';
			$response['answer'] = array(
				2 => "Да, я раздобыл руду"
			);
		}else{
			$response['question'] = 'Привет. Запомни, эта пещера моя!';
		}
		break;
	}
?>
