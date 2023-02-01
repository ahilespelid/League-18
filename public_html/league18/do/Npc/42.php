<?
	$response['name'] = 'Каролина';
	switch($npcStep){
		case 1:
			if(!quest_isset(9)){
				$response['question'] = 'Око! Мое око! Мое <div class="itemIsset" onclick="issetAll(102,\'item\')" style="background-image: url(/img/world/items/little/102.png)"></div> <b>светящееся око</b>! Оно потерялось тут. Я не могу выдеть, пожалуйста, помогите!';
				quest_update(9,1);
				$response['actionQuest'] = '<img src="/img/quests/9.png" class="quest"> Обновлена информация в задании «Чародейский свет». Загляните в Аквабук.';
				update_zap(9,1,'Кто эта девушка? Она похожа на какую-то колдунью. Я должен ей помочь! Вдруг она меня заколдует.. Ну или наделит меня силой, если я ей помогу. Она потеряла <b>светящееся око</b> в <b>Лесу Веридиана</b>. Я должен его отыскать.');
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			if(quest_step(9,1)){
				if(item_isset(101,1)){
					$response['question'] = 'Что? Почему? Я все равно не могу видеть! Похоже, мое <div class="itemIsset" onclick="issetAll(101,\'item\')" style="background-image: url(/img/world/items/little/101.png)"></div> око сломано! Найди того, кто починит его, прошу тебя!';
					update_zap(9,2,'Еще чего! Почему я должен ей помогать? Ах, да, она же колдунья. Заколдует меня и все.. Чтоб тебя! Надо искать человека, который бы починил светящееся око.. Но где же его найти?');
					quest_update(9,2);
					$response['actionQuest'] = '<img src="/img/quests/9.png" class="quest"> Обновлена информация в задании «Чародейский свет». Загляните в Аквабук.';
				}else{
					$response['question'] = 'Ошибка!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 3:
			if(quest_step(9,4)){
				if(item_isset(102,1)){
					$response['question'] = 'Да! Я вижу! Ах-ха-ха!!! <i>~Злобный смех~</i> Как мне тебя отблагодарить? Может быть дать супер силу? Или же наградить тебя безграничным богатством? Эх.. Если бы я только могла. Я даже за вещами уследить не могу, какие там богатства.. Но, кое что все же есть, держи <i>~Дает вам <div class="itemIsset" onclick="issetAll(19,\'item\')" style="background-image: url(/img/world/items/little/19.png)"></div> Сумрачный камень~</i> Спасибо тебе. Если будет нужна помощь, ты всегда можешь найти меня тут ^_^';
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/102.png" class="item"> Светящееся око (1 шт.)';
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/19.png" class="item"> Камень сумрака (1 шт.)';
					minus_item(102,1);
					update_zap(9,5,'Я помог чародейке. В знак благодарности мне дали Камень сумрака. Если понадобится какая-нибудь помощь по "мистике", я всегда могу обратиться к ней.');
					quest_update(9,5,1);
					$response['actionQuest'] = '<img src="/img/quests/9.png" class="quest"> Обновлена информация в задании «Чародейский свет». Загляните в Аквабук.';
					itemAdd(19,1);
				}else{
					$response['question'] = 'Ошибка!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 4:
			if(quest_step(9,5,1) && !quest_isset(3)){
				$response['question'] = 'Я? Ты еще смеешь сомневаться? Могу показать.. Сейчас превращу тебя в Катерпи, ой как будет забавно!';
				$response['answer'] = array(
					5 => "Нет!!! Стой! Не надо. Я ни капли не сомневался, что ты колдунья.. Мне нужна помощь."
				);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 5:
			if(quest_step(9,5,1) && !quest_isset(3)){
				$response['question'] = 'Какая еще помощь? Ты мне помог - я тебе отплатила камнем. Теперь иди своей дорогой, а я своей. Я никому не помогаю!';
				$response['answer'] = array(
					6 => "Если бы не я, то ты бы так и сидела тут без своего ока и никто бы тебе не помог!"
				);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 6:
			if(quest_step(9,5,1) && !quest_isset(3)){
				$response['question'] = '... Ладно, прости, что тебе нужно?';
				$response['answer'] = array(
					7 => "Можно ли как-нибудь изменить характер или гены покемону?"
				);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 7:
			if(quest_step(9,5,1) && !quest_isset(3)){
				$response['question'] = 'Да, это возможно, но не всегда получается. Магия это такая штука.. Кто-то владеет ей в совершенстве, а кто-то.. я..';
				$response['answer'] = array(
					8 => "Что для этого нужно?"
				);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 8:
			if(quest_step(9,5,1) && !quest_isset(3)){
				$response['question'] = 'Знаешь.. помоги-ка мне с посылкой. Ее нужно доставить в Хоэнн. Моему хорошему другу.';
				$response['answer'] = array(
					9 => "Что? Какая еще посылка?"
				);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 9:
			if(quest_step(9,5,1) && !quest_isset(3)){
				$response['question'] = 'Да обычная посылка.. С ингредиентами для зелий. Нужно отнести ее Джорджу. Он живет в Олдейле. Помоги мне - я помогу тебе!';
				$response['answer'] = array(
					10 => "Хорошо. И обещай, что поможешь!"
				);
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 10:
			if(quest_step(9,5,1) && !quest_isset(3)){
				$response['question'] = 'Я тебя хоть раз обманывала? Иди уже.';
				update_zap(3,1,'Мне в голову пришла мысль - а вдруг можно как-нибудь сменить характер или гены покемона? Я спросил у Каролины, колдуньи, которой я помог. Она сказала, что это возможно, но она не скажет, пока я не <b>отвезу посылку в Хоэнн</b> какому-то <b>Джорджу</b> - ее приятелю. Он живет в <b>Олдейле</b>. Чтож, как говориться, в путь!');
				quest_update(3,1);
				itemAdd(153,1);
				$response['actionQuestPlus'] = '<img src="/img/world/items/little/153.png" class="item"> Посылка Каролины (1 шт.)';
				$response['actionQuest'] = '<img src="/img/quests/3.png" class="quest"> Обновлена информация в задании «Посылка для...». Загляните в Аквабук.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 11:
			if(quest_step(9,5,1) && quest_step(3,2)){
				$response['question'] = 'Спасибо, надеюсь, что он даволен.. Пока ты был в поездке, я подготовилась. Чтобы тебе было легче воспринимать магию, я буду создавать леденцы, которые будут повышать гены и менять характер. Леденец, который будет менять характер, будет чаще всего менять его на обычный. А второй леденец будет чаще увеличивать ген Здоровья. <i>~Обновлен ваш Крафт~</i>';
				update_zap(3,3,'Передал Каролине, что Джордж взял посылку. Каролина сказала, что теперь она мне будет помогать создавать леденцы, которые меняют характер покемону, повышают гены.');
				quest_update(3,3,1);
				$mysqli->query("INSERT INTO `craft_recipe_user` (`user`,`recipe`) VALUES ('".$_SESSION['id']."',154) ");
				$mysqli->query("INSERT INTO `craft_recipe_user` (`user`,`recipe`) VALUES ('".$_SESSION['id']."',155) ");
				$response['actionQuest'] = '<img src="/img/quests/3.png" class="quest"> Обновлена информация в задании «Посылка для...». Загляните в Аквабук.';
			}else{
				$response['question'] = 'Посылка все еще у тебя.. Врун!';
			}
		break;
		case 12:
			if(quest_step(3,3,1) && quest_step(19,3)){
				$response['question'] = 'Что случилось?';
				$response['answer'] = array(
					13 => "Меня послала к тебе одна Загадочная старушка. Она сказала, что ты можешь помочь... Дело в том, что в Хоэнне на Маршруте 121 обосновалась стая Реуниклусов и их младших форм. Беда в том, что один из них ведёт себя очень неподобающи, чем нервирует остальных. Пока все под контролем старшего Реуниклуса, но тот опасается последствий, нужно что-то сделать с этим"
				);
			}
		break;
		case 13:
			if(quest_step(3,3,1) && quest_step(19,3)){
				$response['question'] = 'Бабушка!? Неужели, ты не догодался. Заколдованный кислый леденец запросто решит твою проблему с нравом слизнячка. Только вот... <i>~Каролина задумалась~</i>';
				$response['answer'] = array(
					14 => "Это была твоя бабушка? Серьезно?"
				);
			}
		break;
		case 14:
			if(quest_step(3,3,1) && quest_step(19,3)){
				$response['question'] = 'Не перебивай. Зная какие Реуниклусы мудрые создания, они явно бы не стали бунтовать по пустякам, понимаешь к чему я?';
				$response['answer'] = array(
					15 => "Эм-м-м... Не совсем понимаю"
				);
			}
		break;
		case 15:
			if(quest_step(3,3,1) && quest_step(19,3)){
				update_zap(19,4,'Вот же колдуньи! Куда не сунься на них натыкаюсь, но что поделать... По крайней мере, мы на одной стороне, и они мне помогли. Теперь нужно <b>создать Заколдованный кислый леденец</b> и <b>#710 Пампкабу 30 ур. с атакой «Зловещий луч»</b> раздобыть и вернуться к стае Реуниклусов.');
				quest_update(19,4);
				$response['actionQuest'] = '<img src="/img/quests/19.png" class="quest"> Обновлена информация в задании «Слизняк». Загляните в Аквабук.';
				$response['question'] = 'Этот покемон так просто не дастся. Думаю, тебе понадобится <span class="bgPok" onclick="openDex(710)"><img src="/img/pokemons/anim/normal/710.gif"> #710 Пампкабу</span> с атакой <b>«Зловещий луч»</b>. Советую докачать тыкву до <b>30 уровня</b>, мало ли... Вообщем, создавай заколдованный леденец и найди покемона-тыковку. Возвращайся с этим добром к Реуниклусу. К сожалению, больше помочь ничем не могу.';
			}
		break;
		default:
		if(!quest_isset(9)){
			$response['question'] = '<i>~Плача отмахивается во все стороны, с криками о помощи пробегает мимо вас~</i> Нет! Нет! Нет! Остановите это кто-нибудь, пожалуйста! Темно! Мне слишком темно, спасите!';
			$response['answer'] = array(
				1 => "Что? Что с вами? Как мне вам помочь?"
			);
		}elseif(quest_step(9,1)){
			$response['question'] = 'Мое <div class="itemIsset" onclick="issetAll(102,\'item\')" style="background-image: url(/img/world/items/little/102.png)"></div> око, оно у тебя?';
			if(item_isset(101,1)){
				$response['answer'] = array(
					2 => "Да, оно у меня"
				);
			}
		}elseif(quest_step(9,2)){
			$response['question'] = 'Ты починил око? Я боюсь тут находиться.. Я же ничего не вижу.';
			if(item_isset(102,1)){
				$response['answer'] = array(
					3 => "Да, я нашел одного мага, он его и починил"
				);
			}
		}elseif(quest_step(9,3)){
			$response['question'] = 'Я слепа..';
		}elseif(quest_step(9,4)){
			$response['question'] = 'Я чувствую его! Оно у тебя, да? Дай мне его!';
			$response['answer'] = array(
				3 => "Да, оно у меня, держи. Знаешь сколь.."
			);
		}elseif(quest_step(9,5,1) && !quest_isset(3)){
			$response['question'] = '<i>~Играет с Муркроу~</i>';
			$response['answer'] = array(
				4 => "Каролина, у меня такое дело.. Ты же ведь колдунья?"
			);
		}elseif(quest_step(9,5,1) && quest_step(3,1) || quest_step(9,5,1) && quest_step(3,2)){
			$response['question'] = 'Отвез посылку?';
			$response['answer'] = array(
				11 => "Да"
			);
		}elseif(quest_step(9,5,1) && quest_step(3,3,1)){
			$response['question'] = 'Привет. Как поживаешь? Я всегда тебе помогу с Леденцами!';
			if(quest_step(3,3,1) && quest_step(19,3)){
				$response['answer'] = array(
					12 => "Нет, сейчас есть дело посерьезней."
				);
			}
		}else{
			$response['question'] = '<i>~Играет с Муркроу~</i>';
		}
		break;
	}
?>
