<?php
class GameChat{

       /**@var $userAccess array */
    private $userAccess = [1,2,3,4,5,6];

    /**@var $response array */
    private $response;

    /**@var $sql mysqli */
    private $sql;

    /**@var $userID int */
    private $userID;

    /**@var $userInfo array */
    private $userInfo = [];

    /**@var $time int */
    private $time;

    /**@var $lastID int */
    private $lastID = 0;

    /**@var $msg string */
    private $msg = '';

    /**@var $msgInfo array */
    private $msgInfo = [];

    /** @var array $dataPoke */
    private $dataPoke = [];

    /** @var array $dataMsg */
    private $dataMsg = [];


    const LIFETIME_MSG = 20;

    const MAX_STRLEN = 2000;

    public function __construct(mysqli $mysqli, $data = [], &$response = [], $userInfo = []){

        $this->time = time();

        $this->sql = $mysqli;

        $this->userID = intval($_SESSION['id']);

        $this->userInfo = array_merge($this->userInfo, $userInfo);

        $this->response =& $response;

        $this->parser($data);

        $this->response = $this->_parseData($this->response);
    }


    private function getUserInfo($userID){
        if($userID){
            if(is_numeric($userID) && $userID > 0){
                return $this->sql->query("SELECT * FROM `users` WHERE `id`='".$userID."'")->fetch_assoc();
            }elseif(is_string($userID)){
                return $this->sql->query("SELECT * FROM `users` WHERE `login`='".$this->sql->real_escape_string($userID)."'")->fetch_assoc();
            }
        }
        return [];
    }

    private function parser($data){

        if($data){

            if(empty($this->userInfo['login'])){
                $this->userInfo = $this->getUserInfo($this->userID);
                if(!$this->userInfo){
                    $this->error('Не найден пользователь.');
                    return;
                }
            }

            $this->lastID = (isset($data['lastID']) ? $data['lastID'] : (isset($_SESSION['CHAT_LAST_ID']) ? $_SESSION['CHAT_LAST_ID'] : 0));

            if(isset($data['type'])){

                switch($data['type']){

                    case 'read':
                        $this->read();
                        break;

                    case 'add':
                        $this->add();
                        break;

                    case 'console':
                        $this->console();
                        break;

                }

            }

        }

    }

    private function console(){
        if(isset($_POST['console'])){
            $type = $_POST['console'];
            $user = (isset($_POST['user']) ? $_POST['user'] : '');
            $title = (isset($_POST['title']) ? $_POST['title'] : '...');
            if($user){
                $user = $this->getUserInfo($user);
            }
            switch($type){
                case 's':
                case 'us':
                    if($user && in_array($this->userInfo['user_group'], [1,2,3])){
                        $time = (isset($_POST['time']) ? $_POST['time'] : 10);
                        $time = ($time * 60) + $this->time;

                        if($type == 'us'){
                            $time = 0;
                        }

                        $ban = $this->_unParseData($user['ban']);
                        $ban = array_merge($ban, [
                            'chat'=>$time
                        ]);
                        $ban = $this->_parseData($ban);

                        $this->sql->query("UPDATE `users` SET `ban`='".$this->sql->real_escape_string($ban)."' WHERE `id`='".$user['id']."'");

                        $this->msgInfo['css'] = ['mut'];
                        if($time > 0){
                            $this->add('Выдано молчание тренеру <div class="u-'.$user['user_group'].'">'.$user['login'].'</div> на <span>'.downcounter($time).'.</span> По причине: <span>'.$title.'</span>');
                        }else{
                            $this->add('С тренера <div class="u-'.$user['user_group'].'">'.$user['login'].'</div> снято молчание по причине: <span>'.$title.'</span>');
                        }
                    }
                    break;
                case 'm':
                case 'mm':
                    if($user && in_array($this->userInfo['user_group'], [1,2,3])){
                        $this->msgInfo['css'] = ['pred'];
                        if($type == 'm'){
                            $this->add('Вам выдано предупреждение по причине: '.$title, 1, $user);
                        }else{
                            $this->add('Выдано <span>Предупреждение</span> тренеру <div class="u-'.$user['user_group'].'">'.$user['login'].'</div>! По причине: <span>'.$title.'</span>');
                        }
                    }
                break;
                case 'clear':
                    if($user && in_array($this->userInfo['user_group'], [1,2,3])){
                        $this->sql->query("UPDATE `users` SET `about`= '' WHERE `id`='".$user['id']."'");
                        $this->add('Профиль тренера '.$user['login'].' очищен.', 1, $user);
                    }
					break;
				case 'moder':
                    if(in_array($this->userID, [1])){
                        $this->sql->query('UPDATE `users` SET `user_group`= 3 WHERE `id`='.$user['id']);
                        $this->add('Вы стали модератором.', 1, $user);
                    }
					break;
				case 'moderDel':
                    if(in_array($this->userID, [1])){
                        $this->sql->query('UPDATE `users` SET `user_group`= 6 WHERE `id`='.$user['id']);
                        $this->add('Вы больше не модератор.', 1, $user);
                    }
					break;
				case 'nast':
                    if(in_array($this->userID, [1])){
                        $this->sql->query('UPDATE `users` SET `user_group`= 4 WHERE `id`='.$user['id']);
                        $this->add('Вы стали наставником.', 1, $user);
                    }
					break;
				case 'nastDel':
                    if(in_array($this->userID, [1])){
                        $this->sql->query('UPDATE `users` SET `user_group`= 6 WHERE `id`='.$user['id']);
                        $this->add('Вы больше не наставник.', 1, $user);
                    }
					break;
				case 'upGroup':
						if(in_array($this->userInfo['user_group'], [1])){
							$group = (isset($_POST['group']) ? clearInt($_POST['group']) : 6);
							$this->sql->query('UPDATE `users` SET `user_group`= '.$group.' WHERE `id`='.$user['id']);
							$this->add('Вам была присвоена новая группа.', 1, $user);
						}else{
							$this->add('Вы не Администратор!', 1, $this->userInfo['id']);
						}
					break;
          case 'system':
    if(in_array($this->userInfo['user_group'], [1])){
      $this->msgInfo['css'] = ['arest'];
      $this->add($_POST['text'], false, false, 1);
    }
    break;
          case 'free':
    if($user && in_array($this->userInfo['user_group'], [1,2])){
      $time = 0;
      $ban = $this->_unParseData($user['ban']);
      $ban = array_merge($ban, [
                      'game'=>$time
                  ]);
      $ban = $this->_parseData($ban);
      $banan = $this->sql->query("SELECT * FROM `teleport_user` WHERE `user` = ".$user['id'])->fetch_assoc();
      $banan2 = ($banan ? $banan['location'] : 1);
      $this->sql->query("UPDATE `users` SET
                                                `user_group`= 6,
                                                `location`= '.$banan2.',
                                                `ban`='".$this->sql->real_escape_string($ban)."'
                                           WHERE `id`='".$user['id']."'");
      $this->sql->query("DELETE FROM `teleport_user` WHERE `user` = ".$user['id']);
      $this->msgInfo['css'] = ['arest'];
      $this->add('Тренер <div class="u-'.$user['user_group'].'">'.$user['login'].'</div> освобожден из тюрьмы.');
    }
    break;
                case 'prison':
                    if($user && in_array($this->userInfo['user_group'], [1,2])){
                        $time = (isset($_POST['time']) ? $_POST['time'] : 10);
                        $time = ($time * 24 * 3600) + $this->time;

                        $ban = $this->_unParseData($user['ban']);
                        $ban = array_merge($ban, [
                            'game'=>$time
                        ]);
                        $ban = $this->_parseData($ban);
						$this->sql->query("INSERT INTO  teleport_user (user,location,go) VALUES (".$this->userInfo['id'].",".$this->userInfo['location'].",'prison') ");
                        $this->sql->query("UPDATE `users` SET
                                                      `user_group`= 8,
                                                      `location`= 0,
                                                      `ban`='".$this->sql->real_escape_string($ban)."'
                                                 WHERE `id`='".$user['id']."'");

                        $this->msgInfo['css'] = ['arest'];
						$this->add('Тренер <div class="u-'.$user['user_group'].'">'.$user['login'].'</div> арестован на <span>'.downcounter($time).'.</span> По причине: <span>'.$title.'</span>');
                    }
                    break;
                case 'fine':
                    if($user && in_array($this->userInfo['user_group'], [1,2])){
                        $sum = (isset($_POST['sum']) ? intval($_POST['sum']) : 0);
                        if($sum > 0){
                            minus_item(1, $sum, $user['id']);
                            $this->msgInfo['css'] = ['arest'];
                            $this->add('Тренеру <div class="u-'.$user['user_group'].'">'.$user['login'].'</div> выписан штраф, на сумму <span>'.$sum.' мон.</span> По причине: <span>'.$title.'</span>');
                        }
                    }
                    break;
                // case 'transf':
                //     if($user && in_array($this->userInfo['user_group'], [1,2])){
                //         $poke = (isset($_POST['pokeID']) ? intval($_POST['pokeID']) : 0);
                //         if($poke > 0){
                //             $this->sql->query("UPDATE `user_pokemons` SET `user_id`= 2 WHERE `id`='".$poke."'");
                //             $this->add('У вас изъят покемон, ID которого был: '.$poke, 1, $user);
                //         }
                //     }
                //     break;
                case 'comment':
                    if($user && in_array($this->userInfo['user_group'], [1,2])){
                        if($title){
                            $this->sql->query("INSERT INTO `base_comments`(`user1`,`user2`,`comment`) VALUES ('".$_SESSION['id']."','".$user['id']."','".$this->sql->real_escape_string($this->getText($title))."') ");
                        }
                    }
                    break;
                case 'ban':
                    if($user && in_array($this->userInfo['user_group'], [1,2])){

                        $this->sql->query("UPDATE `users` SET
                                                `status`= 'ban',
                                                `rang` = 'Заблокированный',
                                                `about` = 'Причина блокировки: ".$this->sql->real_escape_string($this->getText($title))."',
                                                `user_group` = '7'
                                            WHERE `id`= '".$user['id']."'");
$this->msgInfo['css'] = ['arest'];
                        $this->add('Тренер <div class="u-'.$user['user_group'].'">'.$user['login'].'</div> заблокирован. Причина: <span>'.$title.'</span>');
                    }
                    break;
                case 'tp':
                    if(in_array($this->userInfo['user_group'], [1])){
                        $locName =  (isset($_POST['loc_name']) ? $_POST['loc_name'] : '');

                        if(!empty($locName)){
                            $baseLoc = $this->sql->query("SELECT `id` FROM `base_location` WHERE `name` = '".$locName."'")->fetch_assoc();

                            if($baseLoc){
                                $this->sql->query("UPDATE `users` SET `location`='".$baseLoc['id']."' WHERE `id`='".$this->userID."'");
                            }

                        }

                    }
                    break;
                    case 'aqua':
                        if(in_array($this->userID, [1])){
                            $sum = (isset($_POST['sum']) ? intval($_POST['sum']) : 0);

                            if($sum > 0){
                                itemAdd(43, $sum, $user['id']);
                                $this->add('Вам выдан Жемчуг в количестве: '.$sum.' шт.', 1, $user);
    							Info::_logGame($this->userID, 'ADD_AQUARITS', [
    								'user_to'=>$user['id'],
    								'count'=>$sum,
    							], 'items');
                            }
                        }
                        break;
                case 'mdel':
                    if(in_array($this->userInfo['user_group'], [1,2,3])){
                        $msg_id = (isset($_POST['msg_id']) ? intval($_POST['msg_id']) : 0);
                        $msg_text = (isset($_POST['msg_text']) ? $_POST['msg_text'] : '');

                        if($msg_id > 0){

                            $this->add('{"msg_del":'.intval($msg_id).'}', 20);
                            $this->add('Удалено сообщение: '.$msg_text, 10);

                        }
                    }
                    break;
                case 'mreport':
                    if(in_array($this->userInfo['user_group'], [1,2,3,4,5,6])){
                        $msg_id = (isset($_POST['msg_id']) ? intval($_POST['msg_id']) : 0);
                        $msg_text = (isset($_POST['msg_text']) ? $_POST['msg_text'] : '');

                        if($msg_id > 0){

                            $this->add('Поступила жалоба на сообщение: '.$msg_text, 21);

                        }
                    }
                    break;
            }
        }
    }

    private function add($msg = '', $type = false, $uinfo = [], $system = false){
    if($system == 1) {
      $userPost = 2;
      $userPostLogin = 'Система League-18';
    }else{
      $userPost = $this->userInfo['id'];
      $userPostLogin = $this->userInfo['login'];
    }
		$userClan = $this->sql->query("SELECT `clan_id` FROM `base_clans_users` WHERE `user_id` = '".$userPost."'")->fetch_assoc();
        $msg = (empty($msg) ? $_POST['msg'] : $msg);
        if(!empty($msg)){

            if($type === false){
                $ban = ($this->userInfo['ban'] ? $this->_unParseData($this->userInfo['ban']) : null);
                if($ban && isset($ban['chat']) && $ban['chat'] > time()){
                    $this->error('Вы будете молчать еще '.downcounter($ban['chat']));
                    return;
                }
            }

            $this->msg = getText($msg);

            if(is_string($this->msg) && strlen($this->msg) <= self::MAX_STRLEN){

                $msg_type   = (isset($_POST['chanel']) ? $_POST['chanel'] : 0);

                $touser     = (isset($_POST['to_user']) ? $_POST['to_user'] : 0);


                if(!empty($touser)){

                    if($touser > 0){
                        $touser = $this->getUserInfo(intval($touser));
                    }else{
                        $touser = $this->getUserInfo($this->getText($touser));
                    }

                    if(empty($touser)){
                        $this->error('Не найден пользователь.');
                        return;
                    }

                }

                if($type && $type !== false){
                    $msg_type = $type;
                }

                if(!empty($uinfo)){
                    $touser = $uinfo;
                }

                if(!($type && $type == 20)){
                    if($this->userInfo['user_group'] == 1 || $this->userInfo['user_group'] == 2 || $this->userInfo['user_group'] == 3 || $this->userInfo['user_group'] == 4 || $this->userInfo['user_group'] == 5 || $this->userInfo['user_group'] == 100){
                      $this->msg = $this->msg;
                    }else{
                      $this->msg = htmlspecialchars(trim($this->msg));
                    }
                }


                $zapret1 = strripos($this->msg,'l-17');
                $zapret2 = strripos($this->msg,'aquaworld');
                if($zapret2 === false) {

                }else{
                  $time123 = time() + 3600;
                  $ban = $this->_unParseData($this->userInfo['ban']);
                  $ban = array_merge($ban, [
                      'chat'=>$time123
                  ]);
                  $ban = $this->_parseData($ban);
                  $this->sql->query("UPDATE `users` SET `ban`='".$this->sql->real_escape_string($ban)."' WHERE `id`='".$this->userInfo['id']."'");
                  $this->error('Вы получили молчание на 1 час.');
                  return;
                }
                if($zapret1 === false) {

                }else{
                  $time123 = time() + 3600;
                  $ban = $this->_unParseData($this->userInfo['ban']);
                  $ban = array_merge($ban, [
                      'chat'=>$time123
                  ]);
                  $ban = $this->_parseData($ban);
                  $this->sql->query("UPDATE `users` SET `ban`='".$this->sql->real_escape_string($ban)."' WHERE `id`='".$this->userInfo['id']."'");
                  $this->error('Вы получили молчание на 1 час.');
                  return;
                }

               if($this->msg{0} == '='){
                    $msg_type = 30;
                    $this->msg = substr($this->msg, 1);
                }elseif($this->msg{0} == '/'){
                    $msg_type = 30;
                    $this->msg = substr($this->msg, 1);
                }

                if(substr($msg_type,0,1) == 5) {
                  $msgTyp = substr($msg_type, 1);
                  $user1 = $this->sql->query("SELECT * FROM `users` WHERE `login` = '".$msgTyp."'")->fetch_assoc();
                  if(!$user1) {
                    $this->error('Тренер не найден.');
                    return;
                  }else{
                    $this->msgInfo['userto_id'] = $user1['id'];
                    $this->msgInfo['userto_login'] = $user1['login'];
        						$this->msgInfo['userto_group'] = $user1['user_group'];
        						$this->msgInfo['img_to'] = 1;
                    $this->msgInfo['sex_to'] = $user1['sex'];
                  }
                }

                if($msg_type == 9 && $type === false){
                    if(isset($_SESSION['timeout_chat_trade'])){

                        if($_SESSION['timeout_chat_trade'] > time()){

                            $this->error('В данный чат можно писать 1 раз в 5 минут.');
                            return;

                        }else{
                            $_SESSION['timeout_chat_trade'] = time() + 260;
                        }

                    }else{
                        $_SESSION['timeout_chat_trade'] = time() + 260;
                    }
                }
                //  if($msg_type == 8 && $type === false){
                //     if(isset($_SESSION['timeout_chat_trade'])){

                //         if($_SESSION['timeout_chat_trade'] > time()){

                //             $this->error('Вы уже задали вопрос, ожидайте ответа.<br> В чат можно писать раз в 1 минуту.');
                //             return;

                //         }else{
                //             $_SESSION['timeout_chat_trade'] = time() + 100;
                //         }

                //     }else{
                //         $_SESSION['timeout_chat_trade'] = time() + 100;
                //     }
                // }

				if($msg_type == 21 && $type === false){
					if(!$userClan){
						$this->error('Вы не состоите в клане.');
						return;
					}
                }

                //if(isset($_SESSION['id']) && $_SESSION['id'] == 5){
                    $this->msg = preg_replace_callback("@(https?://)?(([a-zA-Z0-9.-]+)?[a-zA-Z0-9-]+(!?\.[a-zA-Z]{2,5}))+(/[^\s]*)?@", [$this, 'preg_link'], $this->msg);
                //}

                $this->msg = preg_replace_callback("/\#([0-9]{1,10})/", [$this, 'preg_poke_sprites'], $this->msg, 10);
                $this->msg = preg_replace_callback("/\#s([0-9]{1,10})/", [$this, 'preg_poke_sprites_s'], $this->msg, 10);
                $this->msg = preg_replace_callback("/\%i([0-9]{1,10})/", [$this, 'preg_item'], $this->msg, 10);
                $this->msg = preg_replace_callback("/\%random([0-9]{1,10})/", [$this, 'preg_random'], $this->msg, 10);
                $this->msg = preg_replace_callback("/\%or/", [$this, 'preg_or'], $this->msg, 10);
                $this->msg = preg_replace_callback("/\%p([0-9]{1,10})/", [$this, 'preg_poke_user'], $this->msg, 10);
                // if($this->msg == 'Конфеты или жизнь' || $this->msg == 'Конфета или жизнь') {
                //   $timeHELL = $this->sql->query('SELECT * FROM time_hell WHERE user = '.$userPost.'')->fetch_assoc();
                //   $userHELL = $this->sql->query('SELECT * FROM users WHERE id = '.$touser['id'].'')->fetch_assoc();
                //   if($userHELL) {
                //     $timeOnline = time() - 300;
                //     if($userHELL['online'] >= $timeOnline) {
                //       if($timeHELL) {
                //         if($timeHELL['time'] > time()) {
                //           $this->error('Время просить конфеты еще не пришло!');
                //           return;
                //         }else{
                //           $itemHELL1 = $this->sql->query('SELECT * FROM items_users WHERE item_id = 324 AND user = '.$touser['id'])->fetch_assoc();
                //           $itemHELL2 = $this->sql->query('SELECT * FROM items_users WHERE item_id = 325 AND user = '.$touser['id'])->fetch_assoc();
                //           $itemHELL3 = $this->sql->query('SELECT * FROM items_users WHERE item_id = 326 AND user = '.$touser['id'])->fetch_assoc();
                //           if($itemHELL1 || $itemHELL2 || $itemHELL3) {
                //             if($itemHELL1 && !$itemHELL2 && !$itemHELL3) {
                //               itemAdd(324,1);
                //               minus_item(324,1,$touser['id']);
                //             }elseif(!$itemHELL1 && $itemHELL2 && !$itemHELL3) {
                //               itemAdd(325,1);
                //               minus_item(325,1,$touser['id']);
                //             }elseif(!$itemHELL1 && !$itemHELL2 && $itemHELL3) {
                //               itemAdd(326,1);
                //               minus_item(326,1,$touser['id']);
                //             }elseif($itemHELL1 && $itemHELL2 && !$itemHELL3) {
                //               $rand = mt_rand(1,2);
                //               if($rand == 1) {
                //                 itemAdd(324,1);
                //                 minus_item(324,1,$touser['id']);
                //               }else{
                //                 itemAdd(325,1);
                //                 minus_item(325,1,$touser['id']);
                //               }
                //             }elseif($itemHELL1 && !$itemHELL2 && $itemHELL3) {
                //               $rand = mt_rand(1,2);
                //               if($rand == 1) {
                //                 itemAdd(324,1);
                //                 minus_item(324,1,$touser['id']);
                //               }else{
                //                 itemAdd(326,1);
                //                 minus_item(326,1,$touser['id']);
                //               }
                //             }elseif(!$itemHELL1 && $itemHELL2 && $itemHELL3) {
                //               $rand = mt_rand(1,2);
                //               if($rand == 1) {
                //                 itemAdd(325,1);
                //                 minus_item(325,1,$touser['id']);
                //               }else{
                //                 itemAdd(326,1);
                //                 minus_item(326,1,$touser['id']);
                //               }
                //             }elseif($itemHELL1 && $itemHELL2 && $itemHELL3) {
                //               $rand = mt_rand(1,3);
                //               if($rand == 1) {
                //                 itemAdd(325,1);
                //                 minus_item(325,1,$touser['id']);
                //               }elseif($rand == 2){
                //                 itemAdd(324,1);
                //                 minus_item(324,1,$touser['id']);
                //               }else{
                //                 itemAdd(326,1);
                //                 minus_item(326,1,$touser['id']);
                //               }
                //             }
                //             $this->msg = '<span class="ItemInChat">Спасибо за конфетку!</span>';
                //             $timeh = time() + 3600;
                //             $this->sql->query("UPDATE time_hell SET time = ".$timeh." WHERE user = ".$userPost);
                //           }else{
                //             $this->error('У тренера нет ни одной конфеты.');
                //             return;
                //           }
                //         }
                //       }else{
                //         $time = time() + 3600;
                //         $this->msg = '<span class="ItemInChat">Спасибо за конфетку!</span>';
                //         $this->sql->query("INSERT INTO time_hell (user,time) VALUES (".$userPost.",".$time.") ");
                //         $itemHELL1 = $this->sql->query('SELECT * FROM items_users WHERE item_id = 324 AND user = '.$touser['id'])->fetch_assoc();
                //         $itemHELL2 = $this->sql->query('SELECT * FROM items_users WHERE item_id = 325 AND user = '.$touser['id'])->fetch_assoc();
                //         $itemHELL3 = $this->sql->query('SELECT * FROM items_users WHERE item_id = 326 AND user = '.$touser['id'])->fetch_assoc();
                //         if($itemHELL1 || $itemHELL2 || $itemHELL3) {
                //           if($itemHELL1 && !$itemHELL2 && !$itemHELL3) {
                //             itemAdd(324,1);
                //             minus_item(324,1,$touser['id']);
                //           }elseif(!$itemHELL1 && $itemHELL2 && !$itemHELL3) {
                //             itemAdd(325,1);
                //             minus_item(325,1,$touser['id']);
                //           }elseif(!$itemHELL1 && !$itemHELL2 && $itemHELL3) {
                //             itemAdd(326,1);
                //             minus_item(326,1,$touser['id']);
                //           }elseif($itemHELL1 && $itemHELL2 && !$itemHELL3) {
                //             $rand = mt_rand(1,2);
                //             if($rand == 1) {
                //               itemAdd(324,1);
                //               minus_item(324,1,$touser['id']);
                //             }else{
                //               itemAdd(325,1);
                //               minus_item(325,1,$touser['id']);
                //             }
                //           }elseif($itemHELL1 && !$itemHELL2 && $itemHELL3) {
                //             $rand = mt_rand(1,2);
                //             if($rand == 1) {
                //               itemAdd(324,1);
                //               minus_item(324,1,$touser['id']);
                //             }else{
                //               itemAdd(326,1);
                //               minus_item(326,1,$touser['id']);
                //             }
                //           }elseif(!$itemHELL1 && $itemHELL2 && $itemHELL3) {
                //             $rand = mt_rand(1,2);
                //             if($rand == 1) {
                //               itemAdd(325,1);
                //               minus_item(325,1,$touser['id']);
                //             }else{
                //               itemAdd(326,1);
                //               minus_item(326,1,$touser['id']);
                //             }
                //           }elseif($itemHELL1 && $itemHELL2 && $itemHELL3) {
                //             $rand = mt_rand(1,3);
                //             if($rand == 1) {
                //               itemAdd(325,1);
                //               minus_item(325,1,$touser['id']);
                //             }elseif($rand == 2){
                //               itemAdd(324,1);
                //               minus_item(324,1,$touser['id']);
                //             }else{
                //               itemAdd(326,1);
                //               minus_item(326,1,$touser['id']);
                //             }
                //           }
                //         }else{
                //           $this->error('У тренера нет ни одной конфеты.');
                //           return;
                //         }
                //       }
                //     }else{
                //       $this->error('Тренер оффлайн.');
                //       return;
                //     }
                //   }else{
                //     $this->error('Тренера, у которого вы хотите взять конфету, не существует.');
                //     return;
                //   }
                // }

                # Удалим ненужные слова.
                $this->msg = preg_replace("/(покелегенд(а|ы|у|е)|pokelegenda|l-17|17-l|aquaworld|atom|лига_17|орчрус|очрус|orthrus|league17|cc|league 17|лига 17|лига17|лигу17|лигу 17|сука|пизд(а|ы|у)?|хуй|хуя|хуе|хуи|бляд(ь)?)/si","<small>***</small>", $this->msg);

				#Делаем кликабельными ссылки
				preg_match_all ("/(http:\\/\\/)?([a-z_0-9-.]+\\.[a-z]{2,3}(([ \"'>\r\n\t])|(\\/([^ \"'>\r\n\t]*)?)))/",$this->msg,$url);
				$link_name=mb_strimwidth($found_url,7,20,"...");
				if($link_name !== FALSE){
					$first_str=stristr($this->msg, $found_url, true);
					$last_str = substr(stristr($this->msg, $found_url), strlen($found_url));
					$this->msg = $first_str.'<a target="_blank" href="'.$found_url.'">'.$link_name.'</a>'.$last_str;
				}

				if($msg_type >= 10 && $msg_type != 21 && substr($msg_type,0,1) != 5){
                    if(!in_array($this->userInfo['user_group'], $this->userAccess)){
                        $msg_type = 0;
                    }
                }
                if($type && $type == 21){
                    $msg_type = 10;
                }

                # Занесем данные о пользователе и сообщении.
				$imgU = (file_exists($_SERVER['DOCUMENT_ROOT'].'/img/avatars/mini/'.$userPost.'.png') ? $userPost : 'no-user-img');
				$imgU_to = (file_exists($_SERVER['DOCUMENT_ROOT'].'/img/avatars/mini/'.$touser['id'].'.png') ? $touser['id'] : 'no-user-img');
                $this->msgInfo['user_id']    = $userPost;
                $this->msgInfo['user_login'] = $userPostLogin;
                $this->msgInfo['user_sex'] = $this->userInfo['sex'];
                $this->msgInfo['user_group'] = $this->userInfo['user_group'];
                $this->msgInfo['user_msg_color'] = $this->userInfo['colorChat'];
                $this->msgInfo['user_msg'] = $this->msg;
                $this->msgInfo['msg_type'] = intval($msg_type);
                $this->msgInfo['msg_time'] = date('H:i', $this->time);
                $this->msgInfo['msg_class'] = (isset($msgClass) ? ($msgClass) : '');
				$this->msgInfo['img'] = $imgU;

                # Если сообщение направленное и имеется юзер, добавляем дополнительные данные.
                if($touser && $msg_type < 22){
					if($msg_type == 21){
						$userClanAny = $this->sql->query("SELECT `id` FROM `base_clans_users` WHERE `user_id` = '".$touser['id']."' AND `clan_id` = '".$userClan['clan_id']."'")->fetch_assoc();
						if($userClanAny){
							$this->msgInfo['userto_id']    = $touser['id'];
              $this->msgInfo['userto_login'] = $touser['login'];
							$this->msgInfo['userto_group'] = $touser['user_group'];
							$this->msgInfo['img_to'] = $imgU_to;
              $this->msgInfo['sex_to'] = $touser['sex'];
						}
					}else{
						$this->msgInfo['userto_id']    = $touser['id'];
            $this->msgInfo['userto_login'] = $touser['login'];
						$this->msgInfo['userto_group'] = $touser['user_group'];
						$this->msgInfo['img_to'] = $imgU_to;
            $this->msgInfo['sex_to'] = $touser['sex'];
					}
                }

                if(isset($this->msgInfo['css'])){
                    if(is_array($this->msgInfo['css'])){
                        $this->msgInfo['css'] = implode(' ', $this->msgInfo['css']);
                    }
                }

                if(!empty($this->dataPoke)){
                    $this->msgInfo['poke_list'] = $this->dataPoke;
                }

                if(!empty($this->dataMsg)){
                    $this->msgInfo['data_msg'] = $this->dataMsg;
                }

                $msg = $this->sql->real_escape_string($this->_parseData($this->msgInfo));
				if($this->sql->set_charset("utf8")){
                    $this->sql->query("
                      INSERT INTO
                        `chat_new`
                             (`type`,`user`,`touser`,`info`,`lifetime`,`location`,`clan`,`img`,`img_to`)
                      VALUES ('".$msg_type."', '".$userPost."', '".($touser ? $touser['id'] : 0)."', '".$msg."', '".($this->time + self::LIFETIME_MSG)."', '".(isset($this->userInfo['location']) ? $this->userInfo['location'] : 0)."', '".(isset($userClan) ? $userClan['clan_id'] : 0)."', '".$imgU."', '".$imgU_to."')"
                    );

                    $this->read();
                }

            }
        }
    }

    private function zombie() {
      $rand = mt_rand(1,30);
      if($rand == 1) {
        $a = 'Удачливый засранец';
      }elseif($rand == 2) {
        $a = 'Приручитель зомби';
      }elseif($rand == 3) {
        $a = 'Чувак с бензопилой';
      }elseif($rand == 4) {
        $a = 'Где моя бензопила?';
      }elseif($rand == 5) {
        $a = 'Переиграл в PvZ';
      }elseif($rand == 6) {
        $a = 'Дед с дробовиком';
      }elseif($rand == 7) {
        $a = 'Бабка с лопатой';
      }elseif($rand == 8) {
        $a = 'В каком из этих ящиков ружье?';
      }elseif($rand == 9) {
        $a = 'Спецназовец в отставке';
      }elseif($rand == 10) {
        $a = 'Бесполезный ребенок';
      }elseif($rand == 11) {
        $a = 'Использует Катерпи вместо оружия';
      }elseif($rand == 12) {
        $a = 'Как он вообще выжил?';
      }elseif($rand == 13) {
        $a = 'Кто первый умрет';
      }elseif($rand == 14) {
        $a = 'Мозговитый';
      }elseif($rand == 15) {
        $a = 'Выгнали из убежища';
      }elseif($rand == 16) {
        $a = 'Потерял оружие и чуть не умер';
      }elseif($rand == 17) {
        $a = 'Я съел зомби';
      }elseif($rand == 18) {
        $a = 'Танкист';
      }elseif($rand == 19) {
        $a = 'Пилот вертолета';
      }elseif($rand == 20) {
        $a = 'Покусанный';
      }elseif($rand == 21) {
        $a = 'Остался без ноги';
      }elseif($rand == 22) {
        $a = 'Патрулирует лес';
      }elseif($rand == 23) {
        $a = 'Добывает провизию';
      }elseif($rand == 24) {
        $a = 'Бывший мент';
      }elseif($rand == 25) {
        $a = 'Убил напарника';
      }elseif($rand == 26) {
        $a = 'Мастер боевых искусств';
      }elseif($rand == 27) {
        $a = 'Зомби';
      }elseif($rand == 28) {
        $a = 'Разведчик';
      }elseif($rand == 29) {
        $a = 'Снайпер';
      }elseif($rand == 30) {
        $a = 'ХИЛЬ МЕНЯ МЕДИК';
      }else{
        $a = 'ЗомбоКиллер';
      }
      return $a;
    }


    private function read(){
		$infoChat = [];
        $info = $this->sql->query('
                  SELECT
                    *
                  FROM `chat_new`
                  WHERE
                    `lifetime` >= '.$this->time.' AND
                    `id` > '.intval($this->lastID).'
                ');
		while($row = $info->fetch_assoc()){ $infoChat[] = $row; }

        if(!empty($infoChat)){

            $return = [];

            foreach($info AS $key=>$value){

                if(isset($value['id'])){

                    $this->lastID = intval($value['id']);

                    # Полиция
                    if($value['type'] == 10){
                        if(!(isset($this->userInfo['user_group']) && in_array($this->userInfo['user_group'], $this->userAccess))) continue;
                    }
                    # Торговля
                    /*if($value['type'] == 9){
                        if(!(isset($this->userInfo['user_group']) && in_array($this->userInfo['user_group'], $this->userAccess))) continue;
                    }*/

                       if($value['type'] == 1){
                        if(!(
                            isset($this->userInfo['id']) &&
                            ($this->userInfo['id'] == $value['user'] || $this->userInfo['id'] == $value['touser'])
                        )) continue;
                    }

					# Клан
					if($value['type'] == 21){
						$userClan = $this->sql->query("SELECT `clan_id` FROM `base_clans_users` WHERE `user_id` = '".$this->userInfo['id']."'")->fetch_assoc();
                        if(!(isset($userClan) && $userClan['clan_id'] == $value['clan'])) continue;
                    }

                    # Приват $this->userInfo['id'] == 5
                    if($value['type'] == 30){
                        if(!(
                            isset($this->userInfo['id']) &&
                            ($this->userInfo['id'] == $value['user'] || $this->userInfo['id'] == $value['touser'])
                        )) continue;
                    }

                    if(substr($value['type'],0,30) == 5) {
                      if(!(
                          isset($this->userInfo['id']) &&
                          ($this->userInfo['id'] == $value['user'] || $this->userInfo['id'] == $value['touser'])
                      )) continue;
                    }

                    $return[$value['id']] = $value['info'];

                }

            }

            unset($key,$value);

            if(!empty($return)){
                $this->response['infoChat'] = $return;
            }
            $this->response['infoChatLastId'] = $this->lastID;
        }
    }

    private function error($text, $type = 1){
        $this->response['error'] = $type;
        $this->response['text']  = $text;
    }

    /**
     * @param $data array
     * @return string
     */
    private function _parseData(array $data = []){
        $return = false;
        if(!empty($data)){
            try{
                if(function_exists('json_encode')){
                    $return = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                }else{
                    $return = serialize($data);
                }
            }catch (Exception $e){
                $return = '{}';
            }
        }
        return ($return ? $return : '{}');
    }

    /**
     * @param $data string
     * @return array
     */
    private function _unParseData($data = null){
        $return = [];
        if(!empty($data)){
            try{
                if(function_exists('json_decode')){
                    $return = json_decode($data, true, 512, JSON_BIGINT_AS_STRING);
                }else{
                    $return = unserialize($data);
                }
            }catch (Exception $e){
                $return = [];
            }
        }
        return ($return ? $return : []);
    }

    private function getText($text){
        $text = preg_replace('/  +/',' ', $text);
        return 	htmlspecialchars(stripslashes(trim($text)));
    }

    private function preg_poke_sprites($matches){
        if(isset($matches[1]) && is_numeric($matches[1])){
            $number = intval($matches[1]);
            $check = ($number < 10 ? '00'.$number : ($number < 100 ? '0'.$number : $number));
            $pokemon = $this->sql->query("SELECT `name_rus` FROM `base_pokemons` WHERE `id` = ".$number)->fetch_assoc();
            if(file_exists($_SERVER['DOCUMENT_ROOT'].'/img/pokemons/anim/normal/'.$number.'.gif')){
                return '<span class="bgPok" onclick=openDex("'.$number.'")><img class="__spritePoke" src="/img/pokemons/anim/normal/'.$number.'.gif" data-id="'.$number.'"/> #'.$check.' '.$pokemon['name_rus'].'</span>';
            }else{
                return '#'.$number;
            }
        }
        return '';
    }

    private function preg_poke_sprites_s($matches){
        if(isset($matches[1]) && is_numeric($matches[1])){
            $number = intval($matches[1]);
            $check = ($number < 10 ? '00'.$number : ($number < 100 ? '0'.$number : $number));
            $pokemon = $this->sql->query("SELECT `name_rus` FROM `base_pokemons` WHERE `id` = ".$number)->fetch_assoc();
            if(file_exists($_SERVER['DOCUMENT_ROOT'].'/img/pokemons/anim/shine/'.$number.'.gif')){
                return '<span class="bgPok-s" onclick=openDex("'.$number.'")><img class="__spritePoke" src="/img/pokemons/anim/shine/'.$number.'.gif" data-id="'.$number.'"/> #'.$check.' '.$pokemon['name_rus'].'</span>';
            }else{
                return '#'.$number;
            }
        }
        return '';
    }

    private function preg_item($matches){
        if(isset($matches[1]) && is_numeric($matches[1])){
            $id = intval($matches[1]);
            $item = $this->sql->query("SELECT `name` FROM `base_items` WHERE `id` = ".$id)->fetch_assoc();
            if(isset($item)) {
              return '<span onclick=issetAll('.$id.',"item") class="ItemInChat"><div class="itemIsset" style="background-image: url(/img/world/items/little/'.$id.'.png)"></div> '.$item['name'].'</span>';
            }else{
              return '...';
            }
        }
        return '';
    }

    private function preg_random($matches){
        if(isset($matches[1]) && is_numeric($matches[1])){
          $id = intval($matches[1]);
          $random = mt_rand(1,$id);
          return '<span class="ItemInChat">Генерируется случайное число от 1 до '.$id.' и выпадает: '.$random.'</span>';
        }
        return '';
    }

    private function preg_or(){
        $rand = mt_rand(1,6);
        if($rand == 1) {
          $text = 'Абсолютная правда!';
        }elseif($rand == 2) {
          $text = 'Нет!';
        }elseif($rand == 3) {
          $text = 'Да!';
        }elseif($rand == 4) {
          $text = 'Абсолютная неправда!';
        }elseif($rand == 5) {
          $text = 'Я устала!';
        }else{
          $text = 'Не знаю!';
        }
        return '<span class="ItemInChat">Система говорит: "'.$text.'"</span>';
    }

    private function preg_link($matches){
        if(isset($matches[2]) && !empty($matches[2])){
            $search = preg_replace("(href|url|www\.|\.ru|\.com|\.net|\.info|\.org|\.ua|https?://|https?)", '', $matches[2]);
            if(!empty($search)){
                $rc = '<a href="';
                if(empty($matches[1])){
                    $rc .= 'http://';
                }
                $rc .= html_entity_decode($matches[0], ENT_QUOTES, PROJECT_ENCODE).'" target="_blank" class="link">'.$matches[2].'</a>';
                $matches[0] = $rc;
            }
        }else{
            $matches[0] = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', '', $matches[0]);
            $matches[0] = preg_replace ("(href|url|www|\.ru|\.com|\.net|\.info|\.org|\.ua|https?://|https?)", '', $matches[0]);
        }
        return $matches[0];
    }

    private function preg_poke_user($matches){
        if(isset($matches[1]) && is_numeric($matches[1])){
            $number = intval($matches[1]);
            if($number > 0){
                if(!isset($this->dataPoke['p'.$number])){
                    $info = $this->sql->query("
                      SELECT
                      `exp`,
                      `exp_max`,
                      `attacks`,
                      `basenum`,
                      `birthday`,
                      `character`,
                      `ev`,
                      `evcounts`,
                      `gen`,
                      `gender`,
                      `happy`,
                      `hp`,
                      `id`,
                      `lvl`,
                      `name_new` AS `name`,
                      `sparka`,
                      `stats`,
                      `tren`,
                      `tren_stat`,
                      `type`,
                      `vitamines`,
                      `pp_attacks`,
                      `trade`,
                      `sparkaNumber`,
                      `modification`
                      FROM `user_pokemons`
                      WHERE
                        `id` = '".$number."' AND
                        `user_id` = '".$this->userID."'
                    ")->fetch_assoc();

                    if(!empty($info)){
                      $atks = explode(",", $info['attacks']);
                      $pps = explode(",", $info['pp_attacks']);
                      if(isset($atks[0])){
                        $atks1 = $this->sql->query("SELECT * FROM `base_atk` WHERE id = ".$atks[0])->fetch_assoc();
                      }
                      if(isset($atks[1])){
                        $atks2 = $this->sql->query("SELECT * FROM `base_atk` WHERE id = ".$atks[1])->fetch_assoc();
                      }
                      if(isset($atks[2])){
                        $atks3 = $this->sql->query("SELECT * FROM `base_atk` WHERE id = ".$atks[2])->fetch_assoc();
                      }
                      if(isset($atks[3])){
                        $atks4 = $this->sql->query("SELECT * FROM `base_atk` WHERE id = ".$atks[3])->fetch_assoc();
                      }
                      if($atks1['category'] == 'special') {
                        $c1 = 2;
                      }elseif($atks1['category'] == 'physical') {
                        $c1 = 1;
                      }else{
                        $c1 = 3;
                      }
                      if($atks2['category'] == 'special') {
                        $c2 = 2;
                      }elseif($atks2['category'] == 'physical') {
                        $c2 = 1;
                      }else{
                        $c2 = 3;
                      }
                      if($atks3['category'] == 'special') {
                        $c3 = 2;
                      }elseif($atks3['category'] == 'physical') {
                        $c3 = 1;
                      }else{
                        $c3 = 3;
                      }
                      if($atks4['category'] == 'special') {
                        $c4 = 2;
                      }elseif($atks4['category'] == 'physical') {
                        $c4 = 1;
                      }else{
                        $c4 = 3;
                      }
                      if(!empty($atks1)) {
                      $info['atk1'] = '<div class="Move">
                      <img src="/img/world/typs/'.$atks1['type'].'.png">
                      <div class="MoveInfo">
                      <div class="Name MoveCategory'.$c1.'">'.$atks1['name_rus'].'</div>
                      <div class="PP">'.$pps[0].'/'.$atks1['pp'].' PP</div>
                      </div>
                      </div>';
                      }else{
                      $value['atk1'] = '<div class="Move">
                      <img src="/img/world/typs/empty.png">
                      <div class="MoveInfo">
                      <div class="Name MoveCategory">Нет атаки</div>
                      <div class="PP">0/0 PP</div>
                      </div>
                      </div>';
                      }
                      if(!empty($atks2)) {
                      $info['atk2'] = '<div class="Move">
                      <img src="/img/world/typs/'.$atks2['type'].'.png">
                      <div class="MoveInfo">
                      <div class="Name MoveCategory'.$c2.'">'.$atks2['name_rus'].'</div>
                      <div class="PP">'.$pps[1].'/'.$atks2['pp'].' PP</div>
                      </div>
                      </div>';
                      }else{
                      $info['atk2'] = '<div class="Move">
                      <img src="/img/world/typs/empty.png">
                      <div class="MoveInfo">
                      <div class="Name MoveCategory">Нет атаки</div>
                      <div class="PP">0/0 PP</div>
                      </div>
                      </div>';
                      }
                      if(!empty($atks3)) {
                      $info['atk3'] = '<div class="Move">
                      <img src="/img/world/typs/'.$atks3['type'].'.png">
                      <div class="MoveInfo">
                      <div class="Name MoveCategory'.$c3.'">'.$atks3['name_rus'].'</div>
                      <div class="PP">'.$pps[2].'/'.$atks3['pp'].' PP</div>
                      </div>
                      </div>';
                      }else{
                      $info['atk3'] = '<div class="Move">
                      <img src="/img/world/typs/empty.png">
                      <div class="MoveInfo">
                      <div class="Name MoveCategory">Нет атаки</div>
                      <div class="PP">0/0 PP</div>
                      </div>
                      </div>';
                      }
                      if(!empty($atks4)) {
                      $info['atk4'] = '<div class="Move">
                      <img src="/img/world/typs/'.$atks4['type'].'.png">
                      <div class="MoveInfo">
                      <div class="Name MoveCategory'.$c4.'">'.$atks4['name_rus'].'</div>
                      <div class="PP">'.$pps[3].'/'.$atks4['pp'].' PP</div>
                      </div>
                      </div>';
                      }else{
                      $info['atk4'] = '<div class="Move">
                      <img src="/img/world/typs/empty.png">
                      <div class="MoveInfo">
                      <div class="Name MoveCategory">Нет атаки</div>
                      <div class="PP">0/0 PP</div>
                      </div>
                      </div>';
                      }
                      $info['led'] = Info::_modif($value['modification']);
                        $info['character'] = haracter_pokes($info['character']);
                        $info['birthday'] = Info::_pokeBirthday($info['birthday']);
                        $info['attacks'] = Info::_pokeAtkList($info['attacks'], true);
                        if($info['basenum'] <= 9) {
                          $basa = '00'.$info['basenum'];
                        }elseif($info['basenum'] >= 10 && $info['basenum'] <= 99){
                          $basa = '0'.$info['basenum'];
                        }else{
                          $basa = $info['basenum'];
                        }
                        $this->dataPoke['p'.$info['id']] = $info; 
                        return ' <span class="__info_usr_poke" data-id="'.$info['id'].'"><img class="__spritePoke" src="/img/pokemons/anim/normal/'.$basa.'.gif" data-id="'.$basa.'"/>#'.$basa.' '.$info['name'].' <sup><small>'.$info['lvl'].' ур.</small></sup></span> '; 
                    }
                }
            }
        }
        return '';
    }
}
