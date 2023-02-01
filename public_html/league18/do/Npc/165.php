<?
	$response['name'] = 'Юный маг';
	$user = $mysqli->query("SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
	switch($npcStep){
		case 1:
			$response['question'] = 'О, ну буду ждать тебя! <b>'.$user['login'].'</b>, верно? Да-да, не удивляйтесь! Я немного умею читать мысли... Каролина научила. Ну та, которая... Ай, ладно, забыли! ^_^ Кстати, не хочешь помогать мне с шоу? Подготавливать мне материалы.';
			$response['answer'] = array(
				2 => "Звучит интересно... А что я получу в замен?"
			);
		break;
		case 2:
			$response['question'] = 'Ну, скажем, небольшие подарочки от меня? Обещаю, будет не сложно ^_^';
			$response['answer'] = array(
				3 => "Да почему бы и нет. Что от меня требуется?"
			);
		break;
		case 3:
			$response['question'] = 'Приносить мне покемонов, которых я буду превращать на своих представлениях, и типовую пыль.';
			$response['answer'] = array(
				4 => "Звучит нетрудно. Сейчас тебе нужно что-то?"
			);
		break;
		case 4:
			if(!quest_isset(17)){
				quest_update(17,1);
				update_zap(17,1,'В одном городе встретил доброго фокусника, которому я пообещал помогать и приносить ему материал для его представлений. Сейчас ему нужен любой покемон 1 уровня и 30 пыли нормального покемона. Что-ж, не буду медлить, пойду добывать все это.');
				$response['actionQuest'] = '<img src="/img/quests/17.png" class="quest"> Обновлена информация в задании «Ох уж этот фокусник». Загляните в Аквабук.';
				$response['question'] = 'Да, как раз таки нужны. Принеси мне любого покемона 1 уровня и 30 пыли нормального покемона. Я буду ждать тут.';
			}
		break;
		case 5:
			if(quest_step(17,1)){
				$p = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `start_pok` = 1")->fetch_assoc();
				if(isset($p) && $p['lvl'] == 1){
          if(item_isset(199,30)) {
            minus_item(199,30);
            $wait = time()+86400;
  					$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','164','".$wait."') ");
  					quest_update(17,2);
  					$response['actionQuestMinus'] = '<img src="/img/pokemons/anim/normal/'.$p['basenum'].'.gif"> #'.numCheck_basenum($p['basenum']).' '.$p['name_new'].'<br><img src="/img/world/items/little/199.png" class="item"> Пыль нормального покемона (30 шт.)';
  					$response['actionQuestPlus'] = '<img src="/img/world/items/little/100.png" class="item"> Корона (1 шт.)';
  					$response['actionQuest'] = '<img src="/img/quests/17.png" class="quest"> Обновлена информация в задании «Ох уж этот фокусник». Загляните в Аквабук.';
  					update_zap(17,2,'Первое задание было довольно-таки несложным. Что же будет дальше? Вернусь к юному магу завтра.');
  					$response['question'] = 'Отлично. То, что нужно. Держи от меня этот небольшой подарок. Приходи завтра за следующим заданием, как раз к выступлению. Еще раз спасибо.';
  					itemAdd(100,1);
            $mysqli->query("DELETE FROM `user_pokemons` WHERE `id` = ".$p['id']);
            $response['action'] = 'updateTeam';
          }else{
            $response['question'] = 'У тебя нету пыли.';
          }
				}else{
					$response['question'] = 'У тебя нету покемона 1 уровня.';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 6:
			if(quest_step(17,2)){
				$rand = rand(199,216);
        $item = $mysqli->query("SELECT `name` FROM `base_items` WHERE `id` = ".$rand)->fetch_assoc();
				$proverka = $mysqli->query("SELECT * FROM `quest_steps` WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 17 AND `quest_step` = 3")->num_rows;
				$mysqli->query("DELETE FROM `npc_more_quest` WHERE `quest_id` = 17 AND `user_id` = '".$_SESSION['id']."'");
				$mysqli->query("INSERT INTO `npc_more_quest` (`user_id`,`quest_id`,`need`) VALUES('".$_SESSION['id']."',17,'".$rand."') ");
				quest_update(17,3);
				if($proverka){
					$mysqli->query("UPDATE `quest_steps` SET `text` = 'Мое следующее задание: принести любого покемона первого уровня и <b>".$item['name']." (10 шт.).</b>.' WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 17 AND `quest_step` = 3");
					$response['actionQuest'] = '<img src="/img/quests/17.png" class="quest"> Обновлена информация в задании «Ох уж этот фокусник». Загляните в Аквабук.';
				}else{
					update_zap(17,3,"Мое следующее задание: принести любого покемона первого уровня и <b>".$item['name']." (10 шт.)</b>.");
          $response['actionQuest'] = '<img src="/img/quests/17.png" class="quest"> Обновлена информация в задании «Ох уж этот фокусник». Загляните в Аквабук.';
				}
				$response['question'] = 'Принеси мне для следующего моего выступления любого покемона 1 уровня и <div class="itemIsset" onclick=issetAll('.$rand.',"item") style="background-image: url(/img/world/items/little/'.$rand.'.png)"></div> 10 штук. Жду тебя тут.';
			}
		break;
    case 7:
			if(quest_step(17,3)){
				$pokM = $mysqli->query("SELECT * FROM `npc_more_quest` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '17'")->fetch_assoc();
				$p = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `start_pok` = 1")->fetch_assoc();
        if(isset($p) && $p['lvl'] == 1) {
          if(item_isset($pokM['need'],10)) {
            quest_update(17,2);
            minus_item($pokM['need'],10);
            $random1 = mt_rand(1,30);
            if($random1 == 1) {
              itemAdd(1026,1);
              $prize = 1026;
              $prize2 = 'TM 26 - Землетрясение (1 шт.)';
            }else{
              $random2 = mt_rand(1,9);
              if($random2 == 1) {
                itemAdd(109,10);
                $prize = 109;
                $prize2 = 'Генобол (10 шт.)';
              }elseif($random2 == 2) {
                itemAdd(254,2);
                $prize = 254;
                $prize2 = 'Комплект значков Драз`до (2 шт.)';
              }elseif($random2 == 3) {
                itemAdd(31,10);
                $prize = 31;
                $prize2 = 'Леденец в форме Торчика (10 шт.)';
              }elseif($random2 == 4) {
                itemAdd(33,5);
                $prize = 33;
                $prize2 = 'Леденец в форме Иви (5 шт.)';
              }elseif($random2 == 5) {
                itemAdd(134,3);
                $prize = 134;
                $prize2 = 'Пропуск в вольер (3 шт.)';
              }elseif($random2 == 6) {
                itemAdd(1,50000);
                $prize = 1;
                $prize2 = 'Монета (50000 шт.)';
              }elseif($random2 == 7) {
                itemAdd(193,1);
                $prize = 193;
                $prize2 = 'Обрывок заклинаний (1 шт.)';
              }elseif($random2 == 8) {
                itemAdd(255,1);
                $prize = 255;
                $prize2 = 'Коробка с пирожными (1 шт.)';
              }else{
                itemAdd(256,1);
                $prize = 256;
                $prize2 = 'Коробка с витаминами (1 шт.)';
              }
            }
						$response['question'] = 'Отлично! Спасибо, что выручил меня снова. Приходи завтра за очередным заданием.';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/'.$prize.'.png" class="item"> '.$prize2;
            $item = $mysqli->query("SELECT `name` FROM `base_items` WHERE `id` = '".$pokM['need']."'")->fetch_assoc();
            $response['actionQuestMinus'] = '<img src="/img/pokemons/anim/normal/'.$p['basenum'].'.gif"> #'.numCheck_basenum($p['basenum']).' '.$p['name_rus'].'<br><img src="/img/world/items/little/'.$pokM['need'].'.png" class="item"> '.$item['name'].' (10 шт.)';
            $mysqli->query("DELETE FROM `user_pokemons` WHERE `id` = ".$p['id']);
            $response['action'] = 'updateTeam';
  					$mysqli->query("UPDATE `quest_steps` SET `text` = 'Задание выполнено. Следующее задание от мага поступит завтра.' WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 17 AND `quest_step` = 3");
  					$response['actionQuest'] = '<img src="/img/quests/17.png" class="quest"> Обновлена информация в задании «Ох уж этот фокусник». Загляните в Аквабук.';
  					$wait = time()+86400;
  					$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 164 AND `userID` = '".$_SESSION['id']."'");
  					$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','164','".$wait."') ");
          }else{
            $response['question'] = 'У тебя нет нужной мне пыли!';
          }
        }else{
          $response['question'] = 'У тебя нет нужного мне покемона!';
        }
			}
		break;
		default:
			if(quest_step(17,1)){
				$response['question'] = 'Привет снова. Выполнил мое задание? Принес мне покемона 1 уровня и 30 <div class="itemIsset" onclick=issetAll(199,"item") style="background-image: url(/img/world/items/little/199.png)"></div> ?<br><i>~Чтобы персонаж определил нужного покемона, его необходимо сделать стартовым.~</i>';
				$response['answer'] = array(
					5 => "Да, держи."
				);
			}elseif(quest_step(17,2)){
				if(!npc_time_check(164)){
					$response['question'] = 'Привет. Следующее выступление уже скоро. Мне нужны новые материалы. У меня есть для тебя задание.';
					$response['answer'] = array(
						6 => "Я готов. Что от меня нужно?"
					);
				}else{
					$response['question'] = 'Приходи к моему следующему выступлению за новым заданием. Оно уже скоро.';
				}
			}elseif(quest_step(17,3)){
        $response['question'] = 'Привет снова. Принес все, что нужно?<br><i>~Чтобы персонаж определил нужного покемона, его необходимо сделать стартовым.~</i>';
				$response['answer'] = array(
					7 => "Да, держи."
				);
			}else{
				$response['question'] = 'Привет. Сегодня в этом городе будет мое выступление. Я буду превращать покемонов в другие виды. Это очень сложный и потрясающий трюк. Надеюсь вы будете присутствовать на выступлении. Кстати, прошу заметить, что мои "двойники" проводят свои выступления и в других регионах. Там тоже не менее увлекательные представления.';
				$response['answer'] = array(
					1 => "Я постараюсь придти, но не обещаю."
				);
			}
		break;
	}
?>
