<?php
	$patch_project = $_SERVER['DOCUMENT_ROOT'];
	$patch_global = $patch_project.'/inc/conf/global.php';
	require_once($patch_global);
  $LogBattle = Work::$sql->query('SELECT * FROM battle_log WHERE battle = '.$_POST['id'].' ORDER BY id DESC');
  $Battle = Work::$sql->query('SELECT * FROM battle WHERE id = '.$_POST['id'].'')->fetch_assoc();
  $Battle1 = Info::_unParseData($Battle['info_1']);
  $Battle2 = Info::_unParseData($Battle['info_2']);
  $UserQueryMy = $mysqli->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
  $UserQueryEn = $mysqli->query('SELECT * FROM users WHERE id = '.$Battle1['userInfo']['id'])->fetch_assoc();
	$BattleEnd = Work::$sql->query('SELECT * FROM battle_end WHERE battle = '.$_POST['id'].'')->fetch_assoc();
  if($BattleEnd) {
    $UserQuery = $mysqli->query('SELECT * FROM users WHERE id = '.$BattleEnd['win'])->fetch_assoc();
    $btle = '<div class="endFight">Бой окончен! Победа за '.$UserQuery['login'].'!</div>';
  }else{
    $btle = '';
  }
	//$UserQuery = $mysqli->query('SELECT * FROM users WHERE id = '.$BattleEnd['win'])->fetch_assoc();
	//if($BattleEnd) {
	//	$btle = '<div class="endFight">Бой окончен! Победа за '.$UserQuery['login'].'!</div>';
	//}else{
	//	$btle = '';
	//}
  if(isset($Battle1['pokeLIst'])){
      $list1 =& $Battle1['pokeLIst'];
  }
  if(isset($Battle2['pokeLIst'])){
      $list2 =& $Battle2['pokeLIst'];
  }
  if($list1 && is_array($list1) && $list2 && is_array($list2)){

      if(isset($list2['p'.$Battle2['target']])){
          $target2 = $list2['p'.$Battle2['target']];
      }else{
          $target2 = [];
      }

      if(isset($list1['p'.$Battle1['target']])){
          $target1 = $list1['p'.$Battle1['target']];
      }else{
          $target1 = [];
      }
  }
  $LogBattleSel = '';
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
  if($target1['basenum'] >= 1 && $target1['basenum'] <= 9) {
    $basenum1 = '00'.$target1['basenum'];
  }elseif($target1['basenum'] >= 10 && $target1['basenum'] <= 99){
    $basenum1 = '0'.$target1['basenum'];
  }else{
    $basenum1 = $target1['basenum'];
  }
  if($target2['basenum'] >= 1 && $target2['basenum'] <= 9) {
    $basenum2 = '00'.$target2['basenum'];
  }elseif($target2['basenum'] >= 10 && $target2['basenum'] <= 99){
    $basenum2 = '0'.$target2['basenum'];
  }else{
    $basenum2 = $target2['basenum'];
  }
  if($target1['gender'] == 'Мальчик') {
    $sex1 = 'mars';
  }elseif($target1['gender'] == 'Девочка') {
    $sex1 = 'venus';
  }else{
    $sex1 = 'genderless';
  }
  if($target2['gender'] == 'Мальчик') {
    $sex2 = 'mars';
  }elseif($target2['gender'] == 'Девочка') {
    $sex2 = 'venus';
  }else{
    $sex2 = 'genderless';
  }
  if($target1['type'] != 'normal') {
    $nameS1 = $target1['type'];
  }else{
    $nameS1 = '';
  }
  if($target2['type'] != 'normal') {
    $nameS2 = $target2['type'];
  }else{
    $nameS2 = '';
  }
  foreach($Battle1['pokeLIst'] as $abc1){
    if(isset($abc1)){
      if($abc1['hp'] <= 0){
        $noneHp1 = 'noHp';
      }else{
        $noneHp1 = '';
      }
      $BallsPoke2 .= '<div class="Ball '.$noneHp1.'" style="background-image: url(/img/world/items/little/'.$abc1['ball'].'.png);"></div>';
    }
  }
  foreach($Battle2['pokeLIst'] as $abc2){
    if(isset($abc2)){
      if($abc2['hp'] <= 0){
        $noneHp2 = 'noHp';
      }else{
        $noneHp2 = '';
      }
      $BallsPoke1 .= '<div class="Ball '.$noneHp2.'" style="background-image: url(/img/world/items/little/'.$abc2['ball'].'.png);"></div>';
    }
  }
  foreach($target1['status_list'] as $slist1){
    if($slist1['type'] == 'burn') {
      $names = 'Подожжен';
    }elseif($slist1['type'] == 'toxic'){
      $names = 'Отравлен';
    }elseif($slist1['type'] == 'nightmare'){
      $names = 'Кошмары';
    }elseif($slist1['type'] == 'toxic2'){
      $names = 'Сильно отравлен';
    }elseif($slist1['type'] == 'flinch'){
      $names = 'Напуган';
    }elseif($slist1['type'] == 'paralyzed'){
      $names = 'Парализован';
    }elseif($slist1['type'] == 'sleep'){
      $names = 'Спит';
    }elseif($slist1['type'] == 'frost'){
      $names = 'Заморожен';
    }elseif($slist1['type'] == 'lover'){
      $names = 'Влюблен';
    }elseif($slist1['type'] == 'curse'){
      $names = 'Проклят';
    }elseif($slist1['type'] == 'confused'){
      $names = 'Спутан';
    }elseif($slist1['type'] == 'rage'){
      $names = 'В бешенстве';
    }elseif($slist1['type'] == 'taunt'){
      $names = 'Насмешка';
    }elseif($slist1['type'] == 'aquaRing'){
      $names = 'Водяной щит';
    }elseif($slist1['type'] == 'stock'){
      $names = 'Накопление';
    }else{
      $names = '...';
    }
    $lists1 .= '<div class="Status Status'.$slist1['type'].'">'.$names.'</div>';
  }
  foreach($target2['status_list'] as $slist2){
    if($slist2['type'] == 'burn') {
      $names = 'Подожжен';
    }elseif($slist2['type'] == 'toxic'){
      $names = 'Сильно отравлен';
    }elseif($slist2['type'] == 'nightmare'){
      $names = 'Кошмары';
    }elseif($slist2['type'] == 'flinch'){
      $names = 'Напуган';
    }elseif($slist2['type'] == 'paralyzed'){
      $names = 'Парализован';
    }elseif($slist2['type'] == 'sleep'){
      $names = 'Спит';
    }elseif($slist2['type'] == 'frost'){
      $names = 'Заморожен';
    }elseif($slist2['type'] == 'lover'){
      $names = 'Влюблен';
    }elseif($slist2['type'] == 'curse'){
      $names = 'Проклят';
    }elseif($slist2['type'] == 'confused'){
      $names = 'Спутан';
    }elseif($slist2['type'] == 'rage'){
      $names = 'В бешенстве';
    }elseif($slist2['type'] == 'taunt'){
      $names = 'Насмешка';
    }elseif($slist2['type'] == 'aquaRing'){
      $names = 'Водяной щит';
    }else{
      $names = '...';
    }
    $lists2 .= '<div class="Status Status'.$slist2['type'].'">'.$names.'</div>';
  }
  foreach($target1['modified'] as $key => $val){
    if($key == 'atk') {
      $names = 'Атака';
    }elseif($key == 'def'){
      $names = 'Защита';
    }elseif($key == 'spd'){
      $names = 'Скорость';
    }elseif($key == 'satk'){
      $names = 'Спец. Атака';
    }elseif($key == 'sdef'){
      $names = 'Спец. Защита';
    }elseif($key == 'acr'){
      $names = 'Точность';
    }elseif($key == 'agl'){
      $names = 'Ловкость';
    }else{
      $names = '...';
    }
    if($val['plus']) {
      $cnt = 'Plus';
    }elseif($val['minus']){
      $cnt = 'Minus';
    }else{
      $cnt = '';
    }
    if($val['plus']) {
      $listmod1 .= '<div class="Status Status'.$cnt.'"><div class="StatusNum plus">'.$names.' +'.$val['plus'].'</div></div>';
    }else{
      $listmod1 .= '<div class="Status Status'.$cnt.'"><div class="StatusNum minus">'.$names.' -'.$val['minus'].'</div></div>';
    }
  }
  foreach($target2['modified'] as $key => $val){
    if($key == 'atk') {
      $names = 'Атака';
    }elseif($key == 'def'){
      $names = 'Защита';
    }elseif($key == 'spd'){
      $names = 'Скорость';
    }elseif($key == 'satk'){
      $names = 'Спец. Атака';
    }elseif($key == 'sdef'){
      $names = 'Спец. Защита';
    }elseif($key == 'acr'){
      $names = 'Точность';
    }elseif($key == 'agl'){
      $names = 'Ловкость';
    }else{
      $names = '...';
    }
    if($val['plus']) {
      $cnt = 'Plus';
    }elseif($val['minus']){
      $cnt = 'Minus';
    }else{
      $cnt = '';
    }
    if($val['plus']) {
      $listmod2 .= '<div class="Status Status'.$cnt.'"><div class="StatusNum plus">'.$names.' +'.$val['plus'].'</div></div>';
    }else{
      $listmod2 .= '<div class="Status Status'.$cnt.'"><div class="StatusNum minus">'.$names.' -'.$val['minus'].'</div></div>';
    }
  }
  if($UserQueryMy['location'] == $UserQueryEn['location']) {
  $html = '
  <div class="Battle" style="display: flex;">
  <div class="PokemonA">
  <div class="PokemonBox2">
	<div class="Modif" style="background-image: url('.$target1['tren'].'.png);"></div>
  <img class="imgPok Image" src="/img/pokemons/mini/'.$target1['type'].'/'.$basenum1.'.png">
  <div class="namePokemon Name __name '.$target1['type'].'-color">
  <div class="Text">#'.$basenum1.' '.$target1['name_new'].'</div>
  <div class="Sex"><i class="fas fa-'.$sex1.'"></i></div>
  </div>
  <div class="lvlPokemonOne Lvl __lvl">'.$target1['lvl'].'</div>
  <div class="ballPokemonOne Ball __ball" style="background-image: url(/img/world/items/little/'.$target1['ball'].'.png);"></div>
  <div class="unikPokemonOne Unik __unik '.$target1['type'].'-color">'.$nameS1.'</div>
  <div class="Classific pow0"></div>
  <div class="itemPokemonOne Item __item" onclick=issetAll('.$target1['item_id'].',"item") style="background-image: url(/img/world/items/little/'.$target1['item_id'].'.png);"></div>
  <div class="Bars">
  <div class="Bar">
  <div class="Text __hp">'.intval($target1['hp']).' / '.intval($target1['stats'][0]).'</div>
  <div class="HpBar __hpW" style="width: '.($target1['hp'] / $target1['stats'][0] * 100).'%; max-width: 100%;"></div>
  </div>
  <div class="Bar">
  <div class="Text __exp">'.$target1['exp'].' / '.$target1['exp_max'].'</div>
  <div class="ExpBar __expW" style="width: '.($target1['exp'] / $target1['exp_max'] * 100).'%;"></div>
  </div>
  </div>
  </div>
  <div class="Info">
  <div class="TeamB1">
  '.$BallsPoke1.'
  </div>
  </div>
  </div>
  <div class="Content">
  <div class="Users">
  <div class="Left">
  <div class="user-link u-'.$Battle1['userInfo']['group'].'">'.$Battle1['userInfo']['login'].'</div>
  </div>
  <div class="Right">
  <div class="user-link u-'.$Battle2['userInfo']['group'].'">'.$Battle2['userInfo']['login'].'</div>
  </div>
  </div>
  <div class="Zone" style="background-image: url(battlefon.png);">
  <div class="StatusA">
  <div class="StatusStatsA">'.$listmod1.'</div>
  <div class="StatusStatusesA">'.$lists1.'</div>
  </div>
  <div class="StatusB">
  <div class="StatusStatsB">'.$listmod2.'</div>
  <div class="StatusStatusesB">'.$lists2.'</div>
  </div>
  <div class="Weath">
  <img style="background: #fff;" src="/img/weather/'.$Battle['weather'].'.png">
  </div>
  <div class="Round">
  <div class="Text">Раунд <span>'.$Battle['round'].'</span></div>
  </div>
  </div>
  <div class="Log">'.$btle.'<div class="Wrap">'.$LogBattleSel.'</div></div>
  </div>
  <div class="PokemonB">
  <div class="PokemonBox3">
	<div class="Modif _modif_enemy" style="background-image: url('.$target2['tren'].'.png);"></div>
  <img class="imgPok Image" src="/img/pokemons/mini/'.$target2['type'].'/'.$basenum2.'.png">
  <div class="namePokemon Name __name '.$target2['type'].'-color">
  <div class="Text">#'.$basenum2.' '.$target2['name_new'].'</div>
  <div class="Sex"><i class="fas fa-'.$sex2.'"></i></div>
  </div>
  <div class="lvlPokemonTwo Lvl __lvl">'.$target2['lvl'].'</div>
  <div class="ballPokemonTwo Ball __ball" style="left: -15px; background-image: url(/img/world/items/little/'.$target2['ball'].'.png);"></div>
<div class="unikPokemonTwo Unik __unik '.$target2['type'].'-color">'.$nameS2.'</div>
  <div class="ClassificEnemy pow0"></div>
  <div class="itemPokemonTwo Item __item" onclick=issetAll('.$target2['item_id'].',"item") style="background-image: url(/img/world/items/little/'.$target2['item_id'].'.png);"></div>
  <div class="Bars">
  <div class="Bar">
  <div class="Text __hp">'.intval($target2['hp']).' / '.intval($target2['stats'][0]).'</div>
  <div class="HpBar __hpW" style="width: '.($target2['hp'] / $target2['stats'][0] * 100).'%; max-width: 100%;"></div>
  </div>
  <div class="Bar">
  <div class="Text __exp">'.$target2['exp'].' / '.$target2['exp_max'].'</div>
  <div class="ExpBar __expW" style="width: '.($target2['exp'] / $target2['exp_max'] * 100).'%;"></div>
  </div>
  </div>
  </div>
  <div class="Info">
  <div class="TeamB">
  '.$BallsPoke2.'
  </div>
  </div>
  </div>
  </div>';
}else{
  $html = '<div class="Wait">Невозможно посмотреть бой</div>';
}
	$response = [
		'html' => $html
	];
	echo json_encode($response);
?>
