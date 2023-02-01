<?
	$response['name'] = 'Парикмахер';
	$a = $mysqli->query("SELECT * FROM `cloth` WHERE `user` = '".$_SESSION['id']."'")->fetch_assoc();
	$b = $mysqli->query("SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
	switch($npcStep){
		case 3:
			if($b['sex'] == 'm' && item_isset(1,150000)){
				$response['question'] .= 'Это подровнять.. Тут немного причесать. Готово! Заходите к нам еще.';
				$mysqli->query("UPDATE `cloth` SET `hair` = '1' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 4:
			if($b['sex'] == 'm' && item_isset(1,150000)){
				$response['question'] .= 'Это подровнять.. Тут немного причесать. Готово! Заходите к нам еще.';
				$mysqli->query("UPDATE `cloth` SET `hair` = '2' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 5:
			if($b['sex'] == 'f' && item_isset(1,150000)){
				$response['question'] .= 'Это подровнять.. Тут немного причесать. Готово! Заходите к нам еще.';
				$mysqli->query("UPDATE `cloth` SET `hair` = '7' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 6:
			if($b['sex'] == 'f' && item_isset(1,150000)){
				$response['question'] .= 'Это подровнять.. Тут немного причесать. Готово! Заходите к нам еще.';
				$mysqli->query("UPDATE `cloth` SET `hair` = '8' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 1:
			$response['question'] .= 'Выбери себе новую преческу! <b>Внимание!</b> Если ваши волосы покрашены, то краска смоется.
			<div class="Hairs">
			';
			if($b['sex'] == 'm'){
				$response['question'] .= '
				<div class="Hair boy" onclick="NpcDialog(110,3);" style="background-image: url(/img/avatars/full/hair/m/1.png), url(/img/avatars/full/model/1.png);">
					<div class="Name">Стандартная</div>
					<div class="Price">150.000 мон.</div>
				</div>
				<div class="Hair boy" onclick="NpcDialog(110,4);" style="background-image: url(/img/avatars/full/hair/m/2.png), url(/img/avatars/full/model/1.png);">
					<div class="Name">Морские волны</div>
					<div class="Price">150.000 мон.</div>
				</div>
			';
			}else{
				$response['question'] .= '
				<div class="Hair girl" onclick="NpcDialog(110,5);" style="background-image: url(/img/avatars/full/hair/f/7.png), url(/img/avatars/full/model/2.png);">
					<div class="Name">Водопад</div>
					<div class="Price">150.000 мон.</div>
				</div>
				<div class="Hair girl" onclick="NpcDialog(110,6);" style="background-image: url(/img/avatars/full/hair/f/8.png), url(/img/avatars/full/model/2.png);">
					<div class="Name">Острая</div>
					<div class="Price">150.000 мон.</div>
				</div>
			';
			}
		break;
		$response['question'] .= '</div>';
		case 2:
			$response['question'] .= 'Выберите цвет волос. <div class="Hairs">';
			switch ($b['sex']){
				case 'm':
					switch ($a['hair']){
						case 2:
						case 4:
						$response['question'] .= '
						<div class="Hair boy" onclick="NpcDialog(110,100);" style="background-image: url(/img/avatars/full/hair/m/4.png), url(/img/avatars/full/model/1.png);">
							<div class="Name">Белый</div>
							<div class="Price">150.000 мон.</div>
						</div>
						';
						break;
						case 1:
						case 3:
						$response['question'] .= '
						<div class="Hair boy" onclick="NpcDialog(110,100);" style="background-image: url(/img/avatars/full/hair/m/3.png), url(/img/avatars/full/model/1.png);">
							<div class="Name">Белый</div>
							<div class="Price">150.000 мон.</div>
						</div>
						';
						break;
					}
				break;
				case 'f':
					switch ($a['hair']){
						case 7:
						case 2:
						case 1:
						$response['question'] .= '
						<div class="Hair girl" onclick="NpcDialog(110,100);" style="background-image: url(/img/avatars/full/hair/f/2.png), url(/img/avatars/full/model/2.png);">
							<div class="Name">Белый</div>
							<div class="Price">150.000 мон.</div>
						</div>
						';
						break;
						case 3:
						case 8:
						$response['question'] .= '
						<div class="Hair girl" onclick="NpcDialog(110,100);" style="background-image: url(/img/avatars/full/hair/f/3.png), url(/img/avatars/full/model/2.png);">
							<div class="Name">Белый</div>
							<div class="Price">150.000 мон.</div>
						</div>
						';
						break;
					}
				break;
			}
			$response['question'] .= '</div>';
		break;
		case 100:
			if(item_isset(1,150000)){
				$response['question'] .= 'Чутка тут.. Чутка здесь. Ваши волосы готовы!';
				switch ($b['sex']){
					case 'm':
						switch ($a['hair']){
							case 2:
							case 4:
								$mysqli->query("UPDATE `cloth` SET `hair` = '4' WHERE `user` = '".$_SESSION['id']."'");
							break;
							case 1:
							case 3:
								$mysqli->query("UPDATE `cloth` SET `hair` = '3' WHERE `user` = '".$_SESSION['id']."'");
							break;
						}
					break;
					case 'f':
						switch ($a['hair']){
							case 7:
							case 2:
							case 1:
								$mysqli->query("UPDATE `cloth` SET `hair` = '2' WHERE `user` = '".$_SESSION['id']."'");
							break;
							case 3:
							case 8:
								$mysqli->query("UPDATE `cloth` SET `hair` = '3' WHERE `user` = '".$_SESSION['id']."'");
							break;
						}
					break;
				}
			}else{
				$response['question'] .= 'Не хватает денег.';
			}
		break;
		default:
			$response['question'] = 'Приветик! Ты подстригаться или покрасить волосы?';
			$response['answer'] = array(
				1 => "Хочу подстричься",
				2 => "Хочу покраситься"
			);
		break;
	}
?>