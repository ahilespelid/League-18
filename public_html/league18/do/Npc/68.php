<?
	$response['name'] = 'Мальчик в костюме Генгара';
	switch($npcStep){
		case 1:
			$user = $mysqli->query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
			if($user['location'] != 94){
				$rand1 = rand(1,100);
				if($rand1 >= 1 && $rand1 <= 40){
					itemAdd(33,1);
					$prize = 'Леденец в форме Иви (1 шт.)';
				}elseif($rand1 >= 41 && $rand1 <= 98){
					itemAdd(32,1);
					$prize = 'Леденец в форме Пичу (1 шт.)';
				}else{
					itemAdd(95,1);
					$prize = 'Набор классификаций (1 шт.)';
				}
				$response['question'] = 'Ты меня нашел.. Держи все, что есть!! <i>Дает вам '.$prize.'</i>';
				$mysqli->query("UPDATE `hell` SET `status` = 0");
				$mysqli->query("UPDATE `base_npc` SET `loc_id` = 94 WHERE id = 68");
			}else{
				$response['question'] = 'А-А-А!!! <i>~Убежал~</i>';
				$mysqli->query("UPDATE `hell` SET `status` = 1");
				$rand = rand(1,87);
				if($rand == 68 || $rand == 69 || $rand == 71 || $rand == 72 || $rand == 73 || $rand == 74 || $rand == 75 || $rand == 76 || $rand == 77 || $rand == 78 || $rand == 79 || $rand == 80 || $rand == 82 || $rand == 83 || $rand == 85){
					$mysqli->query("UPDATE `base_npc` SET `loc_id` = 51 WHERE id = 68");
				}else{
					$mysqli->query("UPDATE `base_npc` SET `loc_id` = '".$rand."' WHERE id = 68");
				}
			}
		break;
		default:
		$response['question'] = 'Опять?? Что тебе надо? Я просто стою тут..';
		$response['answer'] = array(
			1 => "КОНФЕТЫ ИЛИ ЖИЗНЬ?"
		);
		break;
	}
?>