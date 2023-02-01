<?
	$response['name'] = 'Мелоетта';
	switch($npcStep){
		case 1:
        $rand = mt_rand(1,20);
        if($rand == 1) {
          $prize = '#506 Лилипап';
          plusEgg(false,false,false,false,false,506,true);
        }elseif($rand == 2) {
          $prize = '#590 Фунгус';
          plusEgg(false,false,false,false,false,590,true);
        }elseif($rand == 3) {
          $prize = '#519 Пидов';
          plusEgg(false,false,false,false,false,519,true);
        }elseif($rand == 4) {
          $prize = '#177 Нату';
          plusEgg(false,false,false,false,false,177,true);
        }elseif($rand == 5) {
          $prize = '#200 Мисдревиус';
          plusEgg(false,false,false,false,false,200,true);
        }elseif($rand == 6) {
          $prize = '#231 Фанпи';
          plusEgg(false,false,false,false,false,231,true);
        }elseif($rand == 7) {
          $prize = '#273 Сидот';
          plusEgg(false,false,false,false,false,273,true);
        }elseif($rand == 8) {
          $prize = '#285 Шрумиш';
          plusEgg(false,false,false,false,false,285,true);
        }elseif($rand == 9) {
          $prize = '#318 Карвана';
          plusEgg(false,false,false,false,false,318,true);
        }elseif($rand == 10) {
          $prize = '#331 Какнея';
          plusEgg(false,false,false,false,false,331,true);
        }elseif($rand == 11) {
          $prize = '#333 Сваблу';
          plusEgg(false,false,false,false,false,333,true);
        }elseif($rand == 12) {
          $prize = '#427 Банири';
          plusEgg(false,false,false,false,false,427,true);
        }elseif($rand == 13) {
          $prize = '#434 Станки';
          plusEgg(false,false,false,false,false,434,true);
        }elseif($rand == 14) {
          $prize = '#511 Пансейдж';
          plusEgg(false,false,false,false,false,511,true);
        }elseif($rand == 15) {
          $prize = '#513 Пансир';
          plusEgg(false,false,false,false,false,513,true);
        }elseif($rand == 16) {
          $prize = '#515 Панпур';
          plusEgg(false,false,false,false,false,515,true);
        }elseif($rand == 17) {
          $prize = '#568 Траббиш';
          plusEgg(false,false,false,false,false,568,true);
        }elseif($rand == 18) {
          $prize = '#684 Свирликс';
          plusEgg(false,false,false,false,false,684,true);
        }elseif($rand == 19) {
          $prize = '#692 Клончер';
          plusEgg(false,false,false,false,false,692,true);
        }else{
          $prize = '#694 Гелиоптайл';
          plusEgg(false,false,false,false,false,694,true);
        }
          $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
          $response['question'] = 'Замечательно! Держи награду! Как соберешь еще ноты - приходи сдавать их мне ^_^';
      }else{
        $response['question'] = 'У тебя не весь набор нот! Нужны До, Ре, Ми, Фа, Соль, Ля и Си.';
      }
		break;
		default:
			$response['question'] = 'Приветики!!! Ой, какой же это был классный рок-фестиваль! Мне очень сильно понравилось, что я даже заколдовала всех покемонов, чтобы они издавали музыкальные нотки!! Не правда-ли здорово? Веселье продолжается!! Но ненадолго. Не всегда же веселиться. Кстати, за весь собранный набор нот я даю одну награду. Так что не ленись собирать из покемонов нотки.<br><br>Э-х-х, ну все же прикольный был рок-фест. Думаю, в следующем году проведем еще один!';
			$response['answer'] = array(
				1 => "Сдать набор нот",
        2 => "Кто уже сдал набор нот?"
			);
		break;
	}
?>
