<?
	$response['name'] = 'Исцеляющий механизм';
	switch($npcStep){
		#Лечение покемонов
		case 1:
			$pokList = $mysqli->query("SELECT `id`,`stats` FROM `user_pokemons` WHERE `active` = 1 AND `user_id` = '".$_SESSION['id']."'");
			while($poks = $pokList->fetch_assoc()){
				$stats = explode(',',$poks['stats']);
				$update = $mysqli->query("UPDATE `user_pokemons` SET `hp` = '".$stats[0]."' WHERE `id` = '".$poks['id']."'");
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
			$response['question'] = '<i>Блиблап-блуп!</i>';
			$response['answer'] = array(
				1 => "Вылечить покемонов"
			);
		break;
	}