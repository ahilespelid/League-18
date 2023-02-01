<?
	$response['name'] = 'Назад к пляжу';
	switch($npcStep){
		default:
      $mysqli->query("UPDATE `users` SET `location`='117' WHERE `id`='".$_SESSION['id']."'");
      $response['action'] = 'updateLocation';
		break;
	}
?>
