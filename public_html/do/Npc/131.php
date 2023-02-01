<?
	$a = $mysqli->query("SELECT * FROM `arena` WHERE `id` = 1")->fetch_assoc();
	$c = $mysqli->query("SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
	$response['name'] = 'Куратор';
	switch($npcStep){
		case 1:
			if($a['open'] == 1){
				$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','151','arena') ");
				$mysqli->query("UPDATE `users` SET `location`='85' WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
			}else{
				$response['question'] = 'Я же сказал, что арена в данный момент закрыта!';
			}
		break;
		case 2:
			if($a['leader'] == $_SESSION['id'] OR $c['user_group'] == 1){
				if($a['open'] == 1){
					$mysqli->query("UPDATE `arena` SET `open` = 0 WHERE `id` = 1");
					$response['question'] = 'Арена закрыта.';
				}else{
					$mysqli->query("UPDATE `arena` SET `open` = 1 WHERE `id` = 1");
					$response['question'] = 'Арена открыта.';
				}
			}else{
				$response['question'] = 'Доступ запрещен!';
			}
		break;
		case 3:
			if($a['leader'] == $_SESSION['id'] OR $c['user_group'] == 1){
				$response['question'] = 'Хозяин :)';
				if($a['open'] == 1){
					$response['answer'] = array(
						2 => "Закрыть арену"
					);
				}else{
					$response['answer'] = array(
						2 => "Открыть арену"
					);
				}
			}else{
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
			if($a['open'] == 1){
				$b = 'открыта';
			}else{
				$b = 'закрыта';
			}
			$response['question'] = 'Приветствую тебя, тренер. В данный момент арена <b>'.$b.'</b>.';
			$response['answer'] = array(
				1 => "Войти на арену",
				3 => "Управление ареной"
			);
		break;
	}
?>