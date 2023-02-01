<?
	$response['name'] = 'Густав';
	switch($npcStep){
		case 1:
			$response['question'] = 'Нилл? Этот старый дурак? Он все еще преподает в Академи? Ха-ха-кхэ-кхэ.. <i>~Начинает подкашливать~</i> Эх, Нилл.. Мой старый приятель. Я ведь тоже преподавал в Академии тренеров. Хорошие были времена. Увы, годы берут свое. Я стал слишком стар. Как этот дурачина может еще на ногах стоять? Помощь мне нужна.. Иш! Совсем меня за старика беспомощного держит.';
			$response['answer'] = array(
				2 => "Может он просто заботится о вас?"
			);
		break;
		case 2:
			$response['question'] = 'Нилл? Думаешь, в его лексиконе есть слово "забота"? Ха-ха, сомневаюсь. Этот дубина.. Ой, что я тебе тут рассказываю. Тебе, наверное, не интересны эти бредни от старика.';
			$response['answer'] = array(
				3 => "Почему же? Было бы интересно послушать пару историй о вашей с Ниллом дружбе"
			);
		break;
		case 3:
			$response['question'] = 'Интересно говоришь? Ну давай расскажу одну.<br>Как-то раз, мы с Ниллом начали собирать команду покемонов, чтобы побеждать <font color="#b6a21e">Лидеров Стадионов</font> для получения значков на <b>Кубок Морских Глубин</b>. Ты ведь знаешь что это такое? Если нет, то объясню. Кубок Морских Глубин - самый крупный турнир League-18. Чтобы принять в нем участие, нужно определенное количество значков, которые можно получить при победе над Лидерами Стадионов. Вообщем, этот "герой", по другому его никак не назвать, взял одного покемона вместо четверых на бой с Лидером. Он думал, что победит его даже с одним покемоном. В итоге, этот герой, проиграл аж в первом раунде. Я никогда в жизни так не смеялся. Даже сейчас улыбка с лица не сходит. Какие же все таки времена были. Молодость..';
			$response['answer'] = array(
				4 => "После этого Ниллу, наверное, было очень стыдно?"
			);
		break;
		case 4:
			$response['question'] = 'Еще как! Зато он после этого случая больше никогда не переоценивал все свои действия. Это ему и помогло взять Кубок Морских Глубин. Я очень им горжусь. Но, все же, он дуралей. Ха-ха-ха-кхэ-кхэ.. <i>~Опять начинает подкашливать~</i>.';
			$response['answer'] = array(
				5 => "Очень интересная история, но все же. Может все таки вам нужна какая-либо помощь? Зря приходил что ли?"
			);
		break;
		case 5:
			$response['question'] = 'Я сейчас исследую некоторые виды покемонов. Если тебе будет не трудно, то можешь ловить для меня некоторых покемонов для изучения. За каждого пойманного покемона ты будешь получать награду. Согласен?';
			$response['answer'] = array(
				6 => "Ловить покемонов? Проще простого! Меня учили этому в Академии. Я готов вам помогать!"
			);
		break;
		case 6:
			if(!quest_isset(7)){
				$wait = time()+600;
				$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
				quest_update(7,1);
				update_zap(7,1,'Познакомился с Густавом, с приятелем профессора Нилла. Добрый и интересный старичок. Теперь я буду получать от него задания, в которых мне нужно будет ловить покемонов для его исследований. Он сказал быть в его доме через 10 минут для получения моего первого задания.');
				$response['actionQuest'] = '<img src="/img/quests/7.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
				$response['question'] = 'Хорошо. Приходи ко мне через 10 минут. Я пока что подумаю кто мне нужен из покемонов.';
			}
		break;
		case 7:
			if(quest_step(7,1)){
				quest_update(7,2);
				update_zap(7,2,'Мое первое задание от Густава. Нужно поймать и принести ему <b>#025 Пикачу</b>.');
				$response['actionQuest'] = '<img src="/img/quests/7.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
				$response['question'] = 'Первое задание для тебя будет для тебя простым. Принеси мне <b>#025 Пикачу</b>.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 8:
			if(quest_step(7,2) && !npc_time_check($npcId)){
				$p = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = 25")->num_rows;
				if($p){
					$wait = time()+86400;
					$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 30 AND `userID` = '".$_SESSION['id']."'");
					$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					quest_update(7,3);
					$response['actionQuestMinus'] = '<img src="/img/pokemons/anim/normal/25.gif"> #025 Пикачу';
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/1039.png" class="item"> TM 39 - Каменная гробница (1 шт.)';
					$response['actionQuest'] = '<img src="/img/quests/7.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
					update_zap(7,3,'Я справился с первым заданием. Думаю, следующие задания будут намного сложнее. Мне сказали прийти через 24 часа.');
					$response['question'] = 'Ты справился с моим первым заданием. Держи от меня награду <i>~Дает вам TM атаку~</i> TM - тренировочная машина, которая способна обучить покемона атаке. Используй ее с умом. Ну, а теперь мне нужно время, чтобы изучить этого покемона, которого ты мне принес. Приходи через 24 часа, я дам тебе новое задание.';
					itemAdd(1039,1);
					$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = 25 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					$response['action'] = 'updateTeam';
				}else{
					$response['question'] = 'У тебя его нету.';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 9:
			if(quest_step(7,3)){
				$rand = rand(1,14);
				if($rand == 1){$pokQ = 104; $pokN = 'Кубон';
				}elseif($rand == 2){$pokQ = 118; $pokN = 'Голдин';
				}elseif($rand == 3){$pokQ = 161; $pokN = 'Сентрет';
				}elseif($rand == 4){$pokQ = 198; $pokN = 'Муркроу';
				}elseif($rand == 5){$pokQ = 278; $pokN = 'Вингул';
				}elseif($rand == 6){$pokQ = 263; $pokN = 'Зигзагун';
				}elseif($rand == 7){$pokQ = 234; $pokN = 'Сентлер';
				}elseif($rand == 8){$pokQ = 222; $pokN = 'Корсола';
				}elseif($rand == 9){$pokQ = 504; $pokN = 'Патрат';
				}elseif($rand == 10){$pokQ = 546; $pokN = 'Катуни';
				}elseif($rand == 11){$pokQ = 618; $pokN = 'Станфиск';
				}elseif($rand == 12){$pokQ = 063; $pokN = 'Абра';
				}elseif($rand == 13){$pokQ = 037; $pokN = 'Вульпикс';
				}elseif($rand == 14){$pokQ = 209; $pokN = 'Снаббул';}
				$proverka = $mysqli->query("SELECT * FROM `quest_steps` WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 7 AND `quest_step` = 4")->num_rows;
				$mysqli->query("DELETE FROM `npc_more_quest` WHERE `quest_id` = 7 AND `user_id` = '".$_SESSION['id']."'");
				$mysqli->query("INSERT INTO `npc_more_quest` (`user_id`,`quest_id`,`need`) VALUES('".$_SESSION['id']."',7,'".$pokQ."') ");
				quest_update(7,4);
				if($proverka){
					$mysqli->query("UPDATE `quest_steps` SET `text` = 'Мое следующее задание: поймать <b>#".$pokQ." ".$pokN."</b>.' WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 7 AND `quest_step` = 4");
					$response['actionQuest'] = '<img src="/img/quests/7.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
				}else{
					update_zap(7,4,'Мое следующее задание: поймать <b>#'.$pokQ.' '.$pokN.'</b>.');
					$response['actionQuest'] = '<img src="/img/quests/7.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
				}
				$response['question'] = 'Ты отлично справился с моим прошлым заданием. Я хорошенько изучил того покемона. Теперь мне нужен: <div class="questPokemon"><img src="/img/pokemons/mini/normal/'.$pokQ.'.png"> <div>#'.$pokQ.' '.$pokN.'</div></div>';
			}
		break;
		case 10:
			if(quest_step(7,4)){
				$pokM = $mysqli->query("SELECT * FROM `npc_more_quest` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '7'")->fetch_assoc();
				$pokH = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `basenum` = '".$pokM['need']."'")->fetch_assoc();
				if($pokH){
					$random = rand(1,13);
					$random2 = rand(1,3);
					$random3 = rand(1,5);
					if($random == 1){
						itemAdd(109,5);
						$priz = 'Генобол (5 шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
					}elseif($random == 2){
						itemAdd(17,$random3);
						$priz = 'Леденец в форме Мадкипа ('.$random3.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/17.png" class="item"> Леденец в форме Мадкипа ('.$random3.' шт.)';
					}elseif($random == 3){
						itemAdd(31,$random3);
						$priz = 'Леденец в форме Торчика ('.$random3.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/31.png" class="item"> Леденец в форме Торчика ('.$random3.' шт.)';
					}elseif($random == 4){
						itemAdd(32,$random3);
						$priz = 'Леденец в форме Пичу ('.$random3.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/32.png" class="item"> Леденец в форме Пичу ('.$random3.' шт.)';
					}elseif($random == 5){
						itemAdd(33,$random3);
						$priz = 'Леденец в форме Иви ('.$random3.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/33.png" class="item"> Леденец в форме Иви ('.$random3.' шт.)';
					}elseif($random == 6){
						itemAdd(37,$random2);
						$priz = 'Банка цинка ('.$random2.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/37.png" class="item"> Банка цинка ('.$random2.' шт.)';
					}elseif($random == 7){
						itemAdd(38,$random2);
						$priz = 'Банка кальция ('.$random2.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/38.png" class="item"> Банка кальция ('.$random2.' шт.)';
					}elseif($random == 8){
						itemAdd(39,$random2);
						$priz = 'Банка железа ('.$random2.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/39.png" class="item"> Банка железа ('.$random2.' шт.)';
					}elseif($random == 9){
						itemAdd(40,$random2);
						$priz = 'Банка йода ('.$random2.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/40.png" class="item"> Банка йода ('.$random2.' шт.)';
					}elseif($random == 10){
						itemAdd(41,$random2);
						$priz = 'Банка углеводов ('.$random2.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/41.png" class="item"> Банка углеводов ('.$random2.' шт.)';
					}elseif($random == 11){
						itemAdd(42,$random2);
						$priz = 'Банка протеина ('.$random2.' шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/42.png" class="item"> Банка протеина ('.$random2.' шт.)';
					}else{
						itemAdd(70,1);
						$priz = 'Сухие духи (1 шт.)';
						$response['actionQuestPlus'] = '<img src="/img/world/items/little/70.png" class="item"> Сухие духи (1 шт.)';
					}
					$pokJ = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$pokH['basenum']."'")->fetch_assoc();
					$response['actionQuestMinus'] = '<img src="/img/pokemons/anim/normal/'.$pokJ['id'].'.gif"> #'.$pokJ['id'].' '.$pokJ['name_rus'].'';
					$response['question'] = 'Превосходно. Держи <b>'.$priz.'</b>. Приходи за следующим заданием завтра, мне нужно подробно изучить этого покемона.';
					$mysqli->query("DELETE FROM `user_pokemons` WHERE `basenum` = '".$pokH['basenum']."' AND `user_id` = '".$_SESSION['id']."' AND active = 1");
					$response['action'] = 'updateTeam';
					$mysqli->query("UPDATE `quest_steps` SET `text` = 'Задание выполнено. Следующее задание Густав даст завтра.' WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 7 AND `quest_step` = 4");
					$response['actionQuest'] = '<img src="/img/quests/7.png" class="quest"> Обновлена информация в задании «Помощь старому приятелю». Загляните в Аквабук.';
					$wait = time()+86400;
					$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 30 AND `userID` = '".$_SESSION['id']."'");
					$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					quest_update(7,3);
				}else{
					$response['question'] = 'У тебя нет нужного мне покемона!';
				}
			}
		break;
		default:
			if(quest_step(7,1)){
				if(!npc_time_check($npcId)){
					$response['question'] = 'Я приготовил для тебя задание.';
					$response['answer'] = array(
						7 => "Кого мне нужно поймать?"
					);
				}else{
					$response['question'] = 'Я еще не определился кто мне нужен. Приходи позже.';
				}
			}elseif(quest_step(7,2)){
				$response['question'] = 'Поймал Пикачу?';
				$response['answer'] = array(
					8 => "Да"
				);
			}elseif(quest_step(7,3)){
				if(!npc_time_check($npcId)){
					$response['question'] = 'Я приготовил для тебя задание.';
					$response['answer'] = array(
						9 => "Кого мне нужно поймать?"
					);
				}else{
					$response['question'] = 'Я еще не определился кто мне нужен. Приходи позже.';
				}
			}elseif(quest_step(7,4)){
				$response['question'] = 'Поймал покемона?';
				$response['answer'] = array(
					10 => "Да, поймал"
				);
			}else{
				$response['question'] = 'Добрый день, тренер. Что привело тебя сюда?';
				$response['answer'] = array(
					1 => "Профессор Нилл из Академии тренеров в Фуксии попросил меня помочь вам"
				);
			}
		break;
	}
?>
