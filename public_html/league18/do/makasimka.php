<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';

if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        _setError('The problem with the connection files.');
    }else{
        require_once($patch_global);
    }
}
ini_set('display_errors', 'ON');
error_reporting(E_ALL);
//(isset($_POST['']) ? $_POST[''] : null);

$_SESSION['id'] = (isset($_SESSION['id']) ? intval($_SESSION['id']) : 0);

$userInfo = $mysqli->query('SELECT * FROM `users` WHERE `id`='.$_SESSION['id'])->fetch_assoc();

$func_1 = function($resp = null){

    $info = [
        'snow_1'=>[
            'id'=>150,
            'name'=>'Ком снега',
            'count'=>item_isset(150, 1)
        ],
        'snow_2'=>[
            'id'=>151,
            'name'=>'Большой ком снега',
            'count'=>item_isset(151, 1)
        ]
    ];

    Work::_setStrongInfo([
        'inf_snowball'=>$info,
        'inf_count'=>(!is_null($resp) ? $resp : false)
    ]);
};

if(!empty($_POST['type']) && !empty($userInfo)){

    switch($_POST['type']){

        case 'offers':

            if($userInfo['status'] != 'free'){
                _setError('На данный момент вы не можете совершить это действие.');
            }


            $offerID = (isset($_POST['offerID']) ? intval($_POST['offerID']) : null);

            if($offerID && $offerID > 0){

                $info = Work::$sql->query('
                SELECT
                  `id`,
                  `type`,
                  `user_id`,
                  `touser_id`,
                  `hash`,
                  `info`
                FROM `user_notice`
                WHERE
                  `id` = '.$offerID.' AND
                    (
                        `user_id` = '.$_SESSION['id'].' OR
                        `touser_id` = '.$_SESSION['id'].'
                    )
            ')->fetch_assoc();

                if(!empty($info)){

                    Work::$sql->query('DELETE FROM `user_notice` WHERE `id` = '.intval($info['id']));

                    if(isset($_POST['confirmed']) && $_POST['confirmed'] > 0){

                        $userID = ($_SESSION['id'] == $info['user_id'] ? $info['touser_id'] : $info['user_id']);
                        $userTo =  Work::$sql->query('SELECT * FROM `users` WHERE `id` = '.$userID)->fetch_assoc();

                        if(!empty($userTo) && $userTo['status'] == 'free'){

                            if($userInfo['location'] != $userTo['location']){
                                _setError('Тренер слишком далеко!');
                            }

                            switch($info['type']){
                                case 'battle':

                                    //_setError('В разработке...');

                                    $info_1 = Info::_userInfoBattle($_SESSION['id'], 'pvp', [
                                        'uinfo'=>$userInfo
                                    ]);
                                    $info_2 = Info::_userInfoBattle($userID, 'pvp', [
                                        'uinfo'=>$userTo
                                    ]);

                                    if(empty($info_1)){
                                        _setError('У вас нет покемонов способных сражаться.');
                                    }
                                    if(empty($info_2)){
                                        _setError('У оппонента нет покемонов способных сражаться.');
                                    }
                                    $UserSelect = Work::$sql->query('SELECT location FROM users WHERE id = '.$info_1['userInfo']['id'].'')->fetch_assoc();
                                    $LocationSelect = Work::$sql->query('SELECT region, img_fight FROM base_location WHERE id = '.$UserSelect['location'].'')->fetch_assoc();
                                    $WeatherNum = Work::$sql->query('SELECT weather FROM base_region WHERE id = '.$LocationSelect['region'].'')->fetch_assoc();
                                    $imgFight = $LocationSelect['img_fight'];
                                    $info_1 = Info::_parseData($info_1);
                                    $info_2 = Info::_parseData($info_2);
                                    Work::$sql->query('INSERT INTO `battle`
                                                              (`user_1`,`user_2`,`info_1`,`info_2`,`type`,`weather`,`img`)
                                                       VALUES ('.$_SESSION['id'].', '.$userID.', "'.Work::$sql->real_escape_string($info_1).'", "'.Work::$sql->real_escape_string($info_2).'", "pvp", "'.$WeatherNum['weather'].'", "'.$imgFight.'")
                                                 ');

                                    break;
                                case 'trade':
                                    $mysqli->query("
                                        INSERT INTO
                                          `users_trade`
                                            (`user1`, `user2`, `status`)
                                        VALUE
                                            ('".$_SESSION['id']."', '".$userID."', 1)
                                    ");
                                    break;
                            }


                            Work::$sql->query('UPDATE `users` SET
                                  `status` = "'.$info['type'].'",
                                  `status_id` = '.intval(Work::$sql->insert_id).'
                                WHERE `id` IN ('.$info['user_id'].', '.$info['touser_id'].')
                                ');

                        }else{
                            _setError('Данный пользователь сейчас занят.');
                        }
                    }
                }
            }elseif($offerID == -1){
                $userID = (isset($_POST['userID']) ? intval($_POST['userID']) : null);

                if($userID && $userID > 0){
                    $userTo =  Work::$sql->query('SELECT `id`,`login`,`status` FROM `users` WHERE `id` = '.$userID)->fetch_assoc();
                    $target = (isset($_POST['target']) ? $_POST['target'] : 'default');

                    if(!in_array($target, ['battle', 'trade', 'zoogamy'])){
                        $target = 'default';
                    }

                    if(!empty($userTo)){
                        if($userTo['status'] == 'free'){
                            $hash = md5('u'.$_SESSION['id'].'-'.$target.'-'.'u'.$userID);

                            $check =  Work::$sql->query('SELECT `id` FROM `user_notice` WHERE `hash` = "'.$hash.'"')->fetch_assoc();
                            if(empty($check)){
                                Work::$sql->query('INSERT INTO `user_notice`
                                                              (`type`,`user_id`,`touser_id`,`hash`)
                                                       VALUES ("'.$target.'", '.$_SESSION['id'].', '.$userID.', "'.$hash.'")
                                                 ');

                                Work::_setInfo('offersCreate', 1);
                            }
                        }else{
                            _setError('Данный пользователь сейчас занят.');
                        }

                    }
                }
            }
            break;

        case 'battle':
            if($userInfo['status'] == 'battle'){
                $response = [];
                new ActionBattle($userInfo, [], $response);
                Work::_setStrongInfo($response);
            }
            break;

        case 'trade':
            if($userInfo['status'] == 'trade'){
                $response = [];
                new Trade($mysqli, $userInfo, $response);
                Work::_setStrongInfo($response);
            }
            break;

        case 'by_shop':
            $response = [];
            Info::_shableShop($_POST, $userInfo, $response);
            Work::_setStrongInfo($response);
            break;

        case 'view_shop':
            $response = [];
            Info::_shableShop((isset($_POST['npc']) ? intval($_POST['npc']) : 0), $userInfo, $response);
            Work::_setStrongInfo($response);
            break;

        case 'items':
            if(isset($_POST['cat'])){

                $response = [];

                $type = null;

                if($_POST['cat'] == 'ball'){
                    $type = 'ball';
                }

                if($type){
					$selInfo = [];
                    $sel = Work::$sql->query('
                        SELECT
                          `bi`.`name`,
                          `ui`.`id`,
                          `ui`.`count`
                        FROM `base_items` AS `bi`
                        INNER JOIN `items_users` AS `ui`
                          ON `ui`.`item_id` = `bi`.`id`
                        WHERE
                          `bi`.`type` = "ball" AND
                          `ui`.`user` = '.$_SESSION['id'].'
                          OR
                          `bi`.`type` = "potion" AND
                          `ui`.`user` = '.$_SESSION['id'].'
                    ');

					while($row = $sel->fetch_assoc()){ $selInfo[] = $row; }

                    if(!empty($selInfo)){
                        $response['ballList'] = $selInfo;

                        Work::_setStrongInfo($response);
                    }

                }

            }
            break;
/*
        case 'snowball':
            if(isset($_POST['view'])){
                $func_1();
            }elseif(isset($_POST['use'])){

                $_POST['use'] = intval($_POST['use']);

                $touser = (isset($_POST['touser']) ? intval($_POST['touser']) : 0);
                $checked = false;
                $countUse =  (isset($_POST['count']) ? intval(abs($_POST['count'])) : 1);
                $countItems = 0;

                if($touser == 52){
                    //_setError('Выбираемый абонент недоступен...');
                }

                if(isset($_POST['rand']) && $_POST['rand'] > 0){
                    if($countItems = item_isset(150, $countUse)){
                        $checked = true;
                        $_POST['use'] = 150;
                    }elseif($countItems = item_isset(151, $countUse)){
                        $checked = true;
                        $_POST['use'] = 151;
                    }else{
                        _setError('У вас нет снежков!');
                    }
                }

                if($touser > 0 && $touser != $_SESSION['id']){

                    if($_POST['use'] > 0 && in_array($_POST['use'], [150, 151])){

                        $countItems = item_isset($_POST['use'], $countUse);

                        if($checked || $countItems > 0){

                            minus_item($_POST['use'], $countUse);

                            $count = 1;
                            switch($_POST['use']){
                                case '150': $count = 1; break;
                                case '151': $count = mt_rand(2,3); break;
                            }
                            $count = $countUse * $count;

                            $check = $mysqli->query(' SELECT * FROM `snowballs` WHERE `user_id`='.$_SESSION['id'].' AND `touser`='.$touser )->fetch_assoc();

                            if(isset($check['count_ball'])){
                                $text = 'Пользователь: '.$userInfo['login'].' запустил в вас очередной ком снега ['.$countUse.']. Проявите и себя в отличном метании.';
                            }else{
                                $text = 'Пользователь: '.$userInfo['login'].' запустил в вас ком снега ['.$countUse.'].';
                            }


                            $mysqli->query( 'INSERT INTO `user_notice` (`type`, `user_id`, `touser_id`, `info`) VALUES (\'default\', '.$_SESSION['id'].', '.$touser.', "'.$mysqli->real_escape_string($text).'")');

                            if(!empty($check['count_ball'])){
                                $mysqli->query('
                               UPDATE `snowballs`
                               SET  `count_ball` = '.($check['count_ball'] + $count).'
                               WHERE
                                `user_id` = '.$_SESSION['id'].' AND
                                `touser`='.$touser
                                );
                            }else{
                                $mysqli->query('INSERT INTO `snowballs` (`user_id`,`count_ball`,`touser`) VALUES ('.$_SESSION['id'].', '.$count.', '.$touser.') ');
                            }

                            $func_1($countItems-$countUse);

                        }else{
                            _setError('У вас нет снежков!');
                        }

                    }
                }
            }
            break;*/
    }
}
Work::_viewOut();
