<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';
	$response['name'] = 'Старик';
	switch($npcStep){
		case 1:
			if(quest_step(6,2)){
				quest_update(6,3);
				$response['question'] = 'Не мог! Убирайся отсюда, от вас, чужаков из внешнего мира одни проблемы!';
				update_zap(6,3,'Я выбрался в какую-то деревню. В ней я нашел старика, но он не захотел со мной разговаривать.. Как мне выбраться обратно?');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			$response['question'] = 'Что? Да быть того не может, здесь нет того, чем можно отравиться. К тому же, я сам даю ему все фрукты.';
			$response['answer'] = array(
				3 => "Если не верите мне, посмотрите сами! Но состояние его ухудшается с каждой минутой."
			);
		break;
		case 3:
			if(quest_step(6,4)){
				quest_update(6,5);
				update_zap(6,5,'Мне нужно добыть Призрачные цветы (5 шт.) на цветочном лугу из #092 Гастли. Из этих цветов старик сделает лекарства для больного Снорлакса. Кстати, старик сказал, что его товарищ Мистер Горг разобрал завал. Теперь я могу вернуться домой, но Снорлакса я бросать не буду!');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				$response['question'] = 'Хорошо, можешь пройти на цветочный луг, там есть всё необходимое, принеси мне <b>Призрачный цветок (5 шт.)</b>, я приготовлю лекарства. Но будь осторожен, здешним Ариадосам не нравится, когда кто-то пробирается на их территорию. Цветы можешь получить с Гастли. Удачи тебе. Кстати, мне сообщил мой товарищ Горг, что завал, который образовался между Узким проходом, разобран. Теперь, если хочешь, можешь отправиться домой. Ты же ведь не из этой деревни.. Но, я думаю, ты не бросишь Снорлакса в беде, ведь тренеры так не поступают.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 4:
			if(quest_step(6,5)){
				if(item_isset(91,5)){
					$wait = time()+1800;
					$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					minus_item(91,5);
					quest_update(6,6);
					update_zap(6,6,'Через 30 минут снадобье для Снорлакса будет готово. Надо бы забрать его у старика.');
					$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/91.png" class="item"> Призрачный цветок (5 шт.)';
					$response['question'] = 'Отлично! Приходи через 30 минут, думаю, снадобье будет готово.';
				}else{
					$response['question'] = 'Ошибка!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 5:
			if(quest_step(6,6)){
				if(!npc_time_check($npcId)){
					itemAdd(92,1);
					quest_update(6,7);
					update_zap(6,7,'<div class="itemIsset" onclick="issetAll(92,\'item\')" style="background-image: url(/img/world/items/little/92.png)"></div> Снадобье готово. Нужно дать его Снорлаксу.');
					$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/92.png" class="item"> Лечебное снадобье (1 шт.)';
					$response['question'] = 'Держи, снадобье готово!';
					$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 28 AND `userID` = '".$_SESSION['id']."'");
				}else{
					$response['question'] = 'Нет, еще не готово. Приходи позже!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 6:
			$response['question'] = 'Верно, спасибо тебе, что позаботился о нём. Оказывается ты хороший человек... Извини за моё предвзятое мнение, может мне тебя как-то отблагодарить?';
			$response['answer'] = array(
				7 => "Было бы неплохо помочь с расшифровкой!"
			);
		break;
		case 7:
			if(quest_step(6,8)){
				update_zap(6,9,'Старик сказал, что Мистер Горг поможет мне с расшифровкой знаков на столпах в Круглом зале.');
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				quest_update(6,9);
				$response['question'] = 'На столпах, что находятся в руинах? Да, Горг, как раз, сейчас переводит их. Возвращайся в круглый зал, он будет ждать тебя там.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 8:
			$response['question'] = 'Отличная идея!';
		break;
		case 9:
			if(quest_step(6,10)){
				quest_update(6,11);
				$response['question'] = 'Подходи к первому столпу, а я пока займусь расшифровкой следующего.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(quest_step(6,2)){
			$response['question'] = 'Что тебе тут нужно, чужак?';
			$response['answer'] = array(
				1 => "Простите, я заблудился в руинах и вышел к этой деревне, не могл..."
			);
		}else if(quest_step(6,4)){
			$response['question'] = 'Что тебе тут нужно, чужак?';
			$response['answer'] = array(
				2 => "Извините ещё раз, скажите где тут можно достать лекарства от отравления? Снорлакс, лежащий на равнине явно нуждается в них!"
			);
		}else if(quest_step(6,3)){
			$response['question'] = 'Убирайся!';
		}else if(quest_step(6,5)){
			$response['question'] = 'Принес <div class="itemIsset" onclick="issetAll(91,\'item\')" style="background-image: url(/img/world/items/little/91.png)"></div> цветы?';
			if(item_isset(91,5)){
				$response['answer'] = array(
					4 => "Да, держите."
				);
			}
		}else if(quest_step(6,6)){
			$response['question'] = '<i>~Стоит возле котла и тщательно перемешивает находящиеся внутри смеси~</i>';
			$response['answer'] = array(
				5 => "Ну что, всё готово?"
			);
		}else if(quest_step(6,8)){
			$response['question'] = 'Ну что?';
			$response['answer'] = array(
				6 => "Похоже, ему становится лучше"
			);
		}else{
			$response['question'] = '<i>~Пьет чай с лимоном~</i>';
		}
		break;
	}
?>
