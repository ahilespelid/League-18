<?
	require_once $_SERVER['DOCUMENT_ROOT'].'/inc/function/Functions.php';
	$response['name'] = '???';
	switch($npcStep){
		case 1:
			if(!quest_isset(21)){
				quest_update(21,1);
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1','ng_quest') ");
		$mysqli->query("UPDATE `users` SET `location`='1001' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
				$response['question'] = 'Ошибка!';
			}
		break;
		case 2:
			if(quest_isset(21)){
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1','ng_quest') ");
		$mysqli->query("UPDATE `users` SET `location`='1001' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
				$response['question'] = 'Ошибка!';
			}
		break;
		default:
		if(!quest_isset(21)){
			$response['question'] = 'В разломе что-то светится... Но пройти вы не можете, щель слишком мала...';
			$response['answer'] = array(
				//1 => "Шагнуть на встречу приключениям"
			);
		}else if (quest_step(21,16,1)){
			$response['question'] = 'Вы спасли Новый год!';
			$response['answer'] = array(
				//2 => "Продолжить приключения"
			);			
		}else if (quest_isset(21)){
			$response['question'] = 'В разломе что-то светится...';
			$response['answer'] = array(
				2 => "Продолжить приключения"
			);
		}else{
			$response['question'] = 'Еще раз спасибо за помощь!';
		}
		break;
	}
?>
