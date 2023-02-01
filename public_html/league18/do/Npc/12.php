<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';
	$response['name'] = 'Невитс Греблипс';
	switch($npcStep){
		case 1:
			$response['question'] = 'Да, вот помощь бы не помешала. Сейчас вся наша съемочная команда на ушах стоит. Мы не успеваем закончить наш фильм в срок! Нам не хватает несколько покемонов для последней сцены. Сможешь принести их?';
			$response['answer'] = array(
				2 => "Да, конечно, какие покемоны вам нужны?"
			);
		break;
		case 2:
			if(!quest_isset(2)){
				quest_update(2,1);
				$response['actionQuest'] = '<img src="/img/quests/2.png" class="quest"> Обновлена информация в задании «Блокбастер». Загляните в Аквабук.';
				update_zap(2,1,'Невитс попросил помочь ему с фильмом. Мне нужны <b>#072 Тентакул</b> с характером <b>Стремительный</b>, <b>#052 Мяут</b> с характером <b>Выносливый</b>, <b>#209 Снаббул</b> с характером <b>Веселый</b>, <b>мужского пола</b>.');
				$response['question'] = 'У нас непростая сцена, где наш главный герой будет бежать от врагов, при этом сзади его будут атаковать несколько злых покемонов. Вообщем, нам сейчас нужны: <br> <b>#072 Тентакул</b> с характером <b>Стремительный</b>. Он будет атаковать прямо из воды! Круто, да? <br> <b>#052 Мяут</b> с характером <b>Выносливый</b>. Этот Мяут будет гнаться за главным героем. Ух-х-х, не хотел бы я попасть в такую ситуацию! <br> <b>#209 Снаббул</b> с характером <b>Веселый</b>, <b>мужского пола</b>. Этот весельчак будет поджидать нашего героя за углом. Не буду спойлирить что произойдет дальше. <br> Вообщем, жду тебя тут. И побыстрее! Наградой не обижу.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 3:
			$allPokemons = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1");
			if($allPokemons->num_rows < 4){
				$response['question'] = 'Если я заберу этих покемонов, у тебя не останется покемонов с собой!';
			}else{
				if(quest_step(2,1)){
					$tentacool = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = 72 AND `character` = 25")->num_rows;
					$meowth = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = 52 AND `character` = 2")->num_rows;
					$snubbul = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = 209 AND `gender` = 'Мальчик' AND `character` = 1")->num_rows;
					if($tentacool > 0 && $meowth > 0 && $snubbul > 0){
						quest_update(2,2,1);
						$response['actionQuest'] = '<img src="/img/quests/2.png" class="quest"> Обновлена информация в задании «Блокбастер». Загляните в Аквабук.';
						$response['actionQuestMinus'] = '<img src="/img/pokemons/anim/normal/72.gif"> #072 Тентакул<br><img src="/img/pokemons/anim/normal/52.gif"> #052 Мяут<br><img src="/img/pokemons/anim/normal/209.gif"> #209 Снаббул';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
						update_zap(2,2,'Я отдал всех нужных покемонов Невитсу. В награду он мне дал <b>яйцо #403 Шинкса</b>.');
						$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = 72 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = 52 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = 209 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
						$response['action'] = 'updateTeam';
						plusEgg(false,false,false,true,false,403);
						$response['question'] = 'Огромное тебе спасибо, тренер! У меня для тебя есть подарок! Вчера мой друг привез с Синно несколько редких покемонов и их яйца. Одно яйцо я дарю тебе. Держи и еще раз спасибо тебе! Твой поступок мы не забудем.';
					}else{
						$response['question'] = 'У тебя их нет!';
					}
				}else{
					$response['question'] = 'Ошибка!';
				}
			}
		break;
		default:
		if(!quest_isset(2)){
			$response['question'] = 'Привет, слушай, не мешай мне! У меня и так работы навалом, а тут еще и ты..';
			$response['answer'] = array(
				1 => "Может я смогу чем-то помочь?"
			);
		}else if(quest_step(2,1)){
			$response['question'] = 'Принес покемонов? <br> <div class="quest-sub">В вашей команде должны быть: <br> <b>#072 Тентакул</b> с характером <b>Стремительный</b>. <br> <b>#052 Мяут</b> с характером <b>Выносливый</b>. <br> <b>#209 Снаббул</b> с характером <b>Веселый</b>, <b>мужского пола</b>.</div>';
			$response['answer'] = array(
				3 => "Да, вот они"
			);
		}else{
			$response['question'] = 'Еще раз спасибо за помощь!';
		}
		break;
	}
?>
