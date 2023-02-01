<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';
	$response['name'] = 'Маленькая Синди';
	switch($npcStep){
		case 1:
			$response['question'] = 'Они! Они украли у меня мою игрушку! <i>~Показывает пальцем в сторону Дороги 18~</i>';
			$response['answer'] = array(
				2 => "Кто они?"
			);
		break;
		case 2:
			if(!quest_isset(4)){
				$response['question'] = 'Эти.. Плохие покемоны! <img src="/img/pokemons/anim/normal/568.gif"> <b>Траббиши</b>! Они напали на меня и отобрали мою <div class="itemIsset" onclick="issetAll(24,\'item\')" style="background-image: url(/img/world/items/little/24.png)"></div> игрушку! <i>~Начинает еще сильнее плакать~</i>';
				$response['answer'] = array(
					3 => "Девочка, не плачь! Я верну тебе твою игрушку"
				);
				quest_update(4,1);
				$response['actionQuest'] = '<img src="/img/quests/4.png" class="quest"> Обновлена информация в задании «Украденная игрушка». Загляните в Аквабук.';
				update_zap(4,1,'Злые <b>#568 Траббиши</b> украли игрушку у маленькой девочки! Я должен помочь этой девочке вернуть игрушку. Бедняжка показывала пальцем в сторону <b>Дороги 18</b>. Наверное, там я и должен искать игрушку.');
			}
		break;
		case 3:
			$response['question'] = 'Спа-спасибо! <i>~Вытерает слезы~</i>';
		break;
		case 4:
			if(quest_step(4,1)){
				if(item_isset(24,1)){
					$response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/1.gif"> #001 Бульбазавр';
					$response['actionQuest'] = '<img src="/img/quests/4.png" class="quest"> Обновлена информация в задании «Украденная игрушка». Загляните в Аквабук.';
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/33.png" class="item"> Леденец в форме Иви (5 шт.)<br><img src="/img/world/items/little/17.png" class="item"> Леденец в форме Мадкипа (5 шт.)<br><img src="/img/world/items/little/32.png" class="item"> Леденец в форме Пичу (5 шт.)<br><img src="/img/world/items/little/31.png" class="item"> Леденец в форме Торчика (5 шт.)';
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/24.png" class="item">  Игрушка Торкоала (1 шт.)';
					quest_update(4,2,1);
					minus_item(24,1);
					itemAdd(17,5);
					itemAdd(31,5);
					itemAdd(32,5);
					itemAdd(33,5);
					$response['question'] = 'Да! Да! Да! Это моя игрушка! Спасибо вам огромное, мистер! Кстати, меня зовут Синди <i>~Протягивает руку, в которой лежит горсть леденцов~</i> Вот, держите эти леденцы. Я их хотела сама съесть, но вы очень сильно мне помогли! Спасибо вам большое еще раз.';
					update_zap(4,2,'Я вернул игрушку. В награду Синди дала мне несколько леденцов.');
				}else{
					$response['question'] = 'Ошибка!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(!quest_isset(4)){
			$response['question'] = '<i>~Плачет~</i>';
			$response['answer'] = array(
				1 => "Привет. Что случилось?"
			);
		}else if(quest_step(4,1)){
			$response['question'] = 'Вы.. принесли мою игрушку <div class="itemIsset" onclick="issetAll(24,\'item\')" style="background-image: url(/img/world/items/little/24.png)"></div> ?';
			if(item_isset(24,1)){
				$response['answer'] = array(
					4 => "Да, держи!"
				);
			}
		}else{
			$response['question'] = '<i>~Мило играет со своей игрушкой~</i>';
		}
		break;
	}
?>
