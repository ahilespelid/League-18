<?
	$response['name'] = 'Марк';
	switch($npcStep){
    case 1:
      $response['question'] = 'Да, она пошла в Лес Петалбурга. Оттуда в последнее время начали убегать покемоны из-за ужастного там холода. Когда я узнал об этом, я сразу же направился за ней. Но было уже поздно, я нигде ее не мог найти. <i>~Опечаленно вздохнул~</i>';
      $response['answer'] = array(
				2 => "Я вам помогу ее найти"
			);
    break;
    case 2:
      if(!quest_isset(20)){
        quest_update(20,1);
        $response['actionQuest'] = '<img src="/img/quests/20.png" class="quest"> Обновлена информация в задании «Мороз по коже». Загляните в Аквабук.';
        update_zap(20,1,'В <b>Лесу Петалбурга</b> пропала милая девушка. Мне нужно попытасться отыскать ее.');
        $response['question'] = 'Правда?! Но, я боюсь, что это невозможно. Я уже обращался за помощью в полицейский участок. Все бестолку. Я не знаю, что и думать сейчас даже... Но, все таки спасибо тебе за помощь. Если будет какая-нибудь информация о ней, то меня можно найти тут.';
      }
    break;
		default:
		if(quest_isset(20)){
			$response['question'] = '<i>~Грустно смотрит на фотографию пропавшей девушки~</i>';
		}else{
			$response['question'] = 'Здравствуйте, вы не видели эту молодую девушку? <i>~Трясущимися руками протягивает Вам фотографию молодой девушки~</i>';
      $response['answer'] = array(
				1 => "Она пропала?"
			);
		}
		break;
	}
?>
