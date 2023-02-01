<?
	$response['name'] = 'Исследователь Велор';
	switch($npcStep){
			case 1:
			if(!npc_time_check(10000001)){
				$mysqli->query("DELETE FROM base_npc_data WHERE userID = '".$_SESSION['id']."' AND npcID = 10000001");
				$response['question'] = 'Перемещение...';
				$mysqli->query("UPDATE `users` SET `location`='313' WHERE `id`='".$_SESSION['id']."'");
				$rand_pok = mt_rand(20,50);
				$mysqli->query("INSERT INTO user_raid (user,type,count,need,raid) VALUES (".$_SESSION['id'].",'pok',0,".$rand_pok.",1)");
				$response['action'] = 'updateLocation';
			}
			break;
		default:
			if(!npc_time_check(10000001)){
				$response['question'] = '<div class="Rd">Рейд «Злобные Диглетты»</div>Здравствуй, друг. Тоже исследуешь эту пещеру? Прекрасное место, особенно, если спуститься на самую глубину... Слушай, не хочешь со мной? Вниз. В самый низ. М? Ты даже не представляешь что нас там ждет! Сокровища, ага! Главное... э-э... отбиться от Диглеттов. И без крепкой веревки я бы туда не лез. А то порвется и все, кранты! Ну так что? Добычу пополам поделим.';
				$response['answer'] = array(
					1 => "Хорошо, отправляемся вниз!"
				);
			}else{
				$response['question'] = '<div class="Rd">Рейд «Злобные Диглетты»</div>Фух! Сходили же мы в подземелье... Было здорово, но я устал. Давай позже, ладно?';
			}
		break;
	}
?>
