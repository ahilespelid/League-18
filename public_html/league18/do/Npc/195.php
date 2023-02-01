<?
	$response['name'] = 'Могучая колдунья острова Акваландии';
	switch($npcStep){
		case 1:
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1','akvalandia2') ");
		$mysqli->query("UPDATE `users` SET `location`='310' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
		break;
		default:
		$response['question'] = 'Здравствуй! Акваворлду исполняется 2 года! Мы не могли не отметить это событие. Мне удалось создать портал на остров Акваландию. Так что, можешь отправиться туда. Тебя ждут несколько удивительных мест, на которых обитают редкие покемоны.';
		$response['answer'] = array(
			1 => "Отправиться на о. Акваландия"
		);
		break;
	}
?>
