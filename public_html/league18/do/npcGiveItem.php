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
$type = (isset($_POST["category"]) ? clearStr($_POST["category"]) : null);
$npc = (isset($_POST["npc"]) ? clearInt($_POST["npc"]) : null);
$id = (isset($_POST["id"]) ? clearInt($_POST['id']) : null);
if(empty($type) ||  empty($npc) || empty($id)){
	$response['error'] = 'error';
	$response['text'] = 'Ошибка в выполнении скрипта.';
	die(json_encode($response));
}
$LocationNpc = $mysqli->query('SELECT
								`bn`.`loc_id`,
								`u`.`location`
							FROM `base_npc` AS `bn`
							INNER JOIN `users` AS `u`
							ON `u`.`id` = '.$_SESSION['id'].'
							WHERE
								`bn`.`id` = '.$npc
						)->fetch_assoc();
$EggQuery = $mysqli->query('SELECT * FROM `user_egg` WHERE `user` = '.$_SESSION['id'].' AND `id` = '.$id)->fetch_assoc();
$quest10 = $mysqli->query('SELECT `need` FROM `npc_more_quest` WHERE `user_id` = '.$_SESSION['id'].' AND `quest_id` = 10')->fetch_assoc();
$response['error'] = 'error';
if($LocationNpc['loc_id'] != $LocationNpc['location']){
	$response['text'] = 'Персонаж отсутствует на этой локации.';
	die(json_encode($response));
}
if($type == 'item') {
  $ItemQuery = $mysqli->query('SELECT * FROM `items_users` WHERE `user` = '.$_SESSION['id'].' AND `id` = '.$id)->fetch_assoc();
  if($ItemQuery) {
    $ItemQueryBase = $mysqli->query('SELECT * FROM `base_items` WHERE `id` = '.$ItemQuery['item_id'])->fetch_assoc();
  }
}
switch ($type) {
    case 'item':
      switch ($npc) {
        case 209:
          if($ItemQuery && in_array($ItemQuery['item_id'], [69,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195])) {
            $proch = explode(',',$ItemQuery['str']);
            if($proch[0] == 0) {
              $pr = $proch[1] * 3;
              if(item_isset($ItemQueryBase['info'],$pr)) {
                $PilBase = $mysqli->query('SELECT * FROM `base_items` WHERE `id` = '.$ItemQueryBase['info'])->fetch_assoc();
                $response['text'] = 'Предмет починился.';
                $response['error'] = "success";
                $response['minus'] = '<img src="/img/world/items/little/'.$PilBase['id'].'.png" class="item"> '.$PilBase['name'].' ('.$pr.' шт.)';
                minus_item($PilBase['id'],$pr);
                $mysqli->query('UPDATE `items_users` SET `str` = "'.$proch[1].','.$proch[1].'" WHERE `id` = '.$id);
              }else{
                $response['text'] = 'Недостаточно типовой пыли.';
              }
            }else{
              $response['text'] = 'Предмет еще не полностью сломан.';
            }
          }else{
            $response['text'] = 'Персонажу не нужен данный айтем.';
          }
        break;
        case 208:
          if($ItemQuery && in_array($ItemQuery['item_id'], [69,179,180,181,182,183,184,185,186,187,188,189,190,191,192,193,194,195])) {
            $proch = explode(',',$ItemQuery['str']);
            $PilBase = $mysqli->query('SELECT * FROM `base_items` WHERE `id` = '.$ItemQueryBase['info'])->fetch_assoc();
            $response['text'] = 'Предмет удачно измельчен на пыль.';
            $response['error'] = "success";
            $response['plus'] = '<img src="/img/world/items/little/'.$PilBase['id'].'.png" class="item"> '.$PilBase['name'].' ('.$proch[1].' шт.)';
            $response['minus'] = '<img src="/img/world/items/little/'.$ItemQuery['item_id'].'.png" class="item"> '.$ItemQueryBase['name'].' (1 шт.)';
            itemAdd($PilBase['id'],$proch[1]);
            $mysqli->query("DELETE FROM `items_users` WHERE `id` = '".$id."'");
          }else{
            $response['text'] = 'Персонажу не нужен данный айтем.';
          }
        break;
        case 188:
          if($ItemQuery && $ItemQuery['item_id'] == 184) {
            $PokemonQuery = $mysqli->query('SELECT * FROM `user_pokemons` WHERE `user_id` = '.$_SESSION['id'].' AND `active` = 1 AND `start_pok` = 1')->fetch_assoc();
            if($PokemonQuery && $PokemonQuery['basenum'] == 82) {
              $mysqli->query("DELETE FROM `items_users` WHERE `id` = '".$id."'");
              $mysqli->query('UPDATE `user_pokemons` SET `basenum` = 462, `name_new` = "Магнезон" WHERE `id` = '.$PokemonQuery['id']);
              $response['minus'] = '<img src="/img/world/items/little/184.png" class="item"> Магнит (1 шт.)';
              $response['text'] = 'Покемон удачно эволюционировал.';
              $response['error'] = "success";
            }else{
              $response['text'] = 'Ошибка в выборе покемона.';
            }
          }else{
            $response['text'] = 'Персонажу не нужен данный айтем.';
          }
        break;
        case 190:
          if($ItemQuery && $ItemQuery['item_id'] == 106) {
            $usilItem = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = '301'")->fetch_assoc();
            $usilFunc = explode(',',$usilItem['info']);
            $time = time() + $usilFunc[0];
            $usil = $mysqli->query("SELECT * FROM `bafs` WHERE `type` = '".$usilFunc[1]."' AND `user` = '".$_SESSION['id']."'")->fetch_assoc();
            if($usil) {
      				$mysqli->query("UPDATE `bafs` SET `time` = '".$time."',`baf` = '301' WHERE `type` = '".$usilFunc[1]."' AND `user` = '".$_SESSION['id']."'");
      			}else{
      				$mysqli->query("INSERT INTO `bafs` (`user`,`baf`,`time`,`type`) VALUES ('".$_SESSION['id']."','301', '".$time."', '".$usilFunc[1]."') ");
      			}
            $mysqli->query("DELETE FROM `items_users` WHERE `id` = '".$id."'");
            $response['minus'] = '<img src="/img/world/items/little/106.png" class="item"> Объедки (1 шт.)';
            $response['text'] = 'Снорлакс насытился и впустил вас на Военный участок. Будьте осторожны!';
            $response['error'] = "success";
          }else{
            $response['text'] = 'Персонажу не нужен данный айтем.';
          }
        break;
        default:
					$response['text'] = 'Данный персонаж не взаимодействует с этим предметом.';
				break;
      }
    break;
		case 'egg':
			switch ($npc) {
				case 99:
					if(!item_isset(1, 350000)){
						$response['text'] = 'У вас недостаточно денег.';
					}else{
						$reborn = floor(($EggQuery['reborn'] - time())/2);
						$newReborn = time() + $reborn;
						minus_item(1,350000);
            $response['minus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (350000 шт.)';
						$mysqli->query('UPDATE `user_egg` SET `reborn` = '.$newReborn.' WHERE `id` = '.$id);
						$response['text'] = 'Срок вылупления яйца уменьшен.';
            $response['error'] = "success";
					}
				break;
				case 116:
					if(Work::_questStep(10,6) && $EggQuery['basenum']){

						if($EggQuery['basenum'] == $quest10['need']){
							if(!Work::_npcTimeCheck(116)){
								$rand = rand(1,5);
								if($rand == 1){
									Work::_itemPlus(109,5);
									$prize = 'Генобол (5 шт.)';
                  $response['plus'] = '<img src="/img/world/items/little/109.png" class="item"> Генобол (5 шт.)';
								}elseif($rand == 2){
									Work::_itemPlus(1,100000);
									$prize = 'Монета (100000 шт.)';
                  $response['plus'] = '<img src="/img/world/items/little/1.png" class="item"> Монета (100000 шт.)';
								}elseif($rand == 3){
									Work::_itemPlus(31,10);
									$prize = 'Леденец в форме Торчика (10 шт.)';
                  $response['plus'] = '<img src="/img/world/items/little/31.png" class="item"> Леденец в форме Торчика (10 шт.)';
								}elseif($rand == 4){
									Work::_itemPlus(35,1);
									$prize = 'Лунный камень (1 шт.)';
                  $response['plus'] = '<img src="/img/world/items/little/35.png" class="item"> Лунный камень (1 шт.)';
								}else{
									Work::_itemPlus(149,3);
									$prize = 'Любовное ожерелье (3 шт.)';
                  $response['plus'] = '<img src="/img/world/items/little/149.png" class="item"> Любовное ожерелье (3 шт.)';
								}
								$mysqli->query("DELETE FROM `user_egg` WHERE `id` = '".$id."'");
								$wait = time()+86400;
								$mysqli->query("DELETE FROM `base_npc_data` WHERE `npcID` = 116 AND `userID` = '".$_SESSION['id']."'");
								$mysqli->query("INSERT INTO `base_npc_data` (`userID`,`npcID`,`time`) VALUES('".$_SESSION['id']."','116','".$wait."') ");
								Work::_questUpdate(10,5);
								$mysqli->query("UPDATE `quest_steps` SET `text` = 'Отдал яйцо Арине. Еще одного заказа от нее не получил, ибо никто не заказал какое-либо яйцо, пока что. Приду позже.' WHERE `id_user` = '".$_SESSION['id']."' AND `quest_id` = 10 AND `quest_step` = 6");
                $response['minus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
              }else{
								$response['text'] = 'Данный персонаж не взаимодействует с этим предметом.';
							}
						}else{
							$response['text'] = 'Данный персонаж не взаимодействует с этим предметом.';
						}
					}else{
						$response['text'] = 'Данный персонаж не взаимодействует с этим предметом.';
					}
				break;
				default:
					$response['text'] = 'Данный персонаж не взаимодействует с этим предметом.';
				break;
			}
		break;
		default:
			$response['text'] = 'Ошибка #1.';
		break;
	}
echo json_encode($response);
?>
