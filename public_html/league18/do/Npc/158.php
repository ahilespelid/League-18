<?
	$response['name'] = 'Коллекционер значков';
	switch($npcStep){
    case 1:
      $response['question'] = 'Награды можно посмотреть <a href="Здесь должен быть форум" target="_blank">тут</a>.';
      $response['answer'] = array(
				2 => "Хочу сдать свою коллекцию значков"
			);
		break;
    case 2:
      if(item_isset(242,1) && item_isset(243,1) && item_isset(244,1) && item_isset(245,1) && item_isset(246,1) && item_isset(247,1) && item_isset(248,1) && item_isset(249,1) && item_isset(250,1) && item_isset(251,1) && item_isset(252,1) && item_isset(253,1)) {
        minus_item(242,1);
        minus_item(243,1);
        minus_item(244,1);
        minus_item(245,1);
        minus_item(246,1);
        minus_item(247,1);
        minus_item(248,1);
        minus_item(249,1);
        minus_item(250,1);
        minus_item(251,1);
        minus_item(252,1);
        minus_item(253,1);
        $rand = mt_rand(1,14);
        if($rand == 1) {
          $prize = '#672 <span>Скиддо</span>';
          plusEgg(false,false,false,false,false,672,true);
        }elseif($rand == 2) {
          $prize = '#190 <span>Айпом</span>';
          plusEgg(false,false,false,false,false,190,true);
        }elseif($rand == 3) {
          $prize = '#175 <span>Тогепи</span>';
          plusEgg(false,false,false,false,false,175,true);
        }elseif($rand == 4) {
          $prize = '#679 <span>Хонэдж</span>';
          plusEgg(false,false,false,false,false,679,true);
        }elseif($rand == 5) {
          $prize = '#554 <span>Дарумака</span>';
          plusEgg(false,false,false,false,false,554,true);
        }elseif($rand == 6) {
          $prize = '#607 <span>Литвик</span>';
          plusEgg(false,false,false,false,false,607,true);
        }elseif($rand == 7) {
          $prize = '#425 <span>Дрифлун</span>';
          plusEgg(false,false,false,false,false,425,true);
        }elseif($rand == 8) {
          $prize = '#147 <span>Дратини</span>';
          plusEgg(false,false,false,false,false,147,true);
        }elseif($rand == 9) {
          $prize = '#422 <span>Шеллос</span>';
          plusEgg(false,false,false,false,false,422,true);
        }elseif($rand == 10) {
          $prize = '#704 <span>Гуми</span>';
          plusEgg(false,false,false,false,false,704,true);
        }elseif($rand == 11) {
          $prize = '#714 <span>Нойбат</span>';
          plusEgg(false,false,false,false,false,714,true);
        }elseif($rand == 12) {
          $prize = '#629 <span>Валлаби</span>';
          plusEgg(false,false,false,false,false,629,true);
        }elseif($rand == 13) {
          $prize = '#627 <span>Раффлет</span>';
          plusEgg(false,false,false,false,false,627,true);
        }else{
          $prize = '#434 <span>Станки</span>';
          plusEgg(false,false,false,false,false,434,true);
        }
        $mysqli->query("INSERT INTO drazdo (user, prize, date) VALUES(".$_SESSION['id'].", '".$prize."', ".time().")");
        $response['actionQuestPlus'] = '<img src="/img/world/items/little/54.png" class="item"> Яйцо (1 шт.)';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/242.png" class="item"> Значок Драз`до «Артикуно» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/243.png" class="item"> Значок Драз`до «Запдос» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/244.png" class="item"> Значок Драз`до «Молтрес» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/245.png" class="item"> Значок Драз`до «Волбит» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/246.png" class="item"> Значок Драз`до «Тимпол» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/247.png" class="item"> Значок Драз`до «Флефи» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/248.png" class="item"> Значок Драз`до «Нинджаск» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/249.png" class="item"> Значок Драз`до «Вимсикот» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/250.png" class="item"> Значок Драз`до «Эскавальер» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/251.png" class="item"> Значок Драз`до «Агрон» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/252.png" class="item"> Значок Драз`до «Флайгон» (1 шт.)<br>';
        $response['actionQuestMinus'] .= '<img src="/img/world/items/little/253.png" class="item"> Значок Драз`до «Пангоро» (1 шт.)<br>';
        $response['question'] = 'Прекрасная коллекция! Держи награду! <b></b>';
      }else{
        $response['question'] = 'У тебя не хватает значков.';
      }
		break;
		default:
			$response['question'] = 'Оу, привет, друг. У тебя нету значков Драз`до случайно? Я бы дал за полную коллекцию хорошую награду.<br>Мне нужны <div class="itemIsset" onclick="issetAll(245,\'item\')" style="background-image: url(/img/world/items/little/245.png)"></div> <div class="itemIsset" onclick="issetAll(246,\'item\')" style="background-image: url(/img/world/items/little/246.png)"></div> <div class="itemIsset" onclick="issetAll(247,\'item\')" style="background-image: url(/img/world/items/little/247.png)"></div> <div class="itemIsset" onclick="issetAll(248,\'item\')" style="background-image: url(/img/world/items/little/248.png)"></div> <div class="itemIsset" onclick="issetAll(249,\'item\')" style="background-image: url(/img/world/items/little/249.png)"></div> <div class="itemIsset" onclick="issetAll(250,\'item\')" style="background-image: url(/img/world/items/little/250.png)"></div> <div class="itemIsset" onclick="issetAll(251,\'item\')" style="background-image: url(/img/world/items/little/251.png)"></div> <div class="itemIsset" onclick="issetAll(252,\'item\')" style="background-image: url(/img/world/items/little/252.png)"></div> <div class="itemIsset" onclick="issetAll(253,\'item\')" style="background-image: url(/img/world/items/little/253.png)"></div> + 3 редкие <div class="itemIsset" onclick="issetAll(242,\'item\')" style="background-image: url(/img/world/items/little/242.png)"></div> <div class="itemIsset" onclick="issetAll(243,\'item\')" style="background-image: url(/img/world/items/little/243.png)"></div> <div class="itemIsset" onclick="issetAll(244,\'item\')" style="background-image: url(/img/world/items/little/244.png)"></div>';
			$response['answer'] = array(
				1 => "Какие награды?",
        2 => "Хочу сдать свою коллекцию значков"
			);
		break;
	}
?>
