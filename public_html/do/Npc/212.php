<?
	$response['name'] = 'Аватар';
	$a = $mysqli->query("SELECT * FROM `cloth` WHERE `user` = '".$_SESSION['id']."'")->fetch_assoc();
	$b = $mysqli->query("SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
	switch($npcStep){
		case 3:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '2' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 4:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '4' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 5:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '5' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 6:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '6' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 7:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '17' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 8:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '19' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 9:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '21' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 10:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '7' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 11:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '9' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 12:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '12' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 13:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '14' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 14:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '16' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 15:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '18' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 16:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '20' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 17:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '8' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 18:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '10' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 19:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '11' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 20:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '13' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 21:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '1002' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 22:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '1003' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 23:
			if($b['sex'] == 'm' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '1004' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 25:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '1008' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 26:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '15' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 27:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '1002' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 28:
			if($b['sex'] == 'f' && item_isset(43,7)){
				$response['question'] .= 'Успешно!';
				minus_item(43,7);
				$mysqli->query("UPDATE `cloth` SET `model` = '50' WHERE `user` = '".$_SESSION['id']."'");
			}else{
				$response['question'] .= 'У тебя не хватает денег.';
			}
		break;
		case 1:
			$response['question'] .= '
			<div class="avatars">
			';
			if($b['sex'] == 'm'){
				$response['question'] .= '
				<div class="skin" onclick="NpcDialog(212,3);" style="background-image: url(/img/avatars/full/model/2.png), url(/img/avatars/full/model/2.png);">
					<div class="Name">Аватар 1</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,4);" style="background-image: url(/img/avatars/full/model/4.png), url(/img/avatars/full/model/4.png);">
					<div class="Name">Аватар 2</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,7);" style="background-image: url(/img/avatars/full/model/17.png), url(/img/avatars/full/model/17.png);">
					<div class="Name">Аватар 3</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,8);" style="background-image: url(/img/avatars/full/model/19.png), url(/img/avatars/full/model/19.png);">
					<div class="Name">Аватар 4</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,9);" style="background-image: url(/img/avatars/full/model/21.png), url(/img/avatars/full/model/21.png);">
					<div class="Name">Аватар 5</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,10);" style="background-image: url(/img/avatars/full/model/7.png), url(/img/avatars/full/model/7.png);">
					<div class="Name">Аватар 6</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,11);" style="background-image: url(/img/avatars/full/model/9.png), url(/img/avatars/full/model/9.png);">
					<div class="Name">Аватар 7</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,12);" style="background-image: url(/img/avatars/full/model/12.png), url(/img/avatars/full/model/12.png);">
					<div class="Name">Аватар 8</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,13);" style="background-image: url(/img/avatars/full/model/14.png), url(/img/avatars/full/model/14.png);">
					<div class="Name">Аватар 9</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,21);" style="background-image: url(/img/avatars/full/model/1002.png), url(/img/avatars/full/model/1002.png);">
					<div class="Name">Аватар 21</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,22);" style="background-image: url(/img/avatars/full/model/1003.png), url(/img/avatars/full/model/1003.png);">
					<div class="Name">Аватар 22</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,23);" style="background-image: url(/img/avatars/full/model/1004.png), url(/img/avatars/full/model/1004.png);">
					<div class="Name">Аватар 23</div>
					<div class="Price">7 жем.</div>
				</div>
			';
			}else{
				$response['question'] .= '
				<div class="skin" onclick="NpcDialog(212,5);" style="background-image: url(/img/avatars/full/model/5.png), url(/img/avatars/full/model/5.png);">
					<div class="Name">Аватар 1</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,6);" style="background-image: url(/img/avatars/full/model/6.png), url(/img/avatars/full/model/6.png);">
					<div class="Name">Аватар 2</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,14);" style="background-image: url(/img/avatars/full/model/16.png), url(/img/avatars/full/model/16.png);">
					<div class="Name">Аватар 3</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,15);" style="background-image: url(/img/avatars/full/model/18.png), url(/img/avatars/full/model/18.png);">
					<div class="Name">Аватар 4</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,16);" style="background-image: url(/img/avatars/full/model/20.png), url(/img/avatars/full/model/20.png);">
					<div class="Name">Аватар 5</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,17);" style="background-image: url(/img/avatars/full/model/8.png), url(/img/avatars/full/model/8.png);">
					<div class="Name">Аватар 6</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,18);" style="background-image: url(/img/avatars/full/model/10.png), url(/img/avatars/full/model/10.png);">
					<div class="Name">Аватар 7</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,19);" style="background-image: url(/img/avatars/full/model/11.png), url(/img/avatars/full/model/11.png);">
					<div class="Name">Аватар 8</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,20);" style="background-image: url(/img/avatars/full/model/13.png), url(/img/avatars/full/model/13.png);">
					<div class="Name">Аватар 9</div>
					<div class="Price">7 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,25);" style="background-image: url(/img/avatars/full/model/1008.png), url(/img/avatars/full/model/1008.png);">
					<div class="Name">Аватар 25</div>
					<div class="Price">25 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,26);" style="background-image: url(/img/avatars/full/model/15.png), url(/img/avatars/full/model/15.png);">
					<div class="Name">Аватар 26</div>
					<div class="Price">25 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,27);" style="background-image: url(/img/avatars/full/model/1002.png), url(/img/avatars/full/model/1002.png);">
					<div class="Name">Аватар 27</div>
					<div class="Price">25 жем.</div>
				</div>
				<div class="skin" onclick="NpcDialog(212,28);" style="background-image: url(/img/avatars/full/model/50.png), url(/img/avatars/full/model/50.png);">
					<div class="Name">Аватар 28</div>
					<div class="Price">25 жем.</div>
				</div>
			';
			}
		break;
			$response['question'] .= '</div>';
		break;
		default:
			$response['question'] = 'Привет! Я могу сменить тебе аватар, но не за бесплатно,хочешь ?';
			$response['answer'] = array(
				1 => "Выбрать Аватар"
			);
		break;
	}
?>