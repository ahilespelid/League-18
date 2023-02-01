<?
  $list = $mysqli->query("SELECT * FROM event_prize WHERE user = ".$_SESSION['id'])->fetch_assoc();
  $zm = $mysqli->query("SELECT * FROM users WHERE id = ".$_SESSION['id'])->fetch_assoc();
  if($list) {
    if($list['end'] == 1) {
      $pr = 1;
    }else{
      $pr = 0;
    }
  }else{
    $pr = 0;
  }
	$response['name'] = 'Генерал Лактунов';
    switch($npcStep){
      case 55:
        if($list) {
          if($zm['zombie'] >= 1600 && $list['type'] == 18) {
            itemAdd(21,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/20.png" class="item"> Рассветный камень (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 19, end = 1 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Это последня группа призов, которую мы можем показать.';
          }else{
            $response['question'] = '<b>Группа призов #18</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 54:
        if($list) {
          if($zm['zombie'] >= 1600 && $list['type'] == 18) {
            itemAdd(20,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/20.png" class="item"> Солнечный камень (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 19, end = 1 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Это последня группа призов, которую мы можем показать.';
          }else{
            $response['question'] = '<b>Группа призов #18</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 53:
        if($list) {
          if($zm['zombie'] >= 1600 && $list['type'] == 18) {
            $response['question'] = '
            <b>Группа призов #18</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(20,"item") style="background-image: url(/img/world/items/little/20.png)"></div> 1 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(21,"item") style="background-image: url(/img/world/items/little/21.png)"></div> 1 шт.
            ';
            $response['answer'] = array(
      			   54 => "Левая рука",
               55 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #18</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 52:
        if($list) {
          if($zm['zombie'] >= 1500 && $list['type'] == 17) {
            newPokemon(597,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/597.gif"> #597 Ферросид';
            $mysqli->query("UPDATE event_prize SET type = 18 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   53 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #17</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 51:
        if($list) {
          if($zm['zombie'] >= 1500 && $list['type'] == 17) {
            newPokemon(551,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/551.gif"> #551 Сандайл';
            $mysqli->query("UPDATE event_prize SET type = 18 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   53 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #17</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 50:
        if($list) {
          if($zm['zombie'] >= 1500 && $list['type'] == 17) {
            $response['question'] = '
            <b>Группа призов #17</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(551)"><img src="/img/pokemons/anim/normal/551.gif"> #551 Сандайл</span> zombie, гены 25 - 30, спаренный, передаваемый.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(597)"><img src="/img/pokemons/anim/normal/597.gif"> #597 Ферросид</span> zombie, гены 25 - 30, спаренный, передаваемый.
            ';
            $response['answer'] = array(
      			   51 => "Левая рука",
               52 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #17</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   53 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 49:
        if($list) {
          if($zm['zombie'] >= 1500 && $list['type'] == 16) {
            itemAdd(1035,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/1035.png" class="item"> TM 35 - Огнемет (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 17 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   50 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #16</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 48:
        if($list) {
          if($zm['zombie'] >= 1500 && $list['type'] == 16) {
            itemAdd(1055,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/1055.png" class="item"> TM 55 - Кипяток (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 17 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   50 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #16</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 47:
        if($list) {
          if($zm['zombie'] >= 1500 && $list['type'] == 16) {
            $response['question'] = '
            <b>Группа призов #16</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(1055,"item") style="background-image: url(/img/world/items/little/1055.png)"></div> 1 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(1035,"item") style="background-image: url(/img/world/items/little/1035.png)"></div> 1 шт.
            ';
            $response['answer'] = array(
      			   48 => "Левая рука",
               49 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #16</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   50 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 46:
        if($list) {
          if($zm['zombie'] >= 1200 && $list['type'] == 15) {
            itemAdd(1024,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/1024.png" class="item"> TM 24 - Молния (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 16 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   47 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #15</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 45:
        if($list) {
          if($zm['zombie'] >= 1200 && $list['type'] == 15) {
            itemAdd(1013,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/1013.png" class="item"> TM 13 - Ледяной луч (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 16 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   47 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #15</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 44:
        if($list) {
          if($zm['zombie'] >= 1200 && $list['type'] == 15) {
            $response['question'] = '
            <b>Группа призов #15</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(1013,"item") style="background-image: url(/img/world/items/little/1013.png)"></div> 1 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(1024,"item") style="background-image: url(/img/world/items/little/1024.png)"></div> 1 шт.
            ';
            $response['answer'] = array(
      			   45 => "Левая рука",
               46 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #15</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   47 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 43:
        if($list) {
          if($zm['zombie'] >= 1200 && $list['type'] == 14) {
            newPokemon(239,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/239.gif"> #239 Эликед';
            $mysqli->query("UPDATE event_prize SET type = 15 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   44 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #14</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 42:
        if($list) {
          if($zm['zombie'] >= 1200 && $list['type'] == 14) {
            newPokemon(355,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/355.gif"> #355 Даскул';
            $mysqli->query("UPDATE event_prize SET type = 15 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   44 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #14</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 41:
        if($list) {
          if($zm['zombie'] >= 1200 && $list['type'] == 14) {
            $response['question'] = '
            <b>Группа призов #14</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(355)"><img src="/img/pokemons/anim/normal/355.gif"> #355 Даскул</span> zombie, гены 25 - 30, спаренный, передаваемый.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(239)"><img src="/img/pokemons/anim/normal/239.gif"> #239 Эликед</span> zombie, гены 25 - 30, спаренный, передаваемый.
            ';
            $response['answer'] = array(
      			   42 => "Левая рука",
               43 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #14</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   44 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 40:
        if($list) {
          if($zm['zombie'] >= 650 && $list['type'] == 13) {
            newPokemon(425,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/425.gif"> #425 Дрифлун';
            $mysqli->query("UPDATE event_prize SET type = 14 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   41 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #13</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 39:
        if($list) {
          if($zm['zombie'] >= 650 && $list['type'] == 13) {
            newPokemon(200,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/200.gif"> #200 Мисдревиус';
            $mysqli->query("UPDATE event_prize SET type = 14 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   41 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #13</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 38:
        if($list) {
          if($zm['zombie'] >= 800 && $list['type'] == 13) {
            $response['question'] = '
            <b>Группа призов #13</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(200)"><img src="/img/pokemons/anim/normal/200.gif"> #200 Мисдревиус</span> zombie, гены 25 - 30, спаренный, передаваемый.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(425)"><img src="/img/pokemons/anim/normal/425.gif"> #425 Дрифлун</span> zombie, гены 25 - 30, спаренный, передаваемый.
            ';
            $response['answer'] = array(
      			   39 => "Левая рука",
               40 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #13</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   41 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 37:
        if($list) {
          if($zm['zombie'] >= 800 && $list['type'] == 12) {
            itemAdd(1061,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/1006.png" class="item"> TM 61 - Блуждающие огни (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 13 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   38 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #12</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 36:
        if($list) {
          if($zm['zombie'] >= 800 && $list['type'] == 12) {
            itemAdd(1006,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/1006.png" class="item"> TM 06 - Отравление (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 13 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   38 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #12</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 35:
        if($list) {
          if($zm['zombie'] >= 800 && $list['type'] == 12) {
            $response['question'] = '
            <b>Группа призов #12</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(1006,"item") style="background-image: url(/img/world/items/little/1006.png)"></div> 1 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(1061,"item") style="background-image: url(/img/world/items/little/1061.png)"></div> 1 шт.
            ';
            $response['answer'] = array(
      			   36 => "Левая рука",
               37 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #12</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   38 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 34:
        if($list) {
          if($zm['zombie'] >= 650 && $list['type'] == 11) {
            newPokemon(343,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/684.gif"> #343 Балтой';
            $mysqli->query("UPDATE event_prize SET type = 12 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   35 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #11</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 33:
        if($list) {
          if($zm['zombie'] >= 650 && $list['type'] == 11) {
            newPokemon(676,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/676.gif"> #676 Фурфру';
            $mysqli->query("UPDATE event_prize SET type = 12 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   35 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #11</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 32:
        if($list) {
          if($zm['zombie'] >= 650 && $list['type'] == 11) {
            $response['question'] = '
            <b>Группа призов #11</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(676)"><img src="/img/pokemons/anim/normal/676.gif"> #676 Фурфру</span> zombie, гены 25 - 30, спаренный, передаваемый.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(343)"><img src="/img/pokemons/anim/normal/343.gif"> #343 Балтой</span> zombie, гены 25 - 30, спаренный, передаваемый.
            ';
            $response['answer'] = array(
      			   33 => "Левая рука",
               34 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #11</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   35 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 31:
        if($list) {
          if($zm['zombie'] >= 600 && $list['type'] == 10) {
            itemAdd(36,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/36.png" class="item"> Сияющий камень (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 11 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   32 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #10</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 30:
        if($list) {
          if($zm['zombie'] >= 600 && $list['type'] == 10) {
            itemAdd(19,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/19.png" class="item"> Сумрачный камень (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 11 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   32 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #10</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 29:
        if($list) {
          if($zm['zombie'] >= 600 && $list['type'] == 10) {
            $response['question'] = '
            <b>Группа призов #10</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(19,"item") style="background-image: url(/img/world/items/little/19.png)"></div> 1 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(36,"item") style="background-image: url(/img/world/items/little/36.png)"></div> 1 шт.
            ';
            $response['answer'] = array(
      			   30 => "Левая рука",
               31 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #10</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   32 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 28:
        if($list) {
          if($zm['zombie'] >= 570 && $list['type'] == 9) {
            newPokemon(684,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/684.gif"> #684 Свирликс';
            $mysqli->query("UPDATE event_prize SET type = 10 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   29 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #9</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 27:
        if($list) {
          if($zm['zombie'] >= 570 && $list['type'] == 9) {
            newPokemon(190,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/190.gif"> #190 Айпом';
            $mysqli->query("UPDATE event_prize SET type = 10 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   29 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #9</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 26:
        if($list) {
          if($zm['zombie'] >= 570 && $list['type'] == 9) {
            $response['question'] = '
            <b>Группа призов #9</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(190)"><img src="/img/pokemons/anim/normal/190.gif"> #190 Айпом</span> zombie, гены 25 - 30, спаренный, передаваемый.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(684)"><img src="/img/pokemons/anim/normal/684.gif"> #684 Свирликс</span> zombie, гены 25 - 30, спаренный, передаваемый.
            ';
            $response['answer'] = array(
      			   27 => "Левая рука",
               28 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #9</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   29 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 25:
        if($list) {
          if($zm['zombie'] >= 500 && $list['type'] == 8) {
            itemAdd(52,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/52.png" class="item"> Протектор (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 9 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   26 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #8</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 24:
        if($list) {
          if($zm['zombie'] >= 500 && $list['type'] == 8) {
            itemAdd(53,1);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/53.png" class="item"> Электрайзер (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 9 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   26 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #8</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 23:
        if($list) {
          if($zm['zombie'] >= 500 && $list['type'] == 8) {
            $response['question'] = '
            <b>Группа призов #8</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(53,"item") style="background-image: url(/img/world/items/little/53.png)"></div> 1 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(52,"item") style="background-image: url(/img/world/items/little/52.png)"></div> 1 шт.
            ';
            $response['answer'] = array(
      			   24 => "Левая рука",
               25 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #8</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   26 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 22:
        if($list) {
          if($zm['zombie'] >= 350 && $list['type'] == 7) {
            newPokemon(273,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/273.gif"> #273 Сидот';
            $mysqli->query("UPDATE event_prize SET type = 8 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   23 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #7</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 21:
        if($list) {
          if($zm['zombie'] >= 350 && $list['type'] == 7) {
            newPokemon(659,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/659.gif"> #659 Баннелбай';
            $mysqli->query("UPDATE event_prize SET type = 8 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   23 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #7</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 20:
        if($list) {
          if($zm['zombie'] >= 350 && $list['type'] == 7) {
            $response['question'] = '
            <b>Группа призов #7</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(659)"><img src="/img/pokemons/anim/normal/659.gif"> #659 Баннелбай</span> zombie, гены 25 - 30, спаренный, передаваемый.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(273)"><img src="/img/pokemons/anim/normal/273.gif"> #273 Сидот</span> zombie, гены 25 - 30, спаренный, передаваемый.
            ';
            $response['answer'] = array(
      			   21 => "Левая рука",
               22 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #7</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   23 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 19:
        if($list) {
          if($zm['zombie'] >= 220 && $list['type'] == 6) {
            newPokemon(300,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/300.gif"> #300 Скитти';
            $mysqli->query("UPDATE event_prize SET type = 7 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   20 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #6</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 18:
        if($list) {
          if($zm['zombie'] >= 220 && $list['type'] == 6) {
            newPokemon(357,$_SESSION['id'],1,false,1,'true',1,false,2,false,false,true);
    				$response['action'] = 'updateTeam';
            $response['actionQuestPlus'] = '<img src="/img/pokemons/anim/normal/357.gif"> #357 Тропиус';
            $mysqli->query("UPDATE event_prize SET type = 7 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   20 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #6</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 17:
        if($list) {
          if($zm['zombie'] >= 220 && $list['type'] == 6) {
            $response['question'] = '
            <b>Группа призов #6</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(357)"><img src="/img/pokemons/anim/normal/357.gif"> #357 Тропиус</span> zombie, гены 25 - 30, спаренный, передаваемый.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> Покебол с <span class="bgPok" onclick="openDex(300)"><img src="/img/pokemons/anim/normal/300.gif"> #300 Скитти</span> zombie, гены 25 - 30, спаренный, передаваемый.
            ';
            $response['answer'] = array(
      			   18 => "Левая рука",
               19 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #6</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   20 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 16:
        if($list) {
          if($zm['zombie'] >= 150 && $list['type'] == 5) {
            itemAdd(95,2);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/95.png" class="item"> Набор классификаций (2 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 6 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   17 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #5</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 15:
        if($list) {
          if($zm['zombie'] >= 150 && $list['type'] == 5) {
            itemAdd(254,6);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/254.png" class="item"> Комплект значков Драз`до (6 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 6 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   17 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #5</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 14:
        if($list) {
          if($zm['zombie'] >= 150 && $list['type'] == 5) {
            $response['question'] = '
            <b>Группа призов #5</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(254,"item") style="background-image: url(/img/world/items/little/254.png)"></div> 6 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(95,"item") style="background-image: url(/img/world/items/little/95.png)"></div> 2 шт.
            ';
            $response['answer'] = array(
      			   15 => "Левая рука",
               16 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #5</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   17 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 13:
        if($list) {
          if($zm['zombie'] >= 80 && $list['type'] == 4) {
            itemAdd(240,2);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/238.png" class="item"> Большой усилитель монет (2 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 5 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   14 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #4</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 12:
        if($list) {
          if($zm['zombie'] >= 80 && $list['type'] == 4) {
            itemAdd(238,2);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/238.png" class="item"> Большой усилитель ловли (2 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 5 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   14 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #4</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 11:
        if($list) {
          if($zm['zombie'] >= 80 && $list['type'] == 4) {
            $response['question'] = '
            <b>Группа призов #4</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(238,"item") style="background-image: url(/img/world/items/little/238.png)"></div> 2 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(240,"item") style="background-image: url(/img/world/items/little/240.png)"></div> 2 шт.
            ';
            $response['answer'] = array(
      			   12 => "Левая рука",
               13 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #4</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   14 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 10:
        if($list) {
          if($zm['zombie'] >= 50 && $list['type'] == 3) {
            itemAdd(105,1);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/105.png" class="item"> Линзы (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 4 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   11 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #3</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 9:
        if($list) {
          if($zm['zombie'] >= 50 && $list['type'] == 3) {
            itemAdd(103,1);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/103.png" class="item"> Блестки (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 4 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   11 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #3</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 8:
        if($list) {
          if($zm['zombie'] >= 50 && $list['type'] == 3) {
            $response['question'] = '
            <b>Группа призов #3</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(103,"item") style="background-image: url(/img/world/items/little/103.png)"></div> 1 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(105,"item") style="background-image: url(/img/world/items/little/105.png)"></div> 1 шт.
            ';
            $response['answer'] = array(
      			   9 => "Левая рука",
               10 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #3</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   11 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 7:
        if($list) {
          if($zm['zombie'] >= 25 && $list['type'] == 2) {
            itemAdd(104,1);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/104.png" class="item"> Лупа (1 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 3 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   8 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #2</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 6:
        if($list) {
          if($zm['zombie'] >= 25 && $list['type'] == 2) {
            $randStab = mt_rand(179,195);
            itemAdd($randStab,2);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/'.$randStab.'.png" class="item"> Стабовый модификатор (2 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 3 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   8 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #2</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 5:
        if($list) {
          if($zm['zombie'] >= 25 && $list['type'] == 2) {
            $response['question'] = '
            <b>Группа призов #2</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> Случайный Стабовый Модификатор (Черные очки, Острый клюв, Сухой лед и т.п.) 2 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(104,"item") style="background-image: url(/img/world/items/little/104.png)"></div> 1 шт.
            ';
            $response['answer'] = array(
      			   6 => "Левая рука",
               7 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #2</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   8 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 4:
        if($list) {
          if($zm['zombie'] >= 1 && $list['type'] == 1) {
            itemAdd(109,10);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/109.png" class="item"> Генобол (10 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 2 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   5 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #1</b><br>Вы уже получили призы с этой группы!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 3:
        if($list) {
          if($zm['zombie'] >= 1 && $list['type'] == 1) {
            itemAdd(106,2);
            $response['actionQuestPlus'] = '<img src="/img/world/items/little/106.png" class="item"> Объедки (2 шт.)';
            $mysqli->query("UPDATE event_prize SET type = 2 WHERE user =  ".$_SESSION['id']);
            $response['question'] = 'Неплохой выбор. Перейдем ко следующей группе призов? Возможно, для тебя осталось что-то.';
            $response['answer'] = array(
      			   5 => "Перейти к следующей группе призов"
      			);
          }else{
            $response['question'] = '<b>Группа призов #1</b><br>Вы уже получили призы с этой группы!';
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 2:
        if($list) {
          if($zm['zombie'] >= 1 && $list['type'] == 1) {
            $response['question'] = '
            <b>Группа призов #1</b><br>Выбирай!<br><i>~Генерал держит в двух руках различные предметы, но своим выражением лица дает понять, что Вы можете взять лишь предметы, находящиеся в одной конкретной руке. Какие предметы выбираете? Те, что <b><font color="#47901c">в левой руке</font></b>? Или те, что <b><font color="#a43333">в правой</font></b>?~</i><br>
            <br>
            <b><font color="#47901c">В левой руке:</font></b> <div class="itemIsset" onclick=issetAll(106,"item") style="background-image: url(/img/world/items/little/106.png)"></div> 2 шт.
            <br><br>
            <b><font color="#a43333">В правой руке:</font></b> <div class="itemIsset" onclick=issetAll(109,"item") style="background-image: url(/img/world/items/little/109.png)"></div> 10 шт.
            ';
            $response['answer'] = array(
      			   3 => "Левая рука",
               4 => "Правая рука"
      			);
          }else{
            $response['question'] = '<b>Группа призов #1</b><br>Вы уже получили призы с этой группы или вы не убили достаточное количество Зомби Покемонов!';
            $response['answer'] = array(
      			   5 => "Перейти к следующей группе призов"
      			);
          }
        }else{
          $response['question'] = 'Ошибка.';
        }
      break;
      case 1:
        if($pr == 0 && $zm['zombie'] > 0 && $zm['zombie'] < 10000) {
          if(!$list) {
            $zm = $mysqli->query("INSERT INTO event_prize (user,type,prize,end) VALUES (".$_SESSION['id'].",1,0,0)");
          }
          $response['question'] = 'Награды? Ах, да. Для тебя есть кое что.';
          $response['answer'] = array(
    			   2 => "Выбрать награду"
    			);
        }else{
          $response['question'] = 'Для тебя нет наград.';
        }
      break;
			default:
				$response['question'] = 'Здравия желаю, тренер! Армия зомби почти повержена. Рад сообщить, что в этом событии никто не пострадал. Все граждане соблюдали инструкцию, сидели дома. Некоторых, конечно, пришлось отлавливать на улице и засовывать в бункеры.. Ну, и лишь храбрые тренеры, вместе с военными силами Лиги-18, смогли противостоять зомби. Их осталось не так уж и много. Думаю, за сегодня управимся.<br>Всем тем, кто храбро сражался с зомби, выдадим хорошие награды.';
        $response['answer'] = array(
  			   1 => "Получить награду"
  			);
      break;
		}
?>
