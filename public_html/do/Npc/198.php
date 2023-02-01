<?php
$user = $mysqli->query("SELECT * FROM users WHERE id = ".$_SESSION['id'])->fetch_assoc();
$response['name'] = 'Колодец желаний';
switch($npcStep){
  case 1:
    if(item_isset(323,5)) {
      $rand = mt_rand(1,1000);
      $coin = $user['coins'] + 5;
      $response['question'] = '<i>~Магическим образом в руках у вас появляется предмет~</i>';
      $mysqli->query("UPDATE users SET coins = ".$coin." WHERE id =  ".$_SESSION['id']);
      if($rand == 0) {
      //if($rand >= 1 && $rand <= 5) {
        $rand2 = mt_rand(1,3);
        if($rand2 == 1) {
          plusEgg(false,false,101,false,false,447,true);
        }elseif($rand2 == 2) {
          plusEgg(false,false,101,false,false,669,true);
        }else{
          plusEgg(false,false,101,false,false,133,true);
        }
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
      }elseif($rand >= 6 && $rand <= 50) {
        $rand2 = mt_rand(1,3);
        if($rand2 == 1) {
          plusEgg(false,false,101,false,false,328,true);
        }elseif($rand2 == 2) {
          plusEgg(false,false,101,false,false,123,true);
        }else{
          plusEgg(false,false,101,false,false,127,true);
        }
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
      }elseif($rand >= 51 && $rand <= 200){
        $randStab = mt_rand(179,195);
        itemAdd($randStab,1);
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/'.$randStab.'.png" class="item"> Стабовый модификатор (1 шт.)';
      }elseif($rand >= 201 && $rand <= 600) {
        $randStab = mt_rand(37,42);
        itemAdd($randStab,3);
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/'.$randStab.'.png" class="item"> Витамины (3 шт.)';
      }elseif($rand >= 601 && $rand <= 860) {
        $randStab = mt_rand(217,234);
        itemAdd($randStab,3);
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/'.$randStab.'.png" class="item"> Пирожное (3 шт.)';
      }elseif($rand >= 861 && $rand <= 920) {
        itemAdd(73,1);
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/73.png" class="item"> Потертый диск (1 шт.)';
      }elseif($rand >= 921 && $rand <= 970) {
        itemAdd(74,1);
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/74.png" class="item"> Усовершенствованный диск (1 шт.)';
      }else{
        $rand2 = mt_rand(1,3);
        if($rand2 == 1) {
          itemAdd(1070,1);
        }elseif($rand2 == 2) {
          itemAdd(1091,1);
        }else{
          itemAdd(1002,1);
        }
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/1006.png" class="item"> Тренировочная машина (1 шт.)';
      }
      minus_item(323,5);
      $response['actionQuestMinus'] = '<img src="/img/world/items/little/323.png" class="item"> Символ Акваворлда (5 шт.)';
    }else{
      $response['question'] = 'Недостаточно Символов Акваворлда.';
    }
    $response['answer'] = array(
       1 => "Я желаю... Какой-нибудь предмет!"
    );
  break;
  case 2:
    if($user['coins'] != 10000) {
      $item = $mysqli->query("SELECT * FROM items_users WHERE user = ".$_SESSION['id']." AND item_id = 323")->fetch_assoc();
      if($item) {
        $response['actionQuestMinus'] = '<img src="/img/world/items/little/323.png" class="item"> Символ Акваворлда ('.$item['count'].' шт.)';
        $itemPlus = $user['coins'] + $item['count'];
        $mysqli->query("UPDATE users SET coins = ".$itemPlus." WHERE id =  ".$_SESSION['id']);
        $mysqli->query("DELETE FROM items_users WHERE user = ".$_SESSION['id']." AND item_id = 323");
      }
      $user = $mysqli->query("SELECT * FROM users WHERE id = ".$_SESSION['id'])->fetch_assoc();
      $response['question'] = 'Вы сдали символов: '.$user['coins'].' шт.';
      $a = $user['coins'];
      if($a != 0){
        if($a >= 1 && $a <= 5) {
          $rand4 = mt_rand(1,3);
          itemAdd(109,5);
          $b .= '<br><img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
          $rand = mt_rand(1,3);
          if($rand == 1){
            itemAdd(104,1);
            $b .= '<br><img src="/img/world/items/little/104.png" class="item"> Лупа (1 шт.)';
          }elseif($rand == 2) {
            itemAdd(103,1);
            $b .= '<br><img src="/img/world/items/little/103.png" class="item"> Блестки (1 шт.)';
          }else{
            itemAdd(105,1);
            $b .= '<br><img src="/img/world/items/little/105.png" class="item"> Линзы (1 шт.)';
          }
          if($rand4 == 1){
            itemAdd(52,1);
            $b .= '<br><img src="/img/world/items/little/52.png" class="item"> Протектор (1 шт.)';
          }elseif($rand4 == 2) {
            itemAdd(51,1);
            $b .= '<br><img src="/img/world/items/little/51.png" class="item"> Магмарайзер (1 шт.)';
          }else{
            itemAdd(53,1);
            $b .= '<br><img src="/img/world/items/little/53.png" class="item"> Электрайзер (1 шт.)';
          }
        }elseif($a >= 6 && $a <= 10){
          $rand4 = mt_rand(1,3);
          itemAdd(109,5);
          $b .= '<br><img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
          $rand = mt_rand(1,3);
          if($rand == 1){
            itemAdd(104,1);
            $b .= '<br><img src="/img/world/items/little/104.png" class="item"> Лупа (1 шт.)';
          }elseif($rand == 2) {
            itemAdd(103,1);
            $b .= '<br><img src="/img/world/items/little/103.png" class="item"> Блестки (1 шт.)';
          }else{
            itemAdd(105,1);
            $b .= '<br><img src="/img/world/items/little/105.png" class="item"> Линзы (1 шт.)';
          }
          if($rand4 == 1){
            itemAdd(52,1);
            $b .= '<br><img src="/img/world/items/little/52.png" class="item"> Протектор (1 шт.)';
          }elseif($rand4 == 2) {
            itemAdd(51,1);
            $b .= '<br><img src="/img/world/items/little/51.png" class="item"> Магмарайзер (1 шт.)';
          }else{
            itemAdd(53,1);
            $b .= '<br><img src="/img/world/items/little/53.png" class="item"> Электрайзер (1 шт.)';
          }
          $rand2 = mt_rand(1,3);
          if($rand2 == 1) {
            itemAdd(20,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Солнечный камень (1 шт.)';
          }elseif($rand2 == 2){
            itemAdd(36,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сияющий камень (1 шт.)';
          }else{
            itemAdd(19,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сумрачный камень (1 шт.)';
          }
          $b .= '<br><img src="/img/world/items/little/95.png" class="item"> Набор классификаций (2 шт.)<br><img src="/img/world/items/little/72.png" class="item"> Чешуя дракона (1 шт.)';
          itemAdd(95,2);
          itemAdd(72,1);
        }elseif($a >= 11 && $a <= 15){
          $rand4 = mt_rand(1,3);
          itemAdd(109,5);
          $b .= '<br><img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
          $rand = mt_rand(1,3);
          if($rand == 1){
            itemAdd(104,1);
            $b .= '<br><img src="/img/world/items/little/104.png" class="item"> Лупа (1 шт.)';
          }elseif($rand == 2) {
            itemAdd(103,1);
            $b .= '<br><img src="/img/world/items/little/103.png" class="item"> Блестки (1 шт.)';
          }else{
            itemAdd(105,1);
            $b .= '<br><img src="/img/world/items/little/105.png" class="item"> Линзы (1 шт.)';
          }
          if($rand4 == 1){
            itemAdd(52,1);
            $b .= '<br><img src="/img/world/items/little/52.png" class="item"> Протектор (1 шт.)';
          }elseif($rand4 == 2) {
            itemAdd(51,1);
            $b .= '<br><img src="/img/world/items/little/51.png" class="item"> Магмарайзер (1 шт.)';
          }else{
            itemAdd(53,1);
            $b .= '<br><img src="/img/world/items/little/53.png" class="item"> Электрайзер (1 шт.)';
          }
          $rand2 = mt_rand(1,3);
          if($rand2 == 1) {
            itemAdd(20,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Солнечный камень (1 шт.)';
          }elseif($rand2 == 2){
            itemAdd(36,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сияющий камень (1 шт.)';
          }else{
            itemAdd(19,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сумрачный камень (1 шт.)';
          }
          $b .= '<br><img src="/img/world/items/little/95.png" class="item"> Набор классификаций (2 шт.)<br><img src="/img/world/items/little/72.png" class="item"> Чешуя дракона (1 шт.)';
          itemAdd(95,2);
          itemAdd(72,1);
          $rand1 = mt_rand(1,3);
          $rand3 = mt_rand(1,3);
          if($rand1 == 1) {
            plusEgg(false,false,101,false,false,543,true);
          }elseif($rand1 == 2){
            plusEgg(false,false,101,false,false,590,true);
          }else{
            plusEgg(false,false,101,false,false,602,true);
          }
          itemAdd(1065,1);
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)<br><img src="/img/world/items/little/1065.png" class="item"> Тренировочная машина (1 шт.)';
          if($rand3 == 1) {
            itemAdd(21,1);
            $b .= '<br><img src="/img/world/items/little/21.png" class="item"> Рассветный камень (1 шт.)';
          }elseif($rand3 == 2){
            itemAdd(96,1);
            $b .= '<br><img src="/img/world/items/little/96.png" class="item"> Овальный камень (1 шт.)';
          }else{
            itemAdd(65,1);
            $b .= '<br><img src="/img/world/items/little/65.png" class="item"> Острый коготь (1 шт.)';
          }
        }elseif($a >= 16 && $a <= 20) {
          $rand4 = mt_rand(1,3);
          itemAdd(109,5);
          $b .= '<br><img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
          $rand = mt_rand(1,3);
          if($rand == 1){
            itemAdd(104,1);
            $b .= '<br><img src="/img/world/items/little/104.png" class="item"> Лупа (1 шт.)';
          }elseif($rand == 2) {
            itemAdd(103,1);
            $b .= '<br><img src="/img/world/items/little/103.png" class="item"> Блестки (1 шт.)';
          }else{
            itemAdd(105,1);
            $b .= '<br><img src="/img/world/items/little/105.png" class="item"> Линзы (1 шт.)';
          }
          if($rand4 == 1){
            itemAdd(52,1);
            $b .= '<br><img src="/img/world/items/little/52.png" class="item"> Протектор (1 шт.)';
          }elseif($rand4 == 2) {
            itemAdd(51,1);
            $b .= '<br><img src="/img/world/items/little/51.png" class="item"> Магмарайзер (1 шт.)';
          }else{
            itemAdd(53,1);
            $b .= '<br><img src="/img/world/items/little/53.png" class="item"> Электрайзер (1 шт.)';
          }
          $rand2 = mt_rand(1,3);
          if($rand2 == 1) {
            itemAdd(20,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Солнечный камень (1 шт.)';
          }elseif($rand2 == 2){
            itemAdd(36,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сияющий камень (1 шт.)';
          }else{
            itemAdd(19,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сумрачный камень (1 шт.)';
          }
          $b .= '<br><img src="/img/world/items/little/95.png" class="item"> Набор классификаций (2 шт.)<br><img src="/img/world/items/little/72.png" class="item"> Чешуя дракона (1 шт.)';
          itemAdd(95,2);
          itemAdd(72,1);
          $rand1 = mt_rand(1,3);
          $rand3 = mt_rand(1,3);
          if($rand1 == 1) {
            plusEgg(false,false,101,false,false,543,true);
          }elseif($rand1 == 2){
            plusEgg(false,false,101,false,false,590,true);
          }else{
            plusEgg(false,false,101,false,false,602,true);
          }
          itemAdd(1065,1);
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)<br><img src="/img/world/items/little/1065.png" class="item"> Тренировочная машина (1 шт.)';
          if($rand3 == 1) {
            itemAdd(21,1);
            $b .= '<br><img src="/img/world/items/little/21.png" class="item"> Рассветный камень (1 шт.)';
          }elseif($rand3 == 2){
            itemAdd(96,1);
            $b .= '<br><img src="/img/world/items/little/96.png" class="item"> Овальный камень (1 шт.)';
          }else{
            itemAdd(65,1);
            $b .= '<br><img src="/img/world/items/little/65.png" class="item"> Острый коготь (1 шт.)';
          }
          $rand6 = mt_rand(1,3);
          $rand7 = mt_rand(1,2);
          if($rand6 == 1) {
            plusEgg(false,false,101,false,false,140,true);
          }elseif($rand6 == 2){
            plusEgg(false,false,101,false,false,562,true);
          }else{
            plusEgg(false,false,101,false,false,686,true);
          }
          itemAdd(1080,1);
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)<br><img src="/img/world/items/little/1080.png" class="item"> Тренировочная машина (1 шт.)';
          if($rand7 == 1) {
            itemAdd(66,1);
            $b .= '<br><img src="/img/world/items/little/66.png" class="item"> Острый клык (1 шт.)';
          }else{
            itemAdd(23,1);
            $b .= '<br><img src="/img/world/items/little/23.png" class="item"> Перламутровая чешуя (1 шт.)';
          }
        }elseif($a >= 21 && $a <= 30) {
          $rand4 = mt_rand(1,3);
          itemAdd(109,5);
          $b .= '<br><img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
          $rand = mt_rand(1,3);
          if($rand == 1){
            itemAdd(104,1);
            $b .= '<br><img src="/img/world/items/little/104.png" class="item"> Лупа (1 шт.)';
          }elseif($rand == 2) {
            itemAdd(103,1);
            $b .= '<br><img src="/img/world/items/little/103.png" class="item"> Блестки (1 шт.)';
          }else{
            itemAdd(105,1);
            $b .= '<br><img src="/img/world/items/little/105.png" class="item"> Линзы (1 шт.)';
          }
          if($rand4 == 1){
            itemAdd(52,1);
            $b .= '<br><img src="/img/world/items/little/52.png" class="item"> Протектор (1 шт.)';
          }elseif($rand4 == 2) {
            itemAdd(51,1);
            $b .= '<br><img src="/img/world/items/little/51.png" class="item"> Магмарайзер (1 шт.)';
          }else{
            itemAdd(53,1);
            $b .= '<br><img src="/img/world/items/little/53.png" class="item"> Электрайзер (1 шт.)';
          }
          $rand2 = mt_rand(1,3);
          if($rand2 == 1) {
            itemAdd(20,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Солнечный камень (1 шт.)';
          }elseif($rand2 == 2){
            itemAdd(36,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сияющий камень (1 шт.)';
          }else{
            itemAdd(19,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сумрачный камень (1 шт.)';
          }
          $b .= '<br><img src="/img/world/items/little/95.png" class="item"> Набор классификаций (2 шт.)<br><img src="/img/world/items/little/72.png" class="item"> Чешуя дракона (1 шт.)';
          itemAdd(95,2);
          itemAdd(72,1);
          $rand1 = mt_rand(1,3);
          $rand3 = mt_rand(1,3);
          if($rand1 == 1) {
            plusEgg(false,false,101,false,false,543,true);
          }elseif($rand1 == 2){
            plusEgg(false,false,101,false,false,590,true);
          }else{
            plusEgg(false,false,101,false,false,602,true);
          }
          itemAdd(1065,1);
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)<br><img src="/img/world/items/little/1065.png" class="item"> Тренировочная машина (1 шт.)';
          if($rand3 == 1) {
            itemAdd(21,1);
            $b .= '<br><img src="/img/world/items/little/21.png" class="item"> Рассветный камень (1 шт.)';
          }elseif($rand3 == 2){
            itemAdd(96,1);
            $b .= '<br><img src="/img/world/items/little/96.png" class="item"> Овальный камень (1 шт.)';
          }else{
            itemAdd(65,1);
            $b .= '<br><img src="/img/world/items/little/65.png" class="item"> Острый коготь (1 шт.)';
          }
          $rand6 = mt_rand(1,3);
          $rand7 = mt_rand(1,2);
          if($rand6 == 1) {
            plusEgg(false,false,101,false,false,140,true);
          }elseif($rand6 == 2){
            plusEgg(false,false,101,false,false,562,true);
          }else{
            plusEgg(false,false,101,false,false,686,true);
          }
          itemAdd(1080,1);
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)<br><img src="/img/world/items/little/1080.png" class="item"> Тренировочная машина (1 шт.)';
          if($rand7 == 1) {
            itemAdd(66,1);
            $b .= '<br><img src="/img/world/items/little/66.png" class="item"> Острый клык (1 шт.)';
          }else{
            itemAdd(23,1);
            $b .= '<br><img src="/img/world/items/little/23.png" class="item"> Перламутровая чешуя (1 шт.)';
          }
          $rand8 = mt_rand(1,3);
          $rand9 = mt_rand(1,3);
          if($rand8 == 1) {
            plusEgg(false,false,101,false,false,714,true);
          }elseif($rand8 == 2){
            plusEgg(false,false,101,false,false,622,true);
          }else{
            plusEgg(false,false,101,false,false,451,true);
          }
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
          if($rand9 == 1) {
            itemAdd(1081,1);
            $b .= '<br><img src="/img/world/items/little/1081.png" class="item"> Тренировочная машина (1 шт.)';
          }elseif($rand9 == 2){
            itemAdd(1031,1);
            $b .= '<br><img src="/img/world/items/little/1031.png" class="item"> Тренировочная машина (1 шт.)';
          }else{
            itemAdd(1003,1);
            $b .= '<br><img src="/img/world/items/little/1003.png" class="item"> Тренировочная машина (1 шт.)';
          }
        }elseif($a >= 31 && $a <= 2000) {
          $rand4 = mt_rand(1,3);
          itemAdd(109,5);
          $b .= '<br><img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
          $rand = mt_rand(1,3);
          if($rand == 1){
            itemAdd(104,1);
            $b .= '<br><img src="/img/world/items/little/104.png" class="item"> Лупа (1 шт.)';
          }elseif($rand == 2) {
            itemAdd(103,1);
            $b .= '<br><img src="/img/world/items/little/103.png" class="item"> Блестки (1 шт.)';
          }else{
            itemAdd(105,1);
            $b .= '<br><img src="/img/world/items/little/105.png" class="item"> Линзы (1 шт.)';
          }
          if($rand4 == 1){
            itemAdd(52,1);
            $b .= '<br><img src="/img/world/items/little/52.png" class="item"> Протектор (1 шт.)';
          }elseif($rand4 == 2) {
            itemAdd(51,1);
            $b .= '<br><img src="/img/world/items/little/51.png" class="item"> Магмарайзер (1 шт.)';
          }else{
            itemAdd(53,1);
            $b .= '<br><img src="/img/world/items/little/53.png" class="item"> Электрайзер (1 шт.)';
          }
          $rand2 = mt_rand(1,3);
          if($rand2 == 1) {
            itemAdd(20,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Солнечный камень (1 шт.)';
          }elseif($rand2 == 2){
            itemAdd(36,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сияющий камень (1 шт.)';
          }else{
            itemAdd(19,1);
            $b .= '<br><img src="/img/world/items/little/20.png" class="item"> Сумрачный камень (1 шт.)';
          }
          $b .= '<br><img src="/img/world/items/little/95.png" class="item"> Набор классификаций (2 шт.)<br><img src="/img/world/items/little/72.png" class="item"> Чешуя дракона (1 шт.)';
          itemAdd(95,2);
          itemAdd(72,1);
          $rand1 = mt_rand(1,3);
          $rand3 = mt_rand(1,3);
          if($rand1 == 1) {
            plusEgg(false,false,101,false,false,543,true);
          }elseif($rand1 == 2){
            plusEgg(false,false,101,false,false,590,true);
          }else{
            plusEgg(false,false,101,false,false,602,true);
          }
          itemAdd(1065,1);
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)<br><img src="/img/world/items/little/1065.png" class="item"> Тренировочная машина (1 шт.)';
          if($rand3 == 1) {
            itemAdd(21,1);
            $b .= '<br><img src="/img/world/items/little/21.png" class="item"> Рассветный камень (1 шт.)';
          }elseif($rand3 == 2){
            itemAdd(96,1);
            $b .= '<br><img src="/img/world/items/little/96.png" class="item"> Овальный камень (1 шт.)';
          }else{
            itemAdd(65,1);
            $b .= '<br><img src="/img/world/items/little/65.png" class="item"> Острый коготь (1 шт.)';
          }
          $rand6 = mt_rand(1,3);
          $rand7 = mt_rand(1,2);
          if($rand6 == 1) {
            plusEgg(false,false,101,false,false,140,true);
          }elseif($rand6 == 2){
            plusEgg(false,false,101,false,false,562,true);
          }else{
            plusEgg(false,false,101,false,false,686,true);
          }
          itemAdd(1080,1);
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)<br><img src="/img/world/items/little/1080.png" class="item"> Тренировочная машина (1 шт.)';
          if($rand7 == 1) {
            itemAdd(66,1);
            $b .= '<br><img src="/img/world/items/little/66.png" class="item"> Острый клык (1 шт.)';
          }else{
            itemAdd(23,1);
            $b .= '<br><img src="/img/world/items/little/23.png" class="item"> Перламутровая чешуя (1 шт.)';
          }
          $rand8 = mt_rand(1,3);
          $rand9 = mt_rand(1,3);
          if($rand8 == 1) {
            plusEgg(false,false,101,false,false,714,true);
          }elseif($rand8 == 2){
            plusEgg(false,false,101,false,false,622,true);
          }else{
            plusEgg(false,false,101,false,false,451,true);
          }
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
          if($rand9 == 1) {
            itemAdd(1081,1);
            $b .= '<br><img src="/img/world/items/little/1081.png" class="item"> Тренировочная машина (1 шт.)';
          }elseif($rand9 == 2){
            itemAdd(1031,1);
            $b .= '<br><img src="/img/world/items/little/1031.png" class="item"> Тренировочная машина (1 шт.)';
          }else{
            itemAdd(1003,1);
            $b .= '<br><img src="/img/world/items/little/1003.png" class="item"> Тренировочная машина (1 шт.)';
          }
          $rand10 = mt_rand(1,3);
          if($rand10 == 1) {
            plusEgg(false,false,101,false,false,704,true);
          }elseif($rand10 == 2){
            plusEgg(false,false,101,false,false,610,true);
          }else{
            plusEgg(false,false,101,false,false,529,true);
          }
          $b .= '<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
        }
        $response['actionQuestPlus'] = $b;
      }
      $mysqli->query("UPDATE users SET coins = 10000 WHERE id =  ".$_SESSION['id']);
    }else{
      $response['question'] = 'Вы уже получили подарок.';
    }
  break;
  default:
     $response['question'] = 'Возле колодца стоит табличка, на которой написано:<br>
     <b>Здравствуй, путник. Этот магический колодец может дать тебе различные предметы, нужно лишь пожелать, ну и... дать взамен ему Символы League-18.</b><br>
     За <b>5 Символов League-18</b> колодец может вам выдать случайный предмет из списка:<br>
     - Случайный стабовый усилитель (1 шт.)<br>
     - Случайное пирожное (3 шт.)<br>
     - Случайная банка витаминов (3 шт.)<br>
     - Потертый диск<br>
     - Усовершенствованный диск<br>
     - Случайная TM атака из списка: TM 70 - Водопад, TM 91 - Лучевая пушка, TM 02 - Коготь дракона.<br>
     - Случайное яйцо покемона из списка: <span class="bgPok" onclick="openDex(447)"><img src="/img/pokemons/anim/normal/447.gif"> #447 Риолу</span>,
     <span class="bgPok" onclick="openDex(328)"><img src="/img/pokemons/anim/normal/328.gif"> #328 Трапинч</span>,
     <span class="bgPok" onclick="openDex(123)"><img src="/img/pokemons/anim/normal/123.gif"> #123 Сайтер</span>,
     <span class="bgPok" onclick="openDex(127)"><img src="/img/pokemons/anim/normal/127.gif"> #127 Пинсир</span>,
     <span class="bgPok" onclick="openDex(669)"><img src="/img/pokemons/anim/normal/669.gif"> #669 Флабэбэ</span>,
     <span class="bgPok" onclick="openDex(133)"><img src="/img/pokemons/anim/normal/133.gif"> #133 Иви</span><br>
     Покемоны после вылупления спарены, гены 25-30, с окрасом birthday.
     <br>
     <b>Также 28.10.2018г. колодец желаний будет выдавать подарки всем тренерам, которые сдали хотя бы один Символ League-18. Не забудьте забрать свой подарок!</b><br>
     Вы сдали Символов League-18: '.$user['coins'].' шт.
     ';
    $response['question'] = '<i>~Из колодца доносятся непонятные звуки~</i>';
     $response['answer'] = array(
        2 => "Получить награду"
     );
  break;
}
