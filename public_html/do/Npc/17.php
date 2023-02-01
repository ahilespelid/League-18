<?
	$response['name'] = 'Профессор Рейн';
	switch($npcStep){
		case 1:
		$response['question'] = '
		Я могу обучить этим знаниям:
		<br><b>1.</b> За <b>20.000</b> PVE очков я могу обучить тебя знаниям приманивать еще больше Shine и Shadow покемонов. Встреча шайни будет увеличена в 2 раза.
		<br><b>2.</b> За <b>15.000</b> PVE очков я могу обучить тебя бережнее относиться к предметам. Шанс поломки предмета снизится на 10%.
		<br><b>3.</b> За <b>25.000</b> PVE очков я могу обучить тебя таким знаниям, которые позволят тебе при спарке получать яйца до 10 дней вылупления, но не меньше 7.
		<br><b>4.</b> За <b>25.000</b> PVE очков я могу обучить тебя таким знаниям, которые позволят тебе получать в два раза больше монет с помощью Денежного кольца.
		<br><b>5.</b> За <b>25.000</b> PVE очков я могу обучить тебя тщательнее находить Значки Драз`до с диких покемонов. Шанс дропа значков будет увеличен в 2 раза.
		<br><b>6.</b> За <b>500</b> PVE очков я могу обучить тебя находить Геноболы у диких покемонов. С каждого дикого покемона у тебя будет шанс дропнуть Геноболы. Время действия 1 час.
		';
		$response['answer'] = array(
			2 => "Обучите меня первому пункту",
			3 => "Обучите меня второму пункту",
			4 => "Обучите меня третьем пункту",
			5 => "Обучите меня четвертому пункту",
			6 => "Обучите меня пятому пункту",
			7 => "Обучите меня шестому пункту"
		);
		break;
		case 2:
		$learn = $mysqli->query('SELECT * FROM learn_pve WHERE user = '.$_SESSION['id'].' AND type = 1')->fetch_assoc();
		if($learn) {
			$response['question'] = 'Ты уже выучил это.';
		}else{
			if(learn_pve() >= 20000) {
				minus_learn_pve(20000);
				$mysqli->query("INSERT INTO learn_pve (user,type) VALUES(".$_SESSION['id'].",1) ");
				$response['question'] = 'Вы удачно выучили эти знания.';
			}else{
				$response['question'] = 'Недостаточно PVE очков.';
			}
		}
		break;
		case 3:
		$learn = $mysqli->query('SELECT * FROM learn_pve WHERE user = '.$_SESSION['id'].' AND type = 2')->fetch_assoc();
		if($learn) {
			$response['question'] = 'Ты уже выучил это.';
		}else{
			if(learn_pve() >= 15000) {
				minus_learn_pve(15000);
				$mysqli->query("INSERT INTO learn_pve (user,type) VALUES(".$_SESSION['id'].",2) ");
				$response['question'] = 'Вы удачно выучили эти знания.';
			}else{
				$response['question'] = 'Недостаточно PVE очков.';
			}
		}
		break;
		case 4:
		$learn = $mysqli->query('SELECT * FROM learn_pve WHERE user = '.$_SESSION['id'].' AND type = 3')->fetch_assoc();
		if($learn) {
			$response['question'] = 'Ты уже выучил это.';
		}else{
			if(learn_pve() >= 25000) {
				minus_learn_pve(25000);
				$mysqli->query("INSERT INTO learn_pve (user,type) VALUES(".$_SESSION['id'].",3) ");
				$response['question'] = 'Вы удачно выучили эти знания.';
			}else{
				$response['question'] = 'Недостаточно PVE очков.';
			}
		}
		break;
		case 5:
		$learn = $mysqli->query('SELECT * FROM learn_pve WHERE user = '.$_SESSION['id'].' AND type = 4')->fetch_assoc();
		if($learn) {
			$response['question'] = 'Ты уже выучил это.';
		}else{
			if(learn_pve() >= 25000) {
				minus_learn_pve(25000);
				$mysqli->query("INSERT INTO learn_pve (user,type) VALUES(".$_SESSION['id'].",4) ");
				$response['question'] = 'Вы удачно выучили эти знания.';
			}else{
				$response['question'] = 'Недостаточно PVE очков.';
			}
		}
		break;
		case 6:
		$learn = $mysqli->query('SELECT * FROM learn_pve WHERE user = '.$_SESSION['id'].' AND type = 5')->fetch_assoc();
		if($learn) {
			$response['question'] = 'Ты уже выучил это.';
		}else{
			if(learn_pve() >= 25000) {
				minus_learn_pve(25000);
				$mysqli->query("INSERT INTO learn_pve (user,type) VALUES(".$_SESSION['id'].",5) ");
				$response['question'] = 'Вы удачно выучили эти знания.';
			}else{
				$response['question'] = 'Недостаточно PVE очков.';
			}
		}
		break;
		case 7:
		if(learn_pve() >= 500) {
			$usilItem = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = '280'")->fetch_assoc();
			$usilFunc = explode(',',$usilItem['info']);
			$time = time() + $usilFunc[0];
			$usil = $mysqli->query("SELECT * FROM `bafs` WHERE `type` = '".$usilFunc[1]."' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
			if($usil) {
				$mysqli->query("UPDATE `bafs` SET `time` = '".$time."',`baf` = '280' WHERE `type` = '".$usilFunc[1]."' AND `user` = '".$_SESSION['id']."'");
			}else{
				$mysqli->query("INSERT INTO `bafs` (`user`,`baf`,`time`,`type`) VALUES ('".$_SESSION['id']."','280', '".$time."', '".$usilFunc[1]."') ");
			}
			minus_learn_pve(500);
			$response['question'] = 'Вы удачно выучили эти знания.';
		}else{
			$response['question'] = 'Недостаточно PVE очков.';
		}
		break;
		default:
		$response['question'] = 'Добрый день. Я могу обучить тебя различным знаниям по Покемоноведению за твои PVE очки.<br><i>~PVE очки даются за победу над диким покемоном. 1 дикий покемон = 1 PVE очко. Также PVE очки можно заработать в различных заданиях.~</i><br>У тебя '.learn_pve().' PVE очков.';
		$response['answer'] = array(
			1 => "Здравствуйте. Какими знаниями вы можете меня обучить?"
		);
		break;
	}
?>
