<?php
  $chekquest = $mysqli->query("SELECT * FROM `npc_more_quest` WHERE `user_id`='".$_SESSION['id']."' AND quest_id = 5002")->fetch_assoc();
  $response['name'] = 'Чудной ученый';
   switch($npcStep){
  	 case 1:
  	 if(!quest_isset(5002) && !npc_time_check(5002)){
 	   $a = rand(199,216);
  		 $response['question'] = 'Мне нужна <div class="itemIsset" onclick=issetAll('.$a.',"item") style="background-image: url(/img/world/items/little/'.$a.'.png)"></div>';
  		 $mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 5002 AND `userID` = '".$_SESSION['id']."'");
  		 $mysqli->query("DELETE FROM `npc_more_quest` WHERE `quest_id` = 5002 AND `user_id` = '".$_SESSION['id']."'");
  		 $mysqli->query("INSERT INTO `npc_more_quest` (`user_id`,`quest_id`,`need`) VALUES('".$_SESSION['id']."',5002,'".$a."') ");
        quest_update(5002,1);
  	 }else{
  		 $response['question'] = 'Ошибка!';
  	 }
  	 break;
  	 case 2:
  	 if(quest_step(5002,1) && !npc_time_check(5002)){
        if(item_isset($chekquest['need'],3)) {
          $mysqli->query("DELETE FROM `user_quests` WHERE `quest_id` = 5002 AND `user_id` = '".$_SESSION['id']."'");
          $wait = time()+3600;
          $mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','5002','".$wait."') ");
          $chekquest1 = $mysqli->query("SELECT * FROM `base_items` WHERE `id`='".$chekquest['need']."'")->fetch_assoc();
          itemAdd(108,10);
          minus_item($chekquest['need'],3);
          $response['question'] = 'Отлично! Приходи через час. Я приготовлю еще отвар для превращения.';
          $response['actionQuestPlus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль (10 шт.)';
          $response['actionQuestMinus'] = '<img src="/img/world/items/little/'.$chekquest1['id'].'.png" class="item"> '.$chekquest1['name'].' (3 шт.)';
        }else{
          $response['question'] = 'У тебя нет типовой пыли.';
        }
      }
  	 break;
  	 default:
  		 if(!quest_isset(5002) && !npc_time_check(5002)){
  			 $response['question'] = 'Привет! Я разработал химическую формулу, при помощи которой я могу превращать типовую пыль в разноцветную! За каждые 3 иповые пылинки я даю 10 разноцветной!';
  			 $response['answer'] = array(
  				 1 => "Здорово! Какая типовая пыль вам нужна сейчас?"
  			 );
  		 }elseif(quest_step(5002,1) && !npc_time_check(5002)){
  			 $response['question'] = 'Принес <div class="itemIsset" onclick=issetAll('.$chekquest['need'].',"item") style="background-image: url(/img/world/items/little/'.$chekquest['need'].'.png)"></div> ?';
  			 $response['answer'] = array(
  				2 => "Принес"
  			 );
  		 }else{
  			 $response['question'] = 'Я еще готовлю свой отвар! Приходи позже!';
  		 }
  	 break;
    }
 //switch($npcStep){
   //default:
     //$response['question'] = 'Аттракцион больше не работает. Ярмарка закрыта.';
   //break;
 //}
?>
