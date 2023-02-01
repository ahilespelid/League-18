<?
	$response['name'] = 'Секретный агент';
	switch($npcStep){
		case 1:
			$mysqli->query("UPDATE `users` SET `location`='121' WHERE `id`='".$_SESSION['id']."'");
			$response['question'] = 'Мы пришли!';
			$response['action'] = 'updateLocation';
		break;
		default:
			if(item_isset(113,1) && item_isset(114,1) && item_isset(115,1)){
				$response['question'] = 'Вижу все готово, тогда уходим быстро!';
				$response['answer'] = array(
					1 => "Бежать за агентом!"
				);
			}else{
				$response['question'] = 'Приветствую тебя тренер! Меня подослал на базу генерал. Я проведу тебя обратно в полигон, если ты соберешь необходимые детали. Нужно собрать 3 детали: Ствол, Дуло, и Снаряды. Я жду тебя!';
			}
		break;
	}
?>