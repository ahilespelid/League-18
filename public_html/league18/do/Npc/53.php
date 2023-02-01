<?
	$response['name'] = 'Кэтрин';
	switch($npcStep){
		#Лечение покемонов
		case 1:
			$pokList = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `active` = 1 AND `user_id` = '".$_SESSION['id']."'");
			while($poks = $pokList->fetch_assoc()){
				$poksA = explode(',',$poks['attacks']);
				if($poksA[0]) {
					$pokList1 = $mysqli->query("SELECT `id`,`pp` FROM `base_atk` WHERE `id` = ".$poksA[0]."")->fetch_assoc();
					$pokList1 = $pokList1['pp'];
				}else{
					$pokList1 = '0';
				}
				if($poksA[1]) {
					$pokList2 = $mysqli->query("SELECT `id`,`pp` FROM `base_atk` WHERE `id` = ".$poksA[1]."")->fetch_assoc();
					$pokList2 = $pokList2['pp'];
				}else{
					$pokList2 = '0';
				}
				if($poksA[2]) {
					$pokList3 = $mysqli->query("SELECT `id`,`pp` FROM `base_atk` WHERE `id` = ".$poksA[2]."")->fetch_assoc();
					$pokList3 = $pokList3['pp'];
				}else{
					$pokList3 = '0';
				}
				if($poksA[3]) {
					$pokList4 = $mysqli->query("SELECT `id`,`pp` FROM `base_atk` WHERE `id` = ".$poksA[3]."")->fetch_assoc();
					$pokList4 = $pokList4['pp'];
				}else{
					$pokList4 = '0';
				}
				$stats = explode(',',$poks['stats']);
				$update = $mysqli->query("UPDATE `user_pokemons` SET `hp` = '".$stats[0]."' WHERE `id` = '".$poks['id']."'");
				$update1 = $mysqli->query("UPDATE `user_pokemons` SET `pp_attacks` = '".$pokList1.",".$pokList2.",".$pokList3.",".$pokList4.",' WHERE `id` = '".$poks['id']."'");
			}
			$response['question'] = 'Ваши покемоны вылечены!';
		break;
		#Питомник покемонов
		case 2:
			$response['question'] = '{{new}}';
			$response['type'] = 'nursery';
		break;
		#Питомник покемонов
		case 3:
			$response['question'] = '{{new}}';
			$response['type'] = 'reproduction';
		break;
		default:
			$response['question'] = 'Здравствуй, тренер! Добро пожаловать в наше кафе. Я могу чем-нибудь помочь?';
			$response['answer'] = array(
				1 => "Вылечите моих покемонов",
				2 => "Я хочу получить доступ к питомнику",
				3 => "Я хочу развести покемонов"
			);
		break;
	}
