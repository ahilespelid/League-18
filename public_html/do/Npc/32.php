<?
	$response['name'] = 'Кассир';
	switch($npcStep){
		case 1:
			$response['question'] = '1. Выберите регион, в который вы хотите отправиться, заплатив при этом необходимое количество монет.<br>
			2. Подождите 5 минут, пока ваш транспорт готовиться к отправке.<br>
			3. Через 5 минут появиться ваш транспорт. Зайдите в него, предварительно поговорив со мной. ВНИМАНИЕ! После этого пункта из транспорта <b>невозможно</b> будет выйти назад.<br>
			4. Поговорите с капитаном об отправке.<br>
			5. Ожидайте прибытия вашего транспорта в пункт назначния.<br>
			<b>Удачной поездки!</b>';
			$response['answer'] = array(
				2 => "Я хочу выбрать регион для перемещения"
			);
		break;
		case 2:
			$response['question'] = '
			Поездка из <b>Канто</b> в <b>Хоэнн</b> будет стоить <b><i>350.000 монет</i></b>. Вы будете добираться туда <b>1 час 30 минут</b>.<br>
			';
			$response['answer'] = array(
				3 => "Я хочу в Хоэнн",
			);
		break;
		case 3:
			if(!npc_time_check($npcId)){
				if(item_isset(1,350000)){
					$wait = time()+300;
					$mysqli->query("DELETE FROM  `base_npc_data` WHERE `userID` = ".$_SESSION['id']." AND `npcID` = ".$npcID);
					$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					$response['question'] = 'Ваш транспорт будет через 5 минут!';
					quest_update(1000,1);
					minus_item(1,350000);
					$response['actionQuestMinus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (400000 шт.)';
				}else{
					$response['question'] = 'Недостаточно монет.';
				}
			}elseif(npc_time_check($npcId)){
				$response['question'] = 'Вы уже заказали транспорт! Ожидайте.';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 4:
			$response['question'] = 'Извините. В данный момент поездка в данный регион невозможна.';
		break;
		case 5:
			if(quest_step(1000,1) && !npc_time_check($npcId)){
				//update_ach(14,1);
				$mysqli->query("UPDATE `users` SET `location`='82' WHERE `id`='".$_SESSION['id']."'"); // Перемещение в Каюту
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		case 6:
			if(quest_isset(1000)){
				if(npc_time_check($npcId)){
					$response['question'] = 'Ваш транспорт еще не готов. Ожидайте.';
				}elseif(quest_isset(1000) && !npc_time_check($npcId)){
					$response['question'] = 'Ваш транспорт готов.';
					$response['answer'] = array(
						5 => "Войти в транспорт"
					);
				}
			}else{
				$response['question'] = 'Вы не заказывали транспорт.';
			}
		break;
		default:
		        $user = $mysqli->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
    if(($user['id'] == 190)) {
			$response['question'] = 'Привет! Мы предоставляем возможность тренерам путешествовать в другие регионы в любое время, быстро и качественно! Расценки:<br><br>
			Поездка из <b>Канто</b> в <b>Хоэнн</b> будет стоить <b><i>350.000 монет</i></b><br>
			';
			$response['answer'] = array(
				1 => "Как мне совершить поездку в другой регион?",
				2 => "Я хочу выбрать регион для перемещения",
				6 => "Мой транспорт готов?"
  );
    }else{
      $response['question'] = 'Касса временно не работает!';
    }
  break;
}

?>
