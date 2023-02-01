<?
	$response['name'] = 'Мелоетта';
	switch($npcStep){
		case 1:
      if(item_isset(268,1) && item_isset(269,1) && item_isset(270,1) && item_isset(271,1) && item_isset(272,1) && item_isset(273,1) && item_isset(274,1)) {
        $rand = mt_rand(1,20);
        minus_item(268,1);
        minus_item(269,1);
        minus_item(270,1);
        minus_item(271,1);
        minus_item(272,1);
        minus_item(273,1);
        minus_item(274,1);
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
          Work::$sql->query("INSERT INTO `noti` (`user`,`prize`) VALUES ('".$_SESSION['id']."','".$prize."') ");
          $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
          $response['question'] = 'Замечательно! Держи награду! Как соберешь еще ноты - приходи сдавать их мне ^_^';
      }else{
        $response['question'] = 'У тебя не весь набор нот! Нужны До, Ре, Ми, Фа, Соль, Ля и Си.';
      }
		break;
    case 2:
      $noti = Work::$sql->query("SELECT * FROM noti ORDER BY id DESC");
      while($nota = $noti->fetch_assoc()){
        $user = Work::$sql->query("SELECT * FROM users WHERE id = ".$nota['user'])->fetch_assoc();
				if($user['sex'] == 'm') {
					$per = 'сдал набор нот и получил';
				}else{
					$per = 'сдала набор нот и получила';
				}
        $a .= '<div class="user-link"><div onclick="showUserTooltip('.$user['id'].')" class="Info-Link sex'.$user['sex'].'"><i class="fa fa-info"></i></div> <div class="u-'.$user['user_group'].'">'.$user['login'].'</div></div> '.$per.' яйцо '.$nota['prize'].'.<br><br>';
      }
      $response['question'] = '<div style="line-height: normal;">'.$a.'</div>';
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
