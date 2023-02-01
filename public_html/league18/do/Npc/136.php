<?
	$a = $mysqli->query("SELECT * FROM teleport_user WHERE user = '".$_SESSION['id']."' AND `go` = 'prison'")->fetch_assoc();
	$b = $mysqli->query("SELECT * FROM users WHERE id = ".$_SESSION['id'])->fetch_assoc();
	$ban = json_decode($b['ban']);
	$time = time();
	if($time > $ban->game){
		$c = 'Ты можешь выйти из тюрьмы';
		$d = 1;
	}else{
		$c = 'Тебе еще сидеть и сидеть...';
		$d = 0;
	}
	$response['name'] = 'Начальник тюрьмы';
	switch($npcStep){
		case 1:
			if($d == 1){
				$mysqli->query("UPDATE `users` SET `location`='".$a['location']."' WHERE `id`='".$_SESSION['id']."'");
				$mysqli->query("UPDATE `users` SET `user_group`='6' WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
				$mysqli->query("DELETE FROM `teleport_user` WHERE `user` = '".$_SESSION['id']."' AND `go` = 'prison'");
			}else{
				$response['question'] = $c;
			}
		break;
		default:
			$response['question'] = 'Чего вылупился? '.$c;
			$response['answer'] = array(
				1 => "Я хочу выйти из тюрьмы"
			);
		break;
	}
?>