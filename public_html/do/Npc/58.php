<?php
  if(isset($_POST['pokID'])){
   $patch_project = $_SERVER['DOCUMENT_ROOT'];
  $patch_global = $patch_project.'/inc/conf/global.php';
   if(!empty($patch_global)){
       if(!file_exists($patch_global)){
           die('The problem with the connection files.');
       }else{
  		 require_once($patch_global);
       }
   }
   $chekquest = $mysqli->query("SELECT * FROM `npc_more_quest` WHERE `user_id`='".$_SESSION['id']."' AND quest_id = 5000")->fetch_assoc();
   $checkUserLoc = $mysqli->query("SELECT `location` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
   if($checkUserLoc['location'] == 96){
  	 $pokID = clearInt($_POST['pokID']);
  	 $pokInfo = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `id`='".$pokID."'")->fetch_assoc();
  	 $countMoney = $mysqli->query("SELECT * FROM `items_users` WHERE `user`= '".$_SESSION['id']."' AND `item_id` = '1'")->fetch_assoc();
 	 $PokemonBase = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `id`= '".$pokInfo['basenum']."'")->fetch_assoc();
  	if($chekquest['need'] == 1){
 		 $d = 'normal';
  	 }elseif($chekquest['need'] == 2){
  		 $d = 'fire';
  	 }elseif($chekquest['need'] == 3){
  		 $d = 'water';
  	 }elseif($chekquest['need'] == 4){
  		 $d = 'grass';
  	 }elseif($chekquest['need'] == 5){
  		 $d = 'fly';
  	 }elseif($chekquest['need'] == 6){
  		 $d = 'bug';
  	 }elseif($chekquest['need'] == 7){
  		 $d = 'dragon';
  	 }elseif($chekquest['need'] == 8){
  		 $d = 'ghost';
  	 }elseif($chekquest['need'] == 9){
  		 $d = 'steel';
  	 }elseif($chekquest['need'] == 10){
  		 $d = 'electric';
  	 }elseif($chekquest['need'] == 11){
  		 $d = 'fairy';
  	 }elseif($chekquest['need'] == 12){
  		 $d = 'psychic';
  	 }elseif($chekquest['need'] == 13){
  		 $d = 'dark';
  	 }elseif($chekquest['need'] == 14){
  		 $d = 'rock';
  	 }elseif($chekquest['need'] == 15){
  		 $d = 'ground';
  	 }elseif($chekquest['need'] == 16){
  		 $d = 'fighting';
  	 }elseif($chekquest['need'] == 17){
  		 $d = 'ice';
  	 }elseif($chekquest['need'] == 18){
  		 $d = 'poison';
  	 }
  	 switch($pokInfo['basenum']){
  		 default:
  			 if($PokemonBase['type'] == $d && $pokInfo['event'] != 1 || $PokemonBase['type_two'] == $d && $pokInfo['event'] != 1){
  				 $PokemonBase = $mysqli->query("SELECT * FROM `user_quests` WHERE `user_id`= '".$_SESSION['id']."' AND `quest_id` = 5000 AND `step` = 1")->fetch_assoc();
  				 if($PokemonBase){
  					 if($pokInfoBase['id'] >= 1 && $pokInfoBase['id'] <= 9) {
  						 $basen = '00'.$pokInfoBase['id'];
  					 }elseif($pokInfoBase['id'] >= 10 && $pokInfoBase['id'] <= 99) {
  						 $basen = '0'.$pokInfoBase['id'];
  					 }else{
  						 $basen = $pokInfoBase['id'];
  					 }
  					 $e = rand(10,15);
  					 itemAdd(108,$e);
  					 $response['text'] = 'Вы получили: Разноцветная пыль ('.$e.' шт.)';
  					 $mysqli->query("DELETE FROM `user_quests` WHERE `quest_id` = 5000 AND `user_id` = '".$_SESSION['id']."'");
  					 $mysqli->query("DELETE FROM `user_pokemons` WHERE `id` = '".$pokID."'");
  					 $wait = time()+3600;
  					 $mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','5000','".$wait."') ");
  				 }else{
  					 $response['text'] = 'Вы не взяли задание.';
  				 }
  			 }else{
  				 $response['text'] = 'Данный покемон не подходит!';
  				 $response['error'] = 1;
  			 }
  		 break;
  	 }
   }else{
  	 $response['text'] = 'Ошибка!';
  	 $response['error'] = 1;
   }
   die(json_encode($response));
  }
  $chekquest = $mysqli->query("SELECT * FROM `npc_more_quest` WHERE `user_id`='".$_SESSION['id']."' AND quest_id = 5000")->fetch_assoc();
  		 if($chekquest['need'] == 1){
  			 $c = 'Нормальный';
  		 }elseif($chekquest['need'] == 2){
  			 $c = 'Огненный';
  		 }elseif($chekquest['need'] == 3){
  			 $c = 'Водный';
  		 }elseif($chekquest['need'] == 4){
  			 $c = 'Травяной';
  		 }elseif($chekquest['need'] == 5){
  			 $c = 'Летающий';
  		 }elseif($chekquest['need'] == 6){
  			 $c = 'Жук';
  		 }elseif($chekquest['need'] == 7){
  			 $c = 'Драконий';
  		 }elseif($chekquest['need'] == 8){
  			 $c = 'Призрачный';
  		 }elseif($chekquest['need'] == 9){
  			 $c = 'Стальной';
  		 }elseif($chekquest['need'] == 10){
  			 $c = 'Электрический';
  		 }elseif($chekquest['need'] == 11){
  			$c = 'Волшебный';
  		 }elseif($chekquest['need'] == 12){
  			 $c = 'Психический';
  		 }elseif($chekquest['need'] == 13){
  			 $c = 'Темный';
  		 }elseif($chekquest['need'] == 14){
  			$c = 'Каменный';
  		 }elseif($chekquest['need'] == 15){
  			 $c = 'Земляной';
  		 }elseif($chekquest['need'] == 16){
  			 $c = 'Боевой';
  		 }elseif($chekquest['need'] == 17){
  			$c = 'Ледяной';
  		 }elseif($chekquest['need'] == 18){
  			 $c = 'Ядовитый';
  		 }
 
  $response['name'] = 'Мистер Авотор';
   switch($npcStep){
  	 case 1:
  	 if(!quest_isset(5000) && !npc_time_check(5000)){
  			 $a = rand(1,18);
  		 if($a == 1){
  			 $b = 'Нормальный';
  		 }elseif($a == 2){
  			 $b = 'Огненный';
  		 }elseif($a == 3){
  			 $b = 'Водный';
  		 }elseif($a == 4){
  			 $b = 'Травяной';
  		 }elseif($a == 5){
  			 $b = 'Летающий';
  		 }elseif($a == 6){
  			 $b = 'Жук';
  		 }elseif($a == 7){
  			 $b = 'Драконий';
  		 }elseif($a == 8){
  			 $b = 'Призрачный';
  		 }elseif($a == 9){
  			 $b = 'Стальной';
  		 }elseif($a == 10){
  			 $b = 'Электрический';
  		 }elseif($a == 11){
  			 $b = 'Волшебный';
  		 }elseif($a == 12){
  			 $b = 'Психический';
  		 }elseif($a == 13){
  			 $b = 'Темный';
  		 }elseif($a == 14){
  			 $b = 'Каменный';
  		 }elseif($a == 15){
  			 $b = 'Земляной';
  		 }elseif($a == 16){
  			 $b = 'Боевой';
  		}elseif($a == 17){
  			 $b = 'Ледяной';
  		 }else{
  			 $b = 'Ядовитый';
  		 }
  		 $response['question'] = 'Мне нужен покемон с типом <b>'.$b.'</b>.';
  		 $mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 5000 AND `userID` = '".$_SESSION['id']."'");
  		 $mysqli->query("DELETE FROM `npc_more_quest` WHERE `quest_id` = 5000 AND `user_id` = '".$_SESSION['id']."'");
  		 $mysqli->query("INSERT INTO `npc_more_quest` (`user_id`,`quest_id`,`need`) VALUES('".$_SESSION['id']."',5000,'".$a."') ");
  		 quest_update(5000,1);
  	 }else{
  		 $response['question'] = 'Ошибка!';
  	 }
  	 break;
      case 2:
  			 $poks = $mysqli->query("SELECT `id`,`name_new`,`basenum` FROM `user_pokemons` WHERE `user_id`='".$_SESSION['id']."' AND `active` = '1'");
  			 $list = '';
  			 while($pokList = $poks->fetch_assoc()){
  				 $list.= '<option value="'.$pokList['id'].'">#'.numbPok($pokList['basenum']).' '.$pokList['name_new'].'</option>';
  			 }
  			 $response['question'] = 'Выбери покемона
  									 <form class="evolNpcForm" onsubmit="evolutionPok(58);return false;"">
  									 <select id="pokID">'.$list.'
  									 </select>
 										 <input class="mn-btn" type="submit" value="Выбрать">
  									 </form>';
  	 break;
      case 3:
  		 if(quest_step(5000,1)) {
          if(!npc_time_check(6000)){
            $mysqli->query("DELETE FROM `npc_more_quest` WHERE `quest_id` = 5000 AND `user_id` = '".$_SESSION['id']."'");
            $response['question'] = 'Задание можно менять один раз в час. Ты уже менял его в течении этого часа. Приходи позже.';
            $a = rand(1,18);
   			 if($a == 1){
   				 $b = 'Нормальный';
   			 }elseif($a == 2){
   				 $b = 'Огненный';
   			 }elseif($a == 3){
   				 $b = 'Водный';
   			 }elseif($a == 4){
   				 $b = 'Травяной';
   			 }elseif($a == 5){
   				 $b = 'Летающий';
   			 }elseif($a == 6){
   				 $b = 'Жук';
   			 }elseif($a == 7){
   				 $b = 'Драконий';
   			 }elseif($a == 8){
   				 $b = 'Призрачный';
   			 }elseif($a == 9){
   				 $b = 'Стальной';
   			 }elseif($a == 10){
   				 $b = 'Электрический';
   			 }elseif($a == 11){
   				 $b = 'Волшебный';
   			 }elseif($a == 12){
   				 $b = 'Психический';
   			 }elseif($a == 13){
  				 $b = 'Темный';
  			 }elseif($a == 14){
  				 $b = 'Каменный';
  			 }elseif($a == 15){
   				 $b = 'Земляной';
   			 }elseif($a == 16){
   				 $b = 'Боевой';
   			}elseif($a == 17){
   				 $b = 'Ледяной';
   			 }else{
   				 $b = 'Ядовитый';
   			 }
   			 $response['question'] = 'Мне нужен покемон с типом <b>'.$b.'</b>.';
          $mysqli->query("INSERT INTO `npc_more_quest` (`user_id`,`quest_id`,`need`) VALUES('".$_SESSION['id']."',5000,'".$a."') ");
          $wait = time()+3600;
          $mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 6000 AND `userID` = '".$_SESSION['id']."'");
         $mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','6000','".$wait."') ");
          }else{
            $response['question'] = 'Задание можно менять один раз в час. Ты уже менял его в течении этого часа. Приходи позже.';
          }
        }else{
          $response['question'] = 'Ты еще старого задания не брал, дружище!';
        }
  	 break;
  	 default:
  		 if(!quest_isset(5000) && !npc_time_check(5000)){
  			 $response['question'] = 'Здравствуйте, я Авотор. Мне нужен покемон с определенным типом. За каждого покемона я буду давать по 10 - 15 разноцветной пыли.';
  			 $response['answer'] = array(
  				 1 => "Какого типа покемон вам сейчас нужен?"
  			 );
  		 }elseif(quest_step(5000,1) && !npc_time_check(5000)){
  			 $response['question'] = 'Принес покемона с типом <b>'.$c.'</b>?';
  			 $response['answer'] = array(
  				2 => "Принес",
           3 => "Можно другое задание?"
  			 );
  		 }else{
  			 $response['question'] = 'Сейчас нет заданий. Приходи позже.';
  		 }
  	 break;
   }
	//switch($npcStep){
		//default:
			//$response['question'] = 'Аттракцион больше не работает. Ярмарка закрыта.';
		//break;
	//}
?>
