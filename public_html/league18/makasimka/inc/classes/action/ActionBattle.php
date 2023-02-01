<?php
function quest_step($id, $step){
  global $mysqli;
  if($step == 0)  $a = true;
   else{
      $q = $mysqli->query("SELECT `step` FROM `user_quests` WHERE `user_id` = '".$_SESSION['id']."' AND `quest_id` = '".$id."'")->fetch_assoc();
      $a = ($q['step'] == $step?true:false);
  }
 return $a;
}
class ActionBattle{

    private $defaultInfo = [
        'id'=>0,
        'login'=>'Дикий покемон',
        'user_group'=>6
    ];

    public $round = 0;

    public $weather = 0;

    public $img = 0;

    private $update = [];

    private $battleInfo = [];

    private $battleHH = 0;

    private $battleType = 'pve';

    public $userInfo = [];

    private $enemyInfo = [];

    private $userData = [];

    private $enemyData = [];

    private $userPokes = [];

    private $enemyPokes = [];

    private $userTarget = [];

    private $enemyTarget = [];

    private $otherInfo = [];

    private $response = [];

    private $answer = [];

    private $log = [];

    const TIMER_ATK_ROUND = 300;

    const LOSE_NO_HP = 'NO_HP';
    const LOSE_TIMEOUT = 'NO_TIME';
    const LOSE_COWARD = 'COWARD';
    const LOSE_ALL = 'ALL';
    const LOSE_OTHER = 'OTHER';


    public function __construct(array $userInfo = [], array $enemyInfo = [], array &$response = []){

        if(Work::$sql){

            $this->response =& $response;

            $this->userInfo = array_merge($this->defaultInfo, $userInfo);


            if($this->userInfo['id'] && $this->userInfo['id'] > 0){

                if(isset($this->userInfo['status_id']) && $this->userInfo['status_id'] > 0){

                    if(empty($enemyInfo)){

                    }else{
                        $this->enemyInfo = array_merge($this->defaultInfo, $enemyInfo);
                    }

                    $this->battleInfo = Work::$sql->query('SELECT * FROM `battle` WHERE `id` ='.intval($this->userInfo['status_id']))->fetch_assoc();

                    if(!empty($this->battleInfo)){
                        $this->start();
                        return;
                    }

                }

                $this->resetAction();

            }
        }
        return null;
    }

    private function generateAnswer(array $value, $user_id = null){
        $user_id = ($user_id ? $user_id : $this->enemyInfo['id']);

        if($user_id && $user_id > 0){
            if(isset($this->answer['u'.$user_id])){
                $this->answer['u'.$user_id] = array_merge($this->answer['u'.$user_id], $value);
            }else{
                $this->answer['u'.$user_id] = $value;
            }
        }

        return $value;
    }

    private function start(){
        if($this->parser()){
            $this->parserPost();
            $this->response['battleInfo'] = $this->viewInfo();
            $this->response['battleHH'] = 0;
        }else{
            $this->resetAction();
        }

    }

    private function parser(){
        if(isset($this->battleInfo['id'])){

            $this->round = intval($this->battleInfo['round']);
            $this->weather = intval($this->battleInfo['weather']);
            $this->img = intval($this->battleInfo['img']);

            $this->battleType = $this->battleInfo['type'];

            if($this->userInfo['id'] == $this->battleInfo['user_1']){
                $this->userData  = $this->battleInfo['info_1'];
                $this->enemyData = $this->battleInfo['info_2'];
            }else{
                $this->userData  = $this->battleInfo['info_2'];
                $this->enemyData = $this->battleInfo['info_1'];
            }

            $this->userData  = Info::_unParseData($this->userData);
            $this->enemyData = Info::_unParseData($this->enemyData);

            if(!empty($this->battleInfo['other'])){
                $this->otherInfo = array_merge($this->otherInfo, Info::_unParseData($this->battleInfo['other']));
            }

            if(!empty($this->battleInfo['answer'])){
                $this->answer = array_merge($this->answer, Info::_unParseData($this->battleInfo['answer']));
            }

            if(isset($this->userData['userInfo'])){
                $this->userInfo = array_merge($this->userInfo, $this->userData['userInfo']);
            }
            if(isset($this->enemyData['userInfo'])){
                $this->enemyInfo = array_merge($this->enemyInfo, $this->enemyData['userInfo']);
            }

            if(isset($this->userData['pokeLIst'])){
                $this->userPokes =& $this->userData['pokeLIst'];
            }
            if(isset($this->enemyData['pokeLIst'])){
                $this->enemyPokes =& $this->enemyData['pokeLIst'];
            }

            if($this->_isPVP()){
                if(isset($this->answer['battleEND']) || ($this->battleInfo['user_2'] <= 0 || $this->battleInfo['user_1'] <= 0)){
                    $this->resetAction(true);
                }
            }

            if($this->userPokes && is_array($this->userPokes) && $this->enemyPokes && is_array($this->enemyPokes)){

                if(isset($this->enemyData['target']) && $this->enemyData['target'] > 0){

                    if(isset($this->enemyPokes['p'.$this->enemyData['target']])){
                        $this->enemyTarget = $this->enemyPokes['p'.$this->enemyData['target']];
                    }else{
                        $this->enemyTarget = [];
                    }

                }

                if(isset($this->userData['target']) && $this->userData['target'] > 0){

                    if(isset($this->userPokes['p'.$this->userData['target']])){
                        $this->userTarget = $this->userPokes['p'.$this->userData['target']];
                    }else{
                        $this->userTarget = [];
                    }

                }else{
                    $this->enemyTarget = [];
                }

                return true;
            }

        }
        return false;
    }

    private function captcha($value = false){

        if($this->_isPVP()){
            return true;
        }

        if(!empty($value)){
            if(isset($_SESSION['user_captcha'])){
                if($_SESSION['user_captcha']['value'] == $value){

                    $_SESSION['user_captcha'] = [
                        'tick'=>0,
                        'max_tick'=>mt_rand(30, 50),
                        'value'=>0,
                        'title'=>''
                    ];

                    $this->response['captcha'] = [
                        'cpl'=>true
                    ];

                }else{

                    $val_1 = mt_rand(1, 10);
                    $val_2 = mt_rand(1, 10);

                    $_SESSION['user_captcha']['value'] = ($val_1 + $val_2);
                    $_SESSION['user_captcha']['title'] = $val_1.' + '.$val_2.' = ';

                    $this->response['captcha'] = [
                        'title'=>$_SESSION['user_captcha']['title']
                    ];

                }
            }
            return true;
        }

        if(isset($_SESSION['user_captcha'])){

            $_SESSION['user_captcha']['tick'] = $_SESSION['user_captcha']['tick'] + 1;

            if($_SESSION['user_captcha']['tick'] >= $_SESSION['user_captcha']['max_tick']){

                if($_SESSION['user_captcha']['value'] <= 0){

                    $val_1 = mt_rand(1, 10);
                    $val_2 = mt_rand(1, 10);

                    $_SESSION['user_captcha']['value'] = ($val_1 + $val_2);
                    $_SESSION['user_captcha']['title'] = $val_1.' + '.$val_2.' = ';

                }

                $this->response['captcha'] = [
                    'title'=>$_SESSION['user_captcha']['title']
                ];

                return false;
            }

        }else{
            $_SESSION['user_captcha'] = [
                'tick'=>0,
                'max_tick'=>mt_rand(30, 50),
                'value'=>0,
                'title'=>''
            ];
        }

        return true;
    }

    private function checkTimeout($userInfo){

        if($userInfo && isset($userInfo['timer'])){

            $time = time();

            if(isset($userInfo['timer']['atk']) && $userInfo['timer']['atk'] > 0 && $time > $userInfo['timer']['atk']){
                return true;
            }

        }

        return false;
    }

    private function parserPost(){
        if($this->userPokes && $this->enemyPokes){

            if(isset($_POST['targetPoke'])){

                $target = intval($_POST['targetPoke']);

                if($this->checkTimeout($this->enemyData)){
                    $this->lose($this->userInfo['id'], self::LOSE_TIMEOUT);
                    return;
                }

                if(isset($this->userPokes['p'.$target])){

                    if(isset($this->userData['target']) && $this->userData['target'] > 0){

                        $this->update['my'] = true;

                        $target = new PokeBattle($this->userPokes['p'.$target]);

                        if(isset($this->userTarget['hp']) && $this->userTarget['hp'] <= 0){
              Work::$sql->query('DELETE FROM atk_rollout WHERE user = '.$this->userInfo['id']);
              Work::$sql->query('DELETE FROM atk_furycutter WHERE user = '.$this->userInfo['id']);
							Work::$sql->query('DELETE FROM battle_block WHERE user = '.$this->userInfo['id']);
							Work::$sql->query('INSERT INTO battle_log (battle,round,text,end,user) VALUES ('.$this->battleInfo['id'].','.$this->battleInfo['round'].',"[{"user": "'.$this->userInfo['id'].'", fdsf") WHERE battle = '.$this->battleInfo['id'].' ');
                            // $this->log[] = [
                                // 'log'=>[
                                    // [
                                        // 'user'=>$this->userInfo['id'],
                                        // 'log'=>[
                                            // 'Заменяет обессиленного покемона на '.$target->_getName(true)
                                        // ]
                                    // ]
                                // ]
                            // ];
                            $this->generateAnswer([
                                'log'=>$this->log
                            ]);
                            $this->userTarget = $this->userPokes['p'.$target->_getID()];
                            $this->userData['target'] = $target->_getID();

                        }else{

                            if(!$this->captcha()){
                                return;
                            }

                            $this->userData['targetAtk'] = 9999;
                            $this->userData['targetPokemon'] = $target->_getID();

                            if(!$this->goRound()){ // Апдейт боя
                                $this->userData['timer']['atk'] = time() + self::TIMER_ATK_ROUND;
                                $this->update['my'] = true;
                            }

                        }

                    }else{
                        $this->userTarget = $this->userPokes['p'.$target];
                        $this->userData['target'] = $target;
                        $this->update['my'] = true;
                    }

                }

            }elseif(isset($_POST['aHH'])){

              if(!(isset($this->userData['targetAtk']) && $this->userData['targetAtk'] > 0)){
                $target = 235;
                $target2 = intval($_POST['aHH']);
                if($this->userTarget && $this->enemyTarget && isset($this->userTarget['atkList']['a'.$target])){
                  if($this->userTarget['hp'] > 0){
                    if(!$this->captcha()){
                        return;
                    }
                    $target = $this->userTarget['atkList']['a'.$target];
                    if(isset($target['id'])){

                      $target2 = new PokeBattle($this->userPokes['p'.$target2]);
                      $this->userData['targetHH'] = $target2->_getID();

                        $this->userData['targetAtk'] = $target['id'];

                        if(!$this->goRound()){
                            $this->userData['timer']['atk'] = time() + self::TIMER_ATK_ROUND;
                            $this->update['my'] = true;
                        }

                    }
                  }
                }
              }

            }elseif(isset($_POST['targetAtk'])){

                if(!(isset($this->userData['targetAtk']) && $this->userData['targetAtk'] > 0)){

                    $target = intval($_POST['targetAtk']);

                    if($this->userTarget && $this->enemyTarget && $target > 0 && isset($this->userTarget['atkList']['a'.$target])){

                        if($this->userTarget['hp'] > 0){

                            if(!$this->captcha()){
                                return;
                            }

                            $target = $this->userTarget['atkList']['a'.$target];

                            if(isset($target['id'])){

                                $this->userData['targetAtk'] = $target['id'];

                                if(!$this->goRound()){
                                    $this->userData['timer']['atk'] = time() + self::TIMER_ATK_ROUND;
                                    $this->update['my'] = true;
                                }

                            }

                        }

                    }
                }

            }elseif(isset($_POST['coward'])){
                $this->lose($this->userInfo['id'], self::LOSE_COWARD);
            }elseif(isset($_POST['catch'])){

				if(!(isset($this->userData['targetAtk']) && $this->userData['targetAtk'] > 0)){

					if(!$this->captcha()){
						return;
					}
					if($this->userTarget && $this->userTarget['hp'] > 0){
						$this->pokeCatch($_POST['catch']);
					}

				}


            }elseif(isset($_POST['captcha'])){

                $this->captcha($_POST['captcha']);

            }elseif(isset($_POST['check_timer'])){

                if($this->checkTimeout($this->userData)){
                    $this->lose($this->enemyInfo['id'], self::LOSE_TIMEOUT);
                    return;
                }

            }

        }
    }

    private function pokeCatch($targetID){
        if($targetID && $targetID > 0){
          $sel = Work::$sql->query('
                  SELECT
                    `bi`.`id` AS `number`,
                    `bi`.`name`,
                    `bi`.`type`,
                    `bi`.`info`,
                    `ui`.`id`,
                    `ui`.`id`,
                    `ui`.`count`,
                    `bi`.`battle`
                  FROM `items_users` AS `ui`
                  INNER JOIN `base_items` AS `bi`
                    ON `bi`.`id`= `ui`.`item_id`
                  WHERE
                    `ui`.`id` = '.$targetID.' AND
                    `ui`.`user` = '.$_SESSION['id'].'
              ')->fetch_assoc();

                if(!empty($sel['count']) && $sel['count'] > 0 && $sel['battle'] == '1'){
                    if($sel['type'] == 'ball'){
                      if(isset($this->enemyInfo['catch']) && $this->enemyInfo['catch'] > 0){
                        minus_item_id($targetID, 1, $_SESSION['id']);
                        $this->userData['targetAtk'] = 9998;
                        $this->userData['targetItem'] = [
                            'number'=>intval($sel['number']),
                            'name'=>$sel['name'],
                            'val'=>($sel['info'] > 0 ? floatval($sel['info']) : 1)
                        ];
          						  if(!$this->goRound()){
          							  $this->userData['timer']['atk'] = time() + self::TIMER_ATK_ROUND;
          							  $this->update['my'] = true;
          						  }
                      }else{
                          _setError('Этого покемона ловить нельзя!','plus');
                      }
                    }else{
                      minus_item_id($targetID, 1, $_SESSION['id']);
                      $this->userData['targetAtk'] = 9998;
                      $this->userData['targetItem'] = [
                          'number'=>intval($sel['number']),
                          'name'=>$sel['name'],
                          'val'=>($sel['info'] > 0 ? floatval($sel['info']) : 1)
                      ];
          						if(!$this->goRound()){
          							$this->userData['timer']['atk'] = time() + self::TIMER_ATK_ROUND;
          							$this->update['my'] = true;
          						}
                    }
                }
        }
    }

    private function goRound(){

        if(!$this->_isPVP()){
            if(isset($this->enemyTarget['attacks'],$this->enemyTarget['atkList'])){

                if(!is_array($this->enemyTarget['attacks'])){
                    $this->enemyTarget['attacks'] = explode(',', $this->enemyTarget['attacks']);
                }

                if(shuffle($this->enemyTarget['attacks'])){
                    $this->enemyData['targetAtk'] = intval($this->enemyTarget['attacks'][0]);
                }

            }
        }

        if(isset($this->enemyData['targetAtk']) && $this->enemyData['targetAtk'] > 0){

            $this->update['enemy'] = true;

            $u =& $this->userTarget;
            $e =& $this->enemyTarget;

            $battle = new Battle($this, $this->userData, $this->enemyData, $u, $e);

            $this->userPokes['p'.$u['id']] = $u;
            $this->enemyPokes['p'.$e['id']] = $e;

            $this->log[] = [
                'round'=>$this->battleInfo['round'],
                'log'=>$battle->_getLog(),
                'log_status'=>$battle->_getLogStatus()
            ];
			$LogGame = json_encode($battle->_getLog(), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
			$LogGame1 = json_encode($battle->_getLogStatus(), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
			Work::$sql->query('INSERT INTO battle_log (battle,round,text,end,user) VALUES ('.$this->battleInfo['id'].','.$this->battleInfo['round'].',"'.Work::$sql->real_escape_string($LogGame).'","'.Work::$sql->real_escape_string($LogGame1).'",0)');
			$this->generateAnswer([
                'log'=>$this->log
            ]);

            $myRetarget = $this->_isRetarget($this->userPokes);
            $enemyRetarget = $this->_isRetarget($this->enemyPokes);

            if(isset($this->enemyData['timer'], $this->enemyData['timer']['atk'])){
                $this->enemyData['timer']['atk'] = 0;
            }
            if(isset($this->userData['timer'], $this->userData['timer']['atk'])){
                $this->userData['timer']['atk'] = 0;
            }


            if(!$myRetarget && !$enemyRetarget){
                $this->lose(true, self::LOSE_ALL);
            }elseif(!$myRetarget){
                $this->lose($this->userInfo['id'], self::LOSE_NO_HP);
            }elseif(!$enemyRetarget){
                $this->lose($this->enemyInfo['id'], self::LOSE_NO_HP);
            }else{
                /*if($this->userTarget['hp'] <= 0){
                    $this->
                }*/
            }
            return true;
        }

        return false;
    }

    private function viewInfo(){
        if($this->userPokes && $this->enemyPokes){

            $myAnswer = [];
            if(!empty($this->answer)){
                if(isset($this->answer['u'.$this->userInfo['id']])){
                    $myAnswer = $this->answer['u'.$this->userInfo['id']];
                    $this->update['my'] = true;
                    unset($this->answer['u'.$this->userInfo['id']]);
                }
            }

		    $return = [
                'id'			=> intval($this->battleInfo['id']),
                'my'			=> $this->viewInfoUser($this->userInfo),
                'enemy'			=> $this->viewInfoUser($this->enemyInfo),
                'myTarget'		=> $this->viewInfoTarget($this->userTarget, true),
                'enemyTarget'	=> $this->viewInfoTarget($this->enemyTarget),
                'myTeam'		=> $this->viewInfoTeam($this->userPokes),
                'timeout'		=> isset($this->userData['timer']) ? $this->userData['timer'] : [],
                'time'			=> time(),
                'round'			=> $this->round,
                'weather'   => $this->weather,
                'img'       => $this->img
            ];

			if(isset($myAnswer['log'])){
                $return['log'] = $myAnswer['log'];
            }else if(!empty($this->log)){
                $return['log'] = $this->log;
            }

            if(isset($myAnswer['battleEND'])){
                if(empty($return['log'])){
                    $return['log'] = [];
                }
                $return['log'] = array_merge($return['log'], ['battleEND'=>$myAnswer['battleEND']]);
            }
            return $return;
        }
        return [];
    }

    private function viewInfoUser($userInfo){
        if($userInfo && isset($userInfo['id'])){
            return [
                'id'    =>$userInfo['id'],
                'login' =>$userInfo['login'],
                'group' =>$userInfo['group'],
                'sex'   =>$userInfo['sex'],
                'catch' =>$userInfo['catch'],
            ];
        }
        return [];
    }

    private function viewInfoTarget($targetID, $my = false){
        if(is_array($targetID) && isset($targetID['id'])){
            $targetID = intval($targetID['id']);
        }
        if(is_numeric($targetID) && $targetID > 0){
            $targetID = (isset($this->userPokes['p'.$targetID]) ? $this->userPokes['p'.$targetID] : (isset($this->enemyPokes['p'.$targetID]) ? $this->enemyPokes['p'.$targetID] : [] ) );
        }
        if(!empty($targetID) && is_array($targetID)){

            if($targetID['hp'] === true){
                $targetInfo = new PokeBattle($targetID);
                $targetID = $targetInfo->_getData();
            }

            $targetID['stats'] = (isset($targetID['stats']) ? (is_array($targetID['stats']) ? $targetID['stats'] : explode(',', $targetID['stats'])) : []);

		    $LogBattle = Work::$sql->query('SELECT * FROM battle_log WHERE battle = '.$this->battleInfo['id'].' ORDER BY id DESC');
			$LogBattleSel = '';
			$BallsPoke = '';
			if(isset($this->enemyData['pokeLIst']) && $this->battleInfo['type'] == 'pve'){
				$BallsPoke = '<div class="Ball" style="background-image: url(/img/world/items/little/3.png);"></div>';
			}else{
				foreach($this->enemyData['pokeLIst'] as $abc){
					if(isset($abc)){
						if($abc['hp'] <= 0){
							$noneHp = 'noHp';
						}else{
							$noneHp = '';
						}
						$BallsPoke .= '<div class="Ball '.$noneHp.'" style="background-image: url(/img/world/items/little/'.$abc['ball'].'.png);"></div>';
					}
				}
			}
			while($Log = $LogBattle->fetch_row()){
				$LogBattle1 = json_decode($Log[3], true);
				$LogEndBattle = json_decode($Log[4], true);
				$user1 = Work::$sql->query('SELECT login,user_group FROM users WHERE id = '.$LogBattle1[0]['user'])->fetch_row();
				if(isset($LogBattle1[1]) && $LogBattle1[1]['user'] != 0){
					$user2 = Work::$sql->query('SELECT login,user_group FROM users WHERE id = '.$LogBattle1[1]['user'])->fetch_row();
					$userNick2 = '<div class="u-'.$user2[1].'">'.$user2[0].'</div>';
					if(file_exists('img/avatars/mini/'.$LogBattle1[1]['user'].'.png')){
						$userImage2 = '<img src="img/avatars/mini/'.$LogBattle1[1]['user'].'.png" class="ava">';
					}else{
						$userImage2 = '<img src="img/avatars/mini/no-user-img.png" class="ava">';
					}
				}else{
					$userNick2 = '<div class="u-6">Дикий покемон</div>';
					$userImage2 = '';
				}
				$userNick1 = '<div class="u-'.$user1[1].'">'.$user1[0].'</div>';
				if(file_exists('img/avatars/mini/'.$LogBattle1[0]['user'].'.png')){
					$userImage1 = '<img src="img/avatars/mini/'.$LogBattle1[0]['user'].'.png" class="ava">';
				}else{
					$userImage1 = '<img src="img/avatars/mini/no-user-img.png" class="ava">';
				}
				$LogText1 = "";
				$LogText2 = "";
				$LogEnd = "";
				if(isset($LogBattle1[0]["log"])){
					$LogText1 .= '<div class="User">'.$userNick1.'</div>';
					foreach($LogBattle1[0]["log"] as $a){
						$LogText1 .= "<span>".$a."</span>";
					}
				}
				if(isset($LogBattle1[1]["log"])){
					$LogText2 .= '<div class="User">'.$userNick2.'</div>';
					foreach($LogBattle1[1]["log"] as $b){
						$LogText2 .= "<span>".$b."</span>";
					}
				}
				foreach($LogEndBattle as $c){
					$LogEnd .= "<span>".$c."</span>";
				}
				$LogBattleSel .= '<div class="Step"><div class="Round">Раунд '.$Log[2].'</div><div class="Process">'.$LogText1.'</div><div class="Process">'.$LogText2.''.$LogEnd.'</div></div>';
			}

			$typeSprite = $targetID['type'];
			if((int)$this->userInfo['sprite'] == 0){
				$sprite = '/img/pokemons/mini/'.$typeSprite.'/'.numbPok($targetID['basenum']).'.png';
			}else if((int)$this->userInfo['sprite'] == 1){
				$sprite = '/img/pokemons/3d/'.$typeSprite.'/'.numbPok($targetID['basenum']).'.gif';
			}


            //var_dump($targetID['pp_my']);
            if($targetID['gender'] == 'Мальчик') {
              $sex2 = 'mars';
            }elseif($targetID['gender'] == 'Девочка') {
              $sex2 = 'venus';
            }else{
              $sex2 = 'genderless';
            }
            return [
                'id'        => ((isset($targetID['id']) ? intval($targetID['id']) : 0)),
                'ball'      => ((isset($targetID['ball']) ? intval($targetID['ball']) : 3)),
                'basenum'   => ((isset($targetID['basenum']) ? intval($targetID['basenum']) : 0)),
                'basenum2'  => numbPok($targetID['basenum']),
                'name'      => ((isset($targetID['name_new']) ? $targetID['name_new'] : '...')),
                'lvl'       => ((isset($targetID['lvl']) ? intval($targetID['lvl']) : 1)),
                'type2'     => ($targetID['type'] == 'normal' ? '' : $targetID['type']),
                'type'      => ((isset($targetID['type']) ? $targetID['type'] : 'normal')),
                'sex'       => ((isset($targetID['gender']) ? $targetID['gender'] : 'Мальчик')),
                'sex2'      => $sex2,
                'hp'        => ((isset($targetID['hp']) ? intval($targetID['hp']) : 0)),
                'hp_max'    => ((isset($targetID['stats'][0]) ? intval($targetID['stats'][0]) : 0)),
                'hp_before' => 0,
                'atk_before'=> 0,
                'exp'       => (isset($targetID['base_exp_group']) ? Info::_pokeEXP($targetID['lvl'], $targetID['base_exp_group'], $targetID['exp'], $targetID['exp_max']) : []),
                'item'      => ((isset($targetID['item_id']) ? intval($targetID['item_id']) : 0)),
                'pp_my'     => ''.$targetID['pp_my'].'',
                'atkList'   => ((isset($targetID['atkList']) && $my) ? $targetID['atkList'] : []),
                'statMod'   => (isset($targetID['modified']) ? $targetID['modified'] : []),
				'statusList'=> (isset($targetID['status_list']) ? $targetID['status_list'] : []),
				'tren'      => (isset($targetID['tren']) ? $targetID['tren'] : []),
				'LogBattle' => $LogBattleSel,
				'BallsPoke' => $BallsPoke,
				'sprite'	=> $sprite,
            ];

        }
        return [];
    }

    private function viewInfoTeam($teamList){
        if(!empty($teamList) && is_array($teamList)){
            $return = [];
            foreach($teamList AS $key=>$value){
                if(isset($value['id'])){
                    $return['p'.$value['id']] = $this->viewInfoTarget($value);
                }
            }
            return $return;
        }
        return [];
    }

    private function resetAction($battleEnd = false){

        if(isset($this->userInfo['id'])){
            Work::$sql->query("UPDATE `users` SET `status` = 'free' WHERE `id` = '" . intval($this->userInfo['id']) . "'");
        }

        if($battleEnd){

            if($this->_isPVP()){
                if($this->battleInfo['user_1'] <= 0 || $this->battleInfo['user_2'] <= 0){

                    $this->update = [];
                    Work::$sql->query('DELETE FROM atk_helping_hand WHERE user = '.$_SESSION['id']);
					Work::$sql->query('DELETE FROM battle_block WHERE user = '.$_SESSION['id']);
          Work::$sql->query('DELETE FROM atk_rollout WHERE user = '.$_SESSION['id']);
          Work::$sql->query('DELETE FROM atk_furycutter WHERE user = '.$_SESSION['id']);
                    Work::$sql->query('DELETE FROM `battle` WHERE `id` = '.intval($this->battleInfo['id']));

                }else{

                    $upd = ($this->battleInfo['user_1'] == $_SESSION['id'] ? 'user_1' : 'user_2');
                    Work::$sql->query('UPDATE `battle` SET
                                        `'.$upd.'` = 0
                                     WHERE `id` = '.intval($this->battleInfo['id']));

                }


            }else{

                $this->update = [];
                Work::$sql->query('DELETE FROM atk_helping_hand WHERE user = '.$_SESSION['id']);
				Work::$sql->query('DELETE FROM battle_block WHERE user = '.$_SESSION['id']);
        Work::$sql->query('DELETE FROM atk_rollout WHERE user = '.$_SESSION['id']);
        Work::$sql->query('DELETE FROM atk_furycutter WHERE user = '.$_SESSION['id']);
                Work::$sql->query('DELETE FROM `battle` WHERE `id` = '.intval($this->battleInfo['id']));

            }
        }

    }

    /** ~~ PUBLIC METHOD's ~~ **/

    public function _nextRound(){
        $this->round += 1;
    }

    public function lose($user_lose_id, $lose_type = 'OTHER'){

        if(isset($this->userData['lose']) || isset($this->enemyData['lose'])){
            return;
        }
        $this->userData['lose'] = $lose_type;
        $this->update['my'] = true;

        $user_lose = [];
        $user_winner = [];


        if($user_lose_id === true){

            if($this->userInfo['id'] > 0){
                if($this->_isPVP()){
                  foreach($this->userPokes AS $key=>&$value){
                      $value = Info::_updatePokeExp($value, true);
                  }
                  unset($key,$value);
                }
            }

            if($this->enemyInfo['id'] > 0){
              if($this->_isPVP()){
                foreach($this->enemyPokes AS $key=>&$value){
                    $value = Info::_updatePokeExp($value, true);
                }
                unset($key,$value);
              }
            }


        }else{

            $user_lose   = ($this->userInfo['id'] == $user_lose_id ? $this->userInfo  : $this->enemyInfo);
            $user_winner = ($this->userInfo['id'] == $user_lose_id ? $this->enemyInfo : $this->userInfo);

            if($this->userInfo['id'] == $user_lose_id){
                $loser_pokes =& $this->userPokes;
            }else{
                $loser_pokes =& $this->enemyPokes;
            }

            if($this->userInfo['id'] == $user_lose_id){
                $winner_pokes =& $this->enemyPokes;
            }else{
                $winner_pokes =& $this->userPokes;
            }

            if($user_lose['id'] > 0){
              if($this->_isPVP()){
                foreach($loser_pokes AS $key=>&$value){
                    $value = Info::_updatePokeExp($value, true);
                }
                unset($key,$value);
              }

            }

            if($user_winner['id'] > 0){

                if(!$this->_isPVP() && $this->battleInfo['user_2'] == 0){
                  if($this->userInfo['location'] == 313) {
                    $countPokDig = Work::$sql->query('SELECT * FROM `user_raid` WHERE `user` = '.$_SESSION['id'])->fetch_assoc();
                    $dig = $countPokDig['count'] + 1;
                    Work::$sql->query('UPDATE user_raid SET count = '.$dig.' WHERE user = '.$_SESSION['id']);
                  }

					if($this->userInfo['location'] == 207){
						$countPok = Work::$sql->query('SELECT `countPok`
											FROM `user_quest_info`
											WHERE
												`questID` = 10
											AND
												`userID` = '.$_SESSION['id'])->fetch_assoc();
						if($countPok['countPok'] > 0){
							$newCount = $countPok['countPok'] + 1;
							Work::$sql->query('UPDATE `user_quest_info`
										SET
											`countPok` = '.$newCount.'
										WHERE
											`questID` = 10 AND `userID` = '.$_SESSION['id']);
						}
					}
					$winnerRating = json_decode($user_winner['rating']);
					$winnerRatingUpd = '{"pve": '.($winnerRating->pve+1).', "pvp": '.$winnerRating->pvp.', "battleCount": '.$winnerRating->battleCount.'}';

					Work::$sql->query("UPDATE `users`
										SET `rating` = '".$winnerRatingUpd."', `countKillPok` = `countKillPok` + 1 WHERE `id` = '".$user_winner['id']."'");

				   // GOVNO drop
          if($this->userTarget['item_id'] == 44) {
            $kolco = mt_rand(1,100);
            $lrn = Work::$sql->query('SELECT * FROM `learn_pve` WHERE `user` = '.$_SESSION['id'].' AND type = 4')->fetch_assoc();
            if(isset($lrn)){
              $kolco = $kolco * 2;
            }
          }else{
            $kolco = 0;
          }
					$systemBonuses = Work::$sql->query('SELECT * FROM system WHERE id = 1')->fetch_assoc();
          $bafBonuses = Work::$sql->query('SELECT * FROM bafs WHERE type = 2 AND user = '.$_SESSION['id'])->fetch_assoc();
          if($bafBonuses) {
            $bafBonuses1 = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$bafBonuses['baf'])->fetch_assoc();
            $bafBonuses3 = explode(',',$bafBonuses1['info']);
            if($bafBonuses['time'] > time()) {
              $bafBonuses2 = $bafBonuses3['1'];
            }else{
              $bafBonuses2 = 1;
            }
          }else{
            $bafBonuses2 = 1;
          }
					$money = abs(ceil(round(rand(((15*$this->enemyTarget['lvl'])*1*1.5)/5,((16*($this->enemyTarget['lvl']+6))*$systemBonuses['money']*1.5*$bafBonuses2)/4))) + $kolco);
					$this->response['logDrop'] = [];
          $this->response['logDrop'][] = [
              'name'=>'Монета',
              'count'=>$money,
              'id'=> 1
          ];
          // Ивент Зомби
          // if($this->enemyTarget['type'] == 'zombie') {
          //   $zombie = $user_winner['zombie'] + 1;
          //   Work::$sql->query("UPDATE `users`
  				// 						SET `zombie` = '.$zombie.' WHERE `id` = '".$user_winner['id']."'");
          //             $zmRand = mt_rand(1,2000);
          //             if($zmRand >= 1 && $zmRand <= 5) {
          //               $zmItem = 95;
          //             }elseif($zmRand >= 6 && $zmRand <= 20) {
          //               $zmItem = 106;
          //             }elseif($zmRand >= 21 && $zmRand <= 60) {
          //               $zmItem = 187;
          //             }elseif($zmRand >= 61 && $zmRand <= 150) {
          //               $zmItem = 109;
          //             }elseif($zmRand >= 151 && $zmRand <= 325) {
          //               $zmItem2 = mt_rand(37,42);
          //               $zmItem = $zmItem2;
          //             }else{
          //               $zmItem = 0;
          //             }
          //             if($zmItem != 0) {
          //               $zmItem3 = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$zmItem)->fetch_assoc();
          //               $this->response['logDrop'][] = [
          //                   'name'=>$zmItem3['name'],
          //                   'count'=>1,
          //                   'id'=> $zmItem
          //               ];
          //               itemAdd($zmItem, 1, $_SESSION['id']);
          //             }
          // }
          $randPil1 = mt_rand(1,100);
          $randPil2 = mt_rand(1,100);
          $lrn1 = Work::$sql->query('SELECT * FROM `learn_pve` WHERE `user` = '.$_SESSION['id'].' AND type = 5')->fetch_assoc();
          if(isset($lrn1)){
            $randZnak = mt_rand(1,6000);
          }else{
            $randZnak = mt_rand(1,3000);
          }
          $bafgenobol = Work::$sql->query('SELECT * FROM `bafs` WHERE `user` = '.$_SESSION['id'].' AND baf = 280')->fetch_assoc();
          if(isset($bafgenobol) && $bafgenobol['time'] > time()){
            $randgenobol = mt_rand(1,100);
            if($randgenobol >= 85) {
              $this->response['logDrop'][] = [
                  'name'=>'Генобол',
                  'count'=>1,
                  'id'=> 109
              ];
              itemAdd(109, 1, $_SESSION['id']);
            }
          }
          $bafhell = Work::$sql->query('SELECT * FROM `bafs` WHERE `user` = '.$_SESSION['id'].' AND baf = 324')->fetch_assoc();
          if(isset($bafhell) && $bafhell['time'] > time()){
            $randhell1 = mt_rand(1,100);
            $randhell2 = mt_rand(1,100);
            $randhell3 = mt_rand(1,100);
            if($randhell1 >= 85) {
              $this->response['logDrop'][] = [
                  'name'=>'Генобол',
                  'count'=>1,
                  'id'=> 109
              ];
              itemAdd(109, 1, $_SESSION['id']);
            }
            if($randhell2 >= 85) {
              $this->response['logDrop'][] = [
                  'name'=>'Обрывок заклинаний',
                  'count'=>1,
                  'id'=> 193
              ];
              itemAdd(193, 1, $_SESSION['id']);
            }
            if($randhell2 >= 100) {
              $this->response['logDrop'][] = [
                  'name'=>'Набор классификаций',
                  'count'=>1,
                  'id'=> 95
              ];
              itemAdd(95, 1, $_SESSION['id']);
            }
          }
          //$randMuz = mt_rand(1,30);
          // Мелоетта Ивент
          //if($randMuz == 1) {
          //  $rand666 = mt_rand(268,274);
          //  $it2 = Work::$sql->query('SELECT * FROM base_items WHERE id = //.$rand666)->fetch_assoc();
          //  $this->response['logDrop'][] = [
          //      'name'=>$it2['name'],
          //      'count'=>1,
          //      'id'=> $rand666
          //  ];
          //  itemAdd($rand666, 1, $_SESSION['id']);
          //}
          // Мелоетта Ивент Конец

          // $randDRAQUA = mt_rand(1,100);
          // if($randDRAQUA == 1) {
          //    $this->response['logDrop'][] = [
          //        'name'=>'Символ Акваворлда',
          //        'count'=>1,
          //        'id'=> 323
          //    ];
          //   itemAdd(323, 1, $_SESSION['id']);
          // }

          // $randHELL = mt_rand(1,15);
          // if($randHELL == 1) {
          //    $randHELL2 = mt_rand(324,326);
          //    $itemHELL = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$randHELL2)->fetch_assoc();
          //    $this->response['logDrop'][] = [
          //        'name'=>$itemHELL['name'],
          //        'count'=>1,
          //        'id'=> $randHELL2
          //    ];
          //   itemAdd($randHELL2, 1, $_SESSION['id']);
          // }
          // if($this->enemyTarget['basenum'] == 711) {
          //   $randHELL3 = mt_rand(1,5);
          //   if($randHELL3 == 1) {
          //     $this->response['logDrop'][] = [
          //         'name'=>'Тыквенный сундук',
          //         'count'=>1,
          //         'id'=> 327
          //     ];
          //    itemAdd(327, 1, $_SESSION['id']);
          //   }
          // }

         /* if($randZnak == 1) {
            $rand1 = mt_rand(1,25);
            if($rand1 == 1) {
              $randZnak2 = mt_rand(242,244);
            }else{
              $randZnak2 = mt_rand(245,253);
            }
            $it2 = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$randZnak2)->fetch_assoc();
            $this->response['logDrop'][] = [
                'name'=>$it2['name'],
                'count'=>1,
                'id'=> $randZnak2
            ];
            itemAdd($randZnak2, 1, $_SESSION['id']);
          }*/
          if($this->enemyTarget['basenum'] == 10000) {
            $randKorabl = mt_rand(1,40);
            if($randKorabl == 1) {
              $randKorabl2 = mt_rand(37,42);
              $kor = $randKorabl2;
            }elseif($randKorabl == 2) {
              $randKorabl2 = mt_rand(45,50);
              $kor = $randKorabl2;
            }elseif($randKorabl == 3) {
              $randKorabl2 = mt_rand(217,234);
              $kor = $randKorabl2;
            }elseif($randKorabl == 4) {
              $kor = 109;
            }elseif($randKorabl == 5) {
              $randKorabl2 = mt_rand(136,140);
              $kor = $randKorabl2;
            }elseif($randKorabl == 6) {
              $randKorabl2 = mt_rand(7,9);
              $kor = $randKorabl2;
            }elseif($randKorabl == 7) {
              $kor = 180;
            }else{
              $kor = 1;
            }
            if($kor == 1) {
              $mon = mt_rand(250,1000);
              $this->response['logDrop'][] = [
                  'name'=>'Еще монеты',
                  'count'=>$mon,
                  'id'=> 1
              ];
              itemAdd(1, $mon, $_SESSION['id']);
            }else{
              $it2 = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$kor)->fetch_assoc();
              $this->response['logDrop'][] = [
                  'name'=>$it2['name'],
                  'count'=>1,
                  'id'=> $kor
              ];
              itemAdd($kor, 1, $_SESSION['id']);
            }
          }
          if($randPil2 >= 95) {
            if($this->enemyTarget['base_type_two'] == 'bug') {
              $itemType2 = 210;
            }elseif($this->enemyTarget['base_type_two'] == 'dark') {
              $itemType2 = 213;
            }elseif($this->enemyTarget['base_type_two'] == 'dragon') {
              $itemType2 = 212;
            }elseif($this->enemyTarget['base_type_two'] == 'electric') {
              $itemType2 = 202;
            }elseif($this->enemyTarget['base_type_two'] == 'fairy') {
              $itemType2 = 215;
            }elseif($this->enemyTarget['base_type_two'] == 'fighting') {
              $itemType2 = 204;
            }elseif($this->enemyTarget['base_type_two'] == 'fire') {
              $itemType2 = 200;
            }elseif($this->enemyTarget['base_type_two'] == 'fly') {
              $itemType2 = 208;
            }elseif($this->enemyTarget['base_type_two'] == 'ghost') {
              $itemType2 = 211;
            }elseif($this->enemyTarget['base_type_two'] == 'grass') {
              $itemType2 = 203;
            }elseif($this->enemyTarget['base_type_two'] == 'ground') {
              $itemType2 = 205;
            }elseif($this->enemyTarget['base_type_two'] == 'ice') {
              $itemType2 = 206;
            }elseif($this->enemyTarget['base_type_two'] == 'normal') {
              $itemType2 = 199;
            }elseif($this->enemyTarget['base_type_two'] == 'poison') {
              $itemType2 = 207;
            }elseif($this->enemyTarget['base_type_two'] == 'psychic') {
              $itemType2 = 209;
            }elseif($this->enemyTarget['base_type_two'] == 'rock') {
              $itemType2 = 216;
            }elseif($this->enemyTarget['base_type_two'] == 'steel') {
              $itemType2 = 214;
            }elseif($this->enemyTarget['base_type_two'] == 'water') {
              $itemType2 = 201;
            }else{
              $itemType2 = 0;
            }
            if($itemType2 != 0) {
              $it = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$itemType2)->fetch_assoc();
              $this->response['logDrop'][] = [
                  'name'=>$it['name'],
                  'count'=>1,
                  'id'=> $itemType2
              ];
              itemAdd($itemType2, 1, $_SESSION['id']);
            }
          }
          if($randPil1 >= 95) {
            if($this->enemyTarget['base_type'] == 'bug') {
              $itemType1 = 210;
            }elseif($this->enemyTarget['base_type'] == 'dark') {
              $itemType1 = 213;
            }elseif($this->enemyTarget['base_type'] == 'dragon') {
              $itemType1 = 212;
            }elseif($this->enemyTarget['base_type'] == 'electric') {
              $itemType1 = 202;
            }elseif($this->enemyTarget['base_type'] == 'fairy') {
              $itemType1 = 215;
            }elseif($this->enemyTarget['base_type'] == 'fighting') {
              $itemType1 = 204;
            }elseif($this->enemyTarget['base_type'] == 'fire') {
              $itemType1 = 200;
            }elseif($this->enemyTarget['base_type'] == 'fly') {
              $itemType1 = 208;
            }elseif($this->enemyTarget['base_type'] == 'ghost') {
              $itemType1 = 211;
            }elseif($this->enemyTarget['base_type'] == 'grass') {
              $itemType1 = 203;
            }elseif($this->enemyTarget['base_type'] == 'ground') {
              $itemType1 = 205;
            }elseif($this->enemyTarget['base_type'] == 'ice') {
              $itemType1 = 206;
            }elseif($this->enemyTarget['base_type'] == 'normal') {
              $itemType1 = 199;
            }elseif($this->enemyTarget['base_type'] == 'poison') {
              $itemType1 = 207;
            }elseif($this->enemyTarget['base_type'] == 'psychic') {
              $itemType1 = 209;
            }elseif($this->enemyTarget['base_type'] == 'rock') {
              $itemType1 = 216;
            }elseif($this->enemyTarget['base_type'] == 'steel') {
              $itemType1 = 214;
            }elseif($this->enemyTarget['base_type'] == 'water') {
              $itemType1 = 201;
            }else{
              $itemType1 = 0;
            }
            if($itemType1 != 0) {
              $it = Work::$sql->query('SELECT * FROM base_items WHERE id = '.$itemType1)->fetch_assoc();
              $this->response['logDrop'][] = [
                  'name'=>$it['name'],
                  'count'=>1,
                  'id'=> $itemType1
              ];
              itemAdd($itemType1, 1, $_SESSION['id']);
            }
          }

					itemAdd(1, $money, $_SESSION['id']);
					//Work::$sql->query("UPDATE `users` SET `coins` = `coins` + ".$money." WHERE `id` = ".$_SESSION['id']);
					//update_ach(7,$money);
					$dropQueryInfo = [];
					$dropQuery = Work::$sql->query('
                        SELECT
                          *
                        FROM `base_drop_pokemons`

                        WHERE
                          `location_id` IN (0, '.$this->userInfo['location'].')
                      ');
					while($row = $dropQuery->fetch_assoc()){ $dropQueryInfo[] = $row; }
					if(!empty($dropQueryInfo)){

					    foreach($dropQuery AS $key=>$value){
							if(isset($value['chance'], $value['item_id'], $value['item_count'])){
								if(!item_isset($value['item_inv'],$value['item_inv_count']) OR $value['item_inv'] == 0){

									if($value['quest_id'] != 0 && !quest_step($value['quest_id'],$value['quest_progress'])){
										break;
									}

									if($value['pok_id'] > 0 && $value['pok_id'] != $this->enemyTarget['id']){
										continue;
									}

									if($value['pok_num'] > 0 && $value['pok_num'] != $this->enemyTarget['basenum']){
										continue;
									}

									if($value['item_id'] <= 0 || $value['chance'] <= 0){
										continue;
									}

									if($value['chance'] * $systemBonuses['drop'] <= random_int(0, 10000)){
										continue;
									}

									$value['item_count'] = explode(',', $value['item_count']);

									if(isset($value['item_count'][1]) && $value['item_count'][1] > $value['item_count'][0]){
										$value['item_count'] = mt_rand($value['item_count'][0], $value['item_count'][1]);
									}else{
										$value['item_count'] = intval($value['item_count'][0]);
									}

									if($value['item_count'] > 0){

										$itemInfo = Work::$sql->query('SELECT `name`,`id`,`news` FROM `base_items` WHERE `id` = "'.$value['item_id'].'"')->fetch_assoc();

										if(!empty($itemInfo)){

											$this->response['logDrop'][] = [
												'name'=>$itemInfo['name'],
												'count'=>$value['item_count'],
												'id'=>$itemInfo['id']
											];

                      if($itemInfo['news'] == 1) {
                        $user = Work::$sql->query("SELECT * FROM users WHERE id = ".$_SESSION['id'])->fetch_assoc();
                        $catch = ($user['sex'] == "m" ? "выбил" : "выбила");
                        $text = '<div class="user-link"><div onclick=showUserTooltip('.$user['id'].') class="Info-Link sex'.$user['sex'].'"><i class="fa fa-info"></i></div> <div class="u-'.$user['user_group'].'">'.$user['login'].'</div></div> <span>'.$catch.' '.$itemInfo['name'].'</span>';
                        Work::$sql->query("INSERT INTO friends_news (user,text,date) VALUES (".$_SESSION['id'].",'".$text."',".time().")");
                      }

											itemAdd($value['item_id'], $value['item_count'], $_SESSION['id']);

										}

									}
								}

                            }
                        }
                        unset($key, $value);
                    }

                }
				#updRating
				if($this->_isPVP()){
          Work::$sql->query('INSERT INTO battle_end (user1,user2,win,battle) VALUES ('.$user_lose['id'].','.$user_winner['id'].','.$user_winner['id'].','.$this->battleInfo['id'].')');
					Work::$sql->query("UPDATE `users`
										SET `pvp` = `pvp` + 2, `battleCount` = `battleCount` + 1 WHERE `id` = '".$user_winner['id']."'");
										 
					Work::$sql->query("UPDATE `users`
										SET `battleCount` = `battleCount` + 1 WHERE `id` = '".$user_lose['id']."'");
				}else{
          if(isset($this->userTarget['item_id']) && $this->userTarget['item_id'] != 29) {
            foreach($winner_pokes AS $key=>&$value){
                $value = Info::_updatePokeExp($value);
            }
            unset($key,$value);
          }
        }

            }

        }

        $log = $this->generateAnswer([
            'battleEND'=>[
                'title'=>$lose_type,
                'winner'=>(isset($user_winner['id']) ? $user_winner['id'] : false),
                'loser'=>(isset($user_lose['id']) ? $user_lose['id'] : false),
            ]
        ]);

        $this->log = array_merge($this->log, $log);

        if(!$this->_isPVP()){
            $this->resetAction(true);
        }else{
            $this->resetAction(true);
        }

    }

    public function _isPVP(){
        return ($this->battleType === 'pvp');
    }

    public function _isRetarget($pokeList){
        if($pokeList){
            $return = false;

            foreach($pokeList AS $key=>$value){
                if($value && isset($value['hp']) && $value['hp'] > 0){
                    $return = true;
                    break;
                }
            }

            return $return;
        }
        return false;
    }

    public function &_getUserData($userID){
        if($this->userInfo['id'] == $userID){
            return $this->userData;
        }else{
            return $this->enemyData;
        }
    }

    public function &_getUserInfo($userID){
        if($this->userInfo['id'] == $userID){
            return $this->userInfo;
        }else{
            return $this->enemyInfo;
        }
    }

    public function _getUserPokes($userID, $pokes = false){
        if($this->userInfo['id'] == $userID){
            $list =  $this->userPokes;
        }else{
            $list =  $this->enemyPokes;
        }

        if($pokes === false){
            return $list;
        }else{
            return (isset($list['p'.$pokes]) ? $list['p'.$pokes] : []);
        }
    }

    public function _setUserPokes($userID, $pokes, $info = []){
        if($this->userInfo['id'] == $userID){

            if(is_array($pokes)){
                $this->userPokes = $pokes;
            }else{

                if($info){
                    $this->userPokes['p'.$pokes] = $info;
                }

            }

        }else{

            if(is_array($pokes)){
                $this->enemyPokes = $pokes;
            }else{

                if($info){
                    $this->enemyPokes['p'.$pokes] = $info;
                }

            }

        }

    }

    public function _setTarget($userID, $target){
        if(!empty($target)){

            if($this->userInfo['id'] == $userID){
                $this->userData['target'] = $target['id'];
                $this->userTarget = $target;
            }else{
                $this->enemyData['target'] = $target['id'];
                $this->enemyTarget = $target;
            }

        }
    }

    public function __destruct(){
        if(!empty($this->update) && isset($this->battleInfo['id'])){

            if($this->userInfo['id'] == $this->battleInfo['user_1']){
                $upd_my = ' `info_1` = "'.Work::$sql->real_escape_string(Info::_parseData($this->userData)).'" ';
                $upd_enemy = ' `info_2` = "'.Work::$sql->real_escape_string(Info::_parseData($this->enemyData)).'" ';
            }else{
                $upd_my = ' `info_2` = "'.Work::$sql->real_escape_string(Info::_parseData($this->userData)).'" ';
                $upd_enemy = ' `info_1` = "'.Work::$sql->real_escape_string(Info::_parseData($this->enemyData)).'" ';
            }

            Work::$sql->query('UPDATE `battle` SET
                                        `round` = '.$this->round.',
                                        '.$upd_my.'
                                        '.(isset($this->update['enemy']) ? ','.$upd_enemy : '').'
                                        '.($this->otherInfo ? ', `other` = "'.Work::$sql->real_escape_string(Info::_parseData($this->otherInfo)).'" ' : '').'
                                        '.($this->answer ? ', `answer` = "'.Work::$sql->real_escape_string(Info::_parseData($this->answer)).'" ' : ', `answer` = "" ').'
                                     WHERE `id` = '.intval($this->battleInfo['id']));

        }
    }
}
