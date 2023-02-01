<?php
$pokemon = $mysqli->query('SELECT * FROM user_pokemons WHERE user_id = '.$_SESSION['id'].' AND active = 1 AND start_pok = 1')->fetch_assoc();
$response['name'] = 'Джек Тыквенная Голова';
switch($npcStep){
  case 1:
    $user = $mysqli->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
    if($user['hell'] == 0) {
      if(item_isset(324,5) && item_isset(325,5) && item_isset(326,5)) {
        if($pokemon) {
          $response['actionQuestMinus'] = '<img src="/img/world/items/little/324.png" class="item"> Просроченная конфета (5 шт.)<br><img src="/img/world/items/little/325.png" class="item"> Жуткая конфета (5 шт.)<br><img src="/img/world/items/little/326.png" class="item"> Загадочная конфета (5 шт.)';
          minus_item(324,5);
          minus_item(325,5);
          minus_item(326,5);
          $mysqli->query("UPDATE user_pokemons SET type = 'shadow' WHERE id = ".$pokemon['id']);
          $mysqli->query("UPDATE users SET hell = 1 WHERE id = ".$_SESSION['id']);
          $response['question'] = 'О-о-ох, спасибо тебе! Какие вкусные конфетки... Ах да! <i>~Произносит магическое заклинание~</i> Вот, твой покемон теперь shadow! Спасибо и удачи.';
        }else{
          $response['question'] = 'Ошибка в выборе покемона.';
        }
      }else{
        $response['question'] = 'У тебя не хватает конфеток.';
      }
    }else{
      $response['question'] = 'Я уже красил одного твоего покемона! Больше не могу.';
    }
  break;
  default:
  $response['question'] = 'Здравствуй, тренер! Неплохой выдался Хэллоуин, не правда ли? У тебя не остались конфетки с праздника? Сладкого захотелось... Давай сделку? Ты мне <b>пять Хэллоуинских конфет каждого вида</b>, а я покрашу твоего покемона в shadow окрас. Но только лишь одного покемона! Согласен?<br>
  <i>~Ваш нужный покемон должен быть отмечен как "стартовый". Будьте внимательнее~</i>';
  $response['answer'] = array(
    1 => "Да, держите конфеты"
  );
  break;
}
