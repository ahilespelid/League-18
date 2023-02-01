<?
	$response['name'] = 'Загадочная старушка';
  if($timeday != 2) {
    switch($npcStep){
  		default:
  		$response['question'] = 'Ошибка выбора персонажа.';
  		break;
  	}
  }else{
    switch($npcStep){
      case 1:
  				$response['question'] = 'Хе-хе, а вот не скажу. Даже такая старуха хочет оставаться загадкой.';
          $response['answer'] = array(
    				2 => "И все таки, кто может помочь мне?"
    			);
  		break;
      case 2:
  				$response['question'] = 'В регионе Канто проживает юная колдунья по имени Каролина, та обязательно сможет помочь тебе.';
          $response['answer'] = array(
    			  3 => "Каролина? Путь далековат, но спасибо большое за помощь."
    			);
  		break;
      case 3:
  			if(quest_step(19,2)){
					$rand = mt_rand(136,140);
					itemAdd($rand,1);
					$response['actionQuestPlus'] = '<img src="/img/world/items/little/'.$rand.'.png" class="item"> Леденец (1 шт.)';
  				$response['question'] = '<i>~Старушка протягивает вам руку с леденцом~</i> Ступай, дитя.';
  				quest_update(19,3);
  				$response['actionQuest'] = '<img src="/img/quests/19.png" class="quest"> Обновлена информация в задании «Слизняк». Загляните в Аквабук.';
  				update_zap(19,3,'Загадочная старушка сказала, что мне поможет Каролина. Необходимо ехать к ней.');
  			}else{
  				$response['question'] = 'Ошибка!';
  			}
  		break;
  		default:
  		if(quest_step(19,2)){
  			$response['question'] = 'Приветствую, юный тренер, я не смогу помочь с буйством характера, но я знаю кто сможет.';
  			$response['answer'] = array(
  				1 => "Что?! Как вы узнали зачем я здесь?"
  			);
  		}else{
  			$response['question'] = '<i>~Напевает одну из песенок группы Rammstein~</i>';
  		}
  		break;
  	}
  }
?>
