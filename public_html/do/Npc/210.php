<?
  $user = $mysqli->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
	$response['name'] = 'Санта';
	switch($npcStep){
    case 1:
			$response['question'] = 'Перемещение..';
			$mysqli->query("UPDATE `users` SET `location`='1' WHERE `id`='".$_SESSION['id']."'");
			$response['action'] = 'updateLocation';
		break;
    case 2:
      if(!quest_isset(666)) {
        $response['question'] = 'Отлично! Жду с новостями и пеплом.';
        quest_update(666,1);
      }
		break;
    case 3:
      if(quest_isset(666,1)) {
        if(item_isset(501,1)) {
          $item = $mysqli->query('SELECT * FROM items_users WHERE user = '.$_SESSION['id'].' AND item_id = 501')->fetch_assoc();
          $myPil = $user['hell'] + $item['count'];
          $mysqli->query("UPDATE `users` SET `hell`=".$myPil." WHERE `id`='".$_SESSION['id']."'");
          $response['question'] = 'Что это, шерсть? Хм, она не похожа на обычную, я оптравлю её своим Эльфам на анализ, встетимся на этом месте </i>~01.01.2019~</i>';
          minus_item(501,$item['count']);
        }else{
          $response['question'] = 'Ты тратишь моё время.';
        }
      }
		break;
		default:
    if(!quest_isset(666)) {
      $response['question'] = '<i>~«Хо-хо-хо»~</i> Приветствую тебя, '.$_SESSION['login'].'! Хочешь расскажу тебе одну очень интересную легенду? Если да, тогда слушай, а коли нет - то не трать моё время напрасно.';
      $response['answer'] = array(
  			2 => "Да, хочу!",
        1 => "Я пожалуй пойду, всего доброго."
  		);
    }else{
      $response['question'] = 'Ты принёс пепел?<br>На данный момент ты сдал: <b>'.$user['hell'].'</b>'.' пепла'.', неси ещё!';
      $response['answer'] = array(
  			3 => "Сдать пепел",
        1 => "Уйти"
  		);
    }
		break;
	}
?>
