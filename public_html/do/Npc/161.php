<?
	$response['name'] = 'Выйти из комнаты трюков';
	switch($npcStep){
		default:
      $mysqli->query("UPDATE `users` SET `location`='145' WHERE `id`='".$_SESSION['id']."'");
      $response['action'] = 'updateLocation';
		break;
	}
?>
