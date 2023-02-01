<?php
$pokemon = $mysqli->query('SELECT * FROM user_pokemons WHERE user_id = '.$_SESSION['id'].' AND active = 1 AND start_pok = 1')->fetch_assoc();
$response['name'] = 'Снеговик';
switch($npcStep){
  case 1:
    $user = $mysqli->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
    if(($user['ng'] == 0) || ($user['id'] == 190)) {
      if(item_isset(341,1) && item_isset(342,1) && item_isset(343,1)) {
        if($pokemon) {
          $response['actionQuestMinus'] = '<img src="/img/world/items/little/342.png" class="item"> Подарок (3 шт.)';
          minus_item(341,1);
          minus_item(342,1);
          minus_item(343,1);
          $mysqli->query("UPDATE user_pokemons SET type = 'snowy' WHERE id = ".$pokemon['id']);
          $mysqli->query("UPDATE user_pokemons SET trade = 'false' WHERE id = ".$pokemon['id']);          
          $mysqli->query("UPDATE users SET ng = 1 WHERE id = ".$_SESSION['id']);
          $response['question'] = 'О-о-ох, подарочки!!! Ах да! <i>~Произносит магическое заклинание~</i> Вот, твой покемон теперь snowy! Спасибо и удачи.';
        }else{
          $response['question'] = 'Ошибка в выборе покемона.';
        }
      }else{
        $response['question'] = 'Но... Я не вижу 3 коробочки у тебя.';
      }
    }else{
      $response['question'] = 'Я уже красил одного твоего покемона! Больше не могу.';
    }
  break;
		case 2:
    $user = $mysqli->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
    if(($user['ng'] == 0) || ($user['id'] == 190)){
		$mysqli->query("INSERT INTO `teleport_user` (`user`,`location`,`go`) VALUES('".$_SESSION['id']."','1','ng_snowy') ");
		$mysqli->query("UPDATE `users` SET `location`='1007' WHERE `id`='".$_SESSION['id']."'");
		$response['action'] = 'updateLocation';
				$response['question'] = 'Готово';
			}else{
				$response['question'] = 'Но ведь ты уже принес подарки!';
			}
		break;
  default:
    $user = $mysqli->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
    if(($user['ng'] == 0) || ($user['id'] == 190)) {
  $response['question'] = 'Здравствуй, тренер! C Новым годом тебя! Хочется еще подарочков... Давай сделку? Ты мне <b>3 подарка, добытых а особом месте</b>, а я покрашу твоего покемона в snowy окрас. Но только лишь одного покемона! Согласен?<br>
  <i>~Ваш нужный покемон должен быть отмечен как "стартовый". Будьте внимательнее. После изменения окраса покемон станет непередаваемым.~</i>';
  $response['answer'] = array(
    1 => "Да, держите подарки",
    2 => "Я хочу отправится на поиск подарков"
  );
    }else{
      $response['question'] = 'Еще раз спасибо за подарки!';
    }
  break;
}
