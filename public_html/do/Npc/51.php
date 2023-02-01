<?
	$response['name'] = 'Администрация Ист-Айленд';
	switch($npcStep){
		case 1:
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1','akvalandia') ");
		$mysqli->query("UPDATE `users` SET `location`='90' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
		break;
		default:
		$response['question'] = 'Добро пожаловать в <b>League-18</b>, тренер покемонов! Ворота в наш увлекательный мир открыт вновь! В честь этого для всех желающих будет открыт остров Островов Ист-Айленд. Поучаствуй в различных мероприятиях, поиграй в интересные атракционы, посражайся в увлекательных боях - и получай призы! Остров будет открыт для посещения <b>С 20 по 25 февраля включительно</b>. Развлекайтесь, тренеры! ^_^';
		$response['answer'] = array(
			1 => "Отправиться на Острова Ист-Айленд."
		);
		break;
	}
?>
