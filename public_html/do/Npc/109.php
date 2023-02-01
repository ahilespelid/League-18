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
	$pok = clearInt($_POST['pokID']);
	$update = $mysqli->query('UPDATE `user_pokemons` SET `type` = "snowy" WHERE `id` = '.$pok);
	$update = $mysqli->query('UPDATE `users` SET `shine` = 1 WHERE `id` = '.$_SESSION['id']);
	$response['text'] = 'Покемон стал Snowy';
	die(json_encode($response));
}
	$patch_project = $_SERVER['DOCUMENT_ROOT'];
	$patch_global = $patch_project.'/inc/conf/global.php';
	if(!empty($patch_global)){
		if(!file_exists($patch_global)){
			die('The problem with the connection files.');
		}else{
			require_once($patch_global);
		}
	}
	$response['name'] = 'Помощник Деда Мороза';
	switch($npcStep){
		case 1:
		$eggs = $mysqli->query('SELECT `id`,`basenum`,`name_new` FROM `user_pokemons` WHERE `user_id` = '.$_SESSION['id'].' AND `active` = 1 AND `type` = "normal"');
				if($eggs->num_rows > 0){
					$list = '';
					while($eggList = $eggs->fetch_assoc()){
						$list.= '<option value="'.$eggList['id'].'">#'.numbPok($eggList['basenum']).' '.$eggList['name_new'].'</option>';
					}
					$response['question'] = 'Выберите покемона
											<form class="evolNpcForm" onsubmit="evolutionPok(109);return false;"">
											<select id="pokID">'.$list.'
											</select>
												<input class="mn-btn" type="submit" value="Выбрать">
											</form>';
				}else{
					$response['question'] = 'Извините, но у вас нет ни одного покемона.';
				}
		break;
		default:
			$a = $mysqli->query('SELECT `shine` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
			if($a['shine'] == 0){
				$response['question'] = 'Здравствуй тренер! Я прилетел с самого Нижнего Устюга, по поручению Деда Мороза. Он не смог сам прилететь, ведь еще многое надо успеть. Он попросил мне помочь разукрасить ваших покемонов, и именно поэтому я могу покрасить твоего покемона в shine окрас.';
				$response['answer'] = array(
						1 => "Да, конечно!"
					);
			}else{
				$response['question'] = 'С Наступающим!';
			}
		break;
	}
?>