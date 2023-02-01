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
// Воришка
//$thiefRand1 = mt_rand(1,9);
//$thiefRand2 = mt_rand(1,9);
//$thiefRand3 = mt_rand(1,9);
//$thiefQuery1 = $mysqli->query("SELECT * FROM `thief` WHERE id = ".$thiefRand1)->fetch_assoc();
//$thiefQuery2 = $mysqli->query("SELECT * FROM `thief` WHERE id = ".$thiefRand2)->fetch_assoc();
//$thiefQuery3 = $mysqli->query("SELECT * FROM `thief` WHERE id = ".$thiefRand3)->fetch_assoc();
//Work::$sql->query("UPDATE `items_npc` SET `item_id` = ".$thiefQuery1['item_id'].", `item_price` = ".$thiefQuery1['prize'].", `item_count` = ".$thiefQuery1['count']." WHERE `id` = 107");
//Work::$sql->query("UPDATE `items_npc` SET `item_id` = ".$thiefQuery3['item_id'].", `item_price` = ".$thiefQuery3['prize'].", `item_count` = ".$thiefQuery3['count']." WHERE `id` = 109");
//Work::$sql->query("TRUNCATE TABLE battle_log");

//Аукцион
if(date("G") == 0) {
  Work::$sql->query("UPDATE `system` SET `online` = 0 WHERE `id` = 1");
  Work::$sql->query("TRUNCATE TABLE battle_log");
  $news = Work::$sql->query("SELECT * FROM friends_news");
  while($a = $news->fetch_assoc()) {
    $time = time() - 604800;
    if($a['date'] <= $time) {
      Work::$sql->query("DELETE FROM friends_news WHERE id = ".$a['id']);
    }
  }
  $rain = $mysqli->query("SELECT * FROM `base_npc` WHERE `id` = 17")->fetch_assoc();
  if($rain['loc_id'] == 64) {
    Work::$sql->query("UPDATE `base_npc` SET `loc_id` = 308 WHERE `id` = ".$rain['id']);
  }else{
    Work::$sql->query("UPDATE `base_npc` SET `loc_id` = 64 WHERE `id` = ".$rain['id']);
  }
  $lomb = $mysqli->query("SELECT * FROM `lombard`");
  while($lot = $lomb->fetch_assoc()) {
    if($lot['dateEnd'] < time()) {
      if(isset($lot['userBuy'])){
        $kup = $lot['userBuy'];
      }else{
        $kup = 0;
      }
      Work::$sql->query('INSERT INTO log_lombard (id_lot,category,name,count,priceStart,priceStep,priceNow,priceBuy,dateAdd,dateEnd,userID,userBuy,productID,kup) VALUES ('.$lot['id'].',"'.$lot['category'].'","'.$lot['name'].'",'.$lot['count'].','.$lot['priceStart'].','.$lot['priceStep'].','.$lot['priceNow'].','.$lot['priceBuy'].','.$lot['dateAdd'].','.$lot['dateEnd'].','.$lot['userID'].','.$kup.','.$lot['productID'].',0)');
      if($lot['category'] == 'item') {
        if(isset($lot['userBuy'])) {
          if(!empty($lot['str'])) {
            $mysqli->query("INSERT INTO `items_users` (`user`,`item_id`,`count`,`str`) VALUES ('".$lot['userBuy']."','".$lot['productID']."',1,'".$lot['str']."') ");
          }else{
            itemAdd($lot['productID'],$lot['count'],$lot['userBuy']);
          }
        }else{
          if(!empty($lot['str'])) {
            $mysqli->query("INSERT INTO `items_users` (`user`,`item_id`,`count`,`str`) VALUES ('".$lot['userID']."','".$lot['productID']."',1,'".$lot['str']."') ");
          }else{
            itemAdd($lot['productID'],$lot['count'],$lot['userID']);
          }
        }
        itemAdd(1,$lot['priceNow'],$lot['userID']);
      }elseif($lot['category'] == 'pok') {
        if(isset($lot['userBuy'])) {
          Work::$sql->query("UPDATE `user_pokemons` SET `active` = 0, `user_id` = ".$lot['userBuy']." WHERE `id` = ".$lot['productID']);
        }else{
          Work::$sql->query("UPDATE `user_pokemons` SET `active` = 0, `user_id` = ".$lot['userID']." WHERE `id` = ".$lot['productID']);
        }
        itemAdd(1,$lot['priceNow'],$lot['userID']);
      }else{
        if(isset($lot['userBuy'])) {
          Work::$sql->query("UPDATE `user_egg` SET `user` = ".$lot['userBuy']." WHERE `id` = ".$lot['productID']);
        }else{
          Work::$sql->query("UPDATE `user_egg` SET `user` = ".$lot['userID']." WHERE `id` = ".$lot['productID']);
        }
        itemAdd(1,$lot['priceNow'],$lot['userID']);
      }
      Work::$sql->query("DELETE FROM lombard WHERE id = ".$lot['id']);
    }
  }
}
//Аукцион конец
if(date("j") == 1 && date("G") == 1) {
  if(date("n") == 1 || date("n") == 5 || date("n") == 9) {
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 1014 WHERE `id` = 120");
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 96 WHERE `id` = 125");
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 237 WHERE `id` = 131");
  }elseif(date("n") == 2 || date("n") == 6 || date("n") == 10) {
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 1044 WHERE `id` = 120");
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 20 WHERE `id` = 125");
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 239 WHERE `id` = 131");
  }elseif(date("n") == 3 || date("n") == 7 || date("n") == 11) {
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 1042 WHERE `id` = 120");
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 52 WHERE `id` = 125");
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 237 WHERE `id` = 131");
  }else{
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 1066 WHERE `id` = 120");
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 71 WHERE `id` = 125");
    Work::$sql->query("UPDATE `items_npc` SET `item_id` = 239 WHERE `id` = 131");
  }
  Work::$sql->query("DELETE FROM items_users WHERE item_id = 236");
}
if(date("N") == 1 && date("G") == 1) {
  Work::$sql->query("TRUNCATE TABLE new_pass");
}
if(date("N") == 6 && $timeday == 4) {
  Work::$sql->query("UPDATE `base_location` SET `pve` = 2 WHERE `id` = 227");
}
if(date("N") == 7) {
  Work::$sql->query("UPDATE `base_location` SET `pve` = 0 WHERE `id` = 227");
}
if(date("N") == 7 && $timeday == 3) {
  Work::$sql->query('INSERT INTO base_npc (id,name,loc_id,event) VALUES (159,"Дрейк Колибри",117,0)');
}
if(date("N") == 7 && $timeday == 4) {
  Work::$sql->query("UPDATE `users` SET `location` = 117 WHERE `location` = 235");
  Work::$sql->query("DELETE FROM base_npc WHERE id = 159");
}

//Мув покемоны
$randMoveKanto = mt_rand(1,10);
$randMoveHoenn = mt_rand(1,10);
if($randMoveKanto == 1){
  $randMoveKanto1 = 15;
}elseif($randMoveKanto == 2){
  $randMoveKanto1 = 36;
}elseif($randMoveKanto == 3){
  $randMoveKanto1 = 34;
}elseif($randMoveKanto == 4){
  $randMoveKanto1 = 33;
}elseif($randMoveKanto == 5){
  $randMoveKanto1 = 25;
}elseif($randMoveKanto == 6){
  $randMoveKanto1 = 8;
}elseif($randMoveKanto == 7){
  $randMoveKanto1 = 44;
}elseif($randMoveKanto == 8){
  $randMoveKanto1 = 221;
}elseif($randMoveKanto == 9){
  $randMoveKanto1 = 37;
}else{
  $randMoveKanto1 = 24;
}
if($randMoveHoenn == 1){
  $randMoveHoenn1 = 137;
}elseif($randMoveHoenn == 2){
  $randMoveHoenn1 = 140;
}elseif($randMoveHoenn == 3){
  $randMoveHoenn1 = 145;
}elseif($randMoveHoenn == 4){
  $randMoveHoenn1 = 137;
}elseif($randMoveHoenn == 5){
  $randMoveHoenn1 = 169;
}elseif($randMoveHoenn == 6){
  $randMoveHoenn1 = 157;
}elseif($randMoveHoenn == 7){
  $randMoveHoenn1 = 164;
}elseif($randMoveHoenn == 8){
  $randMoveHoenn1 = 170;
}elseif($randMoveHoenn == 9){
  $randMoveHoenn1 = 190;
}else{
  $randMoveHoenn1 = 218;
}
Work::$sql->query("UPDATE `pokemons_location` SET `location_id` = '".$randMoveKanto1."' WHERE `id` = 268");
Work::$sql->query("UPDATE `pokemons_location` SET `location_id` = '".$randMoveHoenn1."' WHERE `id` = 269");

//Др игры
$pokemonDR1 = array(120,318,170,592,594);
$pokemonDR2 = array(231,322,694,595,585);
$randDR1 = mt_rand(0,4);
$randDR2 = mt_rand(0,4);
$randDR3 = mt_rand(0,4);
$randDR4 = mt_rand(0,4);
Work::$sql->query("UPDATE `pokemons_location` SET `basenum` = '".$pokemonDR1[$randDR1]."' WHERE `id` = 367");
Work::$sql->query("UPDATE `pokemons_location` SET `basenum` = '".$pokemonDR1[$randDR2]."' WHERE `id` = 368");
Work::$sql->query("UPDATE `pokemons_location` SET `basenum` = '".$pokemonDR2[$randDR3]."' WHERE `id` = 373");
Work::$sql->query("UPDATE `pokemons_location` SET `basenum` = '".$pokemonDR2[$randDR4]."' WHERE `id` = 374");
?>
