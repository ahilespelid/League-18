<?php
class Battle{

    private $types = [
        'bug'       =>['bug'=>1,    'dark'=>2,   'dragon'=>1,   'electric'=>1,   'fairy'=>0.5,  'fighting'=>0.5, 'fire'=>0.5,   'fly'=>0.5, 'ghost'=>0.5,   'grass'=>2,     'ground'=>1,    'ice'=>1,   'normal'=>1, 'poison'=>0.5, 'psychic'=>2,   'rock'=>1,   'steel'=>0.5,  'water'=>1],
        'dark'      =>['bug'=>1,    'dark'=>0.5, 'dragon'=>1,   'electric'=>1,   'fairy'=>0.5,  'fighting'=>0.5, 'fire'=>1,     'fly'=>1,   'ghost'=>2,     'grass'=>1,     'ground'=>1,    'ice'=>1,   'normal'=>1, 'poison'=>1,   'psychic'=>2,   'rock'=>1,   'steel'=>1,    'water'=>1],
        'dragon'    =>['bug'=>1,    'dark'=>1,   'dragon'=>2,   'electric'=>1,   'fairy'=>0,    'fighting'=>1,   'fire'=>1,     'fly'=>1,   'ghost'=>1,     'grass'=>1,     'ground'=>1,    'ice'=>1,   'normal'=>1, 'poison'=>1,   'psychic'=>1,   'rock'=>1,   'steel'=>0.5,  'water'=>1],
        'electric'  =>['bug'=>1,    'dark'=>1,   'dragon'=>0.5, 'electric'=>0.5, 'fairy'=>1,    'fighting'=>1,   'fire'=>1,     'fly'=>2,   'ghost'=>1,     'grass'=>0.5,   'ground'=>0,    'ice'=>1,   'normal'=>1, 'poison'=>1,   'psychic'=>1,   'rock'=>1,   'steel'=>1,    'water'=>2],
        'fairy'     =>['bug'=>1,    'dark'=>2,   'dragon'=>2,   'electric'=>1,   'fairy'=>1,    'fighting'=>2,   'fire'=>0.5,   'fly'=>1,   'ghost'=>1,     'grass'=>1,     'ground'=>1,    'ice'=>1,   'normal'=>1, 'poison'=>0.5, 'psychic'=>1,   'rock'=>1,   'steel'=>0.5,  'water'=>1],
        'fighting'  =>['bug'=>0.5,  'dark'=>2,   'dragon'=>1,   'electric'=>1,   'fairy'=>0.5,  'fighting'=>1,   'fire'=>1,     'fly'=>0.5, 'ghost'=>0,     'grass'=>1,     'ground'=>1,    'ice'=>2,   'normal'=>2, 'poison'=>0.5, 'psychic'=>0.5, 'rock'=>1,   'steel'=>2,    'water'=>1],
        'fire'      =>['bug'=>2,    'dark'=>1,   'dragon'=>0.5, 'electric'=>1,   'fairy'=>1,    'fighting'=>1,   'fire'=>0.5,   'fly'=>1,   'ghost'=>1,     'grass'=>2,     'ground'=>1,    'ice'=>2,   'normal'=>1, 'poison'=>1,   'psychic'=>1,   'rock'=>0.5, 'steel'=>2,    'water'=>0.5],
        'fly'       =>['bug'=>2,    'dark'=>1,   'dragon'=>1,   'electric'=>0.5, 'fairy'=>1,    'fighting'=>2,   'fire'=>1,     'fly'=>1,   'ghost'=>1,     'grass'=>2,     'ground'=>1,    'ice'=>1,   'normal'=>1, 'poison'=>1,   'psychic'=>1,   'rock'=>0.5, 'steel'=>0.5,  'water'=>1],
        'ghost'     =>['bug'=>1,    'dark'=>0.5, 'dragon'=>1,   'electric'=>1,   'fairy'=>1,    'fighting'=>1,   'fire'=>1,     'fly'=>1,   'ghost'=>2,     'grass'=>1,     'ground'=>1,    'ice'=>1,   'normal'=>0, 'poison'=>1,   'psychic'=>2,   'rock'=>1,   'steel'=>1,    'water'=>1],
        'grass'     =>['bug'=>0.5,  'dark'=>1,   'dragon'=>0.5, 'electric'=>1,   'fairy'=>1,    'fighting'=>1,   'fire'=>0.5,   'fly'=>0.5, 'ghost'=>1,     'grass'=>0.5,   'ground'=>2,    'ice'=>1,   'normal'=>1, 'poison'=>0.5, 'psychic'=>1,   'rock'=>2,   'steel'=>0.5,  'water'=>2],
        'ground'    =>['bug'=>0.5,  'dark'=>1,   'dragon'=>1,   'electric'=>2,   'fairy'=>1,    'fighting'=>1,   'fire'=>2,     'fly'=>0,   'ghost'=>1,     'grass'=>0.5,   'ground'=>1,    'ice'=>1,   'normal'=>1, 'poison'=>2,   'psychic'=>1,   'rock'=>2,   'steel'=>2,    'water'=>0.5],
        'ice'       =>['bug'=>1,    'dark'=>1,   'dragon'=>2,   'electric'=>1,   'fairy'=>1,    'fighting'=>1,   'fire'=>0.5,   'fly'=>2,   'ghost'=>1,     'grass'=>2,     'ground'=>2,    'ice'=>0.5, 'normal'=>1, 'poison'=>1,   'psychic'=>1,   'rock'=>1,   'steel'=>0.5,  'water'=>0.5],
        'normal'    =>['bug'=>1,    'dark'=>1,   'dragon'=>1,   'electric'=>1,   'fairy'=>1,    'fighting'=>1,   'fire'=>1,     'fly'=>1,   'ghost'=>0,     'grass'=>1,     'ground'=>1,    'ice'=>1,   'normal'=>1, 'poison'=>1,   'psychic'=>1,   'rock'=>0.5, 'steel'=>0.5,  'water'=>1],
        'poison'    =>['bug'=>1,    'dark'=>1,   'dragon'=>1,   'electric'=>1,   'fairy'=>2,    'fighting'=>1,   'fire'=>1,     'fly'=>1,   'ghost'=>0.5,   'grass'=>2,     'ground'=>0.5,  'ice'=>1,   'normal'=>1, 'poison'=>0.5, 'psychic'=>1,   'rock'=>0.5, 'steel'=>0,    'water'=>1],
        'psychic'   =>['bug'=>1,    'dark'=>0,   'dragon'=>1,   'electric'=>1,   'fairy'=>1,    'fighting'=>2,   'fire'=>1,     'fly'=>1,   'ghost'=>1,     'grass'=>1,     'ground'=>1,    'ice'=>1,   'normal'=>1, 'poison'=>2,   'psychic'=>0.5, 'rock'=>1,   'steel'=>0.5,  'water'=>1],
        'rock'      =>['bug'=>2,    'dark'=>1,   'dragon'=>1,   'electric'=>1,   'fairy'=>1,    'fighting'=>0.5, 'fire'=>2,     'fly'=>2,   'ghost'=>1,     'grass'=>1,     'ground'=>0.5,  'ice'=>2,   'normal'=>1, 'poison'=>1,   'psychic'=>1,   'rock'=>1,   'steel'=>0.5,  'water'=>1],
        'steel'     =>['bug'=>1,    'dark'=>1,   'dragon'=>1,   'electric'=>0.5, 'fairy'=>2,    'fighting'=>1,   'fire'=>0.5,   'fly'=>1,   'ghost'=>1,     'grass'=>1,     'ground'=>1,    'ice'=>2,   'normal'=>1, 'poison'=>1,   'psychic'=>1,   'rock'=>2,   'steel'=>0.5,  'water'=>0.5],
        'water'     =>['bug'=>1,    'dark'=>1,   'dragon'=>0.5, 'electric'=>0.5, 'fairy'=>1,    'fighting'=>1,   'fire'=>2,     'fly'=>1,   'ghost'=>1,     'grass'=>0.5,   'ground'=>2,    'ice'=>1,   'normal'=>1, 'poison'=>1,   'psychic'=>1,   'rock'=>2,   'steel'=>1,    'water'=>0.5],
    ];

    private $titleStatus = [
        'toxic'=>'На %s накладывается статус отравления.',
        'toxic2'=>'На %s накладывается статус сильного отравления.',
        'flinch'=>'%s напуган и не сможет удачно использовать какую-либо атаку.',
        'paralyzed'=>'%s теперь парализован.',
        'sleep'=>'На %s накладывается статус усыпления.',
        'burn'=>'%s теперь в огне.',
        'frost'=>'%s теперь заморожен.',
        'lover'=>'%s влюбляется в своего соперника.',
        'curse'=>'Покемон проклинает противника отдавая половину своих жизней',
        'confused'=>'%s спутан.',
        'rage'=>'%s впадает в бешенство.',
        'taunt'=>'на %s наложена насмешка.',
        'aquaRing'=>'на %s наложен водяной щит.',
        'stock'=>'%s накапливает предметы в своем рту.',
        'trickortreat'=>'К %s добавляется призрачный тип.',
        'nightmare'=>'%s мучается от кошмаров.',
    ];

	private $settingsScreen = [
		'LightScreen'=>[
						'roundEnd'=>0,
					],
		'Reflect'	=>[
						'roundEnd'=>0,
					],
	];

	private $settingsSpikes = [
		'mySettings' 	=> [
					'Spikes'=> [
						'count'=>0,
					],
				],
		'enemySettings' => [
					'Spikes'=> [
						'count'=>0,
					],
				],

	];
    /** @var $_actionBattle ActionBattle */
    private $_actionBattle;

    /** @var $attacker PokeBattle */
    private $attacker;

    /** @var $defender PokeBattle */
    private $defender;

    /** @var $attacker array */
    private $attackerAtk;

    /** @var $defender array */
    private $defenderAtk;

    /** @var $user_log array */
    private $user_log = [];

    /** @var $log_start array */
    private $log_start = [];

    /** @var $log array */
    private $log       = [];

    /** @var $log_end array */
    private $log_end   = [];

    /** @var $log_status array */
    private $log_status   = [];

    /** @var $settings array */
    private $settings = [

        'effect_my'     =>true, # Можно ли накладывать на себя эффекты.
        'effect_enemy'  =>true, # Можно ли накладывать эффекты на соперника.

        'dmg'       =>0, # Урон с атаки за полу-раунд.
        'stab'      =>1, # Это стаб эффект?
        'types'     =>1, # Это типовой эффект?
        'critical'  =>1, # Это критический удар?

        'crash' 	=>false, # Это критический удар?

		'destiny' 	=> false, #Можно убивать?

		'weather'	=> 0, #Погода
    ];

    /** @var $settings array */
    private $settings_default = [
        'dmg'=>0,
        'critical'=>1,
        'stab'=>1,
        'types'=>1
    ];

    private $catch = false;

    private $dmg_1;

    private $dmg_2;


    public function __construct(ActionBattle $actionBattle, array &$info_1, array &$info_2, array &$target_1, array &$target_2){

        $this->_actionBattle = $actionBattle;
        if(isset($target_1['id'], $target_2['id'])){

            $poke_1 = new PokeBattle($target_1);
            $poke_2 = new PokeBattle($target_2);

            $atk_1 = $poke_1->_getAtkInfo((isset($info_1['targetAtk']) ? $info_1['targetAtk'] : 0));
            $atk_2 = $poke_2->_getAtkInfo((isset($info_2['targetAtk']) ? $info_2['targetAtk'] : 0));
            if(!empty($atk_1) && !empty($atk_2)){
                $enemy = false;

                if($poke_1->_getStatSpd() == $poke_2->_getStatSpd() && $atk_1['priority'] == $atk_2['priority']) {
                  $randAtaka = mt_rand (1,2);
                  if($randAtaka == 1) {
                    $enemy = true;
                  }else{
                    $enemy = false;
                  }
                }elseif($poke_1->_getStatSpd() != $poke_2->_getStatSpd() && $atk_1['priority'] == $atk_2['priority']) {
                  if($poke_1->_getStatSpd() > $poke_2->_getStatSpd()) {
                    $enemy = false;
                  }elseif($poke_1->_getStatSpd() < $poke_2->_getStatSpd()) {
                    $enemy = true;
                  }else{
                    $randAtaka = mt_rand (1,2);
                    if($randAtaka == 1) {
                      $enemy = true;
                    }else{
                      $enemy = false;
                    }
                  }
                  //var_dump($poke_1->_getStatSpd());
                  //var_dump($poke_2->_getStatSpd());
                }else{
                  if($atk_1['priority'] > $atk_2['priority']) {
                    $enemy = false;
                  }elseif($atk_1['priority'] < $atk_2['priority']) {
                    $enemy = true;
                  }else{
                    $randAtaka = mt_rand (1,2);
                    if($randAtaka == 1) {
                      $enemy = true;
                    }else{
                      $enemy = false;
                    }
                  }
                }

                // if($atk_2['priority'] != $atk_1['priority']){
                //     if($atk_2['priority'] > $atk_1['priority']){
                //         $enemy = true;
                //     }
                // }elseif($poke_2->_getStatSpd() != $poke_1->_getStatSpd()){
                //     if($poke_2->_getStatSpd() > $poke_1->_getStatSpd()){
                //         $enemy = true;
                //     }
                // }elseif(mt_rand(1,2) == 2){
                //     $enemy = true;
                // }

                $poke_1->hp_before = 0;
                $poke_2->hp_before = 0;

                if($enemy){
                    $this->hit($poke_2, $poke_1, $atk_2, $atk_1);
                    $this->hit($poke_1, $poke_2, $atk_1, $atk_2);

                    $this->issetStatus($poke_2, $poke_1, $atk_2, $atk_1);
                    $this->issetStatus($poke_1, $poke_2, $atk_1, $atk_2);

                }else{
                    $this->hit($poke_1, $poke_2, $atk_1, $atk_2);
                    $this->hit($poke_2, $poke_1, $atk_2, $atk_1);

                    $this->issetStatus($poke_1, $poke_2, $atk_1, $atk_2);
                    $this->issetStatus($poke_2, $poke_1, $atk_2, $atk_1);

                }

                $poke_1->atk_before = $info_1['targetAtk'];
                $poke_2->atk_before = $info_2['targetAtk'];

                $this->_actionBattle->_nextRound();
                $target_1 = $poke_1->_getData();
                $target_2 = $poke_2->_getData();
            }
            $info_1['targetAtk'] = 0;
            $info_2['targetAtk'] = 0;

            $info_2['timer'] = [];
            $info_2['timer'] = [];

        }

    }

    public function _getLog(){
        return $this->user_log;
    }

	public function _getLogStatus(){
        return $this->log_status;
    }

    private function hit(PokeBattle &$attacker, PokeBattle &$defender, array &$attackerAtk, array &$defenderAtk){
        if($this->catch){
            return;
        }
        unset($this->attacker);
        unset($this->defender);

        $this->attacker =& $attacker;
        $this->defender =& $defender;

        unset($this->attackerAtk);
        unset($this->defenderAtk);
        $this->attackerAtk =& $attackerAtk;
        $this->defenderAtk =& $defenderAtk;
        $this->log_start = [];
        $this->log = [];
        $this->log_end = [];
		if($this->_actionBattle->weather == 2){
			if($this->attackerAtk['type'] == 'water'){
				$this->attackerAtk['power'] = $this->attackerAtk['power'] / 1.5;
			}elseif($this->attackerAtk['type'] == 'fire'){
				$this->attackerAtk['power'] = $this->attackerAtk['power'] * 1.5;
			}
		}elseif($this->_actionBattle->weather == 3){
			if($this->attackerAtk['type'] == 'water'){
				$this->attackerAtk['power'] = $this->attackerAtk['power'] * 1.5;
			}elseif($this->attackerAtk['type'] == 'fire'){
				$this->attackerAtk['power'] = $this->attackerAtk['power'] / 1.5;
			}
		}elseif($this->_actionBattle->weather == 4){
			if($this->attacker->base_type != 'ice'){
				if($this->attacker->base_type_two != 'ice'){
					$weatherMinus = ($this->attacker->stats[0] / 16);
					$this->attacker->hp = ($this->attacker->hp - $weatherMinus);
					$this->log[] = 'Град поранил покемона: <span class="HpMinus">-'.ceil($weatherMinus).' HP</span>';
				}
			}
		}elseif($this->_actionBattle->weather == 5){
			if($this->attacker->base_type != 'rock' && $this->attacker->base_type_two != 'rock'){
				if($this->attacker->base_type != 'steel' && $this->attacker->base_type_two != 'steel'){
					if($this->attacker->base_type != 'ground' && $this->attacker->base_type_two != 'ground'){
						$weatherMinus = ($this->attacker->stats[0] / 16);
						$this->attacker->hp = ($this->attacker->hp - $weatherMinus);
						$this->log[] = 'Песок поранил покемона: <span class="HpMinus">-'.ceil($weatherMinus).' HP</span>';
					}
				}
			}
		}
    // var_dump($this->settingsScreen);
    // if($this->settingsScreen[$this->defender->user_id]['Reflect']['roundEnd'] > $this->_actionBattle->round){
    //   $this->log[] = 'У противника действует защитный экран.';
    // }
    $mypp = explode(',',$this->attacker->pp_my);
        if(
            $this->getSelected($this->attacker, $this->defender, $this->attackerAtk, $this->defenderAtk) &&
            $this->getCatch($this->attacker, $this->defender, $this->attackerAtk, $this->defenderAtk) &&
            $this->getNext($this->attacker, $this->defender, $this->attackerAtk, $this->defenderAtk)
        ){
          if($mypp[$this->attackerAtk['attack_num']] >= 1) {
              if($mypp[$this->attackerAtk['attack_num']]) {
                $mypp[$this->attackerAtk['attack_num']] = $mypp[$this->attackerAtk['attack_num']] - 1;
              }


            if($this->attacker->hp > 0){

              if($this->attackerAtk['id'] != 277) {
                Work::$sql->query('DELETE FROM battle_block WHERE pokID = '.$attacker->id.' AND attack = 277');
              }

              if($this->attackerAtk['id'] != 446) {
                Work::$sql->query('DELETE FROM atk_rollout WHERE user = '.$attacker->id);
              }

              if($this->attackerAtk['id'] != 190) {
                Work::$sql->query('DELETE FROM atk_furycutter WHERE user = '.$attacker->id);
              }

              if($this->attackerAtk['id'] != 401) {
                Work::$sql->query('DELETE FROM battle_block WHERE pokID = '.$attacker->id.' AND attack = 401');
              }
                    $this->attacker->pp_my = implode(',',$mypp);
                $this->log[] = $this->attacker->_getName(true).' использует атаку '.$this->getAtkName($this->attackerAtk);
                if($this->isAccuracy($this->attacker, $this->defender, $this->attackerAtk, $this->defenderAtk) ||
                $this->attackerAtk['id'] == 476 ||
                $this->attackerAtk['id'] == 277
                ) {
                  $info_enemy = Info::_unParseData($this->attackerAtk['enemy']);
                  $info_my = Info::_unParseData($this->attackerAtk['my']);
                  if(isset($info_my['stats'])) {
                    foreach($info_my['stats'] AS $key=>$value){
                      if(isset($value['3'])) {
                        $rand_info_my = mt_rand(1,100);
                        if($rand_info_my <= $value['3']) {
                          $this->attacker->_setModifiedStat($value[0], $value[1], ($value[2] == 'minus' ? false : true));
                          if($value[0] == 'atk'){
                            $nameStat = 'Атака';
                          }elseif($value[0] == 'def'){
                            $nameStat = 'Защита';
                          }elseif($value[0] == 'spd'){
                            $nameStat = 'Скорость';
                          }elseif($value[0] == 'satk'){
                            $nameStat = 'Спец. Атака';
                          }elseif($value[0] == 'sdef'){
                            $nameStat = 'Спец. Защита';
                          }elseif($value[0] == 'acr'){
                            $nameStat = 'Точность';
                          }elseif($value[0] == 'agl'){
                            $nameStat = 'Ловкость';
                          }else{
                            $nameStat = 'Здоровье';
                          }
                          $this->log[] = 'У '.$this->attacker->_getName(true).' '.($value[2] == 'plus' ? 'повышается <span class="StatPlus">'.$nameStat.' +'.$value[1].'</span>' : 'понижается <span class="StatMinus">'.$nameStat.' -'.$value[1].'</span>');
                        }
                      }else{
                        $this->attacker->_setModifiedStat($value[0], $value[1], ($value[2] == 'minus' ? false : true));
                        if($value[0] == 'atk'){
                          $nameStat = 'Атака';
                        }elseif($value[0] == 'def'){
                          $nameStat = 'Защита';
                        }elseif($value[0] == 'spd'){
                          $nameStat = 'Скорость';
                        }elseif($value[0] == 'satk'){
                          $nameStat = 'Спец. Атака';
                        }elseif($value[0] == 'sdef'){
                          $nameStat = 'Спец. Защита';
                        }elseif($value[0] == 'acr'){
                          $nameStat = 'Точность';
                        }elseif($value[0] == 'agl'){
                          $nameStat = 'Ловкость';
                        }else{
                          $nameStat = 'Здоровье';
                        }
                        $this->log[] = 'У '.$this->attacker->_getName(true).' '.($value[2] == 'plus' ? 'повышается <span class="StatPlus">'.$nameStat.' +'.$value[1].'</span>' : 'понижается <span class="StatMinus">'.$nameStat.' -'.$value[1].'</span>');
                      }
                    }
                  }
                  if(isset($info_enemy['stats'])) {
                    foreach($info_enemy['stats'] AS $key=>$value){
                      if(isset($value['3'])) {
                        $rand_info_enemy = mt_rand(1,100);
                        if($rand_info_enemy <= $value['3']) {
                          $this->defender->_setModifiedStat($value[0], $value[1], ($value[2] == 'minus' ? false : true));
                          if($value[0] == 'atk'){
                            $nameStat = 'Атака';
                          }elseif($value[0] == 'def'){
                            $nameStat = 'Защита';
                          }elseif($value[0] == 'spd'){
                            $nameStat = 'Скорость';
                          }elseif($value[0] == 'satk'){
                            $nameStat = 'Спец. Атака';
                          }elseif($value[0] == 'sdef'){
                            $nameStat = 'Спец. Защита';
                          }elseif($value[0] == 'acr'){
                            $nameStat = 'Точность';
                          }elseif($value[0] == 'agl'){
                            $nameStat = 'Ловкость';
                          }else{
                            $nameStat = 'Здоровье';
                          }
                          $this->log[] = 'У '.$this->defender->_getName(true).' '.($value[2] == 'plus' ? 'повышается <span class="StatPlus">'.$nameStat.' +'.$value[1].'</span>' : 'понижается <span class="StatMinus">'.$nameStat.' -'.$value[1].'</span>');
                        }
                      }else{
                        $this->defender->_setModifiedStat($value[0], $value[1], ($value[2] == 'minus' ? false : true));
                        if($value[0] == 'atk'){
                          $nameStat = 'Атака';
                        }elseif($value[0] == 'def'){
                          $nameStat = 'Защита';
                        }elseif($value[0] == 'spd'){
                          $nameStat = 'Скорость';
                        }elseif($value[0] == 'satk'){
                          $nameStat = 'Спец. Атака';
                        }elseif($value[0] == 'sdef'){
                          $nameStat = 'Спец. Защита';
                        }elseif($value[0] == 'acr'){
                          $nameStat = 'Точность';
                        }elseif($value[0] == 'agl'){
                          $nameStat = 'Ловкость';
                        }else{
                          $nameStat = 'Здоровье';
                        }
                        $this->log[] = 'У '.$this->defender->_getName(true).' '.($value[2] == 'plus' ? 'повышается <span class="StatPlus">'.$nameStat.' +'.$value[1].'</span>' : 'понижается <span class="StatMinus">'.$nameStat.' -'.$value[1].'</span>');
                      }
                    }
                  }

                  if($this->attackerAtk['id'] == 614) {
                    $this->attackerAtk['power'] = 120 * ($this->defender->hp / $this->defender->lvl);
                    if($this->attackerAtk['power'] <= 1) {
                      $this->attackerAtk['power'] = 1;
                    }elseif($this->attackerAtk['power'] >= 120){
                      $this->attackerAtk['power'] = 120;
                    }else{
                      $this->attackerAtk['power'] = $this->attackerAtk['power'];
                    }
                  }

                  if($this->attackerAtk['id'] == 530) {
                    if($this->defender->_getTypeA() == 'grass' || $this->defender->_getTypeB() == 'grass') {
                      $this->log[] = 'Провал. Невозможно использовать атаку на покемона Травяного типа.';
                    }else{
                      $this->defender->_setStatus('paralyzed', 9999);
                      $this->log[] = $this->defender->_getName(true).' теперь парализован.';
                    }
                  }

                  if($this->attackerAtk['id'] == 167) {
                    $prc = ($this->defender->hp / $this->defender->hp_max) * 100;
                    if($prc >= 68) {
                      $this->attackerAtk['power'] = 20;
                    }elseif($prc < 68 && $prc >= 35) {
                      $this->attackerAtk['power'] = 40;
                    }elseif($prc < 34 && $prc >= 20) {
                      $this->attackerAtk['power'] = 80;
                    }elseif($prc < 19 && $prc >= 10) {
                      $this->attackerAtk['power'] = 100;
                    }elseif($prc < 9 && $prc >= 4) {
                      $this->attackerAtk['power'] = 150;
                    }else{
                      $this->attackerAtk['power'] = 200;
                    }
                  }

                  if($this->attackerAtk['id'] == 293) {
                    $prc = $this->defender->base_weight;
                    if($prc >= 0.1 && $prc <= 9.9) {
                      $this->attackerAtk['power'] = 20;
                    }elseif($prc >= 10 && $prc <= 24.9) {
                      $this->attackerAtk['power'] = 40;
                    }elseif($prc >= 25 && $prc <= 49.9) {
                      $this->attackerAtk['power'] = 60;
                    }elseif($prc >= 50 && $prc <= 99.9) {
                      $this->attackerAtk['power'] = 80;
                    }elseif($prc >= 100 && $prc <= 199.9) {
                      $this->attackerAtk['power'] = 100;
                    }else{
                      $this->attackerAtk['power'] = 120;
                    }
                  }

                  if($this->attackerAtk['id'] == 235) {
                    $this->getAHH($this->attacker, $this->defender, $this->attackerAtk, $this->defenderAtk);
                  }

                  if($this->attackerAtk['id'] == 496) {
                    if($this->defender->_checkStatus('paralyzed')) {
                      $info = $this->defender->_getStatusList();
                      if($info){foreach($info AS $key=>$value){if($value['type'] == 'paralyzed'){unset($info[$key]);}}}
                      $this->defender->_setStatusList($info);
                      $this->attackerAtk['power'] = $this->attackerAtk['power'] * 2;
                      $this->log[] = 'Покемон ударил с двойной силой. Противник больше не парализован.';
                    }
                  }

                  if($this->attackerAtk['id'] == 456) {
                    if($this->defender->_checkStatus('frost')) {
                      $info = $this->defender->_getStatusList();
                      if($info){foreach($info AS $key=>$value){if($value['type'] == 'frost'){unset($info[$key]);}}}
                      $this->defender->_setStatusList($info);
                      $this->log[] = 'Покемон оттаял от атаки.';
                    }
                  }

                  if($this->attackerAtk['id'] == 579) {
                    $atkRAZ = $this->attackerAtk['power'];
                    $atkDVA = $atkRAZ * 2;
                    $atkTRI = $atkDVA * 2;
                    $this->attackerAtk['power'] = $atkRAZ + $atkDVA + $atkTRI;
                    $this->log[] = 'Покемон ударил трижды.';
                  }
					if($this->attackerAtk['id'] == 193){
						if($this->defender->stats[3] > $this->attacker->stats[3] && $this->defenderAtk['id'] == 192){
							$this->attackerAtk['power'] = $this->attackerAtk['power'] * 2;
							$this->log[] = 'Мощность атаки удвоилась.';
						}
					}
					if($this->attackerAtk['id'] == 192){
						if($this->defender->stats[3] > $this->attacker->stats[3] && $this->defenderAtk['id'] == 193){
							$this->attackerAtk['power'] = $this->attackerAtk['power'] * 2;
							$this->log[] = 'Мощность атаки удвоилась.';
						}
					}
                    if($this->attackerAtk['category'] == 'status' || $this->attackerAtk['category'] == 'specific'){

                      if($this->attackerAtk['id'] == 401) {
                        $poke = Work::$sql->query("SELECT * FROM battle_block WHERE attack = ".$this->attackerAtk['id']." AND pokID = ".$attacker->id)->fetch_assoc();
                        if(isset($poke)) {
                          $chanseA = ($poke['chanse'] / 3);
                          $rand = mt_rand(1,100);
                          if($rand < $poke['chanse']){
                            Work::$sql->query("UPDATE battle_block SET `chanse` = ".$chanseA." WHERE pokID = ".$attacker->id);
                            if($this->defenderAtk['target'] == 'enemy'){
          										$this->settings['crash'] = true;
                              $this->log[] = 'Покемон защищается от атаки.';
                              $this->defenderAtk['power'] = 0;
          									}else{
                              $this->log[] = 'Покемону удается защититься от атаки, но атака противника предназначена не для того, чтобы ударить противника.';
                            }
                          }else{
                            $this->log[] = 'Покемону не удается защититься от атаки.';
                            Work::$sql->query('DELETE FROM battle_block WHERE pokID = '.$attacker->id);
                          }
                        }else{
                          Work::$sql->query("INSERT INTO battle_block (attack, chanse, pokID, user) VALUES (".$this->attackerAtk['id'].", 33, ".$attacker->id.", ".$_SESSION['id'].")");
                          if($this->defenderAtk['target'] == 'enemy'){
                            $this->settings['crash'] = true;
                            $this->defenderAtk['power'] = 0;
                            $this->log[] = 'Покемон защищается от атаки.';
                          }else{
                            $this->log[] = 'Покемону удается защититься от атаки, но атака противника предназначена не для того, чтобы ударить противника.';
                          }
                        }
                      }

                      if($this->attackerAtk['id'] == 277) {
                        $poke = Work::$sql->query("SELECT * FROM battle_block WHERE attack = ".$this->attackerAtk['id']." AND pokID = ".$attacker->id)->fetch_assoc();
                        if(isset($poke)) {
                          $chanseA = ($poke['chanse'] / 3);
                          $rand = mt_rand(1,100);
                          if($rand < $poke['chanse']){
                            Work::$sql->query("UPDATE battle_block SET `chanse` = ".$chanseA." WHERE pokID = ".$attacker->id);
                            if($this->defenderAtk['contact'] == 1) {
                              $this->defender->_setModifiedStat('atk', 2, false);
                              $mA = ' У противника <span class="StatMinus">Атака -2</span>';
                            }else{
                              $mA = '';
                            }
                            if($this->defenderAtk['target'] == 'enemy'){
          										$this->settings['crash'] = true;
                              $this->log[] = 'Покемон защищается от атаки.'.$mA;
                              $this->defenderAtk['power'] = 0;
          									}else{
                              $this->log[] = 'Покемону удается защититься от атаки, но атака противника предназначена не для того, чтобы ударить противника.';
                            }
                          }else{
                            $this->log[] = 'Покемону не удается защититься от атаки.';
                            Work::$sql->query('DELETE FROM battle_block WHERE pokID = '.$attacker->id);
                          }
                        }else{
                          Work::$sql->query("INSERT INTO battle_block (attack, chanse, pokID, user) VALUES (".$this->attackerAtk['id'].", 33, ".$attacker->id.", ".$_SESSION['id'].")");
                          if($this->defenderAtk['contact'] == 1) {
                            $this->defender->_setModifiedStat('atk', 2, false);
                            $mA = ' У противника <span class="StatMinus">Атака -2</span>';
                          }else{
                            $mA = '';
                          }
                          if($this->defenderAtk['target'] == 'enemy'){
                            $this->settings['crash'] = true;
                            $this->defenderAtk['power'] = 0;
                            $this->log[] = 'Покемон защищается от атаки.'.$mA;
                          }else{
                            $this->log[] = 'Покемону удается защититься от атаки, но атака противника предназначена не для того, чтобы ударить противника.';
                          }
                        }
                      }
							if($this->attackerAtk['id'] == 511){
								$poke = Work::$sql->query("SELECT * FROM battle_block WHERE pokID = ".$attacker->id)->fetch_assoc();
								if($poke){
									$chanseA = ($poke['chanse'] / 3);
									$rand = mt_rand(1,100);
									if($rand < $poke['chanse']){
										Work::$sql->query("UPDATE battle_block SET `chanse` = ".$chanseA." WHERE pokID = ".$attacker->id);
										if($this->defenderAtk['target'] == 'enemy'){
											$this->settings['crash'] = true;
										}
										if($this->defenderAtk['category'] == 'physical'){
											$minusHp = ($this->defender->stats[0] / 8);
											$this->defender->hp = ($this->defender->hp - $minusHp);
											$this->log[] = 'Покемон вновь защищается от атаки. Противник получает урон от шипов щита: <span class="HpMinus">-'.ceil($minusHp).' HP</span>';
										}else{
											$this->log[] = 'Покемон вновь защищается от атаки.';
										}
										$this->defenderAtk['power'] = 0;
									}else{
										$this->log[] = 'Покемону не удается защититься от атаки.';
										Work::$sql->query('DELETE FROM battle_block WHERE pokID = '.$attacker->id);
									}
								}else{
									Work::$sql->query("INSERT INTO battle_block (attack, chanse, pokID, user) VALUES (".$this->attackerAtk['id'].", 33, ".$attacker->id.", ".$_SESSION['id'].")");
									if($this->defenderAtk['target'] == 'enemy'){
										$this->settings['crash'] = true;
									}
									if($this->defenderAtk['category'] == 'physical'){
										$minusHp = ($this->defender->stats[0] / 8);
										$this->defender->hp = ($this->defender->hp - $minusHp);
										$this->log[] = 'Покемон защищается от атаки. Противник получает урон от шипов щита: <span class="HpMinus">-'.ceil($minusHp).' HP</span>';
									}else{
										$this->log[] = 'Покемон защищается от атаки.';
									}
									$this->defenderAtk['power'] = 0;
								}
							}

              if($this->attackerAtk['id'] == 348){
                $info = $this->defender->_getStatusList();
                if($info){
                  foreach($info AS $key=>$value){
                    if($value['type'] == 'sleep') {
                      $this->defender->_setStatus('nightmare', $value['count']);
                      $proval = 'Противник начал мучаться от кошмаров.';
                    }else{
                      $proval = 'Провал. Покемон не спит.';
                    }
                  }
                }else{
                  $proval = 'Провал. Покемон не спит.';
                }
                $this->log[] = $proval;
              }

              if($this->attackerAtk['id'] == 427) {
                $info = $this->attacker->_getStatusList();
                if($info){foreach($info AS $key=>$value){if($value['type'] == 'toxic' || $value['type'] == 'toxic2' || $value['type'] == 'burn' || $value['type'] == 'paralyzed'){unset($info[$key]);}}}
                $this->log[] = 'Покемон вылечился от некоторых негативных статусов.';
              }

              if($this->attackerAtk['id'] == 220) {
                $this->defender->_setModifiedStatNormal();
                $this->log[] = 'У противника обнулены все характеристики.';
              }

              if($this->attackerAtk['id'] == 419) {
                Work::$sql->query("UPDATE battle SET `weather` = 3 WHERE user_1 = ".$attacker->user_id." OR user_2 = ".$attacker->user_id);
                $this->log[] = 'Погода меняется на Дождь.';
              }

              if($this->attackerAtk['id'] == 534) {
                Work::$sql->query("UPDATE battle SET `weather` = 2 WHERE user_1 = ".$attacker->user_id." OR user_2 = ".$attacker->user_id);
                $this->log[] = 'Погода меняется на Солнечную.';
              }

              if($this->attackerAtk['id'] == 455) {
                Work::$sql->query("UPDATE battle SET `weather` = 5 WHERE user_1 = ".$attacker->user_id." OR user_2 = ".$attacker->user_id);
                $this->log[] = 'Погода меняется на Песчаную бурю.';
              }

              if($this->attackerAtk['id'] == 216) {
                Work::$sql->query("UPDATE battle SET `weather` = 4 WHERE user_1 = ".$attacker->user_id." OR user_2 = ".$attacker->user_id);
                $this->log[] = 'Погода меняется на Град.';
              }
              if($this->attackerAtk['id'] == 209) {
                $this->log[] = 'Покемон начинает обижаться...';
              }
              if($this->attackerAtk['id'] == 398) {
                $this->log[] = 'Покемон меняет статы Защиты и Атаки местами.';
                $stat1 = $this->attacker->stats[1];
                $stat2 = $this->attacker->stats[2];
                $this->attacker->stats[1] = $stat2;
                $this->attacker->stats[2] = $stat1;
              }

              if($this->attackerAtk['id'] == 211) {
                $this->log[] = 'Покемон меняется статами Защиты и Спец. Защиты с противником.';
                $stat1 = $this->attacker->stats[2];
                $stat2 = $this->attacker->stats[5];
                $stat3 = $this->defender->stats[2];
                $stat4 = $this->defender->stats[5];
                $this->attacker->stats[2] = $stat3;
                $this->attacker->stats[5] = $stat4;
                $this->defender->stats[2] = $stat1;
                $this->defender->stats[5] = $stat2;
              }
							if($this->attackerAtk['id'] == 290){
								$this->settingsScreen[$attacker->user_id]['LightScreen'] = [
																			'roundEnd'=>$this->_actionBattle->round + 5
																		];
                                    $rn = $this->_actionBattle->round + 5;
								$this->log[] = 'На поле появился экран света до '.$rn.' раунда включительно.';
							}
							if($this->attackerAtk['id'] == 425){
								$this->settingsScreen[$attacker->user_id]['Reflect'] = [
																			'roundEnd'=>$this->_actionBattle->round + 5
																		];
                                    $rn = $this->_actionBattle->round + 5;
								$this->log[] = 'На поле появился защитный экран до '.$rn.' раунда включительно.';
							}
							if($this->attackerAtk['id'] == 510 && $this->_actionBattle->_isPVP()){
								// $battleSettings = Work::$sql->query('SELECT *
													// FROM `battle_settings`
													// WHERE
														// `userID` = '.$attacker->user_id.'
														// AND `battleID` = '.$this->_actionBattle->userInfo['status_id']
													// )->fetch_assoc();
								// if(empty($battleSettings['spikes'])){
									// $this->log[] = 'На поле выставлен ряд шипов.';
									// Work::$sql->query('INSERT INTO `battle_settings`
													// (`)
														// `userID` = '.$attacker->user_id
													// )->fetch_assoc();
								// }
							//	if($this->settingsSpikes[$this->_actionBattle->enemyInfo['login']]['Spikes']['count'] < 3){
									//$this->settingsSpikes[$attacker->user_id]['Spikes']['count'] = ($this->settingsSpikes[$attacker->user_id]['Spikes']['count'] ? $this->settingsSpikes[$attacker->user_id]['Spikes']['count'] + 1 : 4);
									//if(isset($this->settingsSpikes[$this->_actionBattle->enemyInfo['login']]['Spikes']['count'])){
									//
									//}else{
									//$this->settingsSpikes['mySettings']['Spikes']['count'] = $this->settingsSpikes['mySettings']['Spikes']['count'] + 1;
									//$this->log[] = 'На поле выставлен ряд шипов.'.$this->settingsSpikes['mySettings']['Spikes']['count'];
									//}
								//}else{
								//	$this->log[] = 'Провал';
								//}
							}
              $this->settings['crash'] = false;
                    }else{
                        if($this->defender->hp > 0){

                            $this->getDmg($this->attacker, $this->defender, $this->attackerAtk, $this->defenderAtk);

                        }else{
                            $this->log[] = 'Но, '.$this->defender->_getName(true).' уже полностью обессилен.';
                        }
                    }

                }else{

                  $this->settings['crash'] = true;
                  $this->log[] = 'Но, '.$this->attacker->_getName(true).' промахнулся.';
                  Work::$sql->query('DELETE FROM atk_rollout WHERE user = '.$this->attacker->user_id);
                  Work::$sql->query('DELETE FROM atk_furycutter WHERE user = '.$this->attacker->user_id);


                }

                if(!$this->settings['crash']){
                    if($this->attacker->item_id == 100) {
                      $randKorona = mt_rand(1,100);
                      if($randKorona <= 12) {
                        $this->defender->_setStatus( 'flinch', 1);
                        $this->log[] = 'Противник напуган.';
                      }
                    }
                    $this->issetEffect($this->attacker, $this->attacker, $this->attackerAtk, $this->attackerAtk, true);
                    $this->issetEffect($this->attacker, $this->defender, $this->attackerAtk, $this->defenderAtk);
                }
            }else{
                if($this->attackerAtk['id'] == 209) {
                  $mypp = explode(',',$this->defender->pp_my);
                  if($mypp[$this->defenderAtk['attack_num']] <= 100) {
                    $mypp[$this->defenderAtk['attack_num']] = 0;
                  }
                  $this->defender->pp_my = implode(',',$mypp);
                  $this->settings['crash'] = true;
                  $this->log_status[] = $this->attacker->_getName(true).' не может продолжать битву. Атака противника потеряла все PP.';
                }else{
                  $this->settings['crash'] = true;
                  $this->log_status[] = $this->attacker->_getName(true).' не может продолжать битву.';
                }

            }
          }else{
            $rand = mt_rand(1,2);
            $this->defender->hp = $this->defender->hp - $rand;
            $this->log[] = 'У покемона недостаточно PP, и он со всех сил пытается сделать хоть что-то...<br>Покемон немного задевает противника и наносит: <span class="HpMinus">-'.$rand.' HP</span>';
          }
        }else{
            $this->settings['crash'] = true;
        }

        $this->user_log[] = [
            'user'=>$attacker->user_id,
            'start'=>$this->log_start,
            'log'=>$this->log
        ];

        if($this->attacker->hp <= 0){
            $this->attacker->hp = 0;
        }
        if($this->attacker->hp > $this->attacker->hp_max){
            $this->attacker->hp = $this->attacker->hp_max;
        }
        if($this->defender->hp <= 0){
            $this->defender->hp = 0;
        }
        if($this->defender->hp > $this->defender->hp_max){
            $this->defender->hp = $this->defender->hp_max;
        }

        if($this->settings['crash'] != true){
            $this->attacker->actionCount = $this->attacker->actionCount + 1;
            $this->attacker->targetLvl['p'.$this->defender->_getID()] = $this->defender->_getLvl();
        }
    }

    private function getAtkName(array $aInfo){
        return (!empty($aInfo['name']) ? '<span onclick="viewDescriptionAttak(this,'.$aInfo['id'].');" class="Attack MoveCategory'.($aInfo['category'] == 'physical' ? '1' : ( $aInfo['category'] == 'special' ? '2' : '3') ).'">'.$aInfo['name'].'</span>' : '...');
    }

    private function getDmg(PokeBattle $atk, PokeBattle $def, array &$atkAtk, array &$defAtk){
        if($def->_isHp()){
            /*
                0.5,0.51,0.52,0.53,0.54,0.55,0.56,0.57,0.58,0.59,
                0.6,0.61,0.62,0.63,0.64,0.65,0.66,0.67,0.68,0.69,
            */

            $random = Info::_arrRandDefOne([
                0.7,0.71,0.72,0.73,0.74,0.75,0.76,0.77,0.78,0.79,
                0.8,0.81,0.82,0.83,0.84,0.85,0.86,0.87,0.88,0.89,
                0.9,0.91,0.92,0.93,0.94,0.95,0.96,0.97,0.98,0.99,
                1
            ]);

            if(!$random){
                $random = 1;
            }


            $chance_critical = 7;
            $count_hit = 1;

            if(!empty($atkAtk['settings'])){

                if(isset($atkAtk['settings']['atk_pow_no_items']) && !$atk->_getItems() && $atkAtk['power'] > 0){
                    $atkAtk['settings']['atk_pow_no_items'] = floatval($atkAtk['settings']['atk_pow_no_items']);
                    $atkAtk['power'] += floor($atkAtk['power'] * $atkAtk['settings']['atk_pow_no_items']);
                    $this->log[] = 'Мощность этой атаки была повышена на '.($atkAtk['settings']['atk_pow_no_items'] * 100).'%.';
                }

                if(isset($atkAtk['settings']['chance_critical'])){
                     $atkAtk['settings']['chance_critical'] = floatval($atkAtk['settings']['chance_critical']);
                     $chance_critical += floor($chance_critical * $atkAtk['settings']['chance_critical']);
                }

                if(isset($atkAtk['settings']['critical_hit'])){
                    $chance_critical = 7;
                }

                if(isset($atkAtk['settings']['count_hit'], $atkAtk['settings']['count_hit'][0], $atkAtk['settings']['count_hit'][1])){
                    if($atkAtk['settings']['count_hit'][0] > 0){
                        if($atkAtk['settings']['count_hit'][1] > $atkAtk['settings']['count_hit'][0]){
                            $count_hit = mt_rand($atkAtk['settings']['count_hit'][0], $atkAtk['settings']['count_hit'][1]);
                        }else{
                            $count_hit = $atkAtk['settings']['count_hit'][0];
                        }

                    }
                }

            }

			if($atkAtk['id'] == 56){
				if($this->settingsScreen[$def->user_id]['LightScreen']['roundEnd']  > $this->_actionBattle->round || $this->settingsScreen[$def->user_id]['Reflect']['roundEnd'] > $this->_actionBattle->round){
					$this->log[] = 'Все экраны противника разрушены.';
					$this->settingsScreen[$def->user_id]['LightScreen']['roundEnd'] = 0;
					$this->settingsScreen[$def->user_id]['Reflect']['roundEnd'] = 0;
				}
            }
            if(in_array($atkAtk['id'], [152, 236])){
                if($atk->_checkStatus('toxic') || $atk->_checkStatus('toxic2') || $atk->_checkStatus('burn') || $atk->_checkStatus('paralyzed')){
                    $atkAtk['power'] = $atkAtk['power'] * 2;
                }
            }

            if($atkAtk['id'] == 375) {
              $randPot = mt_rand(1,2);
              if($randPot == 1) {
                $randPot2 = mt_rand(1,100);
                itemAdd(1,$randPot2);
                $this->log[] = 'Покемон находит <div class="itemIsset" onclick=issetAll(1,"item") style="background-image: url(/img/world/items/little/1.png)"></div> '.$randPot2.' шт.';
              }
              $this->log[] = 'Покемон не находит монет.';
            }
            if($atkAtk['id'] == 446) {
              $atka =  Work::$sql->query('SELECT * FROM atk_rollout WHERE pokID = '.$atk->id)->fetch_assoc();
                if(isset($atka)) {
                  $atkAtk['power'] = $atka['mnoz'] * 2;
                  $this->log[] = 'Мощность атаки увеличена в x'.$atka['mnoz'];
                  if($atka['mnoz'] == 5) {
                    Work::$sql->query("UPDATE atk_rollout SET `mnoz` = 1 WHERE pokID = ".$atk->id);
                  }else{
                     $atkp = $atka['mnoz'] + 1;
                     Work::$sql->query("UPDATE atk_rollout SET `mnoz` = $atkp WHERE pokID = ".$atk->id);
                   }
                }else{
                  Work::$sql->query("INSERT INTO atk_rollout (pokID, mnoz, user) VALUES (".$atk->id.", 2, ".$_SESSION['id'].")");
                  $this->log[] = 'Мощность атаки увеличена в х1';
                }
            }
            if($atkAtk['id'] == 190) {
              $atka =  Work::$sql->query('SELECT * FROM atk_furycutter WHERE pokID = '.$atk->id)->fetch_assoc();
                if(isset($atka)) {
                  $atkAtk['power'] = $atkAtk['power'] * $atka['mnoz'];
                  $this->log[] = 'Мощность атаки увеличена в x'.$atka['mnoz'];
                  if($atka['mnoz'] == 4) {
                    Work::$sql->query("UPDATE atk_furycutter SET `mnoz` = 4 WHERE pokID = ".$atk->id);
                  }else{
                     $atkp = $atka['mnoz'] + 1;
                     Work::$sql->query("UPDATE atk_furycutter SET `mnoz` = $atkp WHERE pokID = ".$atk->id);
                   }
                }else{
                  Work::$sql->query("INSERT INTO atk_furycutter (pokID, mnoz, user) VALUES (".$atk->id.", 2, ".$_SESSION['id'].")");
                  $this->log[] = 'Мощность атаки увеличена в х1';
                }
            }
            if($atkAtk['id'] == 598) {
              $power = 150 * ($atk->hp / $atk->hp_max);
              if($power <= 1) {
                $atkAtk['power'] = 1;
              }else{
                $atkAtk['power'] = $power;
              }
            }

      $randCrit = ($atk->item_id == 105 ? mt_rand(0, 70) : mt_rand(0, 100));
            $this->settings['stab'] = (($atkAtk['type'] == $atk->_getTypeA() || $atkAtk['type'] == $atk->_getTypeB()) ? 1.5 : 1);
            $this->settings['critical'] = ($randCrit <= $chance_critical ? 1.5 : 1);
            if($this->settings['critical'] == '1.5') {
              $lrn = Work::$sql->query('SELECT * FROM learn_pve WHERE user = '.$def->id.' AND type = 2')->fetch_assoc();
              if(isset($lrn)) {
                $lrn = 4;
              }else{
                $lrn = 3;
              }
              $randSlomat = mt_rand(1,$lrn);
              if($randSlomat == 1) {
                $itemSlom = Work::$sql->query('SELECT item_id,item_str FROM user_pokemons WHERE id = '.$def->id)->fetch_assoc();
                 if($itemSlom['item_id'] != 0 && !empty($itemSlom['item_str'])) {
                   $slom = explode(',',$itemSlom['item_str']);
                   $slom1 = $slom[0] - 1;
                   if($slom1 <= 0) {
                     Work::$sql->query("INSERT INTO `items_users` (`user`,`item_id`,`count`,`str`) VALUES ('".$def->user_id."','".$def->item_id."',1,'0,".$slom[1]."') ");
                     $def->item_id = 0;
                     $this->log[] = 'Предмет покемона сломался.';
                     Work::$sql->query("UPDATE `user_pokemons` SET `item_id` = 0, `item_str` = '' WHERE `id` = '".$def->id."'");
                   }else{
                     $this->log[] = 'Предмет покемона потерял одну прочность.';
                     Work::$sql->query("UPDATE `user_pokemons` SET `item_str` = '".$slom1.",".$slom[1]."' WHERE `id` = '".$def->id."'");
                   }
                }
              }
              $this->log[] = '<span class="Critical">Критический удар!</span>';
            }
            $this->settings['types'] = 1;
            $this->settings['types'] *= (isset($this->types[$atkAtk['type']], $this->types[$atkAtk['type']][$def->_getTypeA()]) ? $this->types[$atkAtk['type']][$def->_getTypeA()] : 1);
            $this->settings['types'] *= (isset($this->types[$atkAtk['type']], $this->types[$atkAtk['type']][$def->_getTypeB()]) ? $this->types[$atkAtk['type']][$def->_getTypeB()] : 1);
            if($atk->_getTypeA() == 'bug' && $atk->item_id == 191 || $atk->_getTypeB() == 'bug' && $atk->item_id == 191) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'dark' && $atk->item_id == 195 || $atk->_getTypeB() == 'dark' && $atk->item_id == 195) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'dragon' && $atk->item_id == 182 || $atk->_getTypeB() == 'dragon' && $atk->item_id == 182) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'electric' && $atk->item_id == 184 || $atk->_getTypeB() == 'electric' && $atk->item_id == 184) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'fairy' && $atk->item_id == 180 || $atk->_getTypeB() == 'fairy' && $atk->item_id == 180) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'fighting' && $atk->item_id == 179 || $atk->_getTypeB() == 'fighting' && $atk->item_id == 179) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'fire' && $atk->item_id == 181 || $atk->_getTypeB() == 'fire' && $atk->item_id == 181) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'fly' && $atk->item_id == 188 || $atk->_getTypeB() == 'fly' && $atk->item_id == 188) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'ghost' && $atk->item_id == 193 || $atk->_getTypeB() == 'ghost' && $atk->item_id == 193) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'grass' && $atk->item_id == 185 || $atk->_getTypeB() == 'grass' && $atk->item_id == 185) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'ground' && $atk->item_id == 192 || $atk->_getTypeB() == 'ground' && $atk->item_id == 192) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'ice' && $atk->item_id == 186 || $atk->_getTypeB() == 'ice' && $atk->item_id == 186) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'normal' && $atk->item_id == 190 || $atk->_getTypeB() == 'normal' && $atk->item_id == 190) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'poison' && $atk->item_id == 187 || $atk->_getTypeB() == 'poison' && $atk->item_id == 187) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'psychic' && $atk->item_id == 194 || $atk->_getTypeB() == 'psychic' && $atk->item_id == 194) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'rock' && $atk->item_id == 183 || $atk->_getTypeB() == 'rock' && $atk->item_id == 183) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'steel' && $atk->item_id == 69 || $atk->_getTypeB() == 'steel' && $atk->item_id == 69) {
              $this->settings['otherDmg'] = 1.1;
            }elseif($atk->_getTypeA() == 'water' && $atk->item_id == 189 || $atk->_getTypeB() == 'water' && $atk->item_id == 189) {
              $this->settings['otherDmg'] = 1.1;
            }else{
              $this->settings['otherDmg'] = 1;
            }

            if($atkAtk['id'] == 74) {
              $atkDef = ($atkAtk['category'] == 'physical' ? ($atk->_getStatAtk() / $def->_getStatDef()) : ($atk->_getStatSAtk() / $def->_getStatSDef(1)));
            }else{
              $atkDef = ($atkAtk['category'] == 'physical' ? ($atk->_getStatAtk() / $def->_getStatDef()) : ($atk->_getStatSAtk() / $def->_getStatSDef()));
            }
            $atkDmg = $atkAtk['power'];

            $this->settings['dmg'] = 0;

            for($i=0; $i<$count_hit; $i++){
				if($atkAtk['power'] != 0){
          if($atkAtk['id'] == 408 || $atkAtk['id'] == 409) {
            $atkDef = $atk->_getStatSAtk() / $def->_getStatDef();
            $this->log[] = 'Атака наносит физические повреждения!';
          }else{
            $atkDef = $atkDef;
          }
					$this->settings['dmg'] += intval(floor(( ( ( (2 * $atk->_getLvl()) + 10) / 250) * $atkDef * $atkDmg + 2) * $this->settings['stab'] * $this->settings['critical'] * $this->settings['types']  * $this->settings['otherDmg'] * $random));
				}else{
					$this->settings['dmg'] += 0;
				}
            }

            if($atkAtk['id'] == 30) {
              if($defAtk['power'] > 0) {
                $this->settings['dmg'] = floor($this->settings['dmg'] * 2);
                $this->log[] = 'Атака нанесла удвоенные повреждения.';
              }
            }

            if($atkAtk['id'] == 505) {
              if($def->_getTypeA() != 'ghost' && $def->_getTypeB() != 'ghost') {
                $this->settings['dmg'] = 20;
              }
            }

            if($atkAtk['id'] == 326) {
              if($defAtk['category'] == 'special' && $def->_getTypeB() != 'dark' && $def->_getTypeA() != 'dark') {
                 $this->settings['dmg'] = floor(($def->hp_before) * 2);
                 $this->log[] = 'Атака нанесла двойной урон от урона противника.';
               }else{
                $this->settings['dmg'] = 0;
               }
            }

            if($atkAtk['id'] == 160) {
              $this->settings['dmg'] = floor($atk->hp);
              $atk->hp = 0;
              $this->log[] = 'Пользователь не может продолжать битву.';
            }

            if($atkAtk['id'] == 130) {
              if($def->_checkStatus('sleep')) {
                $this->log[] = 'Атака сработала.';
              }else{
                $this->settings['dmg'] = 0;
                $this->log[] = 'Провал. Противник не спит.';
              }
            }
            if(isset($this->settingsScreen[$def->user_id]['LightScreen']['roundEnd']) && $atkAtk['category'] == 'special' && $this->settingsScreen[$def->user_id]['LightScreen']['roundEnd'] > $this->_actionBattle->round){
  						$this->settings['dmg'] = floor($this->settings['dmg'] * 0.5);
  					}
            if(isset($this->settingsScreen[$def->user_id]['Reflect']['roundEnd']) && $atkAtk['category'] == 'physical' && $this->settingsScreen[$def->user_id]['Reflect']['roundEnd'] > $this->_actionBattle->round){
  						$this->settings['dmg'] = floor($this->settings['dmg'] * 0.5);
  					}
            if($this->settings['dmg'] > 0){

                if($atkAtk['category'] == 'physical' && $atk->_checkStatus('burn')){
                    $this->settings['dmg'] = floor($this->settings['dmg'] * 0.5);
                }
                if($this->settings['types'] != 1){

                    if($this->settings['types'] >= 4){
                        $this->log[] = 'Сверх-эффективная атака.';
                    }elseif($this->settings['types'] >= 2.5){
                        $this->log[] = 'Суперэффективная атака.';
                    }elseif($this->settings['types'] >= 2){
                        $this->log[] = 'Очень эффективная атака.';
                    }elseif($this->settings['types'] > 1){
                        $this->log[] = 'Эффективная атака.';
                    }elseif($this->settings['types'] <= 0.51){
                        $this->log[] = 'Малоэффективная атака.';
                    }elseif($this->settings['types'] <= 0.26){
                        $this->log[] = 'Неэффективная атака.';
                    }

                }

                if($count_hit > 1){
                    if($count_hit == 2 || $count_hit == 3 || $count_hit == 3 || $count_hit == 4) {
                      $raz = 'раза';
                    }else{
                      $raz = 'раз';
                    }
                    $this->log[] = 'Покемон бьет противника <b>'.$count_hit.'</b> '.$raz.'.';
                }
				if($atkAtk['id'] == 473 || $atkAtk['id'] == 212 || $atkAtk['id'] == 243 || $atkAtk['id'] == 166){
                    #One-Hit KO
					$this->log[] = 'Смертельная атака';
					$this->settings['dmg'] = $def->hp;
				}elseif($atkAtk['id'] == 125){
				    #Dragon Rage
					$this->settings['dmg'] = 40;
				}elseif($atkAtk['id'] == 346){
				    #Night Shade
					if($def->lvl < $atk->lvl){
						$this->settings['dmg'] = $atk->lvl;
					}
				}elseif(!empty($atkAtk['settings'])){

					if(isset($atkAtk['settings']['recoil'])){
						$recoil = $atkAtk['settings']['recoil'];
						$damageMy = floor($atk->hp/$recoil);
						if($damageMy > $atk->hp_max){
							$damageMy = $atk->hp_max / 2;
						}
						$atk->hp = ($atk->hp - $damageMy);
						$this->log[] = 'Отдача ранит покемона: <span class="HpMinus">-'.$damageMy.' HP</span>';
					}

				}
				if(isset($atkAtk['settings'], $atkAtk['settings']['return_dmg'])){
				    $returnDmg = ($this->settings['dmg'] * floatval($atkAtk['settings']['return_dmg']));
					if($returnDmg > $atk->hp_max){
						$returnDmg = $atk->hp_max / 2;
					}
                    $atk->hp = ($atk->hp - $returnDmg);
                    $this->log[] = $atk->_getName(true).' получает отдачу от нанесенного урона в размере: <span class="HpMinus">-'.floor($returnDmg).' HP</span>';
                }

				if($atk->_checkStatus('confused') && 25 >= mt_rand(0, 100)){
          $dmgConf = ($atk->hp - ($this->settings['dmg'] / 3));
					$this->log[] = 'Но, из-за спута '.$atk->_getName(true).' ударил себя и нанес урон <span class="HpMinus">-'.floor($dmgConf).' HP</span>';
					$atk->hp = $dmgConf;
				}else{
					$def->hp = ($def->hp - $this->settings['dmg']);
				}

                if($atkAtk['id'] == 156){
                    if($def->hp <= 1){
                        $def->hp = 1;
                    }
                }

				//$this->settings['destiny'] = ($defAtk['id'] == 108 ? true : false);
        $this->settings['destiny'] = false;
				if($this->settings['dmg'] > $def->hp+7 && $this->settings['destiny'] == true){
					 $atk->hp = $def->hp;
				}

                $this->log[] = 'Атака наносит урон: <span class="HpMinus">-'.$this->settings['dmg'].' HP</span>';

			}elseif($atkAtk['id'] == '160'){
				if($this->settings['types'] > 0){
					$this->log[] = 'Покемон упал в обморок. Противнику ненесено столько урона, сколько было здоровья у пользователя <span class="HpMinus">-'.$atk->hp.'</span>.';
					if($atk->hp >= $def->hp){
						$atk->hp = 0;
						$def->hp = 0;
					}else{
						$def->hp = $atk->hp;
					}
				}else{
					$this->log[] = 'Нет эффекта от атаки.';
				}
			}else{
                if($this->settings['types'] > 0){
					if($atkAtk['power'] != 0){
						$this->log[] = 'Но атака не наносит урона.';
					}
                }else{
                    $this->log[] = 'Нет эффекта от атаки.';
                }
            }
            $atk->hp_before = $this->settings['dmg'];
            if($atk->item_id == 106) {
              $obedki = ($atk->stats[0] / 16);
              $atk->hp = ($atk->hp + $obedki);
              $this->log[] = 'Объедки восстановили часть здоровья покемону: <span class="HpPlus">+'.ceil($obedki).' HP</span>';
            }
        }else{
          $this->log_status[] = $this->attacker->_getName(true).' не может продолжать битву.';
        }

        return false;
    }

    private function getCatch(PokeBattle &$atk, PokeBattle $def, array &$atkAtk, array &$defAtk){

        if($atkAtk['id'] == 9998){

            $uData =& $this->_actionBattle->_getUserData($atk->_getUser());

            if(isset($uData['targetItem']) && is_array($uData['targetItem'])){

                $target = $uData['targetItem'];

                if(!empty($target)){
                    if($target['number'] == 7){
                      $atk->hp = $atk->hp + 50;
                      $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(7,\'item\')" style="background-image: url(/img/world/items/little/7.png)"></div> и восстанавливает своем покемону <span class="HpPlus">+50 HP</span>';
                    }elseif($target['number'] == 8){
                      $atk->hp = $atk->hp + 100;
                      $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(8,\'item\')" style="background-image: url(/img/world/items/little/8.png)"></div> и восстанавливает своем покемону <span class="HpPlus">+100 HP</span>';
                    }elseif($target['number'] == 9){
                      $atk->hp = $atk->hp + 5000;
                      $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(9,\'item\')" style="background-image: url(/img/world/items/little/9.png)"></div> и полностью восстанавливает здоровье своему покемону.';
                    }elseif($target['number'] == 45){
                    $info = $atk->_getStatusList();
                    if($info){foreach($info AS $key=>$value){if($value['type'] == 'sleep'){unset($info[$key]);}}}
                    $atk->_setStatusList($info);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(45,\'item\')" style="background-image: url(/img/world/items/little/45.png)"></div> и будит своего покемона.';
                  }elseif($target['number'] == 46){
                    $info = $atk->_getStatusList();
                    if($info){foreach($info AS $key=>$value){if($value['type'] == 'burn'){unset($info[$key]);}}}
                    $atk->_setStatusList($info);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(46,\'item\')" style="background-image: url(/img/world/items/little/46.png)"></div> и потушил своего покемона.';
                  }elseif($target['number'] == 47){
                    $info = $atk->_getStatusList();
                    if($info){foreach($info AS $key=>$value){if($value['type'] == 'toxic' || $value['type'] == 'toxic2'){unset($info[$key]);}}}
                    $atk->_setStatusList($info);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(47,\'item\')" style="background-image: url(/img/world/items/little/47.png)"></div> и лечит от отравления своего покемона.';
                  }elseif($target['number'] == 48){
                    $info = $atk->_getStatusList();
                    if($info){foreach($info AS $key=>$value){if($value['type'] == 'paralyzed'){unset($info[$key]);}}}
                    $atk->_setStatusList($info);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(48,\'item\')" style="background-image: url(/img/world/items/little/48.png)"></div> и лечит от парализованности своего покемона.';
                  }elseif($target['number'] == 49){
                    $info = $atk->_getStatusList();
                    if($info){foreach($info AS $key=>$value){if($value['type'] == 'confused'){unset($info[$key]);}}}
                    $atk->_setStatusList($info);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(49,\'item\')" style="background-image: url(/img/world/items/little/49.png)"></div> и лечит от спута своего покемона.';
                  }elseif($target['number'] == 50){
                    $info = $atk->_getStatusList();
                    if($info){foreach($info AS $key=>$value){if($value['type'] == 'frost'){unset($info[$key]);}}}
                    $atk->_setStatusList($info);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(50,\'item\')" style="background-image: url(/img/world/items/little/50.png)"></div> и размораживает своего покемона.';
                  }elseif($target['number'] == 196){
                    $info = $atk->_getStatusList();
                    if($info){foreach($info AS $key=>$value){if($value['type'] == 'confused' || $value['type'] == 'frost' || $value['type'] == 'toxic' || $value['type'] == 'toxic2' || $value['type'] == 'burn' || $value['type'] == 'paralyzed' || $value['type'] == 'sleep'){unset($info[$key]);}}}
                    $atk->_setStatusList($info);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(196,\'item\')" style="background-image: url(/img/world/items/little/196.png)"></div> и лечит от всех негативных статусов своего покемона.';
                  }elseif($target['number'] == 136){
                    $atk->_setModifiedStat('atk', 1, true);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(136,\'item\')" style="background-image: url(/img/world/items/little/136.png)"></div> и его покемон повышает <span class="StatPlus">Атаку +1</span>';
                  }elseif($target['number'] == 137){
                    $atk->_setModifiedStat('satk', 1, true);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(137,\'item\')" style="background-image: url(/img/world/items/little/137.png)"></div> и его покемон повышает <span class="StatPlus">Спец. Атаку +1</span>';
                  }elseif($target['number'] == 138){
                    $atk->_setModifiedStat('spd', 1, true);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(138,\'item\')" style="background-image: url(/img/world/items/little/138.png)"></div> и его покемон повышает <span class="StatPlus">Скорость +1</span>';
                  }elseif($target['number'] == 139){
                    $atk->_setModifiedStat('def', 1, true);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(139,\'item\')" style="background-image: url(/img/world/items/little/139.png)"></div> и его покемон повышает <span class="StatPlus">Защиту +1</span>';
                  }elseif($target['number'] == 140){
                    $atk->_setModifiedStat('sdef', 1, true);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(140,\'item\')" style="background-image: url(/img/world/items/little/140.png)"></div> и его покемон повышает <span class="StatPlus">Спец. Защиту +1</span>';
                  }elseif($target['number'] == 197){
                    $mypp = explode(',',$this->attacker->pp_my);
                    $myatt = explode(',',$this->attacker->attacks);
                    $a1 =  Work::$sql->query('SELECT pp FROM base_atk WHERE id = '.$myatt[0])->fetch_assoc();
                    $a2 =  Work::$sql->query('SELECT pp FROM base_atk WHERE id = '.$myatt[1])->fetch_assoc();
                    $a3 =  Work::$sql->query('SELECT pp FROM base_atk WHERE id = '.$myatt[2])->fetch_assoc();
                    $a4 =  Work::$sql->query('SELECT pp FROM base_atk WHERE id = '.$myatt[3])->fetch_assoc();
                    if(($a1['pp'] - $mypp[0]) >= 10) {
                      $mypp[0] = $mypp[0] + 10;
                    }else{
                      $mypp[0] = $a1['pp'];
                    }
                    if(($a2['pp'] - $mypp[1]) >= 10) {
                      $mypp[1] = $mypp[1] + 10;
                    }else{
                      $mypp[1] = $a2['pp'];
                    }
                    if(($a3['pp'] - $mypp[2]) >= 10) {
                      $mypp[2] = $mypp[2] + 10;
                    }else{
                      $mypp[2] = $a3['pp'];
                    }
                    if(($a4['pp'] - $mypp[3]) >= 10) {
                      $mypp[3] = $mypp[3] + 10;
                    }else{
                      $mypp[3] = $a4['pp'];
                    }
                    $this->attacker->pp_my = implode(',',$mypp);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(197,\'item\')" style="background-image: url(/img/world/items/little/197.png)"></div> и пополняет PP своего покемона на 10 пунктов.';
                  }elseif($target['number'] == 198){
                    $mypp = explode(',',$this->attacker->pp_my);
                    $myatt = explode(',',$this->attacker->attacks);
                    $a1 =  Work::$sql->query('SELECT pp FROM base_atk WHERE id = '.$myatt[0])->fetch_assoc();
                    $a2 =  Work::$sql->query('SELECT pp FROM base_atk WHERE id = '.$myatt[1])->fetch_assoc();
                    $a3 =  Work::$sql->query('SELECT pp FROM base_atk WHERE id = '.$myatt[2])->fetch_assoc();
                    $a4 =  Work::$sql->query('SELECT pp FROM base_atk WHERE id = '.$myatt[3])->fetch_assoc();
                    if(($a1['pp'] - $mypp[0]) >= 20) {
                      $mypp[0] = $mypp[0] + 20;
                    }else{
                      $mypp[0] = $a1['pp'];
                    }
                    if(($a2['pp'] - $mypp[1]) >= 20) {
                      $mypp[1] = $mypp[1] + 20;
                    }else{
                      $mypp[1] = $a2['pp'];
                    }
                    if(($a3['pp'] - $mypp[2]) >= 20) {
                      $mypp[2] = $mypp[2] + 20;
                    }else{
                      $mypp[2] = $a3['pp'];
                    }
                    if(($a4['pp'] - $mypp[3]) >= 20) {
                      $mypp[3] = $mypp[3] + 20;
                    }else{
                      $mypp[3] = $a4['pp'];
                    }
                    $this->attacker->pp_my = implode(',',$mypp);
                    $this->log[] = 'Тренер использует <div class="itemIsset" onclick="issetAll(198,\'item\')" style="background-image: url(/img/world/items/little/198.png)"></div> и пополняет PP своего покемона на 20 пунктов.';
                  }else{

                      $this->log[] = 'Бросает: '.(isset($target['name']) ? $target['name'] : '???').'.';

                      $type = $this->goCatch($def, $atk->_getUser(), $target, $atk);

                      if($type){

                          $this->catch = true;
                          $this->log[] = 'Пытается поймать '.$def->_getName(true).'.';
                          $this->log[] = 'Удачная поимка!';

                      }else{
                          if(is_null($type)){
                              $this->log[] = 'Пытается поймать '.$def->_getName(true).', но у тренера нет места.';
                          }else{
                              $this->log[] = 'Пытается поймать '.$def->_getName(true).', но тот упорно сопротивляется.';
                          }

                      }
                    }

                    unset($uData['targetItem']);

                    return false;
                }

            }
        }

        return true;

    }

    private function getAHH(PokeBattle &$atk, PokeBattle $def, array &$atkAtk, array &$defAtk) {
      $atk->_setModifiedStat('def',1,false);
      $uData =& $this->_actionBattle->_getUserData($atk->_getUser());
      if(isset($uData['targetHH']) && $uData['targetHH'] > 0){
        $target = $this->_actionBattle->_getUserPokes($atk->_getUser(), $uData['targetHH']);
        if(!empty($target)){
          $atk1 = new PokeBattle($target);
          if($atk->id == $atk1->id) {
            $this->log[] = 'Провал. Невозможно использовать данную атаку на себя.';
          }else{
            Work::$sql->query("INSERT INTO atk_helping_hand (pokID,user) VALUES (".$atk1->id.",".$atk->_getUser().")");
            $this->log[] = 'У '.$atk->_getName(true).' понижается <span class="StatMinus">Защита -1</span>, но у одного из союзных покемонов повышается <span class="StatPlus">Атака +1</span>';
          }
        }
      }
      return true;
    }

    private function getSelected(PokeBattle &$atk, PokeBattle $def, array &$atkAtk, array &$defAtk){

        if($atkAtk['id'] == 9999){
            $uData =& $this->_actionBattle->_getUserData($atk->_getUser());

            if(isset($uData['targetPokemon']) && $uData['targetPokemon'] > 0){
                $target = $this->_actionBattle->_getUserPokes($atk->_getUser(), $uData['targetPokemon']);

                if(!empty($target)){
                    $this->_actionBattle->_setTarget($atk->_getUser(), $target);
                    $atk = new PokeBattle($target);
                    unset($atk->modified);
                    $aHH = Work::$sql->query('SELECT * FROM atk_helping_hand WHERE pokID = '.$atk->id)->fetch_assoc();
                    if($aHH) {
                      $atk->_setModifiedStat('atk',1,true);
                      Work::$sql->query('DELETE FROM atk_helping_hand WHERE pokID = '.$atk->id);
                    }
                    $this->log[] = 'Заменяет покемона на '.$atk->_getName(true);

					Work::$sql->query('DELETE FROM battle_block WHERE user = '.$_SESSION['id']);
          Work::$sql->query('DELETE FROM atk_rollout WHERE user = '.$_SESSION['id']);
          Work::$sql->query('DELETE FROM atk_furycutter WHERE user = '.$_SESSION['id']);

                    unset($uData['targetPokemon']);

                    return false;
                }

            }
        }


        return true;
    }

    private function getNext(PokeBattle $atk, PokeBattle $def, array &$atkAtk, array &$defAtk){

        if($this->attacker->hp > 0){

            if($atk->_checkStatus('flinch')){
                $this->log[] = 'Но '.$atk->_getName(true).' напуган и не желает делать это действие.';
                return false;
            }

            if($atk->_checkStatus('frost')){
                $this->log[] = 'Но '.$atk->_getName(true).' заморожен и не может делать это действие.';
                return false;
            }

            if($atk->_checkStatus('paralyzed') && 25 >= mt_rand(0, 100)){
                $this->log[] = 'Но '.$atk->_getName(true).' парализован и не смог сделать это действие.';
                return false;
            }

            if($atk->_checkStatus('sleep')){

                if(!in_array($atkAtk['id'], [491, 501])){
                    $this->log[] = 'Но '.$atk->_getName(true).' спит и не может делать это действие.';
                    return false;
                }

            }

            if($atk->_checkStatus('lover') && $atkAtk['target'] == 'enemy' && 50 >= mt_rand(0, 100)){
                $this->log[] = 'Но '.$atk->_getName(true).' очарован и не желает делать это действие.';
                return false;
            }

        }

        return true;

    }

    private function issetEffect(PokeBattle $atk, PokeBattle $def, array &$atkAtk, array &$defAtk, $my = false){
        if($my !== true){

            if($this->settings['effect_enemy'] !== true){
                return false;
            }

            if(empty($atkAtk['enemy'])){
                return false;
            }

            $info = Info::_unParseData($atkAtk['enemy']);

        }else{
            $info = Info::_unParseData($atkAtk['my']);
        }

        if(!empty($info)){
            if(isset($info['stats'])){
				if($atk->_checkStatus('taunt')){
                   $this->log[] = 'Покемон под насмешкой.';
				   return false;
				}else{
					foreach($info['stats'] AS $key=>$value){

						if($value && isset($value[0], $value[1], $value[2])){

							if(isset($value[3]) && $value[3] > 0){
								if(!($value[3] >= mt_rand(0, 100))){
									continue;
								}
							}

							if($atkAtk['id'] == '68'){
								if($atk->_getSex() == $def->_getSex()){
									continue;
								}
							}

						}

					}
					unset($key,$value);
				}
            }
            if(isset($info['status'])){
                foreach($info['status'] AS $key=>$value){
                    if($value && isset($value[0], $value[1], $value[2]) && $value[0] > 0 && $value[0] >= mt_rand(0, 100)){


                        if(is_array($value[2])){
                            if(isset($value[2][0], $value[2][1]) && $value[2][0] > 0){
                                $value[2] = mt_rand($value[2][0], $value[2][1]);
                            }else{
                                $value[2] = 1;
                            }
                        }

                        if($value[1] == 'lover'){
                            if($atk->_getSex() == $def->_getSex()){
                                $this->log[] = 'Провал изменения статуса.';
                                continue;
                            }
                        }

                        if($value[1] == 'burn'){
                            if($def->_getTypeA() == 'fire' || $def->_getTypeB() == 'fire' || $def->_checkStatus('burn') || $def->_checkStatus('paralyzed') || $def->_checkStatus('frost')){
                                $this->log[] = 'Провал изменения статуса.';
                                continue;
                            }
                        }

                        if($value[1] == 'frost'){
                            if($atkAtk['type'] == 'ice' && ($def->_getTypeA() == 'ice' || $def->_getTypeB() == 'ice') || $this->_actionBattle->weather == 2 || $def->_checkStatus('burn') || $def->_checkStatus('toxic') || $def->_checkStatus('toxic2') || $def->_checkStatus('paralyzed') || $def->_checkStatus('frost')){
                                $this->log[] = 'Провал изменения статуса.';
                                continue;
                            }
                        }

                        if($value[1] == 'toxic'){
                            if($def->_getTypeA() == 'poison' || $def->_getTypeB() == 'poison' || $def->_getTypeA() == 'steel' || $def->_getTypeB() == 'steel' || $def->_checkStatus('burn') || $def->_checkStatus('toxic') || $def->_checkStatus('toxic2') || $def->_checkStatus('paralyzed') || $def->_checkStatus('frost')){
                                $this->log[] = 'Провал изменения статуса.';
                                continue;
                            }
                        }

                        if($value[1] == 'toxic2'){
                            if($def->_getTypeA() == 'poison' || $def->_getTypeB() == 'poison' || $def->_getTypeA() == 'steel' || $def->_getTypeB() == 'steel' || $def->_checkStatus('burn') || $def->_checkStatus('toxic') || $def->_checkStatus('toxic2') || $def->_checkStatus('paralyzed') || $def->_checkStatus('frost')){
                                $this->log[] = 'Провал изменения статуса.';
                                continue;
                            }
                        }

						if($value[1] == 'curse' && $atk->_getTypeA() != 'ghost' && $atk->_getTypeB() != 'ghost'){
							$atk->_setModifiedStat('atk', 1, true);
							$atk->_setModifiedStat('def', 1, true);
							$atk->_setModifiedStat('spd', 1, false);
							$this->log[] = $def->_getName(true).' повышает свою Атаку и Защиту на 1 ступень, но понижает Скорость.';
							continue;
						}
                        if($value[1] == 'paralyzed'){

                            if($atk->_getTypeA() == 'electric' || $atk->_getTypeB() == 'electric' || $def->_checkStatus('burn') || $def->_checkStatus('toxic') || $def->_checkStatus('toxic2') || $def->_checkStatus('paralyzed') || $def->_checkStatus('frost')){
                                continue;
                            }

                            if($atkAtk['type'] == 'electric' && ($atk->_getTypeA() == 'ground' || $atk->_getTypeB() == 'ground')){
                                continue;
                            }

                        }

                            /*
                        if(isset($value[4])){
                            if(isset($value[4]['sex_lover'])){
                                if($atk->_getSex() == $def->_getSex()){
                                    continue;
                                }
                            }
                        }*/

                        if( $def->_setStatus( $value[1], $value[2], (isset($value[3]) ? $value[3] : null) ) ){

                            if(isset($this->titleStatus[$value[1]])){
                               $this->log[] = sprintf($this->titleStatus[$value[1]], $def->_getName(true));
                            }

                        }

                    }
                }
                unset($key,$value);
            }

			if(isset($info['heal'])){
				$heal = floor($atk->hp_max * floatval($info['heal']));
				$atk->hp = $atk->hp + $heal;
				$this->log[] =  $atk->_getName(true).' восстанавливает <span class="HpPlus">+'.$heal.' HP</span>';
            }

            if(isset($info['heal_dmg']) && $info['heal_dmg'] > 0){

			    if($this->settings['dmg'] > 0){
                    $info['heal_dmg'] = floatval($info['heal_dmg']);
                    $atk->hp = $atk->hp + floor($this->settings['dmg'] * $info['heal_dmg']);
                    $this->log[] =  $atk->_getName(false). ' восстанавливает <span class="HpPlus">+'.(round($this->settings['dmg'] / 2)).' HP</span> своей атакой.';

                }

            }

            if($this->settings['types'] > 0){

            if(isset($info['all_stats'], $info['all_stats'][0], $info['all_stats'][1])){
                if($info['all_stats'][0] >= mt_rand(0, 100)){

                    $type = ($info['all_stats'][1] > 0 ? true : false);
                    $info['all_stats'][1] = abs($info['all_stats'][1]);

                    $atk->_setModifiedStat('atk',  $info['all_stats'][1], $type);
                    $atk->_setModifiedStat('def',  $info['all_stats'][1], $type);
                    $atk->_setModifiedStat('spd',  $info['all_stats'][1], $type);
                    $atk->_setModifiedStat('satk', $info['all_stats'][1], $type);
                    $atk->_setModifiedStat('sdef', $info['all_stats'][1], $type);

                    $atk->_setModifiedStat('acr',  $info['all_stats'][1], $type);
                    $atk->_setModifiedStat('agl',  $info['all_stats'][1], $type);
						$this->log[] = 'У '.$atk->_getName(true).' '.($type ? 'повышены' : 'понижены').' все характеристики на '.$info['all_stats'][1].' ед.';
                }
            }
              if(isset($info['all_stats_no_other'], $info['all_stats_no_other'][0], $info['all_stats_no_other'][1])){
                  if($info['all_stats_no_other'][0] >= mt_rand(0, 100)){

                      $type = ($info['all_stats_no_other'][1] > 0 ? true : false);
                      $info['all_stats_no_other'][1] = abs($info['all_stats_no_other'][1]);

                      $atk->_setModifiedStat('atk',  $info['all_stats_no_other'][1], $type);
                      $atk->_setModifiedStat('def',  $info['all_stats_no_other'][1], $type);
                      $atk->_setModifiedStat('spd',  $info['all_stats_no_other'][1], $type);
                      $atk->_setModifiedStat('satk', $info['all_stats_no_other'][1], $type);
                      $atk->_setModifiedStat('sdef', $info['all_stats_no_other'][1], $type);
  						$this->log[] = 'У '.$atk->_getName(true).' '.($type ? '
              повышены
              <span class="StatPlus">Атака +'.$info['all_stats_no_other'][1].'</span>
              <span class="StatPlus">Защита +'.$info['all_stats_no_other'][1].'</span>
              <span class="StatPlus">Скорость +'.$info['all_stats_no_other'][1].'</span>
              <span class="StatPlus">Спец.Атака +'.$info['all_stats_no_other'][1].'</span>
              <span class="StatPlus">Спец.Защита +'.$info['all_stats_no_other'][1].'</span>
              ' : '
              понижены
              <span class="StatPlus">Атака -'.$info['all_stats_no_other'][1].'</span>
              <span class="StatPlus">Защита -'.$info['all_stats_no_other'][1].'</span>
              <span class="StatPlus">Скорость -'.$info['all_stats_no_other'][1].'</span>
              <span class="StatPlus">Спец.Атака -'.$info['all_stats_no_other'][1].'</span>
              <span class="StatPlus">Спец.Защита -'.$info['all_stats_no_other'][1].'</span>
              ').'';
                  }
              }
            }

            if(isset($info['clear_status_all_poke'])){

                if(is_array($info['clear_status_all_poke'])){

                    $pList = $this->_actionBattle->_getUserPokes($def->_getUser());

                    if($pList){

                        $clear = 0;

                        foreach($pList AS $key_1=>&$value_1){

                            if(isset($value_1['status_list'])){

                                foreach($info['clear_status_all_poke'] AS $key=>$value){
                                    if(isset($value_1['status_list'][$value])){
                                        ++$clear;
                                        unset($value_1['status_list'][$value]);
                                    }
                                }
                                unset($key,$value);

                                if($value_1['id'] == $def->_getID()){
                                    $def->_setStatusList($value_1['status_list']);
                                }

                            }

                        }
                        unset($key_1, $value_1);

                        if($clear > 0){
                            $this->_actionBattle->_setUserPokes($def->_getUser(), $pList);
                            $this->log[] = 'Все союзные покемоны '.$atk->_getName(true).' очищены от некоторых отрицательных статусов.';
                        }

                    }


                }

            }



            return true;

        }

		if($atkAtk['id'] == '478'){

			if(mt_rand(1,100) <= 10){
				$this->log[] = $def->_getName(true).' повышает <span class="StatPlus">Атаку +1</span>, <span class="StatPlus">Защиту +1</span>, <span class="StatPlus">Скорость +1</span>, <span class="StatPlus">Спец. Атаку +1</span> и <span class="StatPlus">Спец. Защиту +1</span>';
				$def->_setModifiedStat('atk',1,true);
				$def->_setModifiedStat('satk',1,true);
				$def->_setModifiedStat('def',1,true);
				$def->_setModifiedStat('spd',1,true);
				$def->_setModifiedStat('sdef',1,true);
			}
        }

        if($atkAtk['id'] == '37'){

            $needHp = round($atk->hp_max * 0.5);

            if($atk->hp > $needHp){
                $def->_setModifiedStat('atk', 6, true);
                $atk->hp = ($atk->hp - $needHp);
                $this->log[] = $def->_getName(true).' повышает <span class="StatPlus">Атаку +1</span>, но теряет 50% от максимального здоровья.';
            }else{
                $this->log[] = 'Провал...';
            }

        }

		if($atkAtk['id'] == '100' && $atk->_getTypeA() == 'ghost' || $atk->_getTypeB() == 'ghost'){

			$minusHP = $atk->hp_max / 2;

			$atk->hp = $atk->hp - $minusHP;

        }

        if($this->attackerAtk['id'] == 521) {
          $atk->_setStatus( 'stock', 9999, 1); //Доработать
          $this->log[] = 'Покемон накапливает предметы в своем рту. Всего накоплений: 1.';
        }

        if($this->attackerAtk['id'] == 6) {
          $rand = mt_rand(1,7);
          if($rand == 1) {
            $povis = 'atk';
            $povisText = '<span class="StatPlus">Атаку +2</span>';
          }elseif($rand == 2){
            $povis = 'def';
            $povisText = '<span class="StatPlus">Защиту +2</span>';
          }elseif($rand == 3){
            $povis = 'spd';
            $povisText = '<span class="StatPlus">Скорость +2</span>';
          }elseif($rand == 4){
            $povis = 'satk';
            $povisText = '<span class="StatPlus">Спец. Атаку +2</span>';
          }elseif($rand == 5){
            $povis = 'sdef';
            $povisText = '<span class="StatPlus">Спец. Защиту +2</span>';
          }elseif($rand == 6){
            $povis = 'agl';
            $povisText = '<span class="StatPlus">Ловкость +2</span>';
          }else{
            $povis = 'acr';
            $povisText = '<span class="StatPlus">Точность +2</span>';
          }
          $atk->_setModifiedStat($povis, 2, true);
          $this->log[] = 'Покемон повышает '.$povisText;
        }

		if($atkAtk['id'] == '315'){
			$def->_setModifiedStat('atk',2,false);
			$def->_setModifiedStat('satk',2,false);
			$atk->hp = 0;

        }

         if($atkAtk['id'] == '429'){ 
         if($atk->hp > 0){ 
         $atk->hp = ($atk->hp + 5000); 
         $atk->_setStatus( 'sleep', mt_rand(2,4), null); 
         $info = $this->attacker->_getStatusList(); 
         if($info){foreach($info AS $key=>$value){if($value['type'] == 'toxic' || $value['type'] == 'toxic2' || $value['type'] == 'burn' || $value['type'] == 'paralyzed'){unset($info[$key]);}}} 
         $this->log[] = $def->_getName(true).' восстанавливает все свое здоровье и погружается в сон.'; 
         }else{ 
         $this->log[] = 'Провал...'; 
         } 
         } 

         return null; 
         }
    private function issetStatus(PokeBattle &$attacker, PokeBattle &$defender, array &$attackerAtk, array &$defenderAtk){

        $info = $attacker->_getStatusList();

        $isHp = $attacker->hp;

        if(!empty($info) && is_array($info)){

            foreach($info AS $key => &$value){

                if(isset($value['type'], $value['count']) && $value['count'] > 0){

                    $value['count'] = intval($value['count']);

                    $valInfo = (isset($value['val']) ? $value['val'] : null);

                    if($value['count'] > 999){

                    }else{
                        $value['count'] = $value['count'] - 1;
                    }

                    if($isHp > 0){

                        switch($value['type']){

                          case 'toxic':

                              $hp = round($attacker->hp_max * 0.0625);

                              $attacker->hp = $attacker->hp - $hp;

                              $this->log_status[] = 'Отравление отнимает силы у '.$attacker->_getName(true).' <span class="HpMinus">-'.$hp.' HP</span>';

                              break;

                              case 'toxic2':
                                  if($value['val'] == 0) {
                                    $mnoz = 1;
                                    $value['val'] = '1,'.$this->_actionBattle->round;
                                  }else{
                                    $txR = explode(',',$value['val']);
                                    $toxRound = $this->_actionBattle->round - $txR[1];
                                    $mnoz = ($toxRound == 1 ? $txR[0] + 1 : 1);
                                    $value['val'] = $mnoz.','.$this->_actionBattle->round;
                                  }
                                  $hp = round(($mnoz*$attacker->hp_max) / 16);

                                  $attacker->hp = $attacker->hp - $hp;

                                  $this->log_status[] = 'Сильное отравление отнимает силы у '.$attacker->_getName(true).' <span class="HpMinus">-'.$hp.' HP</span>';
                                  break;

                            case 'burn':

                                $hp = round($attacker->hp_max * 0.125);

                                $attacker->hp = $attacker->hp - $hp;

                                $this->log_status[] = 'Огонь отнимает здоровье у '.$attacker->_getName(true).': <span class="HpMinus">-'.$hp.' HP</span>';

                                break;
							case 'curse':

                                $hp = round($attacker->hp_max/4);

                                $attacker->hp = $attacker->hp - $hp;

                                $this->log_status[] = 'Проклятие отнимает здоровье у '.$attacker->_getName(true).'.';

                                break;

                              case 'frost':

                                  if(20 >= mt_rand(0, 100)){
                                      unset($info[$key]);
                                      $this->log_status[] = $attacker->_getName(true).' оправился от обморожения.';
                                  }

                                  break;

                            case 'nightmare':

                              $info321 = $attacker->_getStatusList();
                              if($info321) {
                                foreach($info321 as $key1=>$val) {
                                  if($val['type'] == 'sleep') {
                                    $a = 0;
                                  }
                                }
                              }
                              if(isset($a)) {
                                $hp = round($attacker->hp * 0.25);
                                $attacker->hp = $attacker->hp - $hp;
                                $this->log_status[] = 'Покемона мучают кошмары. <span class="HpMinus">-'.$hp.' HP</span>';
                              }else{
                                unset($info[$key]);
                              }

                            break;

							case 'aquaRing':

                                $hp = round($attacker->hp_max/16);

                                $attacker->hp = $attacker->hp + $hp;

                                $this->log_status[] = 'Водный щит восстанавливает '.$hp;

                                break;
                        }

                    }

                    // Для остальных статусов, которые не влияют на потерю здоровья.
                    switch($value['type']){

                        case 'test':


                            break;

                    }


                    if($value['count'] <= 0){
                        unset($info[$key]);
                    }

                }else{

                    unset($info[$key]);

                }

            }

            $attacker->_setStatusList($info);

            unset($key, $value);

            if($isHp && $attacker->hp <= 0){
                $attacker->hp = 0;
                $this->log_status[] = 'После такого, '.$attacker->_getName().', трудно было оклематься.';
            }

        }
    }

    private function isAccuracy(PokeBattle $atk, PokeBattle $def, array &$atkAtk, array &$defAtk){

        if(isset($atkAtk['settings'], $atkAtk['settings']['truehit']) && $atkAtk['settings']['truehit'] == 1){
            return true;
        }

		if($atkAtk['accuracy'] == 0){
            return true;
        }

        if(isset($atk->modified['acr'])) {
          if(isset($atk->modified['acr']['plus'])) {
            if($atk->modified['acr']['plus'] == 1) {
              $acr = 4/3;
            }elseif($atk->modified['acr']['plus'] == 2) {
              $acr = 5/3;
            }elseif($atk->modified['acr']['plus'] == 3) {
              $acr = 6/3;
            }elseif($atk->modified['acr']['plus'] == 4) {
              $acr = 7/3;
            }elseif($atk->modified['acr']['plus'] == 5) {
              $acr = 8/3;
            }elseif($atk->modified['acr']['plus'] == 6) {
              $acr = 9/3;
            }else{
              $acr = 3/3;
            }
          }else{
            if($atk->modified['acr']['minus'] == 1) {
              $acr = 3/4;
            }elseif($atk->modified['acr']['minus'] == 2) {
              $acr = 3/5;
            }elseif($atk->modified['acr']['minus'] == 3) {
              $acr = 3/6;
            }elseif($atk->modified['acr']['minus'] == 4) {
              $acr = 3/7;
            }elseif($atk->modified['acr']['minus'] == 5) {
              $acr = 3/8;
            }elseif($atk->modified['acr']['minus'] == 6) {
              $acr = 3/9;
            }else{
              $acr = 3/3;
            }
          }
       }else{
         $acr = 3/3;
       }

       if(isset($def->modified['agl'])) {
         if(isset($def->modified['agl']['plus'])) {
           if($def->modified['agl']['plus'] == 1) {
             $agl = 3/4;
           }elseif($def->modified['agl']['plus'] == 2) {
             $agl = 3/5;
           }elseif($def->modified['agl']['plus'] == 3) {
             $agl = 3/6;
           }elseif($def->modified['agl']['plus'] == 4) {
             $agl = 3/7;
           }elseif($def->modified['agl']['plus'] == 5) {
             $agl = 3/8;
           }elseif($def->modified['agl']['plus'] == 6) {
             $agl = 3/9;
           }else{
             $agl = 3/3;
           }
         }else{
           if($def->modified['agl']['minus'] == 1) {
             $agl = 4/3;
           }elseif($def->modified['agl']['minus'] == 2) {
             $agl = 5/3;
           }elseif($def->modified['agl']['minus'] == 3) {
             $agl = 6/3;
           }elseif($def->modified['agl']['minus'] == 4) {
             $agl = 7/3;
           }elseif($def->modified['agl']['minus'] == 5) {
             $agl = 8/3;
           }elseif($def->modified['agl']['minus'] == 6) {
             $agl = 9/3;
           }else{
             $agl = 3/3;
           }
         }
      }else{
        $agl = 3/3;
      }

        if($atk->item_id == 104) {
          $atkAcc = 1.1;
        }else{
          $atkAcc = 1;
        }

        if($def->item_id == 103) {
          $atkAcc2 = 1.1;
        }else{
          $atkAcc2 = 1;
        }

        $atkAcc3 = $atkAtk['accuracy'] * (($acr * $agl * $atkAcc)/$atkAcc2);
        //$atkAcc3 = $atkAtk['accuracy'] + $atkAcc - $atkAcc2 + $aglAtkPlus - $aglAtkMinus;

        if(isset($atkAtk['accuracy']) && $atkAcc3 > 0 && $atkAcc3 >= mt_rand(0, 100)){
            return true;
        }

        return false;
    }

    private function goCatch(PokeBattle $target, $userID, $itemInfo, $myInfo){
      $pveR =  Work::$sql->query('SELECT rating,location FROM users WHERE id = '.$userID)->fetch_assoc();
      $pveRR = json_decode($pveR['rating']);
      $pveRR = $pveRR->pve;
      $baf =  Work::$sql->query('SELECT * FROM bafs WHERE type = 1 AND user = '.$userID)->fetch_assoc();
      if($baf) {
        if(time() < $baf['time']) {
          if($baf['id'] == 237) {
            $baf = 10;
          }else{
            $baf = 15;
          }
        }else{
          $baf = 0;
        }
      }else{
        $baf = 0;
      }
        if($userID > 0){

            if($itemInfo['val'] > 200 && $pveR['location'] != 231 || $itemInfo['number'] == 5 && $pveR['location'] != 231){

                $catch = true;

            }else{

                $ball = $itemInfo['val'];
                $hpPokemon = ($target->hp / $target->hp_max) * 100;
                $infoCat = $target->_getStatusList();
                if($infoCat){
                  foreach($infoCat AS $key=>$value){
                    if($value['type'] == 'paralyzed' || $value['type'] == 'toxic' || $value['type'] == 'toxic2' || $value['type'] == 'sleep' || $value['type'] == 'frost' || $value['type'] == 'burn'){
                      $statusCat = 20;
                    }
                  }
                }
                if(!isset($statusCat)) {
                  $statusCat = 0;
                }

                if($hpPokemon <= 75 && $hpPokemon >= 51){
                  $hpPokemon = 10;
                }elseif($hpPokemon <= 50 && $hpPokemon >= 31){
                  $hpPokemon = 15;
                }elseif($hpPokemon <= 30 && $hpPokemon >= 0){
                  $hpPokemon = 20;
                }else{
                  $hpPokemon = 0;
                }
                $pveRR = $pveRR / 1000;
                if($pveRR >= 30) {
                  $pveRR = 30;
                }else{
                  $pveRR = $pveRR;
                }
                if($pveR['location'] == 231) {
                  if($itemInfo['number'] == 241) {
                    $result = 50;
                  }else{
                    $result = 0;
                  }
                }else{
                  if($itemInfo['number'] == 241) {
                    $result = 0;
                  }else{
                    $result = $ball + $hpPokemon + $pveRR + $baf + $statusCat;
                  }
                }
                $result = ($pveR['location'] == 5 ? 100 : $result);
                $random = mt_rand(1,100);
                if($random <= $result) {
                  $catch = true;
                }else{
                  $catch = false;
                }


            }



            if($catch){

                $count =  Work::$sql->query('
                                          SELECT COUNT(*) AS `count`
                                          FROM `user_pokemons`
                                          WHERE `user_id` = '.intval($userID).' AND `active` = 1
                                 ')->fetch_assoc();

                if(isset($count['count']) && $count['count'] < 6){

                    $birthday = [
                        'user_id'=>$userID,
                        'date'=>time()
                    ];
                    if($myInfo->item_id == 265) {
                      $happy = 30;
                    }else{
                      $happy = 15;
                    }

                    $user = Work::$sql->query("SELECT * FROM users WHERE id = ".$userID)->fetch_assoc();
                    $catch = ($user['sex'] == "m" ? "поймал" : "поймала");
                    $text = '<div class="user-link"><div onclick=showUserTooltip('.$user['id'].') class="Info-Link sex'.$user['sex'].'"><i class="fa fa-info"></i></div> <div class="u-'.$user['user_group'].'">'.$user['login'].'</div></div> <span>'.$catch.' '.$target->_getName(true).'</span>';
                    Work::$sql->query("INSERT INTO friends_news (user,text,date) VALUES (".$userID.",'".$text."',".time().")");

                    Work::$sql->query('INSERT INTO `user_pokemons`
                                                              (
                                                                `user_id`,
                                                                `basenum`,
                                                                `name_new`,
                                                                `character`,
                                                                `lvl`,
                                                                `birthday`,
                                                                `active`,
                                                                `gender`,
                                                                `exp`,
                                                                `exp_max`,
                                                                `hp`,
                                                                `stats`,
                                                                `evcounts`,
                                                                `gen`,
                                                                `attacks`,
                                                                `type`,
                                                                `sparkaNumber`,
                                                                `happy`,
																`ball`
                                                              )
                                                       VALUES (
                                                                 '.$userID.',
                                                                 '.$target->basenum.',
                                                                 "'.Work::$sql->real_escape_string($target->name_new).'",
                                                                 '.$target->_getHar().',
                                                                 '.$target->_getLvl().',
                                                                 "'.Work::$sql->real_escape_string(Info::_parseData($birthday)).'",
                                                                  1,
                                                                 "'.$target->_getSex().'",
                                                                 '.$target->_getExp().',
                                                                 '.$target->_getExpNext().',
                                                                 '.$target->hp.',
                                                                 "'.$target->_getStats(true).'",
                                                                 "'.$target->_getEvs(true).'",
                                                                 "'.($itemInfo['number'] == 109 ? $target->_getGens(true,true) : $target->_getGens(true)).'",
                                                                 "'.$target->_getAtk().'",
                                                                 "'.$target->_getType().'",
                                                                 '.mt_rand(1, 3).',
                                                                 "'.$happy.'",
																 '.$itemInfo['number'].'
                                                              )
                                               ');

                    $this->_actionBattle->lose(true, 'CATCH');

                    return true;

                }else{

                    return null;

                }


            }else{

                return false;
            }

        }

        return false;

    }

}
