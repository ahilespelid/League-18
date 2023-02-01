<?php
if(isset($_POST['pokID'])){
	$patch_project = $_SERVER['DOCUMENT_ROOT'];
	$patch_global = $patch_project.'/inc/conf/global.php';
	if(!empty($patch_global)){
	    if(!file_exists($patch_global)){
	        die('The problem with the connection files.');
	    }else{
			require_once($patch_global);
	    }
	}
	$checkUserLoc = $mysqli->query("SELECT `location` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
	if($checkUserLoc['location'] == 95){
		$pokID = clearInt($_POST['pokID']);
		$pokInfo = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `id`='".$pokID."'")->fetch_assoc();
		$countMoney = $mysqli->query("SELECT * FROM `items_users` WHERE `user`= '".$_SESSION['id']."' AND `item_id` = '108'")->fetch_assoc();
		switch($pokInfo['basenum']){
			default:
				if($countMoney['count'] >= 50){
					if($pokInfo['type'] == 'shine'){
						$response['text'] = 'Данный покемон уже имеет окрас Shine.';
						$response['error'] = 1;
					}else{
						$response['text'] = 'Покемон стал Shine!';
						$mysqli->query("UPDATE `user_pokemons` SET `type` = 'shine' WHERE `id` = '".$pokID."'");
						minus_item(108,50);
						$response['action'] = 'updateTeam';
					}
				}else{
					$response['text'] = 'У вас недостаточно разноцветной пыли.';
					$response['error'] = 1;
				}
			break;
		}
	}else{
		$response['text'] = 'Ошибка!';
		$response['error'] = 1;
	}
	die(json_encode($response));
}
	$response['name'] = 'Ярмарочный клоун';
	switch($npcStep){
		case 1:
				$poks = $mysqli->query("SELECT `id`,`name_new`,`basenum` FROM `user_pokemons` WHERE `user_id`='".$_SESSION['id']."' AND `active` = '1'");
				$list = '';
				while($pokList = $poks->fetch_assoc()){
					$list.= '<option value="'.$pokList['id'].'">#'.numbPok($pokList['basenum']).' '.$pokList['name_new'].'</option>';
				}
				$response['question'] = 'Выбери покемона
										<form class="evolNpcForm" onsubmit="evolutionPok(57);return false;"">
										<select id="pokID">'.$list.'
										</select>
											<input class="mn-btn" type="submit" value="Выбрать">
										</form>';
		break;
		default:
				$response['question'] = 'Ха-ха! Привет, человек! Хочешь я покрашу твоего покемона в Shine окрас? Хо-хо! Всего за 50 разноцветной пыли!';
				$response['answer'] = array(
					1 => "Я хочу покрасить покемона"
				);
		break;
	}
?>
