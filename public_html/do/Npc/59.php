<?php
// if(isset($_POST['pokID'])){
	// $patch_project = $_SERVER['DOCUMENT_ROOT'];
	// $patch_global = $patch_project.'/inc/conf/global.php';
	// if(!empty($patch_global)){
	    // if(!file_exists($patch_global)){
	        // die('The problem with the connection files.');
	    // }else{
			// require_once($patch_global);
	    // }
	// }
	// $checkUserLoc = $mysqli->query("SELECT `location` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
	// if($checkUserLoc['location'] == 97){
		// $pokID = clearInt($_POST['pokID']);
		// $pokInfo = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `id`='".$pokID."'")->fetch_assoc();
		// $countMoney = $mysqli->query("SELECT `count` FROM `items_users` WHERE `user`= '".$_SESSION['id']."' AND `item_id` = '1'")->fetch_assoc();
		// switch($pokInfo['basenum']){
			// case 129:
				// if($pokInfo['lvl'] >= 15){
					// $rand = rand(5,10);
					// itemAdd(108,$rand);
					// $response['text'] = 'Вы получили: Разноцветная пыль ('.$rand.' шт.)';
					// $mysqli->query("DELETE FROM `user_pokemons` WHERE `id` = '".$pokID."'");
					// $response['action'] = 'updateTeam';
				// }else{
					// $response['text'] = 'У Маджикарпа должен быть 15 уровень и выше!';
					// $response['error'] = 1;
				// }
			// break;
			// default:
				// $response['text'] = 'Ошибка!';
			// break;
		// }
	// }else{
		// $response['text'] = 'Ошибка!';
		// $response['error'] = 1;
	// }
	// die(json_encode($response));
// }
	 $response['name'] = 'Старый рыболов';
	// switch($npcStep){
		// case 1:
				// $poks = $mysqli->query("SELECT `id`,`name_new`,`basenum` FROM `user_pokemons` WHERE `user_id`='".$_SESSION['id']."' AND `active` = '1'");
				// $list = '';
				// while($pokList = $poks->fetch_assoc()){
					// $list.= '<option value="'.$pokList['id'].'">#'.numbPok($pokList['basenum']).' '.$pokList['name_new'].'</option>';
				// }
				// $response['question'] = 'Выбери покемона
										// <form class="evolNpcForm" onsubmit="evolutionPok(59);return false;"">
										// <select id="pokID">'.$list.'
										// </select>
											// <input class="mn-btn" type="submit" value="Выбрать">
										// </form>';
		// break;
		// default:
				// $response['question'] = 'Привет. За каждого Маджикарпа 15 уровня и выше, я буду давать тебе по 5 - 10 разноцветной пыли. Заходи в Бассейн, лови и пракачивай для меня Маджикарпов.';
				// $response['answer'] = array(
					// 1 => "У меня есть нужный Маджикарп"
				// );
		// break;
	// }
	switch($npcStep){
		default:
			$response['question'] = 'Аттракцион больше не работает. Ярмарка закрыта.';
		break;
	}
?>