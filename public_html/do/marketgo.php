<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$patch_func = $patch_project.'/inc/function/Functions.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
		require_once($patch_func);
    }
}

$type = $_POST["type"];
$id = clearInt($_POST["id"]);
$val = $_POST["val"];
$lot = $mysqli->query("SELECT * FROM `lombard` WHERE `id` = ".$id)->fetch_assoc();
$userI = $mysqli->query("SELECT `status`,`user_group` FROM `users` WHERE `id` = ".$_SESSION['id'])->fetch_assoc();
$month = array(1=>'Января',2=>'Февраля',3=>'Марта',4=>'Апреля',5=>'Мая',6=>'Июня',7=>'Июля',8=>'Августа',9=>'Сентября',10=>'Октября',11=>'Ноября',12=>'Декабря');
$dayToday = date("d");
$monthToday = $month[date("n")];
$YearToday = date("Y");
$dateUved = $dayToday.' '.$monthToday.' '.$YearToday.'г. в '.date("H").':'.date("i");
if($userI['status'] == 'free' && $userI['user_group'] != 7) {
  switch ($type) {
    case 'buynow':
      if(isset($lot)) {
        if($lot['priceBuy'] > 0) {
          if(item_isset(1,$lot['priceBuy'])) {
            $mysqli->query('INSERT INTO `log_lombard`
            (`id_lot`,`category`,`name`,`count`,`priceStart`,`priceStep`,`priceNow`,`priceBuy`,`dateAdd`,`dateEnd`,`userID`,`userBuy`,`productID`,`kup`)
            VALUES
            (
              '.$lot['id'].',
              "'.$lot['category'].'",
              "'.$lot['name'].'",
              '.$lot['count'].',
              '.$lot['priceStart'].',
              '.$lot['priceStep'].',
              '.$lot['priceNow'].',
              '.$lot['priceBuy'].',
              '.$lot['dateAdd'].',
              '.$lot['dateEnd'].',
              '.$lot['userID'].',
              '.$_SESSION['id'].',
              '.$lot['productID'].',
              1
            )
            ');
            if($lot['category'] == 'item') {
              if(isset($lot['userBuy'])) {
                $textBuy = "<div class=u-1>Администрация League 18</div> прислала вам уведомление: <b>ваша ставка по лоту №".$lot['id']." была перебита. Лот выкуплен.</b>";
                $mysqli->query("INSERT INTO `notification` (`text`,`user`,`img`,`date`) VALUES ('".$textBuy."','".$lot['userBuy']."','/img/logo.png','".$dateUved."') ");
                itemAdd(1,$lot['priceNow'],$lot['userBuy']);
              }
              if(!empty($lot['str'])) {
                $mysqli->query("INSERT INTO `items_users` (`user`,`item_id`,`count`,`str`) VALUES ('".$_SESSION['id']."','".$lot['productID']."',1,'".$lot['str']."') ");
              }else{
                itemAdd($lot['productID'],$lot['count']);
              }
              itemAdd(1,$lot['priceBuy'],$lot['userID']);
              minus_item(1,$lot['priceBuy']);
              $response['error'] = 0;
              $response['text'] = 'Предмет удачно выкуплен.';
              $response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета ('.$lot['priceBuy'].' шт.)';
              $response['plus'] = '<img src="/img/world/items/little/'.$lot['productID'].'.png" class="item"> '.$lot['name'].' ('.$lot['count'].' шт.)';
              $mysqli->query("DELETE FROM `lombard` WHERE `id` = '".$id."'");
            }elseif($lot['category'] == 'pok'){
              if(isset($lot['userBuy'])) {
                $textBuy = "<div class=u-1>Администрация League 18</div> прислала вам уведомление: <b>ваша ставка по лоту №".$lot['id']." была перебита. Лот выкуплен.</b>";
                $mysqli->query("INSERT INTO `notification` (`text`,`user`,`img`,`date`) VALUES ('".$textBuy."','".$lot['userBuy']."','/img/logo.png','".$dateUved."') ");
                itemAdd(1,$lot['priceNow'],$lot['userBuy']);
              }
              $pok = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `id` = ".$lot['productID'])->fetch_assoc();
              itemAdd(1,$lot['priceBuy'],$lot['userID']);
              $response['error'] = 0;
              $response['text'] = 'Покемон удачно выкуплен.';
              $mysqli->query("DELETE FROM `lombard` WHERE `id` = '".$id."'");
              $mysqli->query("UPDATE `user_pokemons` SET `user_id` = '".$_SESSION['id']."', `active` = 0 WHERE `id` = '".$lot['productID']."'");
              minus_item(1,$lot['priceBuy']);
              $response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета ('.$lot['priceBuy'].' шт.)';
              $response['plus'] = '<img src="/img/pokemons/anim/normal/'.$pok['basenum'].'.gif"> '.$lot['name'].'';
            }else{
              if(isset($lot['userBuy'])) {
                $textBuy = "<div class=u-1>Администрация League 18</div> прислала вам уведомление: <b>ваша ставка по лоту №".$lot['id']." была перебита. Лот выкуплен.</b>";
                $mysqli->query("INSERT INTO `notification` (`text`,`user`,`img`,`date`) VALUES ('".$textBuy."','".$lot['userBuy']."','/img/logo.png','".$dateUved."') ");
                itemAdd(1,$lot['priceNow'],$lot['userBuy']);
              }
              itemAdd(1,$lot['priceBuy'],$lot['userID']);
              $response['error'] = 0;
              $response['text'] = 'Яйцо удачно выкуплено.';
              $mysqli->query("DELETE FROM `lombard` WHERE `id` = '".$id."'");
              $mysqli->query("UPDATE `user_egg` SET `user` = '".$_SESSION['id']."' WHERE `id` = '".$lot['productID']."'");
              minus_item(1,$lot['priceBuy']);
              $response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета ('.$lot['priceBuy'].' шт.)';
              $response['plus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
            }
          }else{
            $response['error'] = 1;
            $response['text'] = 'Недостаточно монет.';
          }
        }else{
          $response['error'] = 1;
          $response['text'] = 'Данный лот нельзя выкупить.';
        }
      }else{
        $response['error'] = 1;
        $response['text'] = 'Лот уже выкуплен.';
      }
    break;
    case 'stavka_go':
      if(isset($lot)) {
        $val = clearInt($_POST["val"]);
        if($val >= $lot['priceStep']) {
          if(item_isset(1,$val)) {
            if($lot['priceNow'] < $val && $lot['priceStart'] <= $val) {
              minus_item(1,$val);
              if(isset($lot['userBuy'])) {
                $textBuy = "<div class=u-1>Администрация League 18</div> прислала вам уведомление: <b>ваша ставка по лоту №".$lot['id']." была перебита.</b>";
                $mysqli->query("INSERT INTO `notification` (`text`,`user`,`img`,`date`) VALUES ('".$textBuy."','".$lot['userBuy']."','/img/logo.png','".$dateUved."') ");
                itemAdd(1,$lot['priceNow'],$lot['userBuy']);
              }
              $mysqli->query("UPDATE `lombard` SET `userBuy` = '".$_SESSION['id']."', `priceNow` = '".$val."' WHERE `id` = '".$id."'");
              $response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета ('.$val.' шт.)';
              $response['error'] = 0;
              $response['text'] = 'Вы удачно перебили ставку.';
            }else{
              $response['error'] = 1;
              $response['text'] = 'Ваша ставка ниже, чем та, которая есть на данный момент у лота.';
            }
          }else{
            $response['error'] = 1;
            $response['text'] = 'Недостаточно монет.';
          }
        }else{
          $response['error'] = 1;
          $response['text'] = 'Вы ввели недостаточную цену для шага.';
        }
      }else{
        $response['error'] = 1;
        $response['text'] = 'Лот уже выкуплен.';
      }
    break;
    case 'stavka_item_go':
      $zn = explode(',',$val);
      if(isset($zn[0]) && isset($zn[1]) && isset($zn[2]) && isset($zn[3]) && isset($zn[4])) {
        $zn[0] = clearInt($zn[0]);
        $zn[1] = clearInt($zn[1]);
        $zn[2] = clearInt($zn[2]);
        $zn[3] = clearInt($zn[3]);
        $zn[4] = clearInt($zn[4]);
        if(item_isset(1,10000)) {
          $item_isset = $mysqli->query("SELECT * FROM `items_users` WHERE `id` = ".$id)->fetch_assoc();
          if($zn[1] > 0) {
            if(item_isset($item_isset['item_id'],$zn[1])) {
              if($zn[0] <= $zn[3] || $zn[3] == 0) {
                $item = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = ".$item_isset['item_id'])->fetch_assoc();
                if($item['trade'] == true) {
                  if($zn[4] <= 0 && $zn[4] >= 30) {
                    $zn[4] = time() + 604800;
                  }else{
                    $zn[4] = time() + ($zn[4]*24*60*60);
                  }
                  $mysqli->query("INSERT INTO `lombard`
                                  (`category`,`name`,`count`,`priceStart`,`priceStep`,`priceNow`,`priceBuy`,`dateAdd`,`dateEnd`,`userID`,`productID`,`str`)
                                  VALUES
                                  ('item','".$item['name']."','".$zn[1]."','".$zn[0]."','".$zn['2']."','0','".$zn[3]."','".time()."','".$zn[4]."','".$_SESSION['id']."','".$item_isset['item_id']."','".$item_isset['str']."') ");
                  minus_item(1,10000);
                  minus_item_id($id,$zn[1]);
                  $response['error'] = 0;
                  $response['text'] = 'Вы удачно выставили лот.';
                  $response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (10000 шт.)<br><img src="/img/world/items/little/'.$item_isset['item_id'].'.png" class="item"> '.$item['name'].' ('.$zn[1].' шт.)';
                }else{
                  $response['error'] = 1;
                  $response['text'] = 'Данный предмет нельзя выставить на аукцион.';
                }
              }else{
                $response['error'] = 1;
                $response['text'] = 'Выкуп должен привышать начальную цену.';
              }
            }else{
              $response['error'] = 1;
              $response['text'] = 'Не хватает предметов.';
            }
          }else{
            $response['error'] = 1;
            $response['text'] = 'Количество предметов не должно равняться нулю.';
          }
        }else{
          $response['error'] = 1;
          $response['text'] = 'Недостаточно монет для размещения лота.';
        }
      }else{
        $response['error'] = 1;
        $response['text'] = 'Неправильно введены значения.';
      }
    break;
    case 'stavka_egg_go':
      $zn = explode(',',$val);
      if(isset($zn[0]) && isset($zn[1]) && isset($zn[2]) && isset($zn[3])) {
        $zn[0] = clearInt($zn[0]);
        $zn[1] = clearInt($zn[1]);
        $zn[2] = clearInt($zn[2]);
        $zn[3] = clearInt($zn[3]);
        if(item_isset(1,10000)) {
            if($zn[0] <= $zn[2] || $zn[2] == 0) {
              $egg = $mysqli->query("SELECT * FROM `user_egg` WHERE `id` = ".$id)->fetch_assoc();
              $pok = $mysqli->query("SELECT `name_rus` FROM `base_pokemons` WHERE `id` = ".$egg['basenum'])->fetch_assoc();
              if($egg['user'] == $_SESSION['id']) {
                  $mysqli->query("UPDATE `user_egg` SET `user` = 2 WHERE `id` = '".$id."'");
                  if($zn[3] <= 0 && $zn[3] >= 30) {
                    $zn[3] = time() + 604800;
                  }else{
                    $zn[3] = time() + ($zn[3]*24*60*60);
                  }
                  $gens = explode(',',$egg['gens']);
                  $gen = 'h'.$gens['0'].'a'.$gens['1'].'d'.$gens['2'].'s'.$gens['3'].'sa'.$gens['4'].'sd'.$gens['5'];
                  $mysqli->query("INSERT INTO `lombard`
                                  (`category`,`name`,`count`,`priceStart`,`priceStep`,`priceNow`,`priceBuy`,`dateAdd`,`dateEnd`,`userID`,`productID`)
                                  VALUES
                                  ('egg','Яйцо ".$pok['name_rus'].". Генокод: ".$gen."','0','".$zn[0]."','".$zn[1]."','0','".$zn[2]."','".time()."','".$zn[3]."','".$_SESSION['id']."','".$id."') ");
                  minus_item(1,10000);
                  $response['error'] = 0;
                  $response['text'] = 'Вы удачно выставили лот.';
                  $response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (10000 шт.)<br><img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
              }else{
                $response['error'] = 1;
                $response['text'] = 'Яйцо принадлежит не вам.';
              }
            }else{
              $response['error'] = 1;
              $response['text'] = 'Выкуп должен привышать начальную цену.';
            }
        }else{
          $response['error'] = 1;
          $response['text'] = 'Недостаточно монет для размещения лота.';
        }
      }else{
        $response['error'] = 1;
        $response['text'] = 'Неправильно введены значения.';
      }
    break;
    case 'stavka_pokemon_go':
      $zn = explode(',',$val);
      if(isset($zn[0]) && isset($zn[1]) && isset($zn[2]) && isset($zn[3])) {
        $zn[0] = clearInt($zn[0]);
        $zn[1] = clearInt($zn[1]);
        $zn[2] = clearInt($zn[2]);
        $zn[3] = clearInt($zn[3]);
        if(item_isset(1,10000)) {
            if($zn[0] <= $zn[2] || $zn[2] == 0) {
              $pok = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `id` = ".$id." AND `user_id` = ".$_SESSION['id']." AND `trade` = 'true' AND `active` = 1")->fetch_assoc();
              if(isset($pok)) {
                  $pok2 = $mysqli->query("SELECT `id` FROM `user_pokemons` WHERE `active` = 1 AND `user_id` = ".$_SESSION['id']);
                  if($pok2->num_rows > 1) {
                    $mysqli->query("UPDATE `user_pokemons` SET `user_id` = 2 WHERE `id` = '".$id."'");
                    $pok_base = $mysqli->query("SELECT `name_rus` FROM `base_pokemons` WHERE `id` = ".$pok['basenum'])->fetch_assoc();
                    if($zn[3] <= 0 && $zn[3] >= 30) {
                      $zn[3] = time() + 604800;
                    }else{
                      $zn[3] = time() + ($zn[3]*24*60*60);
                    }
                    $mysqli->query("INSERT INTO `lombard`
                                    (`category`,`name`,`count`,`priceStart`,`priceStep`,`priceNow`,`priceBuy`,`dateAdd`,`dateEnd`,`userID`,`productID`)
                                    VALUES
                                    ('pok','#".numCheck($id)." ".$pok_base['name_rus']." ".$pok['lvl']." ур.','0','".$zn[0]."','".$zn[1]."','0','".$zn[2]."','".time()."','".$zn[3]."','".$_SESSION['id']."','".$id."') ");
                    minus_item(1,10000);
                    $response['error'] = 0;
                    $response['text'] = 'Вы удачно выставили лот.';
                    $response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (10000 шт.)<br><img src="/img/pokemons/anim/normal/'.$pok['basenum'].'.gif"> #'.numCheck($id).' '.$pok_base['name_rus'].'';
                  }else{
                    $response['error'] = 1;
                    $response['text'] = 'У вас должен остаться хотя бы один покемон в команде.';
                  }
              }else{
                $response['error'] = 1;
                $response['text'] = 'Ошибка в выборе покемона. Возможно, он непередаваемый.';
              }
            }else{
              $response['error'] = 1;
              $response['text'] = 'Выкуп должен привышать начальную цену.';
            }
        }else{
          $response['error'] = 1;
          $response['text'] = 'Недостаточно монет для размещения лота.';
        }
      }else{
        $response['error'] = 1;
        $response['text'] = 'Неправильно введены значения.';
      }
    break;
    default:
      $response['error'] = 1;
      $response['text'] = 'Ошибка.';
    break;
  }
}else{
  $response['error'] = 1;
  $response['text'] = 'Невозможно выставить лот, так как, возможно, вы в бою или, например, ведете с кем-нибудь обмен.';
}
echo json_encode($response);
