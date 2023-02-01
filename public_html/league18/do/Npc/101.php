<?
	$response['name'] = 'Арцеус';
	switch($npcStep){
		case 1:
			if(quest_step(6,20) || quest_step(6,21)){
				if(quest_step(6,21)){
					quest_update(6,21,1);
				}
				$mysqli->query("UPDATE `users` SET `location`= 71 WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			if(quest_step(6,19)){
				$response['question'] = '<i>~Создает свою копию~</i>. Уничтожь мою копию и отбери, то, что нужно мне!';
				quest_update(6,20);
				$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
				update_zap(6,20,'Арцеус - создатель мира. Я должен победить его, если хочу получить награду. Думаю, это будет что-то стоящее.');
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 3:
			if(quest_step(6,20)){
				if(item_isset(131,1)){
					$response['question'] = 'Поздравляю с победой! Но, это всего лишь моя копия.. Меня бы ты вряд ли победил <i>~Посмеивается~</i>. Держи этого покемона! Тот механизм, что ты мне дал - является некой машиной времени. Этого Аэродактиля я принес тебе далеко из прошлого. Надеюсь, теперь ты знаешь правду. А теперь, уходи в свой мир!';
					quest_update(6,21,1);
					minus_item(131,1);
					$response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/142.gif"> #142 Аэродактиль';
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/131.png" class="item"> Механизм времени (1 шт.)';
					$response['actionQuest'] = '<img src="/img/quests/6.png" class="quest"> Обновлена информация в задании «Древняя неизвестность». Загляните в Аквабук.';
					newPokemon(142,$_SESSION['id'],1,false,0,'true',1,false,false,false,false,true);
					update_zap(6,21,'Арцеус дал мне Аэродактиля за победу над его копией. Это приключение я никогда не забуду!');
				}else{
					$response['question'] = 'У тебя нету того, что мне нужно.';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(quest_step(6,19)){
			$response['question'] = 'Приветствую тебя в моих скромных "апартаментах", человек. Я - создатель этого мира. Столпы - это некие знаки. Они сильно начинают сиять, предупреждая всех об опасности, но, к счастью, кроме Команды Аква, Земле ничего не угрожает. Я думаю, что вы сможите им противостоять. И я удивлен, что до сих пор никто не разгадал их тайну. Ты единственный, кто это сделал. <br> Т.к. я являюсь владыкой этого мира, я даю тебе шанс победить меня, вернее не меня, а мою копию. Ты получишь ценный приз, если победишь.';
			$response['answer'] = array(
				2 => "Я готов сразиться с тобой"
			);
		}else if(quest_step(6,20)){
			$response['question'] = 'Жду от тебя победы!';
			$response['answer'] = array(
				3 => "Держи то, что тебе нужно было!",
				1 => "Я хочу вернуться"
			);
		}else if(quest_step(6,21)){
			$response['question'] = '^_^';
			$response['answer'] = array(
				1 => "Вернуться домой"
			);
		}else{
			$response['question'] = '<i>~Издает непонятные звуки~</i>';
		}
		break;
	}
?>
