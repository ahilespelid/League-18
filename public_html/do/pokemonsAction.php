<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
    }
}
$type = $_POST["type"];
$pokemonID = clearInt($_POST['pokID']);
$pokemonID = $mysqli->real_escape_string($pokemonID);
$user = $mysqli->query("SELECT `status` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
if($user['status'] != 'free' && $type != 'attackInfo'){
	$response['text'] = 'В данный момент вы заняты!';
	$response['error'] = 1;
}else{
	switch ($type) {
		case 'addEV':
			$stat = $_POST['stat'];
			$count = $_POST['count'];
			$response['error'] = 1;
			if($count <= 0 || $count > 126){
				$response['text'] = 'Количество EV не должно быть ниже 0 и больше 126!';
			}else{
				$pokemon = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokemonID."' AND `active` = '1' AND `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
				if(empty($pokemon['id'])){
					$response['text'] = 'Ошибка в выборе покемона!';
				}elseif($pokemon['ev'] <= 0 || $pokemon['ev'] < $count){
					$response['text'] = 'Недостаточно EV!';
				}else{
					$evcounts = explode(',',$pokemon['evcounts']);
					if($evcounts[$stat] > 126){
						$response['text'] = 'В стате максимальное количество EV!';
					}elseif($evcounts[$stat] + $count > 126){
						$response['text'] = 'Максимальное количество EV в одном стате 126!';
					}else{
						$ev = $evcounts[$stat] + $count;
						if($stat == 0){
							$evcounts = $ev.','.$evcounts[1].','.$evcounts[2].','.$evcounts[3].','.$evcounts[4].','.$evcounts[5];
						}elseif($stat == 1){
							$evcounts = $evcounts[0].','.$ev.','.$evcounts[2].','.$evcounts[3].','.$evcounts[4].','.$evcounts[5];
						}elseif($stat == 2){
							$evcounts = $evcounts[0].','.$evcounts[1].','.$ev.','.$evcounts[3].','.$evcounts[4].','.$evcounts[5];
						}elseif($stat == 3){
							$evcounts = $evcounts[0].','.$evcounts[1].','.$evcounts[2].','.$ev.','.$evcounts[4].','.$evcounts[5];
						}elseif($stat == 4){
							$evcounts = $evcounts[0].','.$evcounts[1].','.$evcounts[2].','.$evcounts[3].','.$ev.','.$evcounts[5];
						}else{
							$evcounts = $evcounts[0].','.$evcounts[1].','.$evcounts[2].','.$evcounts[3].','.$evcounts[4].','.$ev;
						}
						$evLost = $pokemon['ev'] - $count;
						$mysqli->query("UPDATE `user_pokemons` SET `evcounts` = '".$evcounts."', `ev` = '".$evLost."' WHERE `id` = '".$pokemonID."'");
						$response['error'] = 0;
						$response['text'] = 'Очки EV успешно добавлены!';
						$response['ev'] = $evLost;
					}
				}
			}
		break;
		case 'deletePok':
			$response['error'] = 1;
			$pokemon = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `active` = '1' AND `user_id` = '".$_SESSION['id']."'");
			if($pokemon->num_rows < 2){
				$response['text'] = 'В команде должен оставаться 1 покемон!';
			}else{
				$pokemon = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `id` = '".$pokemonID."' AND `active` = '1' AND `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
				if(empty($pokemon['id'])){
					$response['text'] = 'Ошибка в выборе покемона!';
				}elseif($pokemon['startGame'] == 1){
					$response['text'] = 'Стартового покемона отпустить нельзя!';
				}else{
					$response['error'] = 0;
					$response['text'] = 'Покемон успешно отпущен!';
          $response['pokId'] = $pokemon['basenum'];
          $response['pokName'] = '#'.numbPok($pokemon['basenum']).' '.$pokemon['name_new'];
					$mysqli->query("UPDATE `user_pokemons` SET `user_id` = 2, `active` = 0 WHERE `id` = '".$pokemonID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
				}
			}

		break;
		case 'attackInfo':
			$baseInfo = $mysqli->query('SELECT * FROM `base_atk` WHERE `id` = '.$pokemonID)->fetch_assoc();
      if($baseInfo['contact'] == 1) {
        $response['contact'] = ', контакт';
      }else{
        $response['contact'] = '';
      }
      $response['contact'] = $baseInfo['contact'];
			$response['name'] = $baseInfo['name'];
			$response['nameRus'] = $baseInfo['name_rus'];
			$response['pp'] = $baseInfo['pp'];
			$response['title'] = $baseInfo['title'];
			$response['type'] = $baseInfo['type'];
			$response['accuracy'] = $baseInfo['accuracy'];
			$response['power'] = $baseInfo['power'];
			if($baseInfo['category'] == 'physical'){
				$response['category'] = 'Физическая';
			}elseif($baseInfo['category'] == 'special'){
				$response['category'] = 'Специальная';
			}elseif($baseInfo['category'] == 'status'){
				$response['category'] = 'Статусная';
			}else{
				$response['category'] = 'Специфическая';
			}

		break;
		case 'putPok':
			$response['error'] = 1;
			$pokemon = $mysqli->query("SELECT * FROM `user_pokemons` WHERE `active` = '1' AND `user_id` = '".$_SESSION['id']."'");
			$locationID = $mysqli->query("SELECT `location` FROM `users` WHERE `id`='".$_SESSION['id']."'")->fetch_assoc();
			$locationName = $mysqli->query("SELECT `name` FROM `base_location` WHERE `id`='".$locationID['location']."'")->fetch_assoc();
			if($locationName['name'] == 'Покецентр' || $locationName['name'] == 'Поле для тренировок' || $locationName['name'] == 'Пляжное кафе' || $locationName['name'] == 'Небольшая деревня' || $locationName['name'] == 'Склад магазина' || $locationName['name'] == 'Арена'){
				$pokemon = $mysqli->query("SELECT `id` FROM `user_pokemons` WHERE `id` = '".$pokemonID."' AND `active` = '1' AND `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
				if(empty($pokemon['id'])){
					$response['text'] = 'Ошибка в выборе покемона!';
				}else{
					$response['error'] = 0;
					$response['text'] = 'Покемон успешно перемещен в питомник!';
					$mysqli->query("UPDATE `user_pokemons` SET `active` = 0, `start_pok` = 0 WHERE `id` = '".$pokemonID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
				}
			}elseif($pokemon->num_rows < 2){
				$response['text'] = 'В команде должен оставаться 1 покемон!';
			}else{
				$response['text'] = 'На данной локации нету питомников!';
			}

		break;
		case 'setStart':
			$response['error'] = 1;
				$pokemon = $mysqli->query("SELECT `id` FROM `user_pokemons` WHERE `id` = '".$pokemonID."' AND `active` = '1' AND `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
				if(empty($pokemon['id'])){
					$response['text'] = 'Ошибка в выборе покемона!';
				}else{
					$response['error'] = 0;
					$response['text'] = 'Стартовый покемон успешно выбран!';
					$mysqli->query("UPDATE `user_pokemons` SET `start_pok` = 1 WHERE `id` = '".$pokemonID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					$mysqli->query("UPDATE `user_pokemons` SET `start_pok` = 0 WHERE `start_pok` > 0 AND `user_id` = '".$_SESSION['id']."' AND `active` = 1 AND `id` != '".$pokemonID."'");
				}

		break;
		case 'wentPok':
			$response['error'] = 1;
			$pokemon = $mysqli->query("SELECT `happy`,`lastWent` FROM `user_pokemons` WHERE `active` = '1' AND `user_id` = '".$_SESSION['id']."' AND `id` = '".$pokemonID."'")->fetch_assoc();
			$happy = 5;
			if($pokemon['happy'] == 255){
				$response['text'] = 'Ваш покемон самый счастливый';
			}else{
				$happyAll = $pokemon['happy']+$happy;
				if($happyAll > 255){
					$happyAll = 255;
				}
				$rand = rand(3,10);
        if(time() > $pokemon['lastWent']){
          sleep($rand);
          $lastWent = time()+60*12;
          $mysqli->query("UPDATE `user_pokemons` SET `happy` = '".$happyAll."', `lastWent` = '".$lastWent."' WHERE `id` = '".$pokemonID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
          $response['error'] = 0;
          $response['text'] = 'Прогулка понравилась покемону, он повысил свое счастье.';
        }else{
          $response['text'] = 'Покемон может гулять лишь один раз в 12 часов.';
        }
			}
		break;
		case 'renamePok':
			$name = clearStr($_POST['name']);
			$name = $mysqli->real_escape_string($name);
      $pokemon = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `id` = '".$pokemonID."' AND `active` = '1' AND `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
      if(empty($pokemon['id'])){
        $response['error'] = 0;
  			$response['text'] = 'Покемон успешно переименован!';
  			$response['name'] = '#'.numbPok($pokemon['basenum']).' '.$name;
  			$mysqli->query("UPDATE `user_pokemons` SET `name_new` = '".$name."' WHERE `id` = '".$pokemonID."'");
      }else{
        $response['text'] = 'Ошибка в выборе покемона!';
      }
		break;
		case 'open':
            $atkNumb = intval($_POST['attackID']);

            if($atkNumb >= 0){

                $pokemon = $mysqli->query('
                    SELECT
                        up.basenum,
                        up.lvl,
                        bap.attacks,
                        bap.lvl a_lvl
                    FROM user_pokemons up
                    LEFT JOIN base_attacks_pokemons bap
                      ON bap.pok = up.basenum
                    WHERE
                      up.id = '.intval($pokemonID).' AND
                      up.active = 1 AND
                      up.user_id = '.intval($_SESSION['id']).'
                ')->fetch_assoc();
				$pokTM = $mysqli->query('
									SELECT
									`attacks`
									FROM `user_pokemons_tm`
									WHERE `pok` = '.intval($pokemonID));
				if(!empty($pokemon)){
                    $attacks = explode(',', $pokemon['attacks']);
                    $lvl = explode(',', $pokemon['a_lvl']);

                    $countAtk = sizeof($attacks);

                    $atkListID = [];
                    $baseAtkList = [];

                    for($i=0; $i<=$countAtk; $i++){

                        if(isset($attacks[$i], $lvl[$i])){

                            if($lvl[$i] > $pokemon['lvl']){
                                continue;
                            }

                            $atkListID[] = intval($attacks[$i]);
                        }

                    }

					if(!empty($pokTM)){
						while($atkTM = $pokTM->fetch_assoc()){
							$atkListID[] = intval($atkTM['attacks']);
						}
					}
                    if(!empty($atkListID)){
                        $atkB = [];
						$baseAtk = $mysqli->query('SELECT
															*
														FROM base_atk
														WHERE id IN ('.implode(',', $atkListID).')');
						while($row = $baseAtk->fetch_assoc()){ $atkB[] = $row; }
						if(!empty($atkB)){
                            foreach($atkB AS $key=>$value){
                                $baseAtkList[$value['id']] = $value['name_rus'].','.$pokemonID.','.$atkNumb.','.$value['type'].','.$value['pp'].','.$value['category'].','.$value['id'];
                            }
                            //unset($key, $value);
                        }

                    }

                    $response['error'] = 0;
                    $response['text'] = $baseAtkList;
                    $response['attacks'] = $baseAtkList;
                }
            }
		break;
		case 'add':
			$positionAtk = $_POST['positionAtk'];
			$pokemon = $mysqli->query("SELECT `basenum`,`attacks`,`pp_attacks` FROM `user_pokemons` WHERE `id` = '".$pokemonID."' AND `active` = '1' AND `user_id` = '".$_SESSION['id']."'")->fetch_assoc();
			$atkNumb = clearInt($_POST['attackID']);
			$atkNumb = $mysqli->real_escape_string($atkNumb);
			$atkList = $mysqli->query("SELECT `attacks` FROM `base_attacks_pokemons` WHERE `pok` = '".$pokemon['basenum']."'")->fetch_assoc();
			$tmList = $mysqli->query("SELECT `id` FROM `user_pokemons_tm` WHERE `pok` = '".$pokemonID."' AND `attacks` = '".$atkNumb."'")->fetch_assoc();
			$attacks = explode(',',$atkList['attacks']);
			if(in_array($atkNumb,$attacks) || !empty($tmList['id'])){
				$pokAtk = explode(',',$pokemon['attacks']);
				if(in_array($atkNumb,$pokAtk)){
					$response['error'] = 1;
					$response['text'] = 'Данная атака уже изучена покемоном!';
				}else{
					$pokPPAtk = explode(',',$pokemon['pp_attacks']);
					$pokAtk[$positionAtk] = $atkNumb;
					$pokPPAtk[$positionAtk] = 0;
					$implodeAtk = implode(',',$pokAtk);
					$implodePPAtk = implode(',',$pokPPAtk);

					if(!empty($tmList['id'])){
						$mysqli->query('DELETE FROM `user_pokemons_tm` WHERE `id` = '.$tmList['id']);
					}
					$mysqli->query("UPDATE `user_pokemons` SET `attacks` = '".$implodeAtk."', `pp_attacks` = '".$implodePPAtk."' WHERE `id` = '".$pokemonID."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 1");
					$response['error'] = 0;
					$response['text'] = 'Атака успешно изучена!';
				}
			}else{
				$response['error'] = 1;
				$response['text'] = 'Ошибка';
			}
		break;
		default:
			echo 'Error';
		break;
	}
}
echo json_encode($response);
