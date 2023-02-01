<?
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
    }
}
if(isset($_POST['search']) && !empty($_POST['search'])){
	$search = $mysqli->real_escape_string($_POST['search']);
	$search = clearStr($search);
	if(is_numeric($search)){
		$PokemonQuery = $mysqli->query("SELECT
											`us`.*,
											`bp`.`name_rus`
										FROM `user_pokemons` AS `us`
										INNER JOIN `base_pokemons` AS `bp`
										ON `bp`.`id` = `us`.`basenum`
										WHERE
											`us`.`basenum` LIKE '%".$search."%'
										AND
											`us`.`user_id` = '".$_SESSION['id']."'
										AND
											`us`.`active` = 0");

	}elseif(is_string($search)){
    if($search == 'shine' || $search == 'Shine' || $search == 'шайни' || $search == 'Шайни') {
      $PokemonQuery = $mysqli->query("SELECT
  											`us`.*,
  											`bp`.`name_rus`
  										FROM `user_pokemons` AS `us`
  										INNER JOIN `base_pokemons` AS `bp`
  										ON `bp`.`id` = `us`.`basenum`
  										WHERE
  											`us`.`user_id` = '".$_SESSION['id']."'
                      AND
                      `us`.`type` = 'shine'
  										AND
  											`us`.`active` = 0");
    }elseif($search == 'шедоу' || $search == 'Шедоу' || $search == 'shadow' || $search == 'Shadow'){
      $PokemonQuery = $mysqli->query("SELECT
  											`us`.*,
  											`bp`.`name_rus`
  										FROM `user_pokemons` AS `us`
  										INNER JOIN `base_pokemons` AS `bp`
  										ON `bp`.`id` = `us`.`basenum`
  										WHERE
  											`us`.`user_id` = '".$_SESSION['id']."'
                      AND
                      `us`.`type` = 'shadow'
  										AND
  											`us`.`active` = 0");
    }elseif($search == 'уники' || $search == 'Уники' || $search == 'unik' || $search == 'Unik'){
      $PokemonQuery = $mysqli->query("SELECT
  											`us`.*,
  											`bp`.`name_rus`
  										FROM `user_pokemons` AS `us`
  										INNER JOIN `base_pokemons` AS `bp`
  										ON `bp`.`id` = `us`.`basenum`
  										WHERE
  											`us`.`user_id` = '".$_SESSION['id']."'
                      AND
                      `us`.`type` != 'normal'
  										AND
  											`us`.`active` = 0");
    }elseif($search[0] == '%') {
      if($search[1] == 's') {
        if($search[2] == 1 || $search[2] == 2 || $search[2] == 3) {
          if(isset($search[3])) {
            $pkm = substr($search, 4);
            $PokemonQuery = $mysqli->query("SELECT
        											`us`.*,
        											`bp`.`name_rus`
        										FROM `user_pokemons` AS `us`
        										INNER JOIN `base_pokemons` AS `bp`
        										ON `bp`.`id` = `us`.`basenum`
        										WHERE
        											`us`.`basenum` LIKE '%".$pkm."%'
        										AND
        											`us`.`user_id` = '".$_SESSION['id']."'
                              AND
                              `us`.`sparkaNumber` = '".$search[2]."'
        										AND
        											`us`.`active` = 0");
          }else{
            $PokemonQuery = $mysqli->query("SELECT
        											`us`.*,
        											`bp`.`name_rus`
        										FROM `user_pokemons` AS `us`
        										INNER JOIN `base_pokemons` AS `bp`
        										ON `bp`.`id` = `us`.`basenum`
        										WHERE
                            `us`.`user_id` = '".$_SESSION['id']."'
                            AND
                            `us`.`sparkaNumber` = '".$search[2]."'
                            AND
        											`us`.`active` = 0");
          }
        }
      }
    }else{
      $PokemonQuery = $mysqli->query("SELECT
  											`us`.*,
  											`bp`.`name_rus`
  										FROM `user_pokemons` AS `us`
  										INNER JOIN `base_pokemons` AS `bp`
  										ON `bp`.`id` = `us`.`basenum`
  										WHERE
  											`us`.`name_new` LIKE '%".$search."%'
  										AND
  											`us`.`user_id` = '".$_SESSION['id']."'
  										AND
  											`us`.`active` = 0");
    }
	}else{
		$response['error'] = 1;
	}
	if($PokemonQuery->num_rows < 1){
		$response['error'] = 1;
	}else{
		$pokList = [];
		while ($pokemons = $PokemonQuery->fetch_assoc()){
			$pokList[$pokemons['id']] = [
								'basenum'=>numbPok($pokemons['basenum']),
								'type'=>$pokemons['type'],
								'name'=>($pokemons['name_new']?$pokemons['name_new']:$pokemons['name_rus']),
								'lvl'=>$pokemons['lvl'],
								'gender'=>$pokemons['gender'],
								'sparka'=>$pokemons['sparka'],
								'sparkaNumber'=>$pokemons['sparkaNumber'],
								'gen'=>$pokemons['gen'],
								'character'=>haracter_pokes($pokemons['character'])
							];
		}
	}
	$response['pokList'] = $pokList;
	die(json_encode($response));
}
	$nursery = $mysqli->query('SELECT
									`us`.`basenum`,
									`us`.`type`,
									`bp`.`name_rus`,
									COUNT(`us`.`basenum`) AS `count`

									FROM `user_pokemons` AS `us`
									INNER JOIN `base_pokemons` AS `bp`
									ON `bp`.`id` = `us`.`basenum`

									WHERE

									`us`.`user_id` = '.$_SESSION['id'].' AND
									`us`.`active`= 0

									GROUP BY `us`.`basenum`');
	$pokemons = '';
	if($nursery->num_rows > 0){
		while($n = $nursery->fetch_assoc()){
			$getBasenum = $n['basenum'];
			$basenum = numbPok($getBasenum);
			$pokemons.='
      <div onclick=nursery("open",'.$getBasenum.')><img src="/img/pokemons/mini/'.$n['type'].'/'.$basenum.'.png"> <span>#'.$basenum.' '.$n['name_rus'].'</span> <div>'.$n['count'].' шт.</div></div>';
		}
	}else{
		$pokemons.= "<center><p class='GrayError'>Ваш питомник пуст</p></center>";
	}

	$response['html'] = $pokemons;
	$response['title'] = 'Питомник';
?>
