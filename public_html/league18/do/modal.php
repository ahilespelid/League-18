<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
if(!empty($patch_global))(!file_exists($patch_global) ?  die('The problem with the connection files.') : require_once($patch_global));
$patch_avatars = $patch_project.'/img/avatars/mini/'.$users['id'].'.png';
if(!file_exists($patch_avatars)){
	$avatarMini = "no-user-img";
}
$type = $_POST["type"];
$tab = intval($_POST["tab"]?$_POST["tab"]:1);
switch ($type) {
    case "nurseryGet":
        $basenum = clearInt($_POST['basenum']);
        $basenum = $mysqli->real_escape_string($basenum);
        $PokemonQuery = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `id` = '".$basenum."' AND `user_id` = '".$_SESSION['id']."' AND `active` = 0");
        $PokemonCount = $mysqli->query("SELECT `basenum` FROM `user_pokemons` WHERE `user_id` = '".$_SESSION['id']."' AND `active` = 1");
        if($PokemonQuery->num_rows < 1){
            $response['error'] = 1;
            $response['html'] = 'Ошибка получения покемонов!';
        }elseif($PokemonCount->num_rows > 5){
            $response['error'] = 1;
            $response['html'] = 'В вашей команде может быть только 6 покемонов!';
        }else{
            $PokemonQuery = $PokemonQuery->fetch_assoc();
            $mysqli->query("UPDATE `user_pokemons` SET `active` = 1 WHERE `user_id` = '".$_SESSION['id']."' AND `id` = '".$basenum."'");
            $response['error'] = 0;
            $response['html'] = 'Покемон успешно переведён в команду!';
            $response['basenum'] = $PokemonQuery['basenum'];
        }
        break;
    case "nurseryList":

        $basenum = clearInt($_POST['basenum']);
        $basenum = $mysqli->real_escape_string($basenum);
		$sort = (isset($_POST['sort']) ? $_POST['sort'] : 0);
		$sortNursery = ($sort == 0 ? '`up`.`lvl` DESC' : ($sort == 1 ? '`up`.`lvl`' : ($sort == 2 ? '`up`.`sparka`' : ($sort == 3 ? '`up`.`gender` DESC' : ($sort == 4 ? '`up`.`gender`' : ($sort == 5 ? '`up`.`sparka` DESC' : '`up`.`name_new`'))))));
        $PokemonQuery = $mysqli->query('
									SELECT
									  `up`.`id`,
									  `up`.`type`,
									  `up`.`name_new`,
									  `up`.`lvl`,
									  `up`.`gender`,
									  `up`.`sparka`,
									  `up`.`sparkaNumber`,
									  `up`.`gen`,
									  `up`.`character`,
									  `bp`.`name_rus`

									FROM `user_pokemons` AS `up`

									INNER JOIN `base_pokemons` AS `bp`
										ON
											`bp`.`id` = `up`.`basenum`
									WHERE
											`up`.`basenum` = '.$basenum.'
										AND
											`up`.`user_id` = '.$_SESSION['id'].'
										AND
											`up`.`active` = 0

											ORDER BY '.$sortNursery
									);

        if($PokemonQuery->num_rows < 1){
            $response['html'] = '<center>Список данных покемонов пуст</center>';
        }else{
            $pokList = [];
            while($pokemons = $PokemonQuery->fetch_assoc()){
                $pokList[] = [
								'id'			=>$pokemons['id'],
								'basenum'		=>numbPok($basenum),
								'type'			=>$pokemons['type'],
								'name'			=>($pokemons['name_new']?$pokemons['name_new']:$pokemons['name_rus']),
								'lvl'			=>$pokemons['lvl'],
								'gender'		=>$pokemons['gender'],
								'sparka'		=>$pokemons['sparka'],
								'sparkaNumber'	=>$pokemons['sparkaNumber'],
								'gen'			=>$pokemons['gen'],
								'character'		=>haracter_pokes($pokemons['character'])
							];
            }
            $response['html'] = $pokList;
        }

    break;
    case 'inventory':
		$user = $mysqli->query("SELECT `status`,`bagType`,`location` FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
		$eggsQuery = $mysqli->query('SELECT `ue`.*,`bp`.`name_rus` FROM `user_egg` AS `ue` INNER JOIN `base_pokemons` AS `bp` ON `bp`.`id` = `ue`.`basenum` WHERE `ue`.`user` = '.intval($_SESSION['id']).' AND `ue`.`reborn` > '.$time.'');
		$categoryItems = (isset($_POST['category']) && $_POST['category'] != 'all' ? 'AND `bi`.`type` = "'.$_POST['category'].'"' : '');
        $itemsQuery = $mysqli->query('SELECT `iu`.*, `bi`.`name`,`bi`.`about`,`bi`.`weight`,`bi`.`use`,`bi`.`dress`,`bi`.`drop`,`bi`.`trade`,`bi`.`give`,`bi`.`info` FROM `items_users` AS `iu` INNER JOIN `base_items` AS `bi` ON `bi`.`id` = `iu`.`item_id` '.$categoryItems.' WHERE `iu`.`user` = '.intval($_SESSION['id']).' ORDER BY `iu`.`id` ASC');
		$weight = 0;
		switch($user['bagType']){
            case 87:$weightMax = 500;break;
            case 85:$weightMax = 1000;break;
            case 88:$weightMax = 2500;break;
            case 84:$weightMax = 5000;break;
            case 89:$weightMax = 7500;break;
            case 90:$weightMax = 10000;break;
			case 99999:$weightMax = 10000000;break;
            default:$weightMax = 250;break;
        }
				$LocationNpcCount = $mysqli->query('SELECT `id` FROM `base_npc` WHERE `loc_id` = '.$user['location']);
		if($_POST['category'] == 'egg' || $_POST['category'] == 'all' || !isset($_POST['category'])){
			$eggList = [];
			while ($egg = $eggsQuery->fetch_assoc()){
				$gen = explode(',',$egg['gens']);
				$gen = '[h'.$gen[0].'a'.$gen[1].'d'.$gen[2].'s'.$gen[3].'sa'.$gen[4].'sd'.$gen[5].']';
				$month = array(1=>'Января',2=>'Февраля',3=>'Марта',4=>'Апреля',5=>'Мая',6=>'Июня',7=>'Июля',8=>'Августа',9=>'Сентября',10=>'Октября',11=>'Ноября',12=>'Декабря');
				$rebornEnd = $egg['reborn'] - $time;
				$reborn = date('j', $rebornEnd);
				$reborn = ($reborn > 0) ? 'Вылупится через '.$reborn.' дн.' : 'Готовиться к вылуплению...';
				$eggList[$egg['id']] = [
					'ctgMdl'=>$_POST['category'],
					'id'=>$egg['id'],
					'gen'=>'Генокод: '.$gen,
					'reborn'=>$reborn,
					'other'=>'54,1,0,false,false,false,true,false,false,\''.$user['status'].'\',true',
					'loc'=>$LocationNpcCount->num_rows,
					'name'=>$egg['name_rus'],
					'ustatus'=>$user['status']
				];
			}
		}
		// while ($items = $itemsQuery->fetch_assoc()){
			// $imgItem = ($items['item_id'] == '1' ? (item_isset(1,3000000) ? '1.2' : '1') : $items['item_id']);
			// $weight = $items['count']*$items['weight'] + $weight;
			// $itemList[$items['id']] = [
				// 'ctgMdl'=>$_POST['category'],
				// 'id'=>$items['id'],
				// 'name'=>($items['item_id'] == 10001 ? $items['name'].' №'.$items['json'] : $items['name']),
				// 'about'=>$items['about'],
				// 'img'=>$imgItem,
				// 'count'=>$items['count'],
				// 'itemWeight'=>$items['weight'],
				// 'use'=>$items['use'],
				// 'dress'=>$items['dress'],
				// 'drop'=>$items['drop'],
				// 'trade'=>$items['trade'],
				// 'give'=>$items['give'],
				// 'ustatus'=>$user['status'],
				// 'count2'=>number_format($items['count'],0,'.','.')
			// ];
		// }
		while($items = $itemsQuery->fetch_assoc()){
			if($items['item_id'] >= 1000001) {
				$mesto = explode(',',$items['info']);
			}
			$str = explode(',',$items['str']);
			$imgItem = ($items['item_id'] >= 1000001 ? $mesto[0].'.'.$mesto[1] : $items['item_id']);
            $weight = $items['count']*$items['weight'] + $weight;
			$tpll.= '<div class="Item" onclick="itemOpen(this,\''.$_POST['category'].'\','.$items['id'].',\''.($items['item_id'] == 10001 ? $items['name'].' №'.$items['json'] : $items['name']).'\',\''.$items['about'].'\','.$imgItem.','.$items['count'].','.$items['weight'].','.$items['use'].','.$items['dress'].','.$items['drop'].','.$items['trade'].','.$items['give'].',\'false\',\''.$user['status'].'\',false,'.$LocationNpcCount->num_rows.');">';
			$tpll.= '<img id="imgItem" src="/img/world/items/little/'.$imgItem.'.png" onerror="$(this).attr(\'src\',\'/img/world/items/little/0.png\');">';
			$tpll.= '<div class="Count">'.number_format($items['count'],0,'.','.').'</div> '.($items['str'] != NULL ? '<div class="Str">'.$str[0].'/'.$str[1].'</div>' : '').'</div>';
        }
		$mysqli->query('UPDATE `users` SET `weight` = '.$weight.' WHERE `id` = '.$_SESSION['id']);
        $bagName = $mysqli->query("SELECT `name` FROM `base_items` WHERE `id` = ".$user['bagType'])->fetch_assoc();
		$response['eggList'] = $eggList;
		//$response['itemList'] = $itemList;
		$response['bagName'] = $bagName['name'];
		$response['bagType'] = $user['bagType'];
		$response['bag'] = $weight;
		$response['bagMax'] = $weightMax;
        $response["html"] = $tpll;
        break;
    case 'dialogs':
			$Dialogs = $mysqli->query('SELECT
										`udl`.*,
										`u`.`login`,
										`u`.`user_group`
										FROM `user_dialogs_links` AS `udl`
										LEFT JOIN `users` AS `u`
										ON
											`u`.`id` != '.$_SESSION['id'].' AND `u`.`id` = `udl`.`sender`
										OR
											`u`.`id` != '.$_SESSION['id'].' AND	`u`.`id` = `udl`.`me`
										WHERE `udl`.`me`= '.$_SESSION['id'].' OR `udl`.`sender`= '.$_SESSION['id'].'  ORDER BY `date` DESC');
			if($Dialogs->num_rows < 1){
				$tpl .= '<center><b>У вас нет личных сообщений.</b></center>';
			}else{
				while($send = $Dialogs->fetch_assoc()){
					$tpl .= '<div class="user-link u-'.$send['user_group'].'">'.$send['login'].'</div><br />';
				}
			}
			$response["html"] = $tpl;
        break;
    case 'trainers':
        $users_list = "";
        $timeOnline = time() - 300;
        switch($tab){
            case 1:
				$friendsQueryNameInfo = [];
                $friendsQuery = $mysqli->query("SELECT `friend_id`,`user_id` FROM `users_friend` WHERE (`user_id`='".$_SESSION['id']."' OR `friend_id` = '".$_SESSION['id']."') AND `status`='1'");
                $users_list_id = [];

                while($friends = $friendsQuery->fetch_assoc()) {
                    $id = ($friends['user_id'] == $_SESSION['id'] ? $friends['friend_id'] : $friends['user_id']);
                    $users_list_id[] = $id;
                }

                if($users_list_id){

                    $friendsQueryName = $mysqli->query('
                        SELECT
                          `u`.`login`,
                          `u`.`user_group`,
                          `u`.`location`,
						  `u`.`id`,
                          `u`.`online`,
                          `bl`.`name`
                        FROM `users` AS `u`
                        LEFT JOIN `base_location` AS `bl`
                          ON `bl`.`id` = `u`.`location`
                        WHERE
                          `u`.`id` IN ('.implode(',', $users_list_id).')
                    ');
					while($row = $friendsQueryName->fetch_assoc()){ $friendsQueryNameInfo[] = $row; }
                    if(!empty($friendsQueryNameInfo)){
                        foreach($friendsQueryName AS $key=>$value){
							$patch_avatars = $patch_project.'/img/avatars/mini/'.$value["id"].'.png';
							if(!file_exists($patch_avatars)){
								$avatarMini = "no-user-img";
							}else{
								$avatarMini = $value["id"];
							}
                            $is_online = ($value['online'] >= $timeOnline) ? '<div class="Status onl"></div>' : '<div class="Status ofl"></div>';
							$users_list .= "<div class='Trainer'><div class='TrainerBlock'><div onclick=showUserTooltip('".$value["id"]."') class='Avatar' style='background-image: url(img/avatars/mini/".$avatarMini.".png);'>".$is_online."</div> <div class='Title'><div class='Name'><div class='u-".intval($value["user_group"])."'>".$value["login"]."</div></div><div class='Other'>".$value["name"]."</div></div></div></div>";
                        }
                        unset($key,$value);
                    }

                }

                break;

            case 2:

                $users_all = $mysqli->query('
                    SELECT
                      `u`.`login`,
                      `u`.`user_group`,
                      `u`.`location`,
					  `u`.`id`,
                      `u`.`online`,
                      `br`.`name`
                    FROM `users` AS `u`
                    INNER JOIN `base_region` AS `br`
                      ON `br`.`id` = (SELECT `region` FROM `base_location` AS `bl` WHERE `bl`.`id` = `u`.`location`)
                    WHERE
                      `u`.`online` >= '.time().' AND
                      `u`.`id` != 2 ORDER BY u.user_group ASC, u.id ASC
                ');

                while ($users = $users_all->fetch_assoc()) {
                    $is_online = ($users['online'] >= $timeOnline) ? '<div class="Status onl"></div>' : '<div class="Status ofl"></div>';
					$patch_avatars = $patch_project.'/img/avatars/mini/'.$users["id"].'.png';
					if(!file_exists($patch_avatars)){
						$avatarMini = "no-user-img";
					}else{
						$avatarMini = $users["id"];
					}
					$users_list .= "<div class='Trainer'><div class='TrainerBlock'><div onclick=showUserTooltip('".$users["id"]."') class='Avatar' style='background-image: url(img/avatars/mini/".$avatarMini.".png);'>".$is_online."</div> <div class='Title'><div class='Name'><div class='u-".intval($users["user_group"])."'>".$users["login"]."</div></div><div class='Other'>".$users["name"]."</div></div></div></div>";
                      }

                break;

            case 3:

                $users_all = $mysqli->query('
                    SELECT
                      `u`.`login`,
                      `u`.`user_group`,
                      `u`.`location`,
					  `u`.`id`,
                      `u`.`online`,
                      `br`.`name`
                    FROM `users` AS `u`
                    LEFT JOIN `base_region` AS `br`
                      ON `br`.`id` = (SELECT `region` FROM `base_location` AS `bl` WHERE `bl`.`id` = `u`.`location`)
                    WHERE
                      `u`.`user_group` = 1 AND
                      `u`.`id` != 2
                    ORDER BY `u`.`online` DESC
                ');

                while ($users = $users_all->fetch_assoc()){
                    $is_online = ($users['online'] >= $timeOnline) ? '<div class="Status onl"></div>' : '<div class="Status ofl"></div>';
                    $patch_avatars = $patch_project.'/img/avatars/mini/'.$users["id"].'.png';
					if(!file_exists($patch_avatars)){
						$avatarMini = "no-user-img";
					}else{
						$avatarMini = $users["id"];
					}
                    $users_list .= "<div class='Trainer'><div class='TrainerBlock'><div onclick=showUserTooltip('".$users["id"]."') class='Avatar' style='background-image: url(img/avatars/mini/".$avatarMini.".png);'>".$is_online."</div> <div class='Title'><div class='Name'><div class='u-".intval($users["user_group"])."'>".$users["login"]."</div></div><div class='Other'>".$users["name"]."</div></div></div></div>";
                }

                break;

            case 4:

                $users_all = $mysqli->query('
                    SELECT
                      `u`.`login`,
                      `u`.`user_group`,
                      `u`.`location`,
					  `u`.`id`,
                      `u`.`online`,
                      `br`.`name`
                    FROM `users` AS `u`
                    LEFT JOIN `base_region` AS `br`
                      ON `br`.`id` = (SELECT `region` FROM `base_location` AS `bl` WHERE `bl`.`id` = `u`.`location`)
                    WHERE
                      `u`.`user_group` = 5 AND
                      `u`.`id` != 2
                    ORDER BY `u`.`online` DESC
                ');

                while ($users = $users_all->fetch_assoc()){
                    $is_online = ($users['online'] >= $timeOnline) ? '<div class="Status onl"></div>' : '<div class="Status ofl"></div>';
                    $patch_avatars = $patch_project.'/img/avatars/mini/'.$users["id"].'.png';
					if(!file_exists($patch_avatars)){
						$avatarMini = "no-user-img";
					}else{
						$avatarMini = $users["id"];
					}
                    $users_list .= "<div class='Trainer'><div class='TrainerBlock'><div onclick=showUserTooltip('".$users["id"]."') class='Avatar' style='background-image: url(img/avatars/mini/".$avatarMini.".png);'>".$is_online."</div> <div class='Title'><div class='Name'><div class='u-".intval($users["user_group"])."'>".$users["login"]."</div></div><div class='Other'>".$users["name"]."</div></div></div></div>";
                }

                break;

            case 5:

                $users_all = $mysqli->query('
                    SELECT
                      `u`.`login`,
                      `u`.`user_group`,
                      `u`.`location`,
					  `u`.`id`,
                      `u`.`online`,
                      `br`.`name`
                    FROM `users` AS `u`
                    LEFT JOIN `base_region` AS `br`
                      ON `br`.`id` = (SELECT `region` FROM `base_location` AS `bl` WHERE `bl`.`id` = `u`.`location`)
                    WHERE
                      `u`.`user_group` = 2 AND
                      `u`.`id` != 2
                    ORDER BY `u`.`online` DESC
                ');

                while ($users = $users_all->fetch_assoc()){
                    $is_online = ($users['online'] >= $timeOnline) ? '<div class="Status onl"></div>' : '<div class="Status ofl"></div>';
                    $patch_avatars = $patch_project.'/img/avatars/mini/'.$users["id"].'.png';
					if(!file_exists($patch_avatars)){
						$avatarMini = "no-user-img";
					}else{
						$avatarMini = $users["id"];
					}
                    $users_list .= "<div class='Trainer'><div class='TrainerBlock'><div onclick=showUserTooltip('".$users["id"]."') class='Avatar' style='background-image: url(img/avatars/mini/".$avatarMini.".png);'>".$is_online."</div> <div class='Title'><div class='Name'><div class='u-".intval($users["user_group"])."'>".$users["login"]."</div></div><div class='Other'>".$users["name"]."</div></div></div></div>";
								}

                break;

            case 6:

                $users_all = $mysqli->query('
                    SELECT
                      `u`.`login`,
                      `u`.`user_group`,
                      `u`.`location`,
					  `u`.`id`,
                      `u`.`online`,
                      `br`.`name`
                    FROM `users` AS `u`
                    LEFT JOIN `base_region` AS `br`
                      ON `br`.`id` = (SELECT `region` FROM `base_location` AS `bl` WHERE `bl`.`id` = `u`.`location`)
                    WHERE
                      `u`.`user_group` = 3 AND
                      `u`.`id` != 2
                    ORDER BY `u`.`online` DESC
                ');

                while ($users = $users_all->fetch_assoc()){
                    $is_online = ($users['online'] >= $timeOnline) ? '<div class="Status onl"></div>' : '<div class="Status ofl"></div>';
                    $patch_avatars = $patch_project.'/img/avatars/mini/'.$users["id"].'.png';
					if(!file_exists($patch_avatars)){
						$avatarMini = "no-user-img";
					}else{
						$avatarMini = $users["id"];
					}
$users_list .= "<div class='Trainer'><div class='TrainerBlock'><div onclick=showUserTooltip('".$users["id"]."') class='Avatar' style='background-image: url(img/avatars/mini/".$avatarMini.".png);'>".$is_online."</div> <div class='Title'><div class='Name'><div class='u-".intval($users["user_group"])."'>".$users["login"]."</div></div><div class='Other'>".$users["name"]."</div></div></div></div>";
										  }

                break;

            case 7:

                $users_all = $mysqli->query('
                    SELECT
                      `u`.`login`,
                      `u`.`user_group`,
                      `u`.`location`,
					  `u`.`id`,
                      `u`.`online`,
                      `br`.`name`
                    FROM `users` AS `u`
                    LEFT JOIN `base_region` AS `br`
                      ON `br`.`id` = (SELECT `region` FROM `base_location` AS `bl` WHERE `bl`.`id` = `u`.`location`)
                    WHERE
                      `u`.`user_group` = 4 AND
                      `u`.`id` != 2
                    ORDER BY `u`.`online` DESC
                ');

                while ($users = $users_all->fetch_assoc()){
                    $is_online = ($users['online'] >= $timeOnline) ? '<div class="Status onl"></div>' : '<div class="Status ofl"></div>';
                    $patch_avatars = $patch_project.'/img/avatars/mini/'.$users["id"].'.png';
					if(!file_exists($patch_avatars)){
						$avatarMini = "no-user-img";
					}else{
						$avatarMini = $users["id"];
					}
                    $users_list .= "<div class='Trainer'><div class='TrainerBlock'><div onclick=showUserTooltip('".$users["id"]."') class='Avatar' style='background-image: url(img/avatars/mini/".$avatarMini.".png);'>".$is_online."</div> <div class='Title'><div class='Name'><div class='u-".intval($users["user_group"])."'>".$users["login"]."</div></div><div class='Other'>".$users["name"]."</div></div></div></div>";
								}

                break;

            case 9:

                $search = trim($_POST['text']);
                $search = htmlspecialchars($search);

                $usersQuery = $mysqli->query('
                    SELECT
                      `u`.`login`,
                      `u`.`user_group`,
                      `u`.`location`,
					  `u`.`id`,
                      `u`.`online`,
                      `br`.`name`
                    FROM `users` AS `u`
                    LEFT JOIN `base_region` AS `br`
                      ON `br`.`id` = (SELECT `region` FROM `base_location` AS `bl` WHERE `bl`.`id` = `u`.`location`)
                    WHERE
                      `u`.`login` LIKE "%'.$search.'%" AND
                      `u`.`id` != 2
                    ORDER BY `u`.`online` DESC
                ');
                while($users = $usersQuery->fetch_assoc()) {
                    $is_online = ($users['online'] >= $timeOnline) ? '<div class="Status onl"></div>' : '<div class="Status ofl"></div>';
                    $patch_avatars = $patch_project.'/img/avatars/mini/'.$users["id"].'.png';
					if(!file_exists($patch_avatars)){
						$avatarMini = "no-user-img";
					}else{
						$avatarMini = $users["id"];
					}
                    $users_list .= "<div class='Trainer'><div class='TrainerBlock'><div onclick=showUserTooltip('".$users["id"]."') class='Avatar' style='background-image: url(img/avatars/mini/".$avatarMini.".png);'>".$is_online."</div> <div class='Title'><div class='Name'><div class='u-".intval($users["user_group"])."'>".$users["login"]."</div></div><div class='Other'>".$users["name"]."</div></div></div></div>";
								}

                break;

            default:
                $js.="$.notify({message: 'Ошибка в выполнении скрипта. Перезагрузите страницу.'},{type: 'danger',placement: {from: 'top',align: 'right'}});";
                break;
        }

        if($users_list==""){
            $users_list.="<div class='unknown'>Категория пуста</div>";
        }
		if($tab != 9){
			 $tpl = '<div class="Title"><div class="Name">Тренеры</div><div class="Close" onclick="closeModal()"><i class="fa fa-close"></i></div></div><div class="Trainers"><div class="Category">
						<div class="Button '.($tab == 1 ? 'active' : '').'" onclick="setTab(this,1);">Друзья</div>
						<div class="Button '.($tab == 2 ? 'active' : '').'" onclick="setTab(this,2);">Онлайн</div>
						<div class="Button '.($tab == 3 ? 'active' : '').'" onclick="setTab(this,3);">Администраторы</div>
						<div class="Button '.($tab == 4 ? 'active' : '').'" onclick="setTab(this,4);">Лидеры Стадионов</div>
						<div class="Button '.($tab == 5 ? 'active' : '').'" onclick="setTab(this,5);">Полиция</div>
						<div class="Button '.($tab == 6 ? 'active' : '').'" onclick="setTab(this,6);">Модераторы</div>
						<div class="Button '.($tab == 7 ? 'active' : '').'" onclick="setTab(this,7);">Наставники</div>
						<input type="text" placeholder="Найти тренера.." id="searchUser" onkeydown="if(event.keyCode == 13){searchUser();}">
					</div>';
		}
		if($tab == 9){
			$tpl .= ''.$users_list.'</div>';
		}else{
			$tpl .= '<div class="List">'.$users_list.'</div></div>';
		}

        $response["title"] = "Тренеры";
        $response["html"] = $tpl;
        break;
    case 'clans':
        $clans = $mysqli->query("SELECT * FROM `base_clans` ORDER BY `rating`");
		$i = 1;
		while($clan = $clans->fetch_assoc()){
			$info = json_decode($clan['info']);
			$mysqli->query('UPDATE `base_clans` SET `position` = '.$i.' WHERE `id` = '.$i);
			$clansList[$clan['id']] = [
				'id'=>$clan['id'],
				'name'=>$info->name,
				'rating'=>$clan['rating']
			];
			$i++;
		}
		$response['clansList'] = $clansList;
        break;
    case 'diary':
		switch($_POST['category']){
			case 'quests':
				$questList = [];
				$questQuery = $mysqli->query("SELECT `id` FROM `base_quest`");
				while ($quest = $questQuery->fetch_assoc()){
					$questQuery1 = $mysqli->query("SELECT * FROM `user_quests` WHERE `quest_id` = ".$quest['id']." AND `user_id` = ".$_SESSION['id'])->fetch_assoc();
					if(isset($questQuery1)) {
						if($questQuery1['end'] == 1) {
							$checkq = 1;
						}else{
							$checkq = 2;
						}
					}else{
						$checkq = 0;
					}
					$questList[$quest['id']] = [
						'id'=>$quest['id'],
						'name'=>quest_info($quest['id'],'name'),
						'check' => $checkq
					];
				}
				$response['questList'] = $questList;
			break;
			case 'questsList':
				$questList = [];
				$questID = (isset($_POST['pokID']) ? clearInt($_POST['pokID']) : 1);
				$questA = $mysqli->query('SELECT * FROM `quest_steps` WHERE `quest_id` = '.$questID.' AND `id_user` = '.$_SESSION['id']);
				$questB = $mysqli->query('SELECT * FROM `base_quest` WHERE `id` = '.$questID)->fetch_assoc();
				while ($quest = $questA->fetch_assoc()){
					$questList[$quest['id']] = [
						'step'=>$quest['quest_step'],
						'text'=>$quest['text']
					];
				}
				$response['questList'] = $questList;
				$response['progress'] = quest_isset_book($questID);
				$response['id'] = $questID;
				$response['name'] = $questB['name'];
			break;
			case 'news':
				$newsA = $mysqli->query('SELECT * FROM `friends_news` ORDER BY `id` DESC');
				while($news = $newsA->fetch_assoc()) {
					$friend = $mysqli->query("SELECT * FROM `users_friend` WHERE (`user_id` = '".$_SESSION['id']."' AND `friend_id` = '".$news['user']."') OR (`user_id` = '".$news['user']."' AND `friend_id` = '".$_SESSION['id']."')");
					if($friend->num_rows > 0 || $news['user'] == $_SESSION['id']) {
						$newsBook .= '<div class="New">'.$news['text'].'<div class="TimeBook">'.date('d.m.Y',$news['date']).'г.</div></div>';
					}
				}
				$response['newsBook'] = $newsBook;
			break;
			case 'raid':
				$raids = $mysqli->query('SELECT * FROM `base_raids`');
				while ($r = $raids->fetch_assoc()){
					$userIDtime = '1000000'.$r['id'];
					$tme = $mysqli->query("SELECT * FROM base_npc_data WHERE userID = ".$_SESSION['id']." AND npcID = ".$userIDtime)->fetch_assoc();
					if($tme) {
						$tme1 = '<span>Откроется '.date('d.m.Y',$tme['time']).'</span>';
					}else{
						$tme1 = '';
					}
					$a .= '
					<div class="Raid">
					<div class="Stepses">'.$r['loc'].'<br>'.$tme1.'</div>
					<div class="Image" style="background-image: url(/img/world/raids/'.$r['id'].'.png);"></div>
					<div class="Name">'.$r['name'].'</div>
					</div>
					';
				}
				$response['html'] = $a;
			break;
			case 'location':
				$pokList = [];
				$user = $mysqli->query('SELECT * FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
				$q = $mysqli->query('SELECT * FROM `base_location` WHERE `id` = '.$user['location'])->fetch_assoc();
				$g = $mysqli->query('SELECT * FROM `base_region` WHERE `id` = '.$q['region'])->fetch_assoc();
				if($g['weather'] == 1) {
					$n = 'Обычная<br>Смена погоды в '.date("H:i",$g['weather_time']);
				}elseif($g['weather'] == 2) {
					$n = 'Солнечно<br>Смена погоды в '.date("H:i",$g['weather_time']);
				}elseif($g['weather'] == 3) {
					$n = 'Дождь<br>Смена погоды в '.date("H:i",$g['weather_time']);
				}elseif($g['weather'] == 4) {
					$n = 'Град<br>Смена погоды в '.date("H:i",$g['weather_time']);
				}elseif($g['weather'] == 5) {
					$n = 'Песчаная буря<br>Смена погоды в '.date("H:i",$g['weather_time']);
				}else{
					$n = 'Неизвестная погода';
				}
				$response['htmlWeather'] = '<div>'.$q['name'].'</div><img src="/img/weather/'.$g['weather'].'.png"><span>'.$n.'</span>';
				$a = $mysqli->query('SELECT * FROM pokemons_location WHERE location_id = '.$user['location']);
				while ($pok = $a->fetch_assoc()){
					$b_pok = $mysqli->query('SELECT * FROM `base_pokemons` WHERE `id` = '.$pok['basenum'])->fetch_assoc();
					$lvl = explode(',',$pok['lvl']);
					if($pok['basenum'] <= 9) {
						$num = '00'.$pok['basenum'];
					}elseif($pok['basenum'] >= 10 && $pok['basenum'] <= 99) {
						$num = '0'.$pok['basenum'];
					}else{
						$num = $pok['basenum'];
					}
					if($pok['catch'] == 0) {
						$catch = 'noCatch';
					}else{
						$catch = '';
					}
					$pokList[$pok['id']] = [
						'catch'=>$catch,
						'num'=>$num,
						'name'=>$b_pok['name_rus'],
						'lvl1'=>$lvl[0],
						'lvl2'=>$lvl[1],
						'drop'=>$pok['text_drop'],
						'c_con'=>$pok['text_catch_condition'],
						'time'=>$pok['text_time'],
						'hide'=>$pok['hide_loc']
					];
				}
				$response['pokList'] = $pokList;
			break;
		}
        break;
		case 'loca':
			$loca1 = $mysqli->query('SELECT
										`bl`.`id`,
										`bl`.`name`,
										`bl`.`pve`
										FROM `base_location` AS `bl`
										INNER JOIN `users` AS `u`
										ON
											`u`.`id` = '.$_SESSION['id'].'
										WHERE `bl`.`id` = `u`.`location`')->fetch_assoc();
			$pok = $mysqli->query('SELECT
									`pl`.`basenum`,
									`pl`.`lvl`,
									`pl`.`catch`,
									`bp`.`id`,
									`bp`.`name_rus`
									FROM `pokemons_location` AS `pl`
									INNER JOIN `base_pokemons` AS `bp`
									ON
										`bp`.`id` = `pl`.`basenum`
									WHERE
										`pl`.`location_id` = '.$loca1['id'].'
									OR
										`pl`.`location_id` = 0
											ORDER BY `pl`.`location_id` DESC');
			$response["title"] = "Покебук";
        $tpl.= '
		<div class="DivBook">
			<div class="BookCategory">
				<div onclick=openModal("diary") class="ctgBook">Задания</div>
				<div class="ctgBook">Заметки</div>
				<div onclick=openModal("loca") class="ctgBook active">Локация</div>
			</div>
			<div class="locationAny">
				<div class="Name">'.$loca1['name'].'</div>
				<div class="Other">Покемоны</div>';
				if($loca1['pve'] >= 1){
					while($a = $pok->fetch_assoc()){
						$c = $mysqli->query("SELECT `pok_num`,`item_id` FROM `base_drop_pokemons` WHERE `pok_num` = '".$a['basenum']."' AND `location_id` = ".$loca1['id']." AND `quest_id` = 0")->fetch_assoc;
						if($c['pok_num'] == $a['basenum']){
							$tpl .= '<div class="pok lov'.$a['catch'].'">
								<img src="/img/pokemons/anim/normal/'.$a['id'].'.gif"> '.$a['name_rus'].' '.str_replace(",", " - ",$a['lvl']).' ур. <div class="itemIsset" onclick="issetAll('.$c['item_id'].',\'item\')" style="background-image: url(/img/world/items/little/'.$c['item_id'].'.png)"></div>
							</div>';
						}else{
							$tpl .= '<div class="pok lov'.$a['catch'].'">
								<img src="/img/pokemons/anim/normal/'.$a['id'].'.gif"> '.$a['name_rus'].' '.str_replace(",", " - ",$a['lvl']).' ур.
							</div>';
						}
					}
				}else{
					$tpl .= '<div class="pok">Покемоны не обитают</div>';
				}
			$tpl.= '</div></div>';
        $response["html"] = $tpl;
        break;
		case 'craft':
        $tpl.= '<div class="Title"><div class="Name">Крафт</div><div class="Close" onclick="closeModal()"><i class="fa fa-close"></i></div></div><div class="DivCraft">
			<div class="CraftCategory">
				<div class="Button cookery" onclick="craftCategory(\'cookery\')">Кулинария</div>
				<div class="Button alchemy" onclick="craftCategory(\'alchemy\')">Алхимия</div>
				<div class="Button sewing" onclick="craftCategory(\'sewing\')">Шитье</div>
				<div class="Button engineering" onclick="craftCategory(\'engineering\')">Инженерия</div>
				<div class="Button pokeballs" onclick="craftCategory(\'pokeballs\')">Покеболы</div>
				<div class="Button medicine" onclick="craftCategory(\'medicine\')">Медицина</div>
				<div class="Button magic" onclick="craftCategory(\'magic\')">Магия</div>
			</div>
			<div class="CraftContent">
				<div class="preview">Начните создавать себе предметы при помощи <b>Крафта</b>, выбрав категорию.</div>
			</div>
			<div class="CraftItemNow"></div></div>';
		$response["html"] = $tpl;
		break;
		//case 'discovery':
			//$response["title"] = "Добыча предметов";
				//$UserQuery = $mysqli->query("SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'")->fetch_assoc();
				//$tpl.= '<div class="DivCraft">
				//<div class="CraftCategory">
				//	<div class="ctgCraft ore" onclick="discoveryCategory(\'ore\')">Руды</div>
				//	<div class="ctgCraft food" onclick="discoveryCategory(\'food\')">Еда</div>
				//	<div class="ctgCraft seed" onclick="discoveryCategory(\'seed\')">Семена</div>
				//</div>
				//<div class="CraftContent">
			//		<div class="preview">Начните добывать себе предметы, выбрав категорию.<br><div onclick="openModal(\'craft\')">Крафт</div> <div onclick="discoveryCategory(\'mypok\')">Покемоны добытчики</div></div>
			//	</div>
			//	<div class="CraftItemNow"></div></div>';
			//$response["html"] = $tpl;
        //break;
    // case 'map':
        // $response["title"] = "Аквабук";
        // $tpl .= '<div class="tr-but">';
		// $tpl .=	'<div>Канто</div>';
		// $tpl .=	'<div>Джото</div>';
		// $tpl .=	'<div>Хоэнн</div>';
		// $tpl .=	'<div>О-ва Севии</div>';
		// $tpl .=	'<div>Синно</div>';
		// $tpl .=	'<div>Юнова</div>';
		// $tpl .=	'<div>Калос</div>';
		// $tpl .=	'</div>';
		// $tpl .=	'<div class="map-preview"></div>';
        // $response["html"] = $tpl;
        // break;
    case 'AquaRits':
        $thingList = [];
		$items = [];
		$aquarits = $mysqli->query('SELECT count FROM items_users WHERE user = '.$_SESSION['id'].' AND item_id = 43')->fetch_assoc();
		$things = $mysqli->query('SELECT a.id, a.price, a.about, bi.name, bi.id item FROM aquarits a INNER JOIN base_items bi ON a.item = bi.id');
		while ($thing = $things->fetch_assoc()){
			$items[$thing['id']] = [
				'id'	=> $thing['id'],
				'item'	=> $thing['item'],
				'price'	=> $thing['price'],
				'about'	=> $thing['about'],
				'name'	=> $thing['name']
			];
		}
		$count = is_null($aquarits['count']) ? 0 : (int)$aquarits['count'];

		$response = [
			'html'		=> 'Покупка Жемчуга является добровольной. Администрация League 18 не заставляет Вас покупать их и не несет ответственность за плательщика. Покупка Жемчуга за реальные деньги оценивается как пожертвование проекту League 18.<br><br>Купить Жемчуг можно в оффлайн режиме, пополнив баланс на определённую сумму и указав свой ник в игре <b>ЗДЕСЬ</b> - <a target="_blank" href="https://qiwi.me/league18">КЛАЦ</a>.<br>Если данный метод Вам не подходит, вы можете отписать Администрации игры <a target="_blank" href="https://vk.com/fionix">в соц. сетях</a>.<br><b>Расценки: 1 жемчуг = 10 рублей | 55,5 тенге.<br>На данный момент у вас '.$count.' шт. Жемчуга</b>',
			'items'		=> $items,
		];
        break;
    case 'clanCard':
        $clanID = clearInt($_POST['id']);
        $info = $mysqli->query('SELECT `info`,`position`,`rating` FROM `base_clans` WHERE  `id` = '.$clanID)->fetch_assoc();
		$userClanMy = $mysqli->query('SELECT * FROM `base_clans_users` WHERE  `user_id` = '.$_SESSION['id'])->fetch_assoc();
		if($userClanMy){
			$a = $userClanMy['clan_id'];
			$b = $userClanMy['group'];
		}
        $usersList = $mysqli->query('SELECT
									`bsu`.*,
									`u`.`login`,
									`u`.`user_group`
									FROM `base_clans_users` AS `bsu`
									INNER JOIN `users` AS `u`
										ON
											`u`.`id` = `bsu`.`user_id`
									WHERE
										`bsu`.`clan_id` = '.$clanID);
        if($usersList->num_rows > 0){
            while($users = $usersList->fetch_assoc()){
                $usersData[$users['user_id']] .= $users['login'].','.$users['user_group'].','.$users['raiting'].','.$users['status'].','.$users['group'].','.$clanID.','.$a.','.$b;
			}
            $logs = $mysqli->query("SELECT * FROM `log_game` WHERE  `user_id` = '".$clanID."' AND `type` = 'clan' ORDER BY `id` DESC");
            $i = 0;
            while($logClan = $logs->fetch_assoc()){
                $log[$i] = array(
                    'type'=>$logClan['title'],
                    'info'=>$logClan['info']
                );
                $i++;
            }

            $response['users'] = $usersData;
            $response['info'] = $info['info'];
            $response['rating'] = $info['rating'];
            $response['position'] = $info['position'];
            $response['log'] = $log;
            $response['countUsers'] = $usersList->num_rows;
        }else{
            $response['text'] = 'Данный клан пустой!';
        }
        break;
		case 'clanCardControl':
        $clanID = clearInt($_POST['id']);
		$user = $mysqli->query("SELECT * FROM `users` WHERE  `id` = ".$_SESSION['id'])->fetch_assoc();
		$userClan = $mysqli->query("SELECT * FROM `base_clans_users` WHERE  `user_id` = ".$_SESSION['id'])->fetch_assoc();
		$a .= "<div class='header'>Управление кланом<span onclick='$(\".model\").remove();'><i class='fa fa-close'></i></span></div>";
		$a .= "<div class='content-model' style='padding: 5px;'>";
		if($userClan){
			if($userClan['group'] == 1){
				$a .= "<div class='clanControlTitle'>Описание клана</div>";
				$a .= "<div class='clanControlContent'>";
				$a .= "<div class='left'>Описание</div><div class='right'><input type='text' placeholder='Описание...' id='clanAbout'></div>";
				$a .= "</div>";
				$a .= "<div class='mn-btn' style='margin-left: 5px;' onclick='actionClan(\"clanAbout\")'>Сохранить</div>";
				$a .= "<div class='clanControlTitle'>Лидеры</div>";
				$a .= "<div class='clanControlContent'>";
				$a .= "<div class='left'>Добавить в лидеры</div><div class='right'><input type='text' placeholder='Имя тренера...' id='goLeaderClan'></div>";
				$a .= "</div>";
				$a .= "<div class='mn-btn' style='margin-left: 5px;' onclick='upgradeClan(\"goLeaderClan\")'>Добавить</div>";
				$a .= "<div class='clanControlContent'>";
				$a .= "<div class='left'>Исключить из лидеров</div><div class='right'><input type='text' placeholder='Имя тренера...' id='goUnleaderClan'></div>";
				$a .= "</div>";
				$a .= "<div class='mn-btn' style='margin-left: 5px;' onclick='upgradeClan(\"goUnleaderClan\")'>Исключить</div>";
				$a .= "<div class='clanControlTitle'>Звания</div>";
				$a .= "<div class='clanControlContent'>";
				$a .= "<div class='left'>Дать звание</div><div class='right'><input type='text' placeholder='Имя тренера...' id='goStatusClanLogin'><input type='text' placeholder='Звание...' id='goStatusClanText'></div>";
				$a .= "</div>";
				$a .= "<div class='mn-btn' style='margin-left: 5px; margin-bottom: 5px;' onclick='upgradeClan(\"goStatusClan\")'>Добавить</div>";
				$a .= "<div class='clanControlTitle'>Прочее</div>";
				$a .= "<div class='clanControlContent'>";
				$a .= "<div class='left'>Исключить из клана</div><div class='right'><input type='text' placeholder='Имя тренера...' id='goDeleteClan'></div>";
				$a .= "</div>";
				$a .= "<div class='mn-btn' style='margin-left: 5px; margin-bottom: 5px;' onclick='upgradeClan(\"goDeleteClan\")'>Исключить</div>";
				$a .= "<div class='clanControlContent'>";
				$a .= "<div class='left'>Сделать объявление</div><div class='right'><input type='text' placeholder='Текст...' id='goNotifyClan'></div>";
				$a .= "</div>";
				$a .= "<div class='mn-btn' style='margin-left: 5px; margin-bottom: 5px;' onclick='upgradeClan(\"goNotifyClan\")'>Готово</div>";
			}else{
				$a .= "<div class='txtCM'>Вы не лидер клана.</div>";
			}
		}else{
			$a .= "<div class='txtCM'>Вы не состоите в клане.</div>";
		}
		$a .= "</div>";
        $response['html'] = $a;
        break;
	case 'giveEggNpc':
			$locationNPC = $mysqli->query('SELECT
                      `bn`.`id`,
                      `bn`.`name`
                    FROM `base_npc` AS `bn`
                    LEFT JOIN `users` AS `u`
                      ON `bn`.`loc_id` = `u`.`location`
                    WHERE
                      `u`.`id` = '.$_SESSION['id']
				);
			if(empty($locationNPC)){
				$response['error'] = 1;
			}else{
				$response['npc'] = [];
				while($npc = $locationNPC->fetch_assoc()){
					$response['npc'][] = [
										'id'	=>$npc['id'],
										'name'	=>$npc['name']
									];
			}
		}
		break;
    default:
        echo "Unknown error";
    break;
}
echo json_encode($response);
?>
