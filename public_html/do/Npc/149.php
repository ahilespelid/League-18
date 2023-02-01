<?php
	//  $patch_project = $_SERVER['DOCUMENT_ROOT'];
	// $patch_global = $patch_project.'/inc/conf/global.php';
	//  if(!empty($patch_global)){
	//      if(!file_exists($patch_global)){
	//          die('The problem with the connection files.');
	//      }else{
	// 		 require_once($patch_global);
	//      }
	//  }
	 $response['name'] = 'Телгид';
	//  switch($npcStep){
	//
  //    case 1:
  //     $response['question'] = '<i>~Диглетт стремительно побежал в небольшое поле и спрятался под одним из камней. Под каким камнем Диглетт? Как вы думаете?~</i>
  //     <div class="StonesDig">
  //     <div onclick=NpcDialog(149,2,"event"); class="Stone" style="background-image: url(/img/rock1.png);"></div>
  //     <div onclick=NpcDialog(149,2,"event"); class="Stone" style="background-image: url(/img/rock2.png);"></div>
  //     <div onclick=NpcDialog(149,2,"event"); class="Stone" style="background-image: url(/img/rock3.png);"></div>
  //     </div>
  //     ';
	// 	 break;
	//
  //    case 2:
  //    if(!npc_time_check(5001)){
  //      $rand = mt_rand(1,3);
  //      if($rand == 1) {
  //        $rand1 = mt_rand(5,10);
  //        itemAdd(108,$rand1);
  //        $response['actionQuestPlus'] = '<img src="/img/world/items/little/108.png" class="item"> Разноцветная пыль ('.$rand1.' шт.)';
  //        $response['question'] = '<i>~Вы подняли этот камень и увидели под ним Диглетта. Вы нашли его!<br>Обернувшись, вы увидели, как Телгид идет к вам и несет вами заслуженную разноцветную пыль~</i>';
  //      }else{
  //        $response['question'] = '<i>~Под камнем никого не оказалось. Диглетт был в соседнем камне. Увидив вас, покемон быстро убежал, что вы не стали его даже догонять.<br>К вам подошел Телгид и сказал, что можно придти сюда через час и попытаться сново поймать его.~</i>';
  //      }
  //      $mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 5001 AND `userID` = '".$_SESSION['id']."'");
  //      $wait = time()+3600;
  //      $mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','5001','".$wait."') ");
  //    }
	// 	 break;
	//
	// 	 default:
	// 		 if(!npc_time_check(5001)){
	// 			 $response['question'] = 'Привет. Поиграем в игру? Я запущу в поле своего одного Диглетта, а ты должен будешь его отыскать? Если поймаешь, дам разноцветную пыль. Готов?';
	// 			 $response['answer'] = array(
	// 				 1 => "Да, давайте"
	// 			 );
	// 		 }else{
	// 			 $response['question'] = 'Все Диглетты спят! Т-с-с! Приходи позже.';
	// 		 }
	// 	 break;
	//  }
	switch($npcStep){
		default:
			$response['question'] = 'Аттракцион больше не работает. Ярмарка закрыта.';
		break;
	}
?>
