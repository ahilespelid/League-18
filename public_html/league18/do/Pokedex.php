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
if(isset($_POST['setTab']) && intval($_POST['setTab']) && !empty($_POST['setTab'])){
	$tab = (isset($_POST['setTab']) ? $_POST['setTab'] : 2);
	$pok = (isset($_POST['pok']) ? clearInt($_POST['pok']) : 1);
	$typeAtk = '';
	$response['lvlList'] = [];
	switch($tab){
		case 1:

		break;
		case 2:
			$typeAtk = 'lvl';
		break;
		case 3:
			$typeAtk = 'tm';
		break;
		case 4:
			$typeAtk = 'sex';
		break;
		case 5:
			$typeAtk = 'npc';
		break;
		default:
			$response['error'] = 1;
			$response['text'] = '{"error":1,"file":"Pokedex:33"}';
		break;
	}
  if($typeAtk == 'tm') {
    $atkQuery = $mysqli->query("SELECT * FROM `attac_poke_tm` WHERE `poke_base_id` = '".$pok."'");
  }else{
    $atkQuery = $mysqli->query("SELECT * FROM `base_attacks_pokemons` WHERE `pok` = '".$pok."' AND `type` = '".$typeAtk."'")->fetch_assoc();
  }
  if($typeAtk == 'lvl') {
    $atkLvl = explode(',',$atkQuery['lvl']);
  	$atkList = explode(',',$atkQuery['attacks']);
    for($i=0;$i<count($atkLvl);$i++){
  		$info = Work::$sql->query('SELECT
  										`id`,
                                          `name_rus`,
                                          `title`,
                                          `type`,
                                          `category`,
                                          `priority`,
                                          `power`,
                                          `accuracy`,
                                          `pp`
                                      FROM `base_atk`
  									WHERE `id` = '.$atkList[$i]
                                  )->fetch_assoc();
  		$response['lvlList'][$i] = $atkLvl[$i];
  		$response['atkList'][$i] = $info;
  	}
  }elseif($typeAtk == 'tm'){
      while($atk = $atkQuery->fetch_assoc()) {
        $tm_id = $mysqli->query("SELECT `info`, `tm_id` FROM `base_items` WHERE `tm_id` = '".$atk['tm_id']."'")->fetch_assoc();
        if($tm_id['tm_id'] >= '1000') {
          if($tm_id['tm_id'] == 1100) {
            $q = '100';
          }else{
            $q = mb_substr($tm_id['tm_id'], 3);
          }
          $tm_id['tm_id'] = 'HM '.$q;
        }else{
          $tm_id['tm_id'] = 'TM '.$tm_id['tm_id'];
        }
        $at = $mysqli->query("SELECT * FROM `base_atk` WHERE `id` = '".$tm_id ['info']."'")->fetch_assoc();
        $a .= '<div class="Move"><img src="/img/world/typs/'.$at['type'].'.png" onclick=viewDescriptionAttak(this,'.$at['id'].');> <div class="MoveInfo"><div class="Name MoveCategory'.$at['category'].'">'.$at['name_rus'].'</div><div class="PP">'.$tm_id['tm_id'].'</div></div></div>';
      }
      $response['t'] = 'tm';
      $response['tt'] = $a;
  }else{
    $atkLvl = explode(',',$atkQuery['lvl']);
  	$atkList = explode(',',$atkQuery['attacks']);
    for($i = 0; $i < count($atkList); $i++){
  		$info = Work::$sql->query('SELECT
  										`id`,
                                          `name_rus`,
                                          `title`,
                                          `type`,
                                          `category`,
                                          `priority`,
                                          `power`,
                                          `accuracy`,
                                          `pp`
                                      FROM `base_atk`
  									WHERE `id` = '.$atkList[$i]
                                  )->fetch_assoc();
  		$response['lvlList'][$i] = $atkList[$i];
  		$response['atkList'][$i] = $info;
  	}
  }
	die(json_encode($response));
}
if(isset($_POST['dex'])){
	$dex = $mysqli->real_escape_string($_POST['dex']);
	$dex = clearStr($dex);
	if(is_numeric($dex)){
		$pokemon = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `id` LIKE '%".$dex."%'")->fetch_assoc();
	}elseif(is_string($dex)){
		$pokemon = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `name_rus` LIKE '%".$dex."%'")->fetch_assoc();
	}else{
		exit();
	}
	$pokemonTypeN = $mysqli->query("SELECT `id` FROM `user_pokemons` WHERE `basenum` = ".$pokemon['id'])->num_rows;
	$pokemonTypeS = $mysqli->query("SELECT `id` FROM `user_pokemons` WHERE `type` = 'shine' AND `basenum` = ".$pokemon['id']." OR `type` = 'shadow' AND `basenum` = ".$pokemon['id']." OR `type` = 'snowy' AND `basenum` = ".$pokemon['id']."")->num_rows;
	$evolutions .= $pokemon['nextEvolution'];

	$numb = numbPok($pokemon['id']);
	$return = array(
	 'id'=>$pokemon['id'],
	 'typeNormal'=>$pokemonTypeN,
	 'typeUnik'=>$pokemonTypeS,
	 'name'=>$pokemon['name_rus'],
	 'numb'=>$numb,
	 'height'=>$pokemon['height'],
	 'weight'=>$pokemon['weight'],
	 'm'=>$pokemon['sex_m'],
	 'd'=>$pokemon['sex_f'],
	 'go'=>$pokemon['exp_group'],
	 'pwr'=>$pokemon['power_category'],
	 'hp'=>$pokemon['hp'],
	 'atk'=>$pokemon['atk'],
	 'def'=>$pokemon['def'],
	 'sp'=>$pokemon['spd'],
	 'sa'=>$pokemon['satk'],
	 'sd'=>$pokemon['sdef'],
	 'info'=>$pokemon['about'],
	 'typeOne'=>$pokemon['type'],
	 'typeTwo'=>$pokemon['type_two'],
	 'evolutions'=>$evolutions
	 );
	echo json_encode($return);
}
