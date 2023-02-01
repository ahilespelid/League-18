<?php
class Info{

    private static $userCache = [];

    const BASE_INFO = '
            `bp`.`name_rus` AS `base_name`,
            `bp`.`hp` AS `base_hp`,
            `bp`.`atk` AS `base_atk`,
            `bp`.`satk` AS `base_satk`,
            `bp`.`def` AS `base_def`,
            `bp`.`sdef` AS `base_sdef`,
            `bp`.`spd` AS `base_spd`,
            `bp`.`type` AS `base_type`,
            `bp`.`type_two` AS `base_type_two`,
            `bp`.`power_category` AS `base_power_category`,
            `bp`.`exp_group` AS `base_exp_group`,
            `bp`.`evol_lvl` AS `base_evol_lvl`,
            `bp`.`evol_type` AS `base_evol_type`,
            `bp`.`evol_basenum` AS `base_evol_basenum`,
            `bp`.`height` AS `base_height`,
            `bp`.`weight` AS `base_weight`
    ';

    public static function _parseData(array $data = [], $void = true){
        $return = false;
        if(!empty($data)){
            try{
                if(function_exists('json_encode')){
                    $return = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                }else{
                    $return = serialize($data);
                }
            }catch (Exception $e){
                $return = '{"void":true}';
            }
        }
        return ($return ? $return : ($void ? '{"void":true}' : '{}'));
    }

    public static function btw($b1){
        $b1 = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $b1);
        $b1 = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $b1);
        return trim($b1);
    }

    public static function _unParseData($data = null){
        $return = [];
        if(!empty($data)){
            if(is_string($data) && (strpos($data, '{') !== false || strpos($data, '[') !== false)){
                try{
                    $data = self::btw($data);
                    if(function_exists('json_decode')){
                        $return = json_decode($data, true, 512, JSON_BIGINT_AS_STRING);
                    }else{
                        $return = unserialize($data);
                    }
                }catch (Exception $e){
                    $return = [];
                }
            }elseif(is_array($data)){
                return $data;
            }
        }
        return ($return ? $return : []);
    }

    public static function _logGame($user_id, $title, $info = [], $type = 'other'){

        if(Work::$sql){

            $typeList = ['items', 'poke', 'trade', 'other'];

            if(in_array($type, $typeList)){

                $info = array_merge([
                    'number'=>0,
                    'count'=>1
                ], $info);

                $info = self::_parseData($info);

                Work::$sql->query('
                      INSERT INTO
                        `log_game`
                             (`user_id`,`type`,`title`,`info`)
                      VALUES ('.intval($user_id).', "'.Work::$sql->real_escape_string($type).'", "'.Work::$sql->real_escape_string($title).'", "'.Work::$sql->real_escape_string($info).'")
                ');


            }

        }



    }

    public static function _userInfoBattle($userID, $type = 'pve', array $option = []){

        if(Work::$sql && is_numeric($userID) && $userID >= 0){

            $userID = intval($userID);

            $type = ($type ? $type : 'pve');

            $target = 0;

            if(isset($option['npc'])){
                $pokeUser = $option['npc'];
            }else{
                $pokeUser = self::_getPokeUserBattle($userID);
            }

            if(!empty($pokeUser)){

                $pokeUserInfo = [];

                if(isset($option['npc'])){
                    $id = 0;
                    foreach($option['npc'] AS $key=>$value){
                        ++$id;
                        if(isset($value['basenum'])){
                            $baseInfo = Work::$sql->query('
                                                              SELECT

                                                                `bp`.`name_rus` AS `name_new`,
                                                                `bp`.`sex_m` AS `base_sex_m`,
                                                                `bp`.`sex_f` AS `base_sex_f`,

                                                                '.self::BASE_INFO.'

                                                              FROM `base_pokemons` AS `bp`

                                                              WHERE `bp`.`id` = '.$value['basenum'].'

                                                        ')->fetch_assoc();

                            if(empty($baseInfo)){
                                continue;
                            }

                            $atk = (isset($value['atk_list']) ? $value['atk_list'] : self::_generateAtkListPoke($value['basenum'], $value['lvl']));

                            if(empty($atk)){
                                continue;
                            }

                            if(!$target){
                                $target = $id;
                            }
							$Bonus = Work::$sql->query('
                                          SELECT  `shine`
                                          FROM `system`
                                          WHERE `id` = '.intval(1).'
							')->fetch_assoc();
							$BonusItemShine = Work::$sql->query('
                                          SELECT  `id`
                                          FROM `items_users`
                                          WHERE `item_id` = '.intval(2).' AND `user` = '.intval($_SESSION['id']).'
							')->fetch_assoc();
              $BonusLearn = Work::$sql->query('
                                          SELECT  *
                                          FROM `learn_pve`
                                          WHERE `user` = '.$_SESSION['id'].' AND `type` = 1
              ')->fetch_assoc();
              $BonusLearn = (!empty($BonusItemShine['id']) ? 10 : 1);
							$BunusItem = (!empty($BonusItemShine['id']) ? 10 : 1);
							$ShineChanse = ((10 * $Bonus['shine']) + $BunusItem + $BonusLearn);
              $randShin = mt_rand(1,11000);
							if($randShin < $ShineChanse){
								if(isset($value['gen']) && $value['gen'] && is_string($value['gen'])){
									$explode = explode(',',$value['gen']);
                  $explode[0] = $explode[0] + 5;
                  $explode[1] = $explode[1] + 5;
                  $explode[2] = $explode[2] + 5;
                  $explode[3] = $explode[3] + 5;
                  $explode[4] = $explode[4] + 5;
                  $explode[5] = $explode[5] + 5;
                  $value['gen'] = implode(',',$explode);
									// $explode[0] += ($explode[0] <= 15 ? mt_rand(10,12) : ($explode[0] <= 20 ? mt_rand(6,8) : mt_rand(4,6)));
									// $explode[1] += ($explode[1] <= 15 ? mt_rand(10,12) : ($explode[0] <= 20 ? mt_rand(6,8) : mt_rand(4,6)));
									// $explode[2] += ($explode[2] <= 15 ? mt_rand(10,12) : ($explode[0] <= 20 ? mt_rand(6,8) : mt_rand(4,6)));
									// $explode[3] += ($explode[3] <= 15 ? mt_rand(10,12) : ($explode[0] <= 20 ? mt_rand(6,8) : mt_rand(4,6)));
									// $explode[4] += ($explode[4] <= 15 ? mt_rand(10,12) : ($explode[0] <= 20 ? mt_rand(6,8) : mt_rand(4,6)));
									// $explode[5] += ($explode[5] <= 15 ? mt_rand(10,12) : ($explode[0] <= 20 ? mt_rand(6,8) : mt_rand(4,6)));
									$value['gen'] = implode(',',$explode);
								}
							}
              $shineTimeRand = mt_rand(1,20);
              if($shineTimeRand == 1) {
                $shineTime = 'shadow';
              }else{
                $shineTime = 'shine';
              }
              if($value['location'] == 227 && $value['basenum'] == 455 || $value['location'] == 227 && $value['basenum'] == 71) {
                $shineMax = 'evil';
              //}elseif($value['id_pok'] >= 282 && $value['id_pok'] <= 286){
                //$shineMax = 'zombie';
              }else{
                $shineMax = ($randShin < $ShineChanse ? $shineTime : 'normal');
                if($shineMax == 'normal') {
                  $frost = mt_rand(1,25000);
                  if($frost <= 10) {
                    $shineMax = 'frost';
                  }else{
                    $shineMax = 'normal';
                  }
                }
              }
                            if($baseInfo['base_sex_f'] == 0 && $baseInfo['base_sex_m'] == 0) {
                              $gender = 'Бесполый';
                            }else{
                              $gender = ($baseInfo['base_sex_f'] > 0 ? ( $baseInfo['base_sex_f'] >= mt_rand(0, 100) ? 'Девочка' : 'Мальчик' ) : 'Мальчик');
                            }
                            $pokeUserInfo['p'.$id] = array_merge($baseInfo, [
                                'id'=>$id,
                                'user_id'=>$userID,
                                'basenum'=>$value['basenum'],
                                'character'=>mt_rand(1, 26),
                                'lvl'=>$value['lvl'],
                                'date_get'=>'',
                                'start_pok'=>1,
                                'active'=>1,
                                'type'=>$shineMax,
                                'gender'=>$gender,
                                'exp'=>self::_getExp($value['lvl'], $baseInfo['base_exp_group']),
                                'exp_max'=>self::_getExp($value['lvl']+1, $baseInfo['base_exp_group']),
                                'ev'=>0,
                                'hp'=>true,
                                'stats'=>'0,0,0,0,0,0',
                                'evcounts'=>'0,0,0,0,0,0',
                                'gen'=>(isset($value['gen']) && $value['gen'] && is_string($value['gen']) ? $value['gen'] : mt_rand(1,25).','.mt_rand(1,25).','.mt_rand(1,25).','.mt_rand(1,25).','.mt_rand(1,25).','.mt_rand(1,25)),
                                'vitamines'=>0,
                                'owner'=>0,
                                'master'=>0,
                                'item_id'=>0,
                                'startGame'=>0,
                                'sparka'=>0,
                                'trn'=>0,
                                'trn_stat'=>0,
                                'happy'=>15,
                                'attacks'=>$atk,
                                'pp_attacks'=>'10,10,10,10',
                                'lastWent'=>'',
                                'trade'=>'true',
                                'sparkaNumber'=>mt_rand(0, 3),
                                'tren'=>0,
                                'tren_stat'=>0,
                                'event'=>0,
                                'atkList'=> self::_pokeAtkList($atk),
                                'catch'=>$value['catch'],
                                'pp_my'=>'2000,2000,2000,2000',
                            ]);

                        }
                    }
                    unset($key,$value);
                }else{
                    while($pokeUserList = $pokeUser->fetch_assoc()){
                        if(isset($pokeUserList['id'])){
                            if(!$target){
                                $target = $pokeUserList['id'];
                            }
                            if($pokeUserList['start_pok'] > 0){
                                $target = $pokeUserList['id'];
                            }
                            $pokeUserList['atkList'] = self::_pokeAtkList($pokeUserList['attacks']);
                            $pokeUserList['pp_my'] = $pokeUserList['pp_attacks'];
                            $pokeUserInfo['p'.$pokeUserList['id']] = $pokeUserList;
                        }
                    }
                }


                $uInfo = (isset($option['uinfo']) ? $option['uinfo'] : []);

                if(!empty($pokeUserInfo)){
                    return [
                        'target'=>($type == 'pvp' ? 0 : $target),
                        'timer'=>[],
                        'pokeLIst'=>$pokeUserInfo,
                        'userInfo'=>[
                            'id'    =>((isset($uInfo['id']) ? intval($uInfo['id']) : 0)),
                            'login' =>((isset($uInfo['login']) ? $uInfo['login'] : 'Дикий покемон')),
                            'group' =>((isset($uInfo['user_group']) ? intval($uInfo['user_group']) : 6)),
                            'sex'   =>((isset($uInfo['sex']) ? $uInfo['sex'] : 'm')),
                            'rating'=>((isset($uInfo['rating']) ? $uInfo['rating'] : '{}')),
                            'catch' =>((isset($uInfo['catch']) ? $uInfo['catch'] : 0)),
                        ]
                    ];
                }
            }

        }

        return [];
    }

    public static function _generateAtkListPoke($poke_num, $poke_lvl){
        if($poke_num && $poke_num > 0 && $poke_lvl && $poke_lvl > 0){
            $info = Work::$sql->query('
                                          SELECT  *
                                          FROM `base_attacks_pokemons`
                                          WHERE `pok` = '.intval($poke_num).' AND `type` = "lvl"
                                 ')->fetch_assoc();

            if(!empty($info['attacks'])){
                $info['attacks'] = explode(',', $info['attacks']);
                $info['lvl'] = explode(',', $info['lvl']);

                $count = sizeof($info['attacks']);

                $return = [];

                $counts = 0;

                for($i=0; $i<$count; $i++){

                    if($counts < 4 && isset($info['attacks'][$i], $info['lvl'][$i]) && $poke_lvl >= $info['lvl'][$i]){
                        $return[] = intval(trim($info['attacks'][$i]));
                        ++$counts;
                    }

                }

                if(!empty($return)){
                    return implode(',', $return);
                }
            }
        }
        return '0';
    }

    public static function _pokeAtkList($atkList, $private = false){

        $return = [];
        if($atkList){
            $info = Work::$sql->query('SELECT
                                            `id`,
                                            `name_rus` AS `name`,
                                            `title`,
                                            `type`,
                                            `category`,
                                            `priority`,
                                            `power`,
                                            `accuracy`,
                                            `pp`,
                                            `target`,
                                            `settings`,
                                            `my`,
                                            `enemy`,
                                            `contact`
                                        FROM `base_atk` WHERE `id` IN ('.$atkList.') ORDER BY FIELD (`id`,'.$atkList.')
                                     ');
            if(!empty($info)){
                $i = 0;
                while($infoList = $info->fetch_assoc()){
                    $infoList['attack_num'] = $i;
                    if(isset($infoList['id'])){

                        if($private){
                            unset(
                                $infoList['target'],
                                $infoList['settings'],
                                $infoList['my'],
                                $infoList['enemy'],
                                $infoList['priority']
                            );
                        }
                        $return['a'.$infoList['id']] = $infoList;

                    }
                    $i++;
                }
            }
        }
        return $return;
    }

    public static function _getPokeUserBattle($user_id = null){
        return Work::$sql->query('
                  SELECT
                    `up`.*,

                    '.self::BASE_INFO.'

                  FROM `user_pokemons` AS `up`
                  INNER JOIN `base_pokemons` AS `bp`
                    ON `bp`.`id` = `up`.`basenum`
                  WHERE
                    `up`.`user_id` = '.($user_id && $user_id > 0 ? intval($user_id) : (isset($_SESSION['id']) ? $_SESSION['id'] : 0)).' AND
                    `up`.`active` = 1 AND
                    `up`. `hp` > 0
            ');
    }

    public static function _generatePve(array $user_info, $location_id, $chance = null){

        if(!($location_id && $location_id > 0)){
            return false;
        }

        if(!($user_info && isset($user_info['id']))){
            return false;
        }

        if(!($chance && $chance > 0 && $chance <= 100)){
            $chance = self::chanseRandom(100, 5);
        }

        $timezone = date('H:i:s');
        $timezone = ($timezone ? $timezone : '00:00:00');

        $chance_limit = random_int(10, 40);

        $select = Work::$sql->query('
                                      SELECT
                                        *
                                      FROM `pokemons_location`
                                      WHERE
                                        `location_id` IN (0, '.$location_id.', 900000) AND
                                        `chance` >= '.$chance.' AND
                                        (
                                            (`timezone` = "00:00:00" AND `timezone_b` = "00:00:00")
                                            OR
                                            ("'.$timezone.'" BETWEEN `timezone` AND `timezone_b`)
                                        )

                                      ORDER BY `chance` DESC
                                      LIMIT '.$chance_limit.'
                                    ');
        if(!empty($select)){
            $list = [];
            while($selectInfo = $select->fetch_assoc()){
				if($selectInfo && isset($selectInfo['basenum']) && $selectInfo['basenum'] > 0 && item_isset($selectInfo['item'],1) OR $selectInfo['item'] == 0){
                    if($selectInfo['chance'] >= mt_rand(0, 100)){
                        $list[] = $selectInfo;
                    }
                }
            }

            if(!empty($list)){
                if(shuffle($list)){

                    if($list = reset($list)){

                        if(isset($list['basenum'])){

                            $uInfo = self::_userInfoBattle($user_info['id'], 'pve', [
                                'uinfo'=>$user_info
                            ]);


                            if(!empty($uInfo)){

                                $lvl = $list['lvl'];
                                $lvl = explode(',', $lvl);

                                if(isset($lvl[0]) && $lvl[0] > 0){
                                    if(isset($lvl[1]) && $lvl[1] > 0 && $lvl[1] > $lvl[0]){
                                        $lvl = mt_rand($lvl[0], $lvl[1]);
                                    }else{
                                        $lvl = $lvl[0];
                                    }
                                }else{
                                    $lvl = mt_rand(5, 25);
                                }

                                $lvl = intval($lvl);

                                $gen = $list['gen'];

                                if(!empty($gen)){
                                    if(strpos($gen, '[') !== false){
                                        $gen = Info::_unParseData($gen);

                                        $genStr = '';

                                        if(isset($gen[0], $gen[0][0], $gen[0][1])){
                                            $genStr .= mt_rand($gen[0][0], $gen[0][1]);
                                        }else{
                                            $genStr .= mt_rand(1, 20);
                                        }

                                        if(isset($gen[1], $gen[1][0], $gen[1][1])){
                                            $genStr .= ','.mt_rand($gen[1][0], $gen[1][1]);
                                        }else{
                                            $genStr .= ','.mt_rand(1, 20);
                                        }

                                        if(isset($gen[2], $gen[2][0], $gen[2][1])){
                                            $genStr .= ','.mt_rand($gen[2][0], $gen[2][1]);
                                        }else{
                                            $genStr .= ','.mt_rand(1, 20);
                                        }

                                        if(isset($gen[3], $gen[3][0], $gen[3][1])){
                                            $genStr .= ','.mt_rand($gen[3][0], $gen[3][1]);
                                        }else{
                                            $genStr .= ','.mt_rand(1, 20);
                                        }

                                        if(isset($gen[4], $gen[4][0], $gen[4][1])){
                                            $genStr .= ','.mt_rand($gen[4][0], $gen[4][1]);
                                        }else{
                                            $genStr .= ','.mt_rand(1, 20);
                                        }

                                        if(isset($gen[5], $gen[5][0], $gen[5][1])){
                                            $genStr .= ','.mt_rand($gen[5][0], $gen[5][1]);
                                        }else{
                                            $genStr .= ','.mt_rand(1, 20);
                                        }

                                        $gen = $genStr;
                                    }else{
                                        $gen = explode(',', $gen);

                                        if(count($gen) > 3){
                                            $gen = (isset($gen[0]) ? $gen[0] : 1).','.(isset($gen[1]) ? $gen[1] : 1).','.(isset($gen[2]) ? $gen[2] : 1).','.(isset($gen[3]) ? $gen[3] : 1).','.(isset($gen[4]) ? $gen[4] : 1).','.(isset($gen[5]) ? $gen[5] : 1);
                                        }else{
                                            $gen = mt_rand($gen[0], $gen[1]).','.mt_rand($gen[0], $gen[1]).','.mt_rand($gen[0], $gen[1]).','.mt_rand($gen[0], $gen[1]).','.mt_rand($gen[0], $gen[1]).','.mt_rand($gen[0], $gen[1]);
                                        }
                                    }
                                }else{
                                    $gen = mt_rand(1, 20).','.mt_rand(1, 20).','.mt_rand(1, 20).','.mt_rand(1, 20).','.mt_rand(1, 20).','.mt_rand(1, 20);
                                }

                                $pokeInfo = [
                                    'id'	=> 1,
                                    'location' => $location_id,
                                    'user'	=> 0,
                                    'lvl'	=> $lvl,
                                    'basenum'=>$list['basenum'],
                                    'gen'	=> $gen,
                                    'catch'	=> (isset($list['catch']) && $list['catch'] > 0 ? 1 : 0),
                                    'wild'	=> true,
                                    'id_pok' =>$list['id']
                                ];

                                if(!empty($list['atk_list'])){
                                    $pokeInfo['atk_list'] = $list['atk_list'];
                                }

                                $pInfo = self::_userInfoBattle(0, 'pve', [
                                    'npc'=>[
                                        $pokeInfo
                                    ],
                                    'uinfo'=>[
                                        'user_group'=>(isset($list['catch']) && $list['catch'] > 0 ? 6 : 1),
                                        'catch'=>(isset($list['catch']) && $list['catch'] > 0 ? 1 : 0),
                                    ]
                                ]);


                                if(!empty($pInfo)){
                                    $info_1 = Info::_parseData($uInfo);
                                    $info_2 = Info::_parseData($pInfo);
									$UserSelect = Work::$sql->query('SELECT location FROM users WHERE id = '.$uInfo['userInfo']['id'].'')->fetch_assoc();
                  $LocationSelect = Work::$sql->query('SELECT region,img_fight FROM base_location WHERE id = '.$UserSelect['location'].'')->fetch_assoc();
                  $WeatherNum = Work::$sql->query('SELECT weather FROM base_region WHERE id = '.$LocationSelect['region'].'')->fetch_assoc();
                  $imgFight = $LocationSelect['img_fight'];
                  Work::$sql->query('INSERT INTO `battle`
                                            (`user_1`,`user_2`,`info_1`,`info_2`,`type`,`weather`,`img`)
                                     VALUES ('.$_SESSION['id'].', 0, "'.Work::$sql->real_escape_string($info_1).'", "'.Work::$sql->real_escape_string($info_2).'", "pve", "'.$WeatherNum['weather'].'", "'.$imgFight.'")
                               ');

                                    Work::$sql->query('UPDATE `users` SET
                                      `status` = "battle",
                                      `status_id` = '.intval(Work::$sql->insert_id).'
                                    WHERE `id` = '.intval($user_info['id']));
                                }

                            }


                        }

                    }

                }

            }
        }

        return false;
    }

    public static function _pokeEXP($lvl, $exp_group, $exp, $exp_next){
        if($lvl && $lvl > 0){

            $exp_my = self::_getExp($lvl-1, $exp_group);

            return [
                'val'   =>(int)($lvl < 100 ? $exp : 100),
                'next'  =>(int)($lvl < 100 ? $exp_next  : 100)
            ];

        }
        return [];
    }

    public static function _getExp($lvl, $group){
        $exp = 0;

        switch($group){

            case '1':

                if($lvl <= 50){
                    $exp = round(( pow($lvl, 3) * (100 - $lvl) ) / 50);
                }elseif($lvl <= 68){
                    $exp = round(( pow($lvl, 3) * (150 - $lvl) ) / 100);
                }elseif($lvl <= 98){
                    $exp = round(( pow($lvl, 3) *  ((1911 - (10 * $lvl)) / 3) ) / 500);
                }elseif($lvl <= 100){
                    $exp = round(( pow($lvl, 3) * (160 - $lvl) ) / 100);
                }

                break;

            case '2':

                $exp = round( (4 * pow($lvl, 3)) / 5);

                break;

            case '3':

                $exp = pow($lvl, 3);

                break;

            case '4':

                $exp = round( ((6/5) * pow($lvl, 3)) - (15 * pow($lvl, 2)) + (100 * $lvl) - 140 );

                break;

            case '5':

                $exp = round((5 * pow($lvl, 3)) / 4);

                break;

            case '6':

                if($lvl <= 15){
                    $exp = round( pow($lvl, 3) * ((( ($lvl + 1) / 3 ) + 24) / 50) );
                }elseif($lvl <= 36){
                    $exp = round( pow($lvl, 3) * ( ($lvl + 14) / 50 ) );
                }elseif($lvl <= 100){
                    $exp = round( pow($lvl, 3) * ( ( ($lvl + 2) + 32 ) / 50 ) );
                }

                break;
        }

        if($exp <=0){
            $exp = 0;
        }

        return intval($exp);
    }

    public static function _updatePokeExp($pokeInfo, $onlyHP = false){

        if($pokeInfo && isset($pokeInfo['id'])){

            if(!$onlyHP){

                if(isset($pokeInfo['lvl'], $pokeInfo['exp'], $pokeInfo['exp_max'], $pokeInfo['base_exp_group'])){

                    if(isset($pokeInfo['actionCount']) && $pokeInfo['actionCount'] > 0){

                        if(isset($pokeInfo['targetLvl']) && is_array($pokeInfo['targetLvl'])){
                            $enemy_lvl = 0;

                            foreach($pokeInfo['targetLvl'] AS $key=>$value){
                                if($value > 0){
                                    $enemy_lvl = $enemy_lvl + $value;
                                }
                            }
                            unset($key,$value);

                            if($enemy_lvl > 0){
								$ExpBonus = $user = Work::$sql->query("SELECT exp FROM system WHERE id = 1")->fetch_assoc();
								$pokeInfo['exp'] = $pokeInfo['exp'] + (( ($pokeInfo['actionCount'] + 220) * ($enemy_lvl / $pokeInfo['lvl'])) * (1 + $ExpBonus['exp']));

						  }

                            unset($pokeInfo['targetLvl']);
                        }
                        unset($pokeInfo['actionCount']);
                    }

                    $lvl = intval($pokeInfo['lvl']) + 1;

                    if($pokeInfo['exp'] >= $pokeInfo['exp_max'] && $pokeInfo['lvl'] < 100){

                        $pokeInfo['lvl'] = intval($pokeInfo['lvl']) + 1;

                        if(isset($pokeInfo['ev'])){

                            if(isset($pokeInfo['item_id']) && in_array($pokeInfo['item_id'], [107, 10002])){
                                $pokeInfo['ev'] = intval($pokeInfo['ev']) + 3;
                            }else{
                                if($pokeInfo['startGame'] == 1) {
                                  $pokeInfo['ev'] = intval($pokeInfo['ev']) + 3;
                                }else{
                                  $SkobaBouns = Work::$sql->query("SELECT skoba FROM system WHERE id = 1")->fetch_assoc();
                                  if($SkobaBouns['skoba'] == 1) {
                                    $pokeInfo['ev'] = intval($pokeInfo['ev']) + 3;
                                  }else{
                                    $pokeInfo['ev'] = intval($pokeInfo['ev']) + 2;
                                  }
                                }
                            }

                        }

                        if($lvl <= 100){

                            if(isset($pokeInfo['base_evol_lvl'], $pokeInfo['base_evol_type'], $pokeInfo['base_evol_basenum'])){

                                $pokeInfo['base_evol_lvl'] = intval($pokeInfo['base_evol_lvl']);

                                if($pokeInfo['base_evol_type'] == 'lvl' && $pokeInfo['base_evol_lvl'] > 0 &&  $pokeInfo['base_evol_lvl'] == $pokeInfo['lvl'] && $pokeInfo['base_evol_basenum'] > 0){
                                    $info =  Work::$sql->query('
                                                              SELECT

                                                                `bp`.`id` AS `base_number`,

                                                                '.self::BASE_INFO.'

                                                              FROM `base_pokemons` AS `bp`

                                                              WHERE `bp`.`id` = '.intval($pokeInfo['base_evol_basenum']).'

                                                        ')->fetch_assoc();

                                    if(!empty($info['base_number'])){
                                        $arr = [
                                            'basenum'=>$info['base_number'],
                                            'name_new'=>($pokeInfo['name_new'] == $pokeInfo['base_name'] ? $info['base_name'] : $pokeInfo['name_new'])
                                        ];
                                        $pokeInfo = array_merge($pokeInfo, $info);
                                        $pokeInfo = array_merge($pokeInfo, $arr);
                                    }
                                }
                            }

                            $exp = self::_getExp($lvl, $pokeInfo['base_exp_group']);

                            if($exp > 0){

                                $pokeInfo['exp_max'] = $exp;

                                if($pokeInfo['exp'] >= $pokeInfo['exp_max']){
                                    return self::_updatePokeExp($pokeInfo, $onlyHP);
                                }

                            }

                        }

                    }

                }

            }

            if(Work::$sql){
                $pokeInfo = new PokeBattle($pokeInfo, true);
                Work::$sql->query('UPDATE `user_pokemons` SET
                                            `hp` = '.intval($pokeInfo->hp).',
                                            `basenum` = '.intval($pokeInfo->basenum).',
                                            `name_new` = "'.$pokeInfo->name_new.'",
                                            `stats` = "'.$pokeInfo->_getStats(true).'",
                                            `lvl` = '.$pokeInfo->_getLvl().',
                                            `ev` = '.$pokeInfo->_getEvCount().',
                                            `exp` = '.$pokeInfo->_getExp().',
                                            `exp_max` = '.$pokeInfo->_getExpNext().',
                                            `pp_attacks` = "'.$pokeInfo->pp_my.'"
                                          WHERE `id` = '.$pokeInfo->_getID());

                return $pokeInfo->_getData();
            }

            return $pokeInfo;

        }

        return $pokeInfo;
    }

    public static function _arrRandDefOne(array $array){
        if(!empty($array)){
            $rand_keys = array_rand($array);
            return ( (is_array($rand_keys) && isset($rand_keys[0])) ? $array[$rand_keys[0]] : $array[$rand_keys]);
        }
        return null;
    }

    public static function _modif($led) {
      if(!is_array($led)){
          $led = self::_unParseData($led);
      }
      return [
          'gen'=>$led['genUp'],
          'char'=>$led['charEdit']
      ];
    }

    public static function _pokeBirthday($birthday){
        if(!is_array($birthday)){
            $birthday = self::_unParseData($birthday);
        }

        $user = [];

        if(isset($birthday['user_id']) && $birthday['user_id'] > 0){

            if(isset(self::$userCache['u'.$birthday['user_id']])){
                $user = self::$userCache['u'.$birthday['user_id']];
            }else{
                $user = Work::$sql->query("SELECT `id`, `login`, `user_group` FROM `users` WHERE `id` = ".intval($birthday['user_id']))->fetch_assoc();

                if(isset($user['id'])){
                    self::$userCache['u'.$user['id']] = $user;
                }else{
                    $user = [];
                }
            }

        }

        return [
            'user'=>'<div class="user-link u-'.(isset($user['user_group']) ? $user['user_group'] : 6).'">'.(isset($user['login']) ? $user['login'] : '???').'</div>',
            'date'=>date('d.m.Y', (isset($birthday['date']) ? $birthday['date'] : time()))
        ];
    }

    public static function chanseRandom($value, $value_max = 20){
        $value_min = intval(ceil($value/2));
        $value_min = ($value_min <= 0 ? 1 : $value_min);
        if(mt_rand(1, 100) <= $value_max){
            return mt_rand(1, $value);
        }
        return mt_rand($value_min, $value);
    }

    public static function _shableShop($npc_id, $uInfo = null, &$response = []){

        if($npc_id && !empty($_SESSION['id'])){

            $uInfo = (($uInfo && !empty($uInfo['id'])) ? $uInfo : Work::$sql->query('
                SELECT
                  `id`,
                  `sex`,
                  `login`,
                  `location`
                FROM `users`
                WHERE `id` = '.intval($_SESSION['id']).'
            ')->fetch_assoc());

            if(!empty($uInfo['id'])){

                if(is_array($npc_id)){

                    if(!empty($npc_id['item']) && !empty($npc_id['npc']) && $npc_id['item'] > 0 && $npc_id['npc'] > 0){

                        $npc_id['npc']    = intval($npc_id['npc']);
                        $npc_id['item']   = intval($npc_id['item']);
                        $npc_id['count']  = intval(abs($npc_id['count']));

                        if($npc_id['count'] <= 0){
                            _setError('Вы будете брать или нет?!');
                        }

                        $checkItem = Work::$sql->query('
                                        SELECT
                                          `id`,
                                          `npc_id`,
                                          `location_id`,
                                          `item_id`,
                                          `item_price`,
                                          `item_type`,
                                          `item_count`
                                        FROM `items_npc`
                                        WHERE
                                          `npc_id` = '.$npc_id['npc'].' AND
                                          `item_id` = '.$npc_id['item'].'
                                    ')->fetch_assoc();

                        if(!empty($checkItem['item_id']) && $checkItem['item_price'] > 0 && ($checkItem['location_id'] == $uInfo['location'] || $checkItem['location_id'] == 0)){

                            if($npc_id['count'] > 0 && ($checkItem['item_count'] >= $npc_id['count'] || $checkItem['item_count'] == -1)){

                                $price = ($npc_id['count'] * $checkItem['item_price']);
                                $type_item = intval($checkItem['item_type']);

                                if(item_isset($type_item, $price)){

                                    minus_item($type_item, $price);

                                    itemAdd(intval($checkItem['item_id']), $npc_id['count']);
                                    $itemName = Work::$sql->query('SELECT name FROM base_items WHERE id = '.$checkItem['item_id'])->fetch_assoc();
                                    $itemName1 = Work::$sql->query('SELECT name FROM base_items WHERE id = '.$checkItem['item_type'])->fetch_assoc();
                                    $response['by_ok'] = 'Успешная покупка!';
                                    $response['by_minus'] = '<img src="/img/world/items/little/'.$checkItem['item_type'].'.png" class="item"> '.$itemName1['name'].' ('.$price.' шт.)';
                                    $response['by_plus'] = '<img src="/img/world/items/little/'.$checkItem['item_id'].'.png" class="item"> '.$itemName['name'].' ('.$npc_id['count'].' шт.)';

                                    if($checkItem['item_count'] != -1){

                                        $checkItem['item_count'] -= $npc_id['count'];
                                        if($checkItem['item_count'] <= 0){
                                            $checkItem['item_count'] = 0;
                                        }

                                        Work::$sql->query('
                                            UPDATE `items_npc` SET
                                              `item_count` = '.intval($checkItem['item_count']).'
                                            WHERE `id` = '.intval($checkItem['id']).'
                                        ');

                                        $response['by_count'] = $checkItem['item_count'];
                                    }

                                    return true;

                                }else{

                                    _setError('Недостаточно средств для совершения покупки!');
                                }

                            }else{

                                if(isset($checkItem['item_count']) && $checkItem['item_count'] == 0){
                                    _setError('Данный предмет уже распродан!');
                                }

                                if(isset($checkItem['item_count']) && $npc_id['count'] > $checkItem['item_count']){
                                    _setError('Запрашиваемое кол-во привышает кол-во оставшиеся у продовца.');
                                }

                                _setError('Данный предмет уже распродан!');
                            }

                        }else{
                            _setError('Что-то пошло не так как надо...');
                        }

                    }else{
                        _setError('Что-то пошло не так как надо...');
                    }

                }elseif($npc_id > 0){
					$listItemsInfo = [];
                    $listItems = Work::$sql->query('
                                    SELECT

                                      `in`.`item_id`,
                                      `in`.`item_price`,
                                      `in`.`item_count`,
                                      `in`.`item_type`,

                                      `bi_2`.`name` AS `type_name`,
									  `bi_2`.`id` AS `id_buyer`,

                                      `bi`.`name`,
                                      `bi`.`about`,
                                      `bi`.`type`

                                    FROM `items_npc` AS `in`
                                    INNER JOIN `base_items` AS `bi`
                                      ON `bi`.`id` = `in`.`item_id`
                                    INNER JOIN `base_items` AS `bi_2`
                                      ON `bi_2`.`id` = `in`.`item_type`
                                    WHERE
                                      `in`.`npc_id` = '.intval($npc_id).' AND
                                      (`in`.`location_id` = 0 OR `in`.`location_id` = '.intval($uInfo['location']).') AND
                                      `in`.`item_id` > 0
                                ');
					while($row = $listItems->fetch_assoc()){ $listItemsInfo[] = $row; }
                    if(!empty($listItemsInfo)){

                        $html = '<div class="market">';

                        foreach($listItems AS $key=>$value){
                            if(isset($value['name'])){
                                $html .=   '<div class="item __npc_item_'.$npc_id.'">
                                                <img src="/img/world/items/little/'.$value['item_id'].'.png" onclick="issetAll('.$value['item_id'].',\'item\')">
                                                <div class="name">
                                                    '.$value['name'].($value['item_count'] != -1 ? ' (<span class="__count">'.$value['item_count'].'</span> шт.)' : '').'
                                                </div>
                                                <div class="prize">'.$value['item_price'].' <img onclick="issetAll('.$value['id_buyer'].',\'item\')" src="/img/world/items/little/'.$value['id_buyer'].'.png"></div>
                                                <input placeholder="Количество" value="1" type="number" title="Введите кол-во"/>
                                                <div class="buy" onclick="ClassInfo._byItem('.intval($value['item_id']).', '.$npc_id.', $(this).prev().val());">Купить</div>
                                            </div>';
                            }
                        }
                        unset($key,$value);

                        $html .= '</div>';

                        $response['by_list'] = $html;

                        return true;

                    }else{
                        _setError('Этот персонаж не торгует предметами.');
                    }

                }else{
                    _setError('Ошибка доступа.');
                }

            }else{

                _setError('Ошибка доступа.');

            }

        }

        return '';
    }
}
