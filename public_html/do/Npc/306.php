<?
	$response['name'] = 'Мелоетта';
	switch($npcStep){
		case 1:
		$a = $mysqli->query('SELECT `podarki` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
      if(item_isset(341,1) && item_isset(342,1) && item_isset(343,1)) {
        if($a['podarki'] == 5 || $a['podarki'] == 10 || $a['podarki'] == 15 || $a['podarki'] == 20 || $a['podarki'] == 25 || $a['podarki'] == 30 || $a['podarki'] == 35 || $a['podarki'] == 40 ){
	    $update = $mysqli->query('UPDATE `users` SET `podarki` = `podarki`+1 WHERE `id` = '.$_SESSION['id']);
        $rand = mt_rand(1,20);
        minus_item(341,1);
        minus_item(342,1);
        minus_item(343,1);
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
 		$a = $mysqli->query('SELECT `podarki` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
      if(item_isset(341,1) && item_isset(342,1) && item_isset(343,1)) {
	    $update = $mysqli->query('UPDATE `users` SET `podarki` = `podarki`+1 WHERE `id` = '.$_SESSION['id']);
        $rand = mt_rand(1,20);
        minus_item(341,1);
        minus_item(342,1);
        minus_item(343,1);
        if($rand == 1) {
          $prize = '#506 Лилипап';
          itemAdd(35,1);
        }elseif($rand == 2) {
          $prize = '#590 Фунгус';
          itemAdd(36,1);
        }elseif($rand == 3) {
          $prize = '#519 Пидов';
          itemAdd(52,1);
        }elseif($rand == 4) {
          $prize = '#177 Нату';
          itemAdd(1,10000);
        }elseif($rand == 5) {
          $prize = '#200 Мисдревиус';
          itemAdd(1,15000);
        }elseif($rand == 6) {
          $prize = '#231 Фанпи';
          itemAdd(1,30000);
        }elseif($rand == 7) {
          $prize = '#273 Сидот';
          itemAdd(33,5);
        }elseif($rand == 8) {
          $prize = '#285 Шрумиш';
          itemAdd(40,3);
        }elseif($rand == 9) {
          $prize = '#318 Карвана';
          itemAdd(37,3);
        }elseif($rand == 10) {
          $prize = '#331 Какнея';
           itemAdd(38,3);
        }elseif($rand == 11) {
          $prize = '#333 Сваблу';
          itemAdd(39,3);
        }elseif($rand == 12) {
          $prize = '#427 Банири';
          itemAdd(41,3);
        }elseif($rand == 13) {
          $prize = '#434 Станки';
          itemAdd(42,3);
        }elseif($rand == 14) {
          $prize = '#511 Пансейдж';
          itemAdd(149,3);
        }elseif($rand == 15) {
          $prize = '#513 Пансир';
          itemAdd(179,1);
        }elseif($rand == 16) {
          $prize = '#515 Панпур';
          itemAdd(181,1);
        }elseif($rand == 17) {
          $prize = '#568 Траббиш';
          itemAdd(190,1);
        }elseif($rand == 18) {
          $prize = '#684 Свирликс';
          itemAdd(193,1);
        }elseif($rand == 19) {
          $prize = '#692 Клончер';
          itemAdd(195,1);
        }else{
          $prize = '#694 Гелиоптайл';
          itemAdd(184,1);
        }
          Work::$sql->query("INSERT INTO `noti` (`user`,`prize`) VALUES ('".$_SESSION['id']."','".$prize."') ");
          $response['actionQuestPlus'] = '<img src="/img/world/items/little/0.png" class="item"> Подарок (1 шт.)';
          $response['question'] = 'Замечательно! Держи награду! Как соберешь еще ноты - приходи сдавать их мне ^_^';
      }
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
			$response['question'] = 'Приветики!!! Давай поиграем? Ты мне 3 разных подарка, а я тебе случайеую награду! Подарки я раздала всем покемонам Канто, так что вперед, на поиски!!! ';
			$response['answer'] = array(
				1 => "Сдать набор подарков",
        //2 => "Кто уже сдал набор нот?"
			);
		break;
	}
?>
