<?
	$response['name'] = 'Генерал Лактунов';
	switch($npcStep){
		default:
		if(item_isset(113,1) && item_isset(114,1) && item_isset(115,1)){
				$rand = mt_rand(1,3);
				$response['question'] = 'Спасибо большое за помощь. С таким оружием мы сможем сами справится! Можешь отдохнуть, а можешь и еще помочь и получить больше награды! Держи награду: Набор тренировки х'.$rand;
				itemAdd(95, $rand, $_SESSION['id']);
				minus_item(113,1);minus_item(114,1);minus_item(115,1);
			}else{
				$response['question'] = 'Мы справились! Наступаем в контратаку! Минное поле - самый быстрый путь к базе Команды Аква! Мина откидывает обратно на полигон, будьте аккуратней! В АТАКУУУ!!!';
			}
		break;
	}
?>