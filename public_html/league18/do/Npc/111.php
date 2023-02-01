<?
	$response['name'] = 'Джордж';
	switch($npcStep){
		case 1:
			if(quest_step(3,1)){
				$response['question'] = 'Посылка? Давно я ее жду тут. Спасибо.';
				quest_update(3,2);
				minus_item(153,1);
				$response['actionQuestMinus'] = '<img src="/img/world/items/little/153.png" class="item"> Посылка Каролины (1 шт.)';
				$response['actionQuest'] = '<img src="/img/quests/3.png" class="quest"> Обновлена информация в задании «Посылка для...». Загляните в Аквабук.';
				update_zap(3,2,'Отдал посылку Джорджу. <b>Надо вернуться к Каролине</b>.');
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(quest_step(3,1)){
			$response['question'] = '<i>~Любуется местными достопримечательностями~</i>';
			$response['answer'] = array(
				1 => "Вам посылка от Каролины"
			);
		}else{
			$response['question'] = '<i>~Любуется местными достопримечательностями~</i>';
		}
		break;
	}
?>
