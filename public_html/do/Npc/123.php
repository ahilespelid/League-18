<? 
	$a = $mysqli->query("SELECT * FROM `teleport_user` WHERE `user` = '".$_SESSION['id']."' AND `go` = 'love_fest'")->fetch_assoc();
	$response['name'] = 'Адмирал Сайкуновский'; 
		switch($npcStep){
			case 1:
				$mysqli->query("UPDATE `users` SET `location`='".$a['location']."' WHERE `id`='".$_SESSION['id']."'");
				$response['action'] = 'updateLocation';
				$mysqli->query("DELETE FROM `teleport_user` WHERE `user` = '".$_SESSION['id']."' AND `go` = 'love_fest'");
			break;
			default: 
				$response['question'] = 'Добро пожаловать в Военный Городок! Прогуляйтесь по местным достопримечательностям... Эти виды не могут не радовать.'; 
				$response['answer'] = array(
					1 => "Я хочу покинуть городок"
				);
			break; 
		}
?>