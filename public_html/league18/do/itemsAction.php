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
$count = clearInt($_POST['count']);
$itemID = clearInt($_POST['itemID']);
$pokID = clearInt($_POST['pokID']);
$checkAction = $mysqli->query("SELECT `dress`,`drop`,`type`,`info` FROM `base_items` WHERE `id` = '".$itemID."'")->fetch_assoc();
$userStatus = $mysqli->query("SELECT `status`,`location` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
$npcLoc = $mysqli->query("SELECT * FROM `base_npc` WHERE `loc_id` = '".$userStatus['location']."'");
if($userStatus['status'] != 'free'){
	$response['error'] = 1;
	die(json_encode($response));
}
switch ($type) {
		case 'drop':
    // $p = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `startGame` = 1");
    // while($pok = $p->fetch_assoc()){
    //   $v = $pok['ev'] + $pok['vitamines'];
    //   Work::$sql->query('UPDATE `user_pokemons` SET `ev` = "'.$v.'" WHERE `id` = '.$pok['id']);
    // }
      //  $p = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `startGame` = 1");
      //  while($pok = $p->fetch_assoc()){
      //    $ev = $pok['lvl'] * 3;
      //   $ev1 = $ev - 15;
      //    if($ev1 <= 0) {
      //      $ev1 = 0;
      //    }else{
      //      $ev1 = $ev - 15;
      //    }
      //    Work::$sql->query('UPDATE `user_pokemons` SET `evcounts` = "0,0,0,0,0,0", `ev` = "'.$ev1.'" WHERE `id` = '.$pok['id']);
      //  }
      $my = $mysqli->query("SELECT * FROM `items_users` WHERE `id` = ".$itemID)->fetch_assoc();
      $i = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = ".$my['item_id'])->fetch_assoc();
			if(item_isset($my['item_id'],$count) && $i['drop'] != 'false'){
				minus_item_id($itemID,$count);
				$response['error'] = 0;
				$response['text'] = 'Предмет успешно выброшен!';
        $response['minus'] = '<img src="/img/world/items/little/'.$i['id'].'.png" class="item"> '.$i['name'].' ('.$count.' шт.)';
			}else{
        $response['text'] = 'Недостаточно предметов.';
				$response['error'] = 1;
			}
		break;
    case 'dropEgg':
			$egg = $mysqli->query("SELECT * FROM `user_egg` WHERE `id` = '".$itemID."' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
			if($egg){
        $response['minus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
				$response['error'] = 0;
				$response['text'] = 'Вы выкинули яйцо покемона.';
				Work::$sql->query("DELETE FROM `user_egg` WHERE `id` = '".$itemID."' AND `user` = '".$_SESSION['id']."'");
			}
		break;
    case 'incubEgg':
			$egg = $mysqli->query("SELECT * FROM `user_egg` WHERE `id` = '".$itemID."' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
			if($egg){
        if(item_isset(275,1)) {
          minus_item(275,1);
          $reborn = floor(($egg['reborn'] - time())/2);
          $newReborn = time() + $reborn;
          $response['minus'] = '<img src="/img/world/items/little/275.png" class="item"> Инкубатор (1 шт.)';
  				$response['error'] = 0;
  				$response['text'] = 'Срок вылупления яйца уменьшен в два раза.';
  				Work::$sql->query('UPDATE `user_egg` SET `reborn` = '.$newReborn.' WHERE `id` = '.$egg['id']);
        }else{
          $response['error'] = 1;
  				$response['text'] = 'У вас нет инкубатора.';
        }
			}
		break;
		case 'buyDonat':
			$thing = $mysqli->query("SELECT * FROM aquarits WHERE id = ".$itemID)->fetch_assoc();
      $thing1 = $mysqli->query("SELECT name FROM base_items WHERE id = ".$thing['item'])->fetch_assoc();
			if(item_isset(43,$thing['price'])){
				minus_item(43,$thing['price']);
				itemAdd($thing['item'],1);
				Info::_logGame($_SESSION['id'], 'BUY_DONAT', ['itemID'=>$itemID], 'items');
        $response['plus'] = '<img src="/img/world/items/little/'.$thing['item'].'.png" class="item"> '.$thing1['name'].' (1 шт.)';
        $response['minus'] = '<img src="/img/world/items/little/43.png" class="item"> Жемчуг ('.$thing['price'].' шт.)';
				$response['error'] = 0;
			}else{
				$response['error'] = 1;
			}
		break;
		case 'DressPok':
      $my = $mysqli->query("SELECT * FROM `items_users` WHERE `id` = ".$itemID)->fetch_assoc();
      $i = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = ".$my['item_id'])->fetch_assoc();
      if(item_isset($my['item_id'],$count) && $i['dress'] != 'false'){
        $pokemon = $mysqli->query("SELECT `item_id`,`item_str` FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
        if($pokemon['item_id'] != 0){
          if(empty($pokemon['item_str'])) {
            itemAdd($pokemon['item_id'],1);
          }else{
            $mysqli->query("INSERT INTO `items_users` (`user`,`item_id`,`count`,`str`) VALUES ('".$_SESSION['id']."','".$pokemon['item_id']."',1,'".$pokemon['item_str']."') ");
          }
				}
        if(!empty($my['str'])) {
          $str = explode(',',$my['str']);
          if($str[0] <= 0) {
            $response['error'] = 1;
            $response['text'] = 'Невозможно выполнить это действие. Предмет сломан.';
          }else{
            $i = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = ".$my['item_id'])->fetch_assoc();
    				$mysqli->query("UPDATE `user_pokemons` SET `item_id` = '".$my['item_id']."', `item_str` = '".$my['str']."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
            $response['minus'] = '<img src="/img/world/items/little/'.$i['id'].'.png" class="item"> '.$i['name'].' (1 шт.)';
            $response['error'] = 0;
    				$response['text'] = 'Предмет успешно надет!';
    				
            minus_item_id($itemID,1);
            minus_item(107,1); 
          }
        }else{
          $i = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = ".$my['item_id'])->fetch_assoc();
  				$mysqli->query("UPDATE `user_pokemons` SET `item_id` = '".$my['item_id']."', `item_str` = '".$my['str']."' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
          $response['minus'] = '<img src="/img/world/items/little/'.$i['id'].'.png" class="item"> '.$i['name'].' (1 шт.)';
          $response['error'] = 0;
  				$response['text'] = 'Предмет успешно надет!';
          minus_item_id($itemID,1);
        }
			}else{
				$response['error'] = 1;
			}
		break;
		case 'GivePok':
			if(item_isset($itemID,$count)){
				require_once($patch_project.'/inc/function/Items.php');
        if($itemID == 278)anti_trenya($pokID);#Зелье сброса трени
        if($itemID == 326)hell_happy($pokID);#Хэлл конфета
        if($itemID == 325)hell_okras($pokID);#Хэлл окрас
        if($itemID == 279)zel_apr($pokID);#Зелье априкорна
        if($itemID == 257 || $itemID == 258 || $itemID == 259 || $itemID == 260 || $itemID == 261 || $itemID == 262 || $itemID == 263 || $itemID == 264)modif($pokID,$itemID); //Модификации
        if($itemID > 1000 && $itemID < 1107)tm($pokID,$itemID);#TM
				if($itemID == 95)trenya($pokID);#Треня
        if($itemID == 177)juce($pokID,$count,$itemID);#Фруктовый сок
				if($itemID == 17 || $itemID == 31 || $itemID == 32 || $itemID == 33 || $itemID >= 217 &&  $itemID <= 234)lollipop($pokID,$count,$itemID);#Леденцы
				if($itemID == 3 || $itemID == 4 || $itemID == 5 || $itemID == 6 || $itemID == 109)balls($pokID,$itemID);#Боллы
				if($itemID > 18 && $itemID < 24 || $itemID > 24 && $itemID < 29 || $itemID > 33 && $itemID < 37 || $itemID > 50 && $itemID < 54 || $itemID > 64 && $itemID < 75 || $itemID > 95 && $itemID < 101 || $itemID == 335)evol_stones($pokID,$itemID);#Камни эволюции
				if($itemID > 36 && $itemID < 43)banka($pokID,$count,$itemID);#Банки
				if($itemID > 6 && $itemID < 10)berries($pokID,$count,$itemID);#Ягоды
				if($itemID == 154)setCharacter($pokID,$itemID);#конфета для смены хара
				if($itemID == 155)genUP($pokID,$itemID);#конфета для поднятия ген
				//if($checkAction['type'] == 'tm')learnTM($pokID,$itemID,$checkAction['info']);#TM
				if($itemID == 162)setShinePok($pokID,$itemID);#Набор красок для окраса в шайни
				$response['error'] = ($_SESSION['error']?$_SESSION['error']:0);
				$response['action'] = ($_SESSION['action']?$_SESSION['action']:0);
				$response['text'] = $_SESSION['text'];
				$response['other'] = $_SESSION['other'];
				$response['other2'] = $_SESSION['other2'];
        $response['error'] = $_SESSION['error'];
        $i = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = ".$itemID)->fetch_assoc();
        $response['minus'] = '<img src="/img/world/items/little/'.$itemID.'.png" class="item"> '.$i['name'].' ('.$count.' шт.)';
			}else{
        $response['text'] = 'Недостаточно предметов.';
				$response['error'] = 1;
			}
		break;
		case 'use':

			if(item_isset($itemID, $count)){
				require_once($patch_project.'/inc/function/Items.php');
				if($itemID >= 116 && $itemID <= 119)Box($itemID);#Ящики
				if($itemID == 152){


				    if($count > 2000){
                        $count = 2000;
                    }

				    if($count > 0){

				        for($i = 0; $i < $count; $i++){
                            NGBox($itemID, ($i + 1)); #Новогодний подарок
                        }

                        minus_item($itemID, $count);

                    }

                }
				if($itemID == 130 || $itemID == 141 || $itemID == 144)recipe($itemID);#Рецепты
        if($itemID == 254)drazdo($itemID);#Драздо
        if($itemID == 332)rainbowdust($itemID);#Радужная пыль
        if($itemID == 327)hell($itemID);#Хэллоуин
        if($itemID == 255)korobka_pirozn($itemID);#Коробка с пирожными
        if($itemID == 256)korobka_banki($itemID);#Коробка с витаминами
        if($itemID == 237 || $itemID == 238 || $itemID == 239 || $itemID == 240 || $itemID == 324)usili($itemID);#Усилители
				if($itemID == 110)Cloth($itemID);#Одежда
        if($itemID == 178)MainBox($itemID);#НовыйMainЯщик
        if($itemID == 334)Checkbank($itemID);#НовыйMainЯщик
				if($itemID == 173 || $itemID == 174 || $itemID == 175 || $itemID == 176)easterEgg($itemID);#Пасхальные яйца
				if($itemID > 83 && $itemID < 91)bagUpdate($itemID);#Рюкзаки
				if($itemID == 111)bagBox($itemID);#Набор рюкзаков
        if($_SESSION['error'] == 0) {
          $i = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = ".$itemID)->fetch_assoc();
          $response['minus'] = '<img src="/img/world/items/little/'.$itemID.'.png" class="item"> '.$i['name'].' ('.$count.' шт.)';
        }
        if($_SESSION['plus']) {
          $response['plus'] = $_SESSION['plus'];
        }
				$response['error'] = ($_SESSION['error']?$_SESSION['error']:0);
				$response['text'] = $_SESSION['text'];
				if(isset($_SESSION['text']) && is_array($_SESSION['text'])){
                    $_SESSION['text'] = '';
                }
			}else{
				$response['error'] = 1;
			}
		break;
		case 'remove':
    $pokemon = $mysqli->query("SELECT `item_id`,`item_str` FROM `user_pokemons` WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1")->fetch_assoc();
    if($pokemon['item_id'] == $itemID) {
      if(empty($pokemon['item_str'])) {
        itemAdd($pokemon['item_id'],1);
      }else{
        $mysqli->query("INSERT INTO `items_users` (`user`,`item_id`,`count`,`str`) VALUES ('".$_SESSION['id']."','".$pokemon['item_id']."',1,'".$pokemon['item_str']."') ");
      }
      $itemSel = $mysqli->query("SELECT name FROM base_items WHERE id = ".$itemID)->fetch_assoc();
      if($itemID == 107){ 
      minus_item(107,1); 
      itemAdd(333,1);
      } 
      $response['error'] = 0;
  		$response['text'] = 'Предмет успешно снят!';
  		$response['nameItem'] = $itemSel['name'];
      $mysqli->query("UPDATE `user_pokemons` SET `item_id` = 0, `item_str` = '' WHERE `id` = '".$pokID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
    }else{
      $response['error'] = 1;
    }
		break;
		case 'pokList':
			$teamUserQuery = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND active = 1");

			$pokList = [];
			if(count($teamUserQuery)){
				while($teamUser = $teamUserQuery->fetch_assoc()){
					$pokList[] = [
								'id'=>$teamUser["id"],
								'basenum'=>numbPok($teamUser["basenum"]),
								'type'=>($teamUser["type"] != 'normal' ? 'shine' : 'normal'),
								'name'=>$teamUser["name_new"],
								'class'=>($teamUser["type"] == 'shadow' ? 'shadow-color' : '')
								];
				}
				$response['pokList'] = $pokList;
			}else{
				$response = 0;
			}
		break;
		case 'reproductionList':
			$teamUserQuery = $mysqli->query('SELECT * FROM `user_pokemons` WHERE `user_id` = '.$_SESSION['id'].' AND `active` = 1 AND `sparka` = 0');
			$pokList = [];
			if(count($teamUserQuery)){
				while($teamUser = $teamUserQuery->fetch_assoc()){
					$pokList[] = [
								'id'=>$teamUser["id"],
								'basenum'=>numbPok($teamUser["basenum"]),
								'type'=>$teamUser["type"],
								'name'=>$teamUser["name_new"],
								'gender'=>$teamUser["gender"],
								'sparkaNumber'=>$teamUser["sparkaNumber"],
								'gen'=>$teamUser["gen"],
								];
				}
				$response['pokList'] = $pokList;
			}else{
				$response = 0;
			}
		break;
		default:
			echo "Unknown error";
		break;
	}
echo json_encode($response);
?>
