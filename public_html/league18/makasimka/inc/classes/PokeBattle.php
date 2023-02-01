<?php
/**
 * @property int id
 * @property int hp
 * @property int hp_start
 * @property int hp_max
 * @property int energy
 * @property int energy_max
 * @property int lvl
 * @property int basenum
 * @property int user_id
 * @property string name_new
 * @property int actionCount
 * @property array targetLvl
 *
 *
 * @property array itemsUsed
 * @property array protect
 * @property int critical_next_atk
 * @property array status_list
 * @property array atk_reset
 * @property array critical_empty
 * @property array defender_atk_types
 * @property array target_atk_types
 * @property bool wild
 * @property array char_next_atk
 * @property array repeat_atk
 * @property string|array atk_list
 * @property array atk_info
 * @property array im_benign
 * @property int last_atk
 * @property array training_atk
 * @property array atk_refusal
 * @property array attack_round
 * @property int count_action
 * @property array actionAtk
 *
 */
class PokeBattle{

    /*

        0 - HP
        1 - ATK
        2 - DEF
        3 - SPD
        4 - m atk
        5 - m def

    */
    private $atkDefault = [
        'a9998' => ['id'=>9998, 'name'=>'Поимка покемона', 'title'=>'...', 'type'=>'NULL', 'category'=>'NULL', 'priority'=>999998, 'power'=>0, 'accuracy'=>900, 'pp'=>0, 'target'=>0, 'settings'=>'',],
        'a9999' => ['id'=>9999, 'name'=>'Замена покемона', 'title'=>'...', 'type'=>'NULL', 'category'=>'NULL', 'priority'=>999999, 'power'=>0, 'accuracy'=>900, 'pp'=>0, 'target'=>0, 'settings'=>'',],
    ];

    private $pokeInfo = [
        'actionCount'=>0,
        'targetLvl'=>[]
    ];

    private $retarget = null;


    const MAX_MODIFIED_COUNT = 6;

    public function __construct(array $pokeInfo = [], $parser = false){

        $this->pokeInfo = array_merge($this->pokeInfo, $pokeInfo);

        $this->parser($parser);

    }

    public function &__get($name){

        if(isset($this->pokeInfo[$name])){
            return $this->pokeInfo[$name];
        }

        $this->retarget = null;
        return $this->retarget;

    }

    public function __set($name, $value){
        $this->pokeInfo[$name] = $value;
    }

    public function __isset($name){
        return isset($this->pokeInfo[$name]);
    }

    public function __unset($name){
        if(isset($this->pokeInfo[$name])){
            unset($this->pokeInfo[$name]);
        }
    }

    private function parser($parser = false){

        if(!(isset($this->pokeInfo['evcounts']) && is_array($this->pokeInfo['evcounts']))){
            $this->pokeInfo['evcounts'] = (isset($this->pokeInfo['evcounts']) ? explode(',', $this->pokeInfo['evcounts']) : []);
        }

        if(!(isset($this->pokeInfo['gen']) && is_array($this->pokeInfo['gen']))){
            $this->pokeInfo['gen'] = (isset($this->pokeInfo['gen']) ? explode(',', $this->pokeInfo['gen']) : []);
        }

        $this->pokeInfo['hp_max'] = $this->_generateStat($this->_getBaseStatHp(), $this->_getGenHp(), $this->_getEvHp(), true);

        if($this->pokeInfo['hp'] === true){
            $this->pokeInfo['hp'] = $this->pokeInfo['hp_max'];
        }

        if(!(isset($this->pokeInfo['stats']) && is_array($this->pokeInfo['stats']))){
            $this->pokeInfo['stats'] = [
                $this->pokeInfo['hp_max'],
                $this->_generateStat($this->_getBaseStatAtk(),  $this->_getGenAtk(),  $this->_getEvAtk()),
                $this->_generateStat($this->_getBaseStatDef(),  $this->_getGenDef(),  $this->_getEvDef()),
                $this->_generateStat($this->_getBaseStatSpd(),  $this->_getGenSpd(),  $this->_getEvSpd()),
                $this->_generateStat($this->_getBaseStatSAtk(), $this->_getGenSAtk(), $this->_getEvSAtk()),
                $this->_generateStat($this->_getBaseStatSDef(), $this->_getGenSDef(), $this->_getEvSDef()),
            ];
        }else{
            if($parser){
                $this->pokeInfo['stats'] = [
                    $this->pokeInfo['hp_max'],
                    $this->_generateStat($this->_getBaseStatAtk(),  $this->_getGenAtk(),  $this->_getEvAtk()),
                    $this->_generateStat($this->_getBaseStatDef(),  $this->_getGenDef(),  $this->_getEvDef()),
                    $this->_generateStat($this->_getBaseStatSpd(),  $this->_getGenSpd(),  $this->_getEvSpd()),
                    $this->_generateStat($this->_getBaseStatSAtk(), $this->_getGenSAtk(), $this->_getEvSAtk()),
                    $this->_generateStat($this->_getBaseStatSDef(), $this->_getGenSDef(), $this->_getEvSDef()),
                ];
            }
        }

        return true;
    }

    public function _generateStat($baseVal, $gen, $ev, $hp = false){
        if($hp){
            return intval(round((($baseVal * 2) + $gen + ($ev/2)) * ($this->_getLvl()/100) + 10 + $this->_getLvl()));
        }else{
            $har = 1;
            $tren = 1;
            return  intval(round(((($baseVal * 2 + $gen + ($ev/2)) * $this->_getLvl()/100 + 5) * $har) * $tren));
        }
    }

    public function _getAtkInfo($atkID){
        if($atkID > 9000){
            $atkID = intval($atkID);
            if(isset($this->atkDefault['a'.$atkID], $this->atkDefault['a'.$atkID]['id']) && $this->atkDefault['a'.$atkID]['id'] == $atkID){
                return $this->atkDefault['a'.$atkID];
            }
        }
        if(isset($this->pokeInfo['atkList'], $this->pokeInfo['atkList']['a'.$atkID])){
            if(!empty($this->pokeInfo['atkList']['a'.$atkID]['settings'])){
                if(!is_array($this->pokeInfo['atkList']['a'.$atkID]['settings'])){
                    $this->pokeInfo['atkList']['a'.$atkID]['settings'] = Info::_unParseData($this->pokeInfo['atkList']['a'.$atkID]['settings']);
                }
            }
            return $this->pokeInfo['atkList']['a'.$atkID];
        }
        return [];
    }

    public function _getName($img = false){
        if($img) {
          return '<span class="bgPok" onclick="openDex('.$this->basenum.')"><img src="/img/pokemons/anim/'.$this->type.'/'.$this->basenum.'.gif"> <div class="'.$this->type.'-color" style="display: inline-block;">#'.$this->_getBaseNum().' '.$this->name_new.'</div></span>';
        }
    }

    public function _getBaseNum(){
        return ($this->basenum < 10 ? '00'.$this->basenum : ($this->basenum < 100 ? '0'.$this->basenum : $this->basenum));
    }

    /* ~~ BaseStats ~~ */
    public function _getBaseStatHp(){
        return (isset($this->pokeInfo['base_hp']) ? intval($this->pokeInfo['base_hp']) : 0);
    }
    public function _getBaseStatAtk(){
        return (isset($this->pokeInfo['base_atk']) ? intval($this->pokeInfo['base_atk']) : 0);
    }
    public function _getBaseStatDef(){
        return (isset($this->pokeInfo['base_def']) ? intval($this->pokeInfo['base_def']) : 0);
    }
    public function _getBaseStatSpd(){
        return (isset($this->pokeInfo['base_spd']) ? intval($this->pokeInfo['base_spd']) : 0);
    }
    public function _getBaseStatSAtk(){
        return (isset($this->pokeInfo['base_satk']) ? intval($this->pokeInfo['base_satk']) : 0);
    }
    public function _getBaseStatSDef(){
        return (isset($this->pokeInfo['base_sdef']) ? intval($this->pokeInfo['base_sdef']) : 0);
    }
    public function _getType(){
        return (isset($this->pokeInfo['type']) ? $this->pokeInfo['type'] : 'normal');
    }
    public function _getTypeA(){
        return (isset($this->pokeInfo['base_type']) ? $this->pokeInfo['base_type'] : '');
    }
    public function _getTypeB(){
        return (isset($this->pokeInfo['base_type_two']) ? $this->pokeInfo['base_type_two'] : '');
    }

    /* ~~ Stats ~~ */
    public function _getStats($string = false){
        if($string){
            return implode(',', $this->pokeInfo['stats']);
        }
        return $this->pokeInfo['stats'];
    }


    public function _getStatHp(){
        return (isset($this->pokeInfo['stats'][0]) ? intval($this->pokeInfo['stats'][0]) : 0);
    }
    public function _getStatAtk(){

        $stat = (isset($this->pokeInfo['stats'][1]) ? intval($this->pokeInfo['stats'][1]) : 0);

        if($stat > 0){
            $mod = $this->_getModAtk();

            if(!empty($mod)){
                $stat = $stat * ( ( 2 + (isset($mod['plus']) ? intval($mod['plus']) : 0) ) / ( 2 + (isset($mod['minus']) ? intval($mod['minus']) : 0) ) );
            }
        }
        return $stat;
    }
    public function _getStatDef(/*$ignore = false*/){

        $stat = (isset($this->pokeInfo['stats'][2]) ? intval($this->pokeInfo['stats'][2]) : 0);

        if($stat > 0/* && $ignore != false*/){
            $mod = $this->_getModDef();

            if(!empty($mod)){
                $stat = $stat * ( ( 2 + (isset($mod['plus']) ? intval($mod['plus']) : 0) ) / ( 2 + (isset($mod['minus']) ? intval($mod['minus']) : 0) ) );
            }
        }
        return $stat;
    }
    public function _getStatSpd(){

        $stat = (isset($this->pokeInfo['stats'][3]) ? intval($this->pokeInfo['stats'][3]) : 0);

        if($stat > 0){
            $mod = $this->_getModSpd();

            if(!empty($mod)){
                $stat = $stat * ( ( 2 + (isset($mod['plus']) ? intval($mod['plus']) : 0) ) / ( 2 + (isset($mod['minus']) ? intval($mod['minus']) : 0) ) );
            }
        }

        if($this->_checkStatus('paralyzed')){
            $stat = floor($stat / 4);
        }


        return $stat;

    }
    public function _getStatSAtk(){

        $stat = (isset($this->pokeInfo['stats'][4]) ? intval($this->pokeInfo['stats'][4]) : 0);

        if($stat > 0){
            $mod = $this->_getModSAtk();

            if(!empty($mod)){
                $stat = $stat * ( ( 2 + (isset($mod['plus']) ? intval($mod['plus']) : 0) ) / ( 2 + (isset($mod['minus']) ? intval($mod['minus']) : 0) ) );
            }
        }

        return $stat;

    }
    public function _getStatSDef(){

        $stat = (isset($this->pokeInfo['stats'][5]) ? intval($this->pokeInfo['stats'][5]) : 0);

        if($stat > 0){
            $mod = $this->_getModSDef();

            if(!empty($mod)){
                $stat = $stat * ( ( 2 + (isset($mod['plus']) ? intval($mod['plus']) : 0) ) / ( 2 + (isset($mod['minus']) ? intval($mod['minus']) : 0) ) );
            }
        }

        return $stat;

    }


    /* ~~ Gen ~~ */
    public function _getGens($string = false,$upGens = false){
        if($string){

            if(!is_array($this->pokeInfo['gen'])){
                $this->pokeInfo['gen'] = explode(',', $this->pokeInfo['gen']);
            }

			if($upGens){
				$this->pokeInfo['gen'][0] += 4;
				$this->pokeInfo['gen'][1] += 4;
				$this->pokeInfo['gen'][2] += 4;
				$this->pokeInfo['gen'][3] += 4;
				$this->pokeInfo['gen'][4] += 4;
				$this->pokeInfo['gen'][5] += 4;
			}

            return implode(',', $this->pokeInfo['gen']);
        }
        return $this->pokeInfo['gen'];
    }

    public function _getGenHp(){
        return (isset($this->pokeInfo['gen'][0]) ? intval($this->pokeInfo['gen'][0]) : 0);
    }
    public function _getGenAtk(){
        return (isset($this->pokeInfo['gen'][1]) ? intval($this->pokeInfo['gen'][1]) : 0);
    }
    public function _getGenDef(){
        return (isset($this->pokeInfo['gen'][2]) ? intval($this->pokeInfo['gen'][2]) : 0);
    }
    public function _getGenSpd(){
        return (isset($this->pokeInfo['gen'][3]) ? intval($this->pokeInfo['gen'][3]) : 0);
    }
    public function _getGenSAtk(){
        return (isset($this->pokeInfo['gen'][4]) ? intval($this->pokeInfo['gen'][4]) : 0);
    }
    public function _getGenSDef(){
        return (isset($this->pokeInfo['gen'][5]) ? intval($this->pokeInfo['gen'][5]) : 0);
    }

    /* ~~ EV ~~ */
    public function _getEvs($string = false){
        if($string){
            return implode(',', $this->pokeInfo['evcounts']);
        }
        return $this->pokeInfo['evcounts'];
    }

    public function _getEvHp(){
        return (isset($this->pokeInfo['evcounts'][0]) ? intval($this->pokeInfo['evcounts'][0]) : 0);
    }
    public function _getEvAtk(){
        return (isset($this->pokeInfo['evcounts'][1]) ? intval($this->pokeInfo['evcounts'][1]) : 0);
    }
    public function _getEvDef(){
        return (isset($this->pokeInfo['evcounts'][2]) ? intval($this->pokeInfo['evcounts'][2]) : 0);
    }
    public function _getEvSpd(){
        return (isset($this->pokeInfo['evcounts'][3]) ? intval($this->pokeInfo['evcounts'][3]) : 0);
    }
    public function _getEvSAtk(){
        return (isset($this->pokeInfo['evcounts'][4]) ? intval($this->pokeInfo['evcounts'][4]) : 0);
    }
    public function _getEvSDef(){
        return (isset($this->pokeInfo['evcounts'][5]) ? intval($this->pokeInfo['evcounts'][5]) : 0);
    }

    /* ~~ MODIFIED STATS ~~ */
    public function _getModAtk(){
        return (isset($this->pokeInfo['modified'], $this->pokeInfo['modified']['atk']) ? $this->pokeInfo['modified']['atk'] : []);
}
    public function _getModDef(){
        return (isset($this->pokeInfo['modified'], $this->pokeInfo['modified']['def']) ? $this->pokeInfo['modified']['def'] : []);
    }
    public function _getModSpd(){
        return (isset($this->pokeInfo['modified'], $this->pokeInfo['modified']['spd']) ? $this->pokeInfo['modified']['spd'] : []);
    }
    public function _getModSAtk(){
        return (isset($this->pokeInfo['modified'], $this->pokeInfo['modified']['satk']) ? $this->pokeInfo['modified']['satk'] : []);
    }
    public function _getModSDef(){
        return (isset($this->pokeInfo['modified'], $this->pokeInfo['modified']['sdef']) ? $this->pokeInfo['modified']['sdef'] : []);
    }

    public function _setModifiedStatNormal(){
      unset($this->pokeInfo['modified']['satk']['plus']);
      unset($this->pokeInfo['modified']['atk']['plus']);
      unset($this->pokeInfo['modified']['spd']['plus']);
      unset($this->pokeInfo['modified']['sdef']['plus']);
      unset($this->pokeInfo['modified']['def']['plus']);
      unset($this->pokeInfo['modified']['satk']['minus']);
      unset($this->pokeInfo['modified']['atk']['minus']);
      unset($this->pokeInfo['modified']['spd']['minus']);
      unset($this->pokeInfo['modified']['sdef']['minus']);
      unset($this->pokeInfo['modified']['def']['minus']);
      //return true;
      //$this->pokeInfo['modified'] = '';
    }

    public function _setModifiedStat($statName, $count = 1, $plus = false){

        if($statName && is_numeric($count) && $count >= 0){

            $count = intval($count);

            if(!isset($this->pokeInfo['modified'])){
                $this->pokeInfo['modified'] = [];
            }

            if(!isset($this->pokeInfo['modified'][$statName])){
                $this->pokeInfo['modified'][$statName] = [];
            }

            if($plus){

                if($count === 0){

                    if(isset($this->pokeInfo['modified'][$statName]['plus'])){
                        unset($this->pokeInfo['modified'][$statName]['plus']);
                    }

                }else{
                    //Add
                    if(isset($this->pokeInfo['modified'][$statName]['minus']) && (int)$this->pokeInfo['modified'][$statName]['minus'] >= $count){
                        $this->pokeInfo['modified'][$statName]['minus'] -= $count;
                        if((int)$this->pokeInfo['modified'][$statName]['minus'] <= 0){
                            unset($this->pokeInfo['modified'][$statName]['minus']);
                        }
                        if((int)$this->pokeInfo['modified'][$statName]['minus'] >= 0){
                            return true;
                        }
                    }

                    if(isset($this->pokeInfo['modified'][$statName]['plus'])){
                        $this->pokeInfo['modified'][$statName]['plus'] += $count;
                    }else{
                        $this->pokeInfo['modified'][$statName]['plus'] = $count;
                    }

                    if($this->pokeInfo['modified'][$statName]['plus'] >= self::MAX_MODIFIED_COUNT){
                        $this->pokeInfo['modified'][$statName]['plus'] = self::MAX_MODIFIED_COUNT;
                    }
                }

            }else{

                if($count === 0){

                    if(isset($this->pokeInfo['modified'][$statName]['minus'])){
                        unset($this->pokeInfo['modified'][$statName]['minus']);
                    }

                }else{
                    //Add
                    if(isset($this->pokeInfo['modified'][$statName]['plus']) && (int)$this->pokeInfo['modified'][$statName]['plus'] >= $count){
                        $this->pokeInfo['modified'][$statName]['plus'] -= $count;
                        if((int)$this->pokeInfo['modified'][$statName]['plus'] <= 0){
                            unset($this->pokeInfo['modified'][$statName]['plus']);
                        }
                        if((int)$this->pokeInfo['modified'][$statName]['plus'] >= 0){
                            return true;
                        }
                    }

                    if(isset($this->pokeInfo['modified'][$statName]['minus'])){
                        $this->pokeInfo['modified'][$statName]['minus'] += $count;
                    }else{
                        $this->pokeInfo['modified'][$statName]['minus'] = $count;
                    }

                    if($this->pokeInfo['modified'][$statName]['minus'] >= self::MAX_MODIFIED_COUNT){
                        $this->pokeInfo['modified'][$statName]['minus'] = self::MAX_MODIFIED_COUNT;
                    }
                }
            }

            return true;
        }

        return false;
    }

    public function _setStatus($statusName, $count = 1, $otherValue = null){

        if($statusName && is_numeric($count) && $count >= 0){

            $count = intval($count);

            if(!isset($this->pokeInfo['status_list'])){
                $this->pokeInfo['status_list'] = [];
            }

            if(!isset($this->pokeInfo['status_list'][$statusName])){
                $this->pokeInfo['status_list'][$statusName] = [];
            }


            if(isset($this->pokeInfo['status_list'][$statusName]['count']) && $this->pokeInfo['status_list'][$statusName]['count'] > 0){

                return false;

            }else{

                $this->pokeInfo['status_list'][$statusName] = [
                    'type'=>$statusName,
                    'count'=>$count,
                    'val'=>$otherValue
                ];

            }

            return true;

        }

        return false;
    }

    public function _getStatusList(){
        return (isset($this->pokeInfo['status_list']) ? $this->pokeInfo['status_list'] : []);
    }

    public function _setStatusList($list = []){
        if(is_array($list)){
            $this->pokeInfo['status_list'] = $list;
        }
    }

    public function _checkStatus($statusName){
        if(isset($this->pokeInfo['status_list'], $this->pokeInfo['status_list'][$statusName])){
            return true;
        }
        return false;
    }


    public function _getLvl(){
        return (isset($this->pokeInfo['lvl']) ? intval($this->pokeInfo['lvl']) : 1);
    }

    public function _getEvCount(){
        return (isset($this->pokeInfo['ev']) ? intval($this->pokeInfo['ev']) : 0);
    }

    public function _getExp(){
        return (isset($this->pokeInfo['exp']) ? intval($this->pokeInfo['exp']) : 1);
    }

    public function _getExpNext(){
        return (isset($this->pokeInfo['exp_max']) ? intval($this->pokeInfo['exp_max']) : 100);
    }

    public function _getID(){
        return (isset($this->pokeInfo['id']) ? intval($this->pokeInfo['id']) : 0);
    }

    public function _getHar(){
        return (isset($this->pokeInfo['character']) ? intval($this->pokeInfo['character']) : 1);
    }

    public function _getSex(){

        return $this->pokeInfo['gender'];
    }

    public function _getAtk(){
        return (isset($this->pokeInfo['attacks']) ? (is_array($this->pokeInfo['attacks']) ? implode(',', $this->pokeInfo['attacks']) : $this->pokeInfo['attacks']) : '0,0,0,0');
    }

    public function _getUser(){
        return (isset($this->pokeInfo['user_id']) ? intval($this->pokeInfo['user_id']) : 0);
    }

    public function _getItems(){
        if(!empty($this->pokeInfo['item_id'])){
            return true;
        }
        return false;
    }



    public function _isHp(){
        return ($this->pokeInfo['hp'] > 0);
    }



    public function _getData(){
        return $this->pokeInfo;
    }

}
