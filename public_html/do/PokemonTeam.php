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
switch($_POST["type"]){
	case "load":
		$pokList = [];
		$pokemons = $mysqli->query('SELECT * FROM `user_pokemons` WHERE `user_id` = "'.(int)$_SESSION['id'].'" AND `active` = 1');
		$user = $mysqli->query('SELECT sprite FROM users WHERE id = '.(int)$_SESSION['id'])->fetch_assoc();
		while($pokemon = $pokemons->fetch_assoc()){
      stat_updates($pokemon['id']);
			switch((int)$pokemon['tren_stat']){
				case 1:
					$trenStat = 2;
					break;
				case 2:
					$trenStat = 3;
					break;
				case 3:
					$trenStat = 4;
					break;
				case 4:
					$trenStat = 5;
					break;
				default:
					$trenStat = 6;
			}
			$stats = explode(',',$pokemon['stats']);
			$gen = explode(',',$pokemon['gen']);
      if($pokemon['type'] == 'shine'){
        $textUnik = '<div class="Unik shine-color">shine</div>';
				$typeSprite = 'shine';
			}elseif($pokemon['type'] == 'shadow'){
        $textUnik = '<div class="Unik shadow-color">shadow</div>';
        $typeSprite = 'shadow';
      }else{
        $typeSprite = 'normal';
        $textUnik = '';
      }
			if((int)$user['sprite'] == 0){
				$sprite = '<img class="Image" onclick="Game.pokemonTeamTabs('.$pokemon['id'].',\'info\')" src="/img/pokemons/mini/'.$pokemon['type'].'/'.numbPok($pokemon['basenum']).'.png">';
			}else if((int)$user['sprite'] == 1){
				$sprite = '<img class="Image" onclick="Game.pokemonTeamTabs('.$pokemon['id'].',\'info\')" src="/img/pokemons/3d/'.$pokemon['type'].'/'.numbPok($pokemon['basenum']).'.gif">';
			}
			$fullBasenum = numbPok($pokemon['basenum']);
			$type = $pokemon['type'] != 'normal' ? '<i>'.$pokemon['type'].'</i>' : '';
			$exp = (int)$pokemon['lvl'] != 100 ? $pokemon['exp'].' / '.$pokemon['exp_max'] : 'полное';
			$paired = $pokemon['sparka'] == 1 ? 'spar' : '';
			if($pokemon['gender'] == 'Девочка') {
        $gender = 'venus';
      }elseif($pokemon['gender'] == 'Мальчик') {
        $gender = 'mars';
      }else{
        $gender = 'genderless';
      }
			$gen = 'h'.$gen[0].'a'.$gen[1].'d'.$gen[2].'s'.$gen[3].'sa'.$gen[4].'sd'.$gen[5];
      if(!empty($pokemon['item_str'])) {
        $str = explode(',',$pokemon['item_str']);
        $str = $str[0].'/'.$str[1];
      }else{
        $str = '';
      }
			$item = $pokemon['item_id'] != 0 ? '<div style="background-image: url(/img/world/items/little/'.$pokemon['item_id'].'.png);" class="Item" onclick=itemAction('.$pokemon['item_id'].',\'remove\',false,false,'.$pokemon['id'].');' .'><div class="str">'.$str.'</div></div>' : '';
      $tren = $pokemon['tren'] != 0 ? '<div class="Tren" id="TrenPokemon'. $pokemon['id'] .'" style="background-image: url(/img/tren/'.$pokemon['tren'].'.png);"></div>' : '';
      $fHp = (($pokemon['hp'] / $stats[0]) * 100);
      if((int)$pokemon['lvl'] == 100) {
        $fExp = 100;
      }else{
        $fExp = ((mb_strimwidth($pokemon['exp'], 0, 5, "..") / mb_strimwidth($pokemon['exp_max'], 0, 5, "..")) * 100);
      }
      $fHappy = (($pokemon['happy'] / 255) * 100);
      $html = ' <div class="Modif" style="background-image: url(/img/tren/'.$pokemon['tren'].'.png);"></div>'.$sprite.' <div class="Ball" onclick="pokAction(this,'.$pokemon['id'].','.$pokemon['start_pok'].',false,'.$pokemon['basenum'].')" style="background-image: url(/img/world/items/little/'.$pokemon['ball'].'.png);"></div>
      <div class="Lvl">'.$pokemon['lvl'].'</div>
      '.$item.'
      '.($pokemon['type'] == 'normal' ? '' : '<div class="Unik '.$pokemon['type'].'-color">'.$pokemon['type'].'</div>').'
      <div class="Name '.$pokemon['type'].'-color">
					<div class="Text">
						#'.$fullBasenum.' '. mb_strimwidth($pokemon['name_new'], 0, 22, '...') .'
					</div>
					<div class="Sex '.$paired.'"><i class="fas fa-'.$gender.'"></i></div>
				</div>
        <div class="Bars">
        					<div class="Bar">
        						<div class="Text">'.$pokemon['hp'].' / '.$stats[0].'</div>
        						<div class="HpBar" style="width: '.$fHp.'%;"></div>
        					</div>
        					<div class="Bar">
        						<div class="Text">'. $exp .'</div>
        						<div class="ExpBar" style="width: '.$fExp.'%;"></div>
        					</div>
        					<div class="Bar">
        						<div class="Text">'.$pokemon['happy'].' / 255</div>
        						<div class="HappyBar" style="width: '.$fHappy.'%;"></div>
        					</div>
        				</div>
				';
			$pokList[$pokemon['id']] = [
											'id'			=> $pokemon['id'],
											'start'			=> $pokemon['start_pok'] == 1 ? "Start-Pokemon-Box" : "",
											'hp'			=> $pokemon['hp'],
											'maxHP'			=> $stats[0],
											'exp'			=> $pokemon['exp'],
											'expMax'		=> $pokemon['exp_max'],
											'happy'			=> $pokemon['happy'],
											'trenColor'		=> $pokemon['tren'],
											'trenStat'		=> $trenStat,
											'html'			=> $html
										];
		}
		echo json_encode($pokList);
	break;
	case "info":
		$pokemon = $mysqli->query('SELECT * FROM `user_pokemons` WHERE `user_id` = "'.$_SESSION['id'].'" AND `active` = 1 AND id = '.$_POST['other'])->fetch_assoc();
    $pokemon2 = $mysqli->query('SELECT * FROM `lombard` WHERE `category` = "pok" AND `productID` = '.$_POST['other'])->fetch_assoc();
    if($pokemon || isset($pokemon2)){
      if(isset($pokemon2)) {
        $pokemon = $mysqli->query('SELECT * FROM `user_pokemons` WHERE id = '.$pokemon2['productID'])->fetch_assoc();
      }
			stat_updates($pokemon['id']);
      $stats = explode(',',$pokemon['stats']);
			$gen = explode(',',$pokemon['gen']);
      if($pokemon['type'] == 'shine'){
        $textUnik = '<div class="Unik shine-color">shine</div>';
				$typeSprite = 'shine';
			}elseif($pokemon['type'] == 'shadow'){
        $textUnik = '<div class="Unik shadow-color">shadow</div>';
        $typeSprite = 'shadow';
      }else{
        $typeSprite = 'normal';
        $textUnik = '';
      }
			$sprite = '<img class="Image" onclick="Game.modals.pokemons()" src="/img/pokemons/mini/'.$pokemon['type'].'/'.numbPok($pokemon['basenum']).'.png">';
			$fullBasenum = numbPok($pokemon['basenum']);
			$type = $pokemon['type'] != 'normal' ? '<i>'.$pokemon['type'].'</i>' : '';
			$exp = (int)$pokemon['lvl'] != 100 ? $pokemon['exp'].' / '.$pokemon['exp_max'] : 'полное';
			$paired = $pokemon['sparka'] == 1 ? 'spar' : '';
      if($pokemon['gender'] == 'Девочка') {
        $gender = 'venus';
      }elseif($pokemon['gender'] == 'Мальчик') {
        $gender = 'mars';
      }else{
        $gender = 'genderless';
      }
			$gen = 'h'.$gen[0].'a'.$gen[1].'d'.$gen[2].'s'.$gen[3].'sa'.$gen[4].'sd'.$gen[5];
      $str = explode(',',$pokemon['item_str']);
      if(!empty($pokemon['item_str'])) {
        $str = explode(',',$pokemon['item_str']);
        $str = $str[0].'/'.$str[1];
      }else{
        $str = '';
      }
			$item = $pokemon['item_id'] != 0 ? '<div style="background-image: url(/img/world/items/little/'.$pokemon['item_id'].'.png);" class="Item" onclick=itemAction('.$pokemon['item_id'].',\'remove\',false,false,'.$pokemon['id'].');' .'><div class="str">'.$str.'</div></div>' : '';
			$tren = $pokemon['tren'] != 0 ? '<div class="Tren" id="TrenPokemon'. $pokemon['id'] .'" style="background-image: url(/img/tren/'.$pokemon['tren'].'.png);"></div>' : '';
      $fHp = (($pokemon['hp'] / $stats[0]) * 100);
      if((int)$pokemon['lvl'] == 100) {
        $fExp = 100;
      }else{
        $fExp = ((mb_strimwidth($pokemon['exp'], 0, 5, "..") / mb_strimwidth($pokemon['exp_max'], 0, 5, "..")) * 100);
      }
      $fHappy = (($pokemon['happy'] / 255) * 100);
			$birthdayJson = json_decode($pokemon['birthday']);
			$up = json_decode($pokemon['modification']);
      $attacks = explode(',',$pokemon['attacks']);
  		$attack_pp = explode(',',$pokemon['pp_attacks']);
  		if($attacks[0] > 0){
  			$atkQuery = $mysqli->query("SELECT * FROM `base_atk` WHERE `id` = '".$attacks[0]."'")->fetch_assoc();
  			$atkOne = $atkQuery['name_rus'];
  			$ppOne = $atkQuery['pp'];
  			$typeOne = $atkQuery['type'];
  			if($atkQuery['category'] === 'physical'){$category1 = 1;}
  			elseif($atkQuery['category'] === 'special'){$category1 = 2;}
  			else{$category1 = 3;}
  		}else{
  			$atkOne = 'Нет атаки';
  			$attacks[0] = 0;
  		}
  		if($attacks[1] > 0){
  			$atkQuery = $mysqli->query("SELECT * FROM `base_atk` WHERE `id` = '".$attacks[1]."'")->fetch_assoc();
  			$atkTwo = $atkQuery['name_rus'];
  			$ppTwo = $atkQuery['pp'];
  			$typeTwo = $atkQuery['type'];
  			if($atkQuery['category'] === 'physical'){$category2 = 1;}
  			elseif($atkQuery['category'] === 'special'){$category2 = 2;}
  			else{$category2 = 3;}
  		}else{
  			$atkTwo = 'Нет атаки';
  			$attacks[1] = 0;
  		}
  		if($attacks[2] > 0){
  			$atkQuery = $mysqli->query("SELECT * FROM `base_atk` WHERE `id` = '".$attacks[2]."'")->fetch_assoc();
  			$atkThree = $atkQuery['name_rus'];
  			$ppThree = $atkQuery['pp'];
  			$typeThree = $atkQuery['type'];
  			if($atkQuery['category'] === 'physical'){$category3 = 1;}
  			elseif($atkQuery['category'] === 'special'){$category3 = 2;}
  			else{$category3 = 3;}
  		}else{
  			$atkThree = 'Нет атаки';
  			$attacks[2] = 0;
  		}
  		if($attacks[3] > 0){
  			$atkQuery = $mysqli->query("SELECT * FROM `base_atk` WHERE `id` = '".$attacks[3]."'")->fetch_assoc();
  			$atkFour = $atkQuery['name_rus'];
  			$ppFour = $atkQuery['pp'];
  			$typeFour = $atkQuery['type'];
  			if($atkQuery['category'] === 'physical'){$category4 = 1;}
  			elseif($atkQuery['category'] === 'special'){$category4 = 2;}
  			else{$category4 = 3;}
  		}else{
  			$atkFour = 'Нет атаки';
  			$attacks[3] = 0;
  		}
      if($pokemon['trade'] == 'false') {
        $trd = 'tradeNo';
      }else{
        $trd = 'tradeYes';
      }
      if($pokemon['sparka'] == 1) {
        $spr = 'Недоступно';
      }else{
        $spr = 'Доступно';
      }
      if($up->genUp == 1 && $up->charEdit == 1) {
        $led = 'Горький и Кислый';
      }elseif($up->genUp == 1 && $up->charEdit == 0){
        $led = 'Горький';
      }elseif($up->genUp == 0 && $up->charEdit == 1){
        $led = 'Кислый';
      }else{
        $led = 'Не использовано';
      }
      if($pokemon['tren_stat'] == 1) {
        $tr = 'в Атаку';
      }elseif($pokemon['tren_stat'] == 2) {
        $tr = 'в Защиту';
      }elseif($pokemon['tren_stat'] == 3) {
        $tr = 'в Скорость';
      }elseif($pokemon['tren_stat'] == 4) {
        $tr = 'в Спец. Атаку';
      }elseif($pokemon['tren_stat'] == 5) {
        $tr = 'в Спец. Защиту';
      }else{
        $tr = '';
      }
      if($pokemon['tren'] == 1) {
        $tr_n = 'Начальная, ';
      }elseif($pokemon['tren'] == 2) {
        $tr_n = 'Морская, ';
      }elseif($pokemon['tren'] == 3) {
        $tr_n = 'Жемчужная, ';
      }elseif($pokemon['tren'] == 4) {
        $tr_n = 'Престижная, ';
      }elseif($pokemon['tren'] == 5) {
        $tr_n = 'Величайшая, ';
      }elseif($pokemon['tren'] == 6) {
        $tr_n = 'Легендарная, ';
      }elseif($pokemon['tren'] == 7) {
        $tr_n = 'Королевская, ';
      }else{
        $tr_n = 'Отсутствует';
      }
      $evcounts = explode(',',$pokemon['evcounts']);
      $userPokemon = $mysqli->query("SELECT `id`,`login`,`user_group`,`sex` FROM `users` WHERE `id` = '".$birthdayJson->user_id."'")->fetch_assoc();
      $html = '
      <div class="Info">
				<div class="Left">
					<div class="PokemonBox">
            <div class="Modif" style="background-image: url(/img/tren/'.$pokemon['tren'].'.png);"></div>
						'.$sprite.' <div class="Ball" onclick="pokAction(this,'.$pokemon['id'].','.$pokemon['start_pok'].',false,'.$pokemon['basenum'].')" style="background-image: url(/img/world/items/little/'.$pokemon['ball'].'.png);"></div>
						<div class="Lvl">'.$pokemon['lvl'].'</div>

            '.$item.'
            '.($pokemon['type'] == 'normal' ? '' : '<div class="Unik '.$pokemon['type'].'-color">'.$pokemon['type'].'</div>').'
            <div class="Name '.$pokemon['type'].'-color">
      					<div class="Text">
      						#'.$fullBasenum.' '. mb_strimwidth($pokemon['name_new'], 0, 22, '...') .'
      					</div>
      					<div class="Sex '.$paired.'"><i class="fas fa-'.$gender.'"></i></div>
      				</div>
              <div class="Bars">
              					<div class="Bar">
              						<div class="Text">'.$pokemon['hp'].' / '.$stats[0].'</div>
              						<div class="HpBar" style="width: '.$fHp.'%;"></div>
              					</div>
              					<div class="Bar">
              						<div class="Text">'. $exp .'</div>
              						<div class="ExpBar" style="width: '.$fExp.'%;"></div>
              					</div>
              					<div class="Bar">
              						<div class="Text">'.$pokemon['happy'].' / 255</div>
              						<div class="HappyBar" style="width: '.$fHappy.'%;"></div>
              					</div>
              				</div>
          </div>
					<div class="MoveBox">
            <div class="Move">
              <img src="/img/world/typs/'.($typeOne?$typeOne:'empty').'.png" onclick="viewDescriptionAttak(this,'.$attacks[0].','.$pokemon['id'].',0);">
              <div class="MoveInfo">
                <div class="Name MoveCategory'.$category1.'">'.$atkOne.'</div>
                <div class="PP">'.$attack_pp[0].'/'.($ppOne?$ppOne:0).' PP</div>
              </div>
            </div>
            <div class="Move">
              <img src="/img/world/typs/'.($typeTwo?$typeTwo:'empty').'.png" onclick="viewDescriptionAttak(this,'.$attacks[1].','.$pokemon['id'].',1);">
              <div class="MoveInfo">
                <div class="Name MoveCategory'.$category2.'">'.$atkTwo.'</div>
                <div class="PP">'.$attack_pp[1].'/'.($ppTwo?$ppTwo:0).' PP</div>
              </div>
            </div>
            <div class="Move">
              <img src="/img/world/typs/'.($typeThree?$typeThree:'empty').'.png" onclick="viewDescriptionAttak(this,'.$attacks[2].','.$pokemon['id'].',2);">
              <div class="MoveInfo">
                <div class="Name MoveCategory'.$category3.'">'.$atkThree.'</div>
                <div class="PP">'.$attack_pp[2].'/'.($ppThree?$ppThree:0).' PP</div>
              </div>
            </div>
            <div class="Move">
              <img src="/img/world/typs/'.($typeFour?$typeFour:'empty').'.png" onclick="viewDescriptionAttak(this,'.$attacks[3].','.$pokemon['id'].',3);">
              <div class="MoveInfo">
                <div class="Name MoveCategory'.$category4.'">'.$atkFour.'</div>
                <div class="PP">'.$attack_pp[3].'/'.($ppFour?$ppFour:0).' PP</div>
              </div>
            </div>
					</div>
				</div>
				<div class="Right">
					<div class="Id Id-'.$trd.'">id'.$pokemon['id'].'</div>
					<div class="Info">
						<div class="Step">
							Характер: <span>'.haracter_pokes($pokemon['character']).' <span class="char" onclick=issetAll(1,"char")><i class="fa fa-info"></i></span></span>
						</div>
            <div class="Step">
							Генокод: <span>'.$gen.'</span>, Витамины: <span>'.$pokemon['vitamines'].'/100</span>
						</div>
            <div class="Step">
							Классификация: <span>'.$tr_n.''.$tr.'</span>
						</div>
						<div class="Step">
							Разведение: <span>'.$spr.'</span>, Группа привлекательности: <span>'.$pokemon['sparkaNumber'].'</span>
						</div>
						<div class="Step">
							Заколдованные леденцы: <span>'.$led.'</span>
						</div>
						<div class="Step">
							Пойман: <span>'.date('d.m.Y',$birthdayJson->date).'г. тренером <div class="user-link"><div onclick=showUserTooltip("'.$userPokemon['id'].'") class="Info-Link sex'.$userPokemon['sex'].'"><i class="fas fa-info"></i></div> <div class="u-'.$userPokemon['user_group'].'">'.$userPokemon['login'].'</div></div></span>
						</div>
						<div class="Step">
							Способность: <span>в разработке</span>
						</div>
					</div>
					<div class="MainInfo">
						<div class="Stats">
							<div class="Stat">
								<div class="Name">Здоровье</div>
								<div class="Count">'.$stats[0].'</div>
								<div class="Progress">
									<div class="Text">'.$evcounts[0].' / 126 EV</div>
									<div class="Bar" style="width: '.(($evcounts[0] / 126) * 100).'%;"></div>
								</div>
								<div class="GoEv">
									<div onclick=addEV("open",0,this,false,'.$pokemon['id'].'); class="Plus"><i class="fa fa-plus"></i></div>
								</div>
							</div>
							<div class="Stat">
								<div class="Name">Атака</div>
								<div class="Count">'.$stats[1].'</div>
								<div class="Progress">
									<div class="Text">'.$evcounts[1].' / 126 EV</div>
									<div class="Bar" style="width: '.(($evcounts[1] / 126) * 100).'%;"></div>
								</div>
								<div class="GoEv">
									<div onclick=addEV("open",1,this,false,'.$pokemon['id'].'); class="Plus"><i class="fa fa-plus"></i></div>
								</div>
							</div>
							<div class="Stat">
								<div class="Name">Защита</div>
								<div class="Count">'.$stats[2].'</div>
								<div class="Progress">
									<div class="Text">'.$evcounts[2].' / 126 EV</div>
									<div class="Bar" style="width: '.(($evcounts[2] / 126) * 100).'%;"></div>
								</div>
								<div class="GoEv">
									<div onclick=addEV("open",2,this,false,'.$pokemon['id'].'); class="Plus"><i class="fa fa-plus"></i></div>
								</div>
							</div>
							<div class="Stat">
								<div class="Name">Скорость</div>
								<div class="Count">'.$stats[3].'</div>
								<div class="Progress">
									<div class="Text">'.$evcounts[3].' / 126 EV</div>
									<div class="Bar" style="width: '.(($evcounts[3] / 126) * 100).'%;"></div>
								</div>
								<div class="GoEv">
									<div onclick=addEV("open",3,this,false,'.$pokemon['id'].'); class="Plus"><i class="fa fa-plus"></i></div>
								</div>
							</div>
							<div class="Stat">
								<div class="Name">Спец. Атака</div>
								<div class="Count">'.$stats[4].'</div>
								<div class="Progress">
									<div class="Text">'.$evcounts[4].' / 126 EV</div>
									<div class="Bar" style="width: '.(($evcounts[4] / 126) * 100).'%;"></div>
								</div>
								<div class="GoEv">
									<div onclick=addEV("open",4,this,false,'.$pokemon['id'].'); class="Plus"><i class="fa fa-plus"></i></div>
								</div>
							</div>
							<div class="Stat">
								<div class="Name">Спец. Защита</div>
								<div class="Count">'.$stats[5].'</div>
								<div class="Progress">
									<div class="Text">'.$evcounts[5].' / 126 EV</div>
									<div class="Bar" style="width: '.(($evcounts[5] / 126) * 100).'%;"></div>
								</div>
								<div class="GoEv">
									<div onclick=addEV("open",5,this,false,'.$pokemon['id'].'); class="Plus"><i class="fa fa-plus"></i></div>
								</div>
							</div>
						</div>
						<div class="CountEv">Свободных EV: <span>'.$pokemon['ev'].'</span></div>
					</div>
				</div>
			</div>
      ';
      $pokList = array(
        'html' => $html,
				'bDay'=>date("d", $birthdayJson->date),
				'bMounth'=>date("m", $birthdayJson->date),
				'bYear'=>date("o", $birthdayJson->date),
				'bTrener'=>'<div class="user-link u-'.$userPokemon['user_group'].'">'.$userPokemon['login'].'</div>',
				'genUp'=>$up->genUp,
				'harUp'=>$up->charEdit,
				'sexGroup'=>$pokemon['sparkaNumber'],
				'trade'=>$pokemon['trade']
			);
		}
		die(json_encode($pokList));
	break;
	case "stats":
		$pokemon = $mysqli->query('SELECT * FROM `user_pokemons` WHERE `user_id` = "'.$_SESSION['id'].'" AND `active` = 1 AND id = '.$_POST['other'])->fetch_assoc();
		if($pokemon){
			$stats = explode(',',$pokemon['stats']);
            $evcounts = explode(',',$pokemon['evcounts']);
			stat_updates($pokemon['id']);
			$pokList = array(
				'ev'=>$pokemon['ev'],
				'evHp'=>$evcounts[0],
				'evAtk'=>$evcounts[1],
				'evDef'=>$evcounts[2],
				'evSpd'=>$evcounts[3],
				'evSa'=>$evcounts[4],
				'evSd'=>$evcounts[5],
				'statHp'=>$stats[0],
				'statAtk'=>$stats[1],
				'statDef'=>$stats[2],
				'statSpd'=>$stats[3],
				'statSa'=>$stats[4],
				'statSd'=>$stats[5]
			);
		}
		die(json_encode($pokList));
	break;
}
