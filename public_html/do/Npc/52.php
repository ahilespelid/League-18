<?
	$response['name'] = 'Тим';
	switch($npcStep){
		case 1:
			$rand = rand(1,15);
			if($rand == 1){
				$b = 485;
			}elseif($rand == 2){
				$b = 378;
			}elseif($rand == 3){
				$b = 601;
			}elseif($rand == 4){
				$b = 571;
			}elseif($rand == 5){
				$b = 639;
			}elseif($rand == 6){
				$b = 642;
			}elseif($rand == 7){
				$b = 376;
			}elseif($rand == 8){
				$b = 530;
			}elseif($rand == 9){
				$b = 609;
			}elseif($rand == 10){
				$b = 486;
			}elseif($rand == 11){
				$b = 381;
			}elseif($rand == 12){
				$b = 448;
			}elseif($rand == 13){
				$b = 516;
			}elseif($rand == 14){
				$b = 612;
			}else{
				$b = 142;
			}
			$a = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `event` = 1 AND user_id = '".$_SESSION['id']."'")->fetch_assoc();
			$c = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$b."'")->fetch_assoc();
			if($a){
				if(npc_time_check($npcId)){
					$response['question'] = 'Привет, как тебе остров? Нравится? .. Если ты за покемоном, то извини, час еще не прошел. Приходи позже.';
				}else{
					$mysqli->query("DELETE FROM `base_npc_data` WHERE `userID` = '".$_SESSION['id']."' AND `npcID` = '".$npcId."'");
					$wait = time()+3600;
					$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
					$mysqli->query("DELETE FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `event` = 1");
					newPokemon($b,$_SESSION['id'],100,false,1,false,1,1);
					$response['question'] = 'У тебя уже был один спутник. Я его заменил на другого. На этот раз тебе достался <b>#'.$b.' '.$c['name_rus'].'</b>. Удачных путешествий!';
				}
			}else{
				$wait = time()+3600;
				$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','".$npcId."','".$wait."') ");
				$response['question'] = 'Тебе достался <b>#'.$b.' '.$c['name_rus'].'</b>. Удачных путешествий!';
				newPokemon($b,$_SESSION['id'],100,false,1,false,1,1);
			}
			$response['action'] = 'updateTeam';
		break;
		default:
		$response['question'] = 'Привет. Первый раз тут? Я выдаю покемонов-спутников для совместного путешествия. Без этих покемонов запрещено посещать какие-либо места на этом острове. Покеболов с покемонами много, выдаю один случайный покебол раз в час. Так что если надоест твой спутник, приходи, выдам нового.';
		$response['answer'] = array(
			1 => "Выдайте мне покемона-спутника"
		);
		break;
	}
?>