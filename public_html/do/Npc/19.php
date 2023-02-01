<?
	$pokemon  = Work::$sql->query("SELECT `attacks` FROM `user_pokemons` WHERE `start_pok` = 1 AND `active` = 1 AND `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
	$quake = explode(',',$pokemon['attacks']);
	$response['name'] = 'Минфу';
	switch($npcStep){
		case 1:
			$response['question'] = 'Минф.. Минфу!!! <i>~Вам издается ответный крик из-за булыжников~</i>';
			$response['answer'] = array(
				2 => "Что с тобой? Ты застрял?"
			);
		break;
		case 2:
			$response['question'] = 'Минфу-у-у!!';
			$response['answer'] = array(
				3 => "Да, похоже ты застрял. Не бойся! Я помогу тебе! Мне лишь нужно каким-либо способом сломать эти булыжники. У тебя есть предложения?"
			);
		break;
		case 3:
			$response['question'] = 'Минфу..';
			$response['answer'] = array(
				4 => "Нету? Вот и у меня нету.. Хотя подожди-ка. А если я найду покемона, который бы разрушил это все?"
			);
		break;
		case 4:
			$response['question'] = 'Минфу!!! Минфу!!';
			$response['answer'] = array(
				5 => "Жди здесь, я скоро.."
			);
		break;
		case 5:
			if(!quest_isset(5)){
				$response['actionQuest'] = '<img src="/img/quests/5.png" class="quest"> Обновлена информация в задании «Безвыходная ситуация». Загляните в Аквабук.';
				quest_update(5,1);
				update_zap(5,1,'Минфу в беде! Он застрял за огромными булыжниками и не может выбраться! Я должен ему помочь. У меня есть план, как разломать булыжники. Мне нужен покемон с атакой <b>Землетрясение</b>. Думаю, мощными толчками я сломаю камни.');
				$response['question'] = 'Минфу - минф? ^-_-^';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 6:
			if(quest_step(5,1)){
				if($pokemon){
					if($quake[0] == 136 OR $quake[1] == 136 OR $quake[2] == 136 OR $quake[3] == 136){
						$response['actionQuest'] = '<img src="/img/quests/5.png" class="quest"> Обновлена информация в задании «Безвыходная ситуация». Загляните в Аквабук.';
						$rand = rand(300,3600);
						$wait = time()+$rand;
						$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
						quest_update(5,2);
						update_zap(5,2,'Я нашел покемона с землетрясением, но ему понадобится время, чтобы разрушить булыжники. Не знаю точное время. Может быть 5 минут.. Может быть 20. А может и час..');
						$response['question'] = 'Минфу.. <i>~Ваш покемон начал создавать сильные земляные толчки, пытаясь сломать камни~</i>';
					}
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 7:
			if(quest_step(5,2)){
				if(!npc_time_check($npcId)){
					quest_update(5,3);
					$response['actionQuest'] = '<img src="/img/quests/5.png" class="quest"> Обновлена информация в задании «Безвыходная ситуация». Загляните в Аквабук.';
					update_zap(5,3,'Землетрясение не помогло! Нужно что-то другое!');
					$response['question'] = 'Минфу ._.';
					$response['answer'] = array(
						8 => "Хм, может попробывать заморозить камни и разломать их в замороженном состоянии? Или напалмом огня их, ах-ха-ха!"
					);
				}else{
					$response['question'] = 'Ошибка!';
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 8:
			$response['question'] = 'Минфу! Минфу! <i>~Стучит сильно лапами по камням, пытаясь вам что-то объяснить~</i>';
			$response['answer'] = array(
				9 => "Ты хочешь мне что-то сказать?"
			);
		break;
		case 9:
			$response['question'] = 'Минфу! Минфу! <i>~Начинает сильнее стучать по камням~</i>';
			$response['answer'] = array(
				10 => "Ты думаешь, кулаками можно сломать камни?"
			);
		break;
		case 10:
			$response['question'] = 'МИНФУ! <i>~Крик на всю пещеру~</i>';
			$response['answer'] = array(
				11 => "Ай.. Мои уши.. Эхо от твоих криков сильное.. Хорошо, я приведу покемона с Камнеломом!"
			);
		break;
		case 11:
			if(quest_step(5,3)){
				$response['actionQuest'] = '<img src="/img/quests/5.png" class="quest"> Обновлена информация в задании «Безвыходная ситуация». Загляните в Аквабук.';
				quest_update(5,4);
				update_zap(5,4,'Мне нужен покемон с атакой <b>Камнелом</b>! Как же я раньше до этого не додумался! Хорошо, что Минфу подсказал об этом.');
				$response['question'] = 'МИНФУ! МИНФУ!';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 12:
			if(quest_step(5,4)){
				newPokemon(619,$_SESSION['id'],5,false,1,'true',1,false,false,false,false,true);
				$response['action'] = 'updateTeam';
				quest_update(5,5,1);
				update_zap(5,5,'Мне удалось освободить Минфу! Он вместе со мной отправился дальше за приключениями!');
				$response['actionQuest'] = '<img src="/img/quests/5.png" class="quest"> Обновлена информация в задании «Безвыходная ситуация». Загляните в Аквабук.';
				$response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/619.gif"> #619 Минфу';
				$response['question'] = 'МИНФУ! МИНФУ! <i>Ваш покемон с камнеломом очень быстро справился с этими булыжниками. Минфу радостно подбежал к вам и жестами показал на покебол. Вы бросили в него покебол, и Минфу остался в нем.</i>';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(!quest_isset(5)){
			$response['question'] = '<i>~Вы слышите голос Минфу за огромными булыжниками перед вами~</i>';
			$response['answer'] = array(
				1 => "Минфу?"
			);
		}elseif(quest_step(5,1)){
			$response['question'] = 'Минфу.<br><i>~Необходимо сделать стартовым нужного покемона.~</i>';
			if($pokemon){
				if($quake[0] == 136 OR $quake[1] == 136 OR $quake[2] == 136 OR $quake[3] == 136){
					$response['answer'] = array(
						6 => "У меня есть покемон с землетрясением!"
					);
				}
			}
		}elseif(quest_step(5,2)){
			if(!npc_time_check($npcId)){
				$response['question'] = 'Минфу? Минфу..';
				$response['answer'] = array(
					7 => "Это бесполезно! Землетрясение не помогает. Как стояли камни, так и стоят! Нужно искать другой выход.."
				);
			}else{
				$response['question'] = '<i>~Ваш покемон все еще пытается ломать камни атакой землетресение~</i>';
			}
		}elseif(quest_step(5,3)){
			$response['question'] = 'Минфу..';
			$response['answer'] = array(
				8 => "Что же делать?"
			);
		}elseif(quest_step(5,4)){
			$response['question'] = 'Минфу?<br><i>~Необходимо сделать стартовым нужного покемона.~</i>';
			if($pokemon){
				if($quake[0] == 440 OR $quake[1] == 440 OR $quake[2] == 440 OR $quake[3] == 440){
					$response['answer'] = array(
						12 => "У меня есть покемон с камнеломом!"
					);
				}
			}
		}else{
			$response['question'] = '<i>~...~</i>';
		}
		break;
	}
?>
