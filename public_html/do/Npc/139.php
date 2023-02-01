<?php
$response['name'] = 'Кладовщик';
switch($npcStep){
	case 1:
		if(events_step(1, 2)){
			$to= $mysqli->query("SELECT * FROM teleport_user WHERE user = ".$_SESSION['id']." AND go = '9may'")->fetch_assoc();
			$mysqli->query("UPDATE users SET location = ".$to['location']." WHERE id = ".$_SESSION['id']);
			$mysqli->query("DELETE FROM teleport_user WHERE user = ".$_SESSION['id']." AND go = '9may'");
			$response['action'] = 'updateLocation';
		}else{
			$response['question'] = 'Поздравляю тебя с Днем Победы!';
		}
	break;
	default:
		if(events_step(1, 2)){
			$response['question'] = 'Привет тренер, чем могу помочь?';
			$response['answer'] = [
				1	=> 'Я хочу вернуться'
			];
		}else{
			$response['question'] = 'Поздравляю тебя с Днем Победы!';
		}
	break;
}