<?
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
	if(item_isset(1, 250000)){
		$UserQuery = $mysqli->query("SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
		$pokID = clearInt($_POST['pokID']);
		$pokInfo = $mysqli->query('SELECT * FROM `user_pokemons` WHERE `active` = 1 AND `user_id` = '.$_SESSION['id'].' AND `id` = '.$pokID)->fetch_assoc();
		if($pokInfo){
			if($pokInfo['tren'] == 0){
				$response['text'] = 'Ошибка!';
				$response['error'] = 1;
			}elseif($pokInfo['tren'] == 1){
				if($UserQuery['location'] == 196){
					$minus = $pokInfo['tren'] - 1;
					$mysqli->query('UPDATE `user_pokemons` SET `tren` = '.$minus.' AND `tren_stat` = 0 WHERE `id` = '.$pokID);
					minus_item(1,250000);
					$response['text'] = 'Ваш покемон понизил классификацию!';
					$response['error'] = 1;
				}else{
					$response['text'] = 'Ошибка!';
					$response['error'] = 1;
				}
			}else{
				if($UserQuery['location'] == 196){
					$minus = $pokInfo['tren'] - 1;
					$mysqli->query('UPDATE `user_pokemons` SET `tren` = '.$minus.' WHERE `id` = '.$pokID);
					minus_item(1,250000);
					$response['text'] = 'Ваш покемон понизил классификацию!';
					$response['error'] = 1;
				}else{
					$response['text'] = 'Ошибка!';
					$response['error'] = 1;
				}
			}
		}else{
			$response['text'] = 'Ошибка!';
			$response['error'] = 1;
		}
	}else{
		$response['question'] = 'Но, у тебя нет денег!';
		$response['error'] = 1;
	}
	die(json_encode($response));
}
	$response['name'] = 'Мастер по классификациям';
	switch($npcStep){
		case 1:
			if(!item_isset(1, 250000)){
				$response['question'] = 'Недостаточно денег.';
			}else{
				$pokc = $mysqli->query('SELECT * FROM `user_pokemons` WHERE `active` = 1 AND user_id = '.$_SESSION['id'].' AND `tren` >=1 ');
				if($pokc->num_rows > 0){
					$list = '';
					while($pok = $pokc->fetch_assoc()){
						$list.= '<option value="'.$pok['id'].'">#'.numbPok($pok['basenum']).' '.$pok['name_new'].' '.$pok['lvl'].' ур.</option>';
					}
					$response['question'] = 'Выберите покемона
											<form class="evolNpcForm" onsubmit="evolutionPok(102);return false;"">
											<select id="pokID">'.$list.'
											</select>
												<input class="mn-btn" type="submit" value="Выбрать">
											</form>';
				}else{
					$response['question'] = 'У вас нет с собой покемонов с классификацией.';
				}
			}			
		break;
		default:
			$response['question'] = 'Приветствую вас в нашем тренировочном центре! Я могу предоставить вам возможность понизить вашему покемону классификацию. Но эта услуга не бесплатна, она будет стоить <b>250.000 монет</b>. Пояс останется в том же стате, понизится лишь классификация.';
			if(item_isset(1, 250000)){
				$response['answer'] = array(
					1 => "Мне нужно понизить классификацию своему покемону"
				);
			}
		break;
	}
?>