<?
	$a = $mysqli->query("SELECT * FROM `teleport_user` WHERE `user` = '".$_SESSION['id']."' AND `go` = 'arena'")->fetch_assoc();
	$response['name'] = 'Куратор арены';
	switch($npcStep){
		case 1:
			$mysqli->query("UPDATE `users` SET `location`='".$a['location']."' WHERE `id`='".$_SESSION['id']."'");
			$response['action'] = 'updateLocation';
			$mysqli->query("DELETE FROM `teleport_user` WHERE `user` = '".$_SESSION['id']."' AND `go` = 'arena'");
		break;
		default:
			$response['question'] = 'Добрый день.';
			// $response['question'] = 'Добрый день. Сегодня проводится <b><a target="_blank" href="http://aquaworld.forum.wtf/viewtopic.php?id=52">Турнир для всех тренеров на 50 ур. (Турнир #2)</a></b>. Участники:<br>
			// <b>Сириус Брок</b> (4 оч.)<br>
			// <b>LACERTO</b> (10 оч.)<br>
			// <b>GEFESTO</b> (6 оч.)<br>
			// <b>fREAKAZOiD</b> (4 оч.)<br>
			// <b>superq</b> (2 оч.)<br>
			// <b>Pawky</b> (4 оч.)<br>
			// Так как участвуют 6 человек, бои будут происходить "Каждый с каждым". За победу дается 2 очка, за поражение 0, за ничью (если она будет) дается 1 очко. Всего 5 туров.<br>
			// <center><h2>5 тур</h2></center>
			// 1. fREAKAZOiD vs GEFESTO<br>
			// 2. Сириус Брок vs Pawky<br>
			// 3. superq vs LACERTO
			// ';
			$response['answer'] = array(
				1 => "Я хочу покинуть арену"
			);
		break;
	}
?>
