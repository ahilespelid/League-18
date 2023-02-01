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
	$response['error'] = 1;
	if($checkUserLoc['location'] == 34){
		$pokID = clearInt($_POST['pokID']);
		$pokInfo = $mysqli->query('SELECT `tren` FROM `user_pokemons` WHERE `id` = '.$pokID)->fetch_assoc();
		if($pokInfo['tren'] > 7){
			$response['text'] = 'Покемон достаточно опытен!';
		}else{
			$countOre = $mysqli->query('SELECT `count` FROM `items_users` WHERE `user`= '.$_SESSION['id'].' AND `item_id` = 63')->fetch_assoc();
			if($countOre['count'] > 99){
				if(random_int(1,200) < 20){
					$stat = rand(1,5);
					$mysqli->query('UPDATE `user_pokemons` SET `tren` = `tren` + 1, `tren_stat` = '.$stat.'  WHERE `id` = '.$pokID);
					minus_item(63,100);
					$response['text'] = 'Поздравляю! Я немного обучил твоего покемона!';
				}else{
					$response['text'] = 'К сожалению, я не смог ничему научить покемона.';
				}
				minus_item(63,100);
				
			}else{
				$response['text'] = 'Недостаточно руды!';
			}
		}
	}else{
		$response['text'] = 'Ошибка!';
	}
	die(json_encode($response));
}
	$response['name'] = 'Вад';
	switch($npcStep){
		case 1:
				$poks = $mysqli->query("SELECT `id`,`name_new`,`basenum` FROM `user_pokemons` WHERE `user_id`='".$_SESSION['id']."' AND `active` = '1' AND `tren` < 7");
				$list = '';
				while($pokList = $poks->fetch_assoc()){
					$list.= '<option value="'.$pokList['id'].'">#'.numbPok($pokList['basenum']).' '.$pokList['name_new'].'</option>';
				}
				$response['question'] = 'Выбери покемона
										<form class="evolNpcForm" onsubmit="evolutionPok(120);return false;"">
										<select id="pokID">'.$list.'
										</select>
											<input class="mn-btn" type="submit" value="Выбрать">
										</form>';
		break;
		default:
				$response['question'] = 'Приветствую тебя! Я работник фабрики по переработке разного вида руды. Нам очень не хватает экземпляров железной руды. Если ты дал бы мне, скажем, 100 руды, я бы мог попробовать немного усилить твоего покемона!<br> <i>~Персонаж повышает классификацию покемона, но шанс мал~</i>';
				$response['answer'] = array(
					1 => "Да, конечно! Держите!"
				);
		break;
	}
?>
