<?
	$response['name'] = 'Профессор Олан';
	switch($npcStep){
		default:
		if(quest_isset(1)){
			$response['question'] = 'День добрый, тренер!';
		}else{
			$response['actionQuest'] = '<img src="/img/quests/1.png" class="quest"> Обновлена информация в задании «Начало путешествия». Загляните в Покебук.';
			$response['question'] = 'Добро пожаловать в академию. '.$_SESSION['login'].', верно? Вас уже ждут в 205 кабинете. Поторопитесь! Курс обучения по миру League-18 уже скоро начнется!';
			quest_update(1,1);
			update_zap(1,1,'Мне сказали пройти в <b>Кабинет №205</b>. Жду не дождусь пройти курс обучения и стать настоящим тренером покемонов!');
		}
		break;
	}
?>
