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
$type = $_POST["type"];
$id = $_POST["id"];
$other = $_POST["other"];
switch ($type) {

  case 'pmove':
    $kombi = $mysqli->query("SELECT `location_id` FROM `pokemons_location` WHERE `id` = 269")->fetch_assoc();
    $loc1 = $mysqli->query("SELECT `name` FROM `base_location` WHERE `id` = ".$kombi['location_id'])->fetch_assoc();
    $mime = $mysqli->query("SELECT `location_id` FROM `pokemons_location` WHERE `id` = 268")->fetch_assoc();
    $loc2 = $mysqli->query("SELECT `name` FROM `base_location` WHERE `id` = ".$mime['location_id'])->fetch_assoc();
    $a = '
    <div class="About">Рой <img src="/img/pokemons/anim/normal/415.gif"> #415 Комби летает в окрестностях локации <i>'.$loc1['name'].'</i></div>
    <br>
    <div class="About">Небольшая группа <img src="/img/pokemons/anim/normal/439.gif"> #439 Майм Джуниоров резвятся в окрестностях локации <i>'.$loc2['name'].'</i></div>
    ';
    $response['text'] = $a;
  break;

  case 'wild':
    $user = $mysqli->query("SELECT `location` FROM `users` WHERE `id` = ".$_SESSION['id'])->fetch_assoc();
    $loc = $mysqli->query("SELECT * FROM `base_location` WHERE `id` = ".$user['location'])->fetch_assoc();
    if($loc['pve'] == 0) {
      $b = 'Покемоны не нападают на этой локации';
    }elseif($loc['pve'] == 1) {
      $b = 'Покемоны нападают на этой локации';
    }else{
      $b = 'Покемоны агрессивно нападают на этой локации';
    }
    $a = '<div class="About">'.$b.'</div>';
    $response['text'] = $a;
  break;

  case 'char':
  $a = '
  <div class="Name">Информация о характерах</div>
  <div class="About">
  Веселый (+С -СА)<br>
  Выносливый (Нейтральный)<br>
  Застенчивый (Нейтральный)<br>
  Кроткий (Нейтральный)<br>
  Мирный (+СЗ -А)<br>
  Мягкий (+СА -З)<br>
  Наглый (+З -А)<br>
  Наивный (+С -СЗ)<br>
  Нахальный (+СЗ -С)<br>
  Нежный (+СЗ -З)<br>
  Непослушный (+А -СЗ)<br>
  Непреклонный (+А -СА)<br>
  Обычный (Нейтральный)<br>
  Одинокий (+А -З)<br>
  Озорной (+З -СА)<br>
  Осторожный (+СЗ -СА)<br>
  Поспешный (+С -З)<br>
  Причудливый (Нейтральный)<br>
  Распущенный (+З -СЗ)<br>
  Робкий (+С -А)<br>
  Серьезный (Нейтральный)<br>
  Скромный (+СА -А)<br>
  Смелый (+А -С)<br>
  Спокойный (+З -С)<br>
  Стремительный (+СА -СЗ)<br>
  Тихий (+СА -С)
  </div>
  ';
  $response['text'] = $a;
  break;
  case 'event':
    if($id == 1) {
      $a = '
      <div class="Name">Нападение Карнивайнов</div>
      <div class="Image"><img id="imgItem" src="https://i.pinimg.com/originals/c2/6d/1d/c26d1dda568f37bf35b432347e23122d.png"></div>
      <div class="About">Каждую неделю злобные Карнивайны собираются группой и атакуют Кукурузные поля, поедая всю кукурузу. Но всегда доблестные тренеры дают им отпор. <br><br>Каждую субботу, вечером, в Небольшом поселке.</div>
      ';
      $response['text'] = $a;
    }elseif($id == 2) {
      $a = '
      <div class="Name">Затопленный корабль</div>
      <div class="About">Каждую неделю призрак капитана Дрейка Колибри посещает Пляж Фуксии, чтобы насладиться прекрасным видом моря и поведать каждому свою историю.<br><br>Каждое воскресенье, днем, на Пляже Фуксии.</div>
      ';
      $response['text'] = $a;
    }elseif($id == 3) {
      $a = '
      <div class="Name">Башня испытаний</div>
      <div class="About">Хозяин башни испытаний, одной из новинок Хоэнна, приготовил для каждого тренера несколько комнат в Башне Испытаний с испытаниями, как ни странно. Способны ли вы пройти их?<br><br>Ежедневно, в любое время, в Зазубренном проходе.</div>
      ';
      $response['text'] = $a;
    }
  break;
  case 'baf':
    $baf = $mysqli->query("SELECT * FROM `bafs` WHERE `baf` = '".$id."' AND `user` = ".$_SESSION['id'])->fetch_assoc();
    if($baf) {
      $time = time();
      $item = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = '".$baf['baf']."'")->fetch_assoc();
      if($time < $baf['time']) {
        $a = '
        <div class="Name">'.$item['name'].'</div>
        <div class="Image"><img id="imgItem" src="/img/world/items/big/'.$item['id'].'.png"></div>
        <div class="About">Действует до '.date('H:i',$baf['time']).'</div>
        ';
      }else{
        $a = '
        <div class="Name">'.$item['name'].'</div>
        <div class="Image"><img id="imgItem" src="/img/world/items/big/'.$item['id'].'.png"></div>
        <div class="About">Закончилось</div>
        ';
      }
    }
    $response['text'] = $a;
  break;
		case 'item':
			$item = $mysqli->query("SELECT * FROM `base_items` WHERE `id` = '".$id."'")->fetch_assoc();
      if($item['id'] >= 1000001) {
        $mesto = explode(',',$item['info']);
        $img = $mesto[0].'.'.$mesto[1];
      }else{
        $img = $item['id'];
      }
			$a = '
			<div class="Name">'.$item['name'].'</div>
			<div class="Image"><img id="imgItem" src="/img/world/items/big/'.$img.'.png"></div>
			<div class="About">'.$item['about'].'</div>
			';
			$response['text'] = $a;
		break;
		case 'pokTeam':
			$pokemon = $mysqli->query("SELECT * FROM `base_pokemons` WHERE `id` = '".$id."'")->fetch_assoc();
			$user = $mysqli->query("SELECT * FROM `users` WHERE `id` = '".$other."'")->fetch_assoc();
			if($user['team_open'] == 1){
				if($pokemon['id'] >= 1 && $pokemon['id'] <= 9){
					$b = '00'.$pokemon['id'];
				}elseif($pokemon['id'] >= 10 && $pokemon['id'] <= 99){
					$b = '0'.$pokemon['id'];
				}else{
					$b = $pokemon['id'];
				}
				$a = '<div class="t-w">#'.$b.' '.$pokemon['name_rus'].'</div><br><center><img src="/img/pokemons/mini/normal/'.$b.'.png"></center>';
			}else{
				$a = 'Команда данного тренера закрыта';
			}
			$response['text'] = $a;
		break;
		default:
			echo "Unknown error";
		break;
	}
echo json_encode($response);
?>
