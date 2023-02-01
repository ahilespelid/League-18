<style>
body {background: #f4f4f4;
    text-align: center;}
span {
  display: inline-block;
  background-color: #616161;
  color: #fff;
  width: 40%;
  text-align: center;
  border-radius: 5px;
  margin-right: 8px;
  margin-bottom: 8px;
  font-family: sans-serif, Arial;
  padding: 10px;
}
h2 {
  color: #934d4d;
      font-family: Arial;
      margin-bottom: 0px;
}
</style>
<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$patch_func = $patch_project.'/inc/function/Functions.php';
$patch_makasimka = $patch_project.'/makasimka/';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
        require_once($patch_global);
        require_once($patch_func);
    }
}
if($_SESSION['id'] == 190 || $_SESSION['id'] == 3 || $_SESSION['id'] == 8) {
$items = $mysqli->query('SELECT id, name, type FROM base_items ORDER BY type ASC, id ASC');
$prev_item = false;
while($item = $items->fetch_array()){
	if(!$prev_item || $item['type'] != $prev_item['type']){
		switch($item['type']){
			case 'other':
				echo '<h2>Разное</h2>';
				break;
			case 'boxes':
				echo '<h2>Боксы</h2>';
				break;
			case 'ball':
				echo '<h2>Боллы</h2>';
				break;
			case 'potion':
				echo '<h2>Регенераторы</h2>';
				break;
			case 'modificator':
				echo '<h2>Модификаторы</h2>';
				break;
			case 'evolver':
				echo '<h2>Эволверы</h2>';
				break;
			case 'craft':
				echo '<h2>Крафт</h2>';
				break;
			case 'trophy':
				echo '<h2>Трофеи</h2>';
				break;
			case 'tm':
				echo '<h2>TM</h2>';
				break;
			case 'cloth':
				echo '<h2>Одежда</h2>';
				break;
			case 'quest':
				echo '<h2>Квестовые</h2>';
				break;
		}
	}
	$prev_item = $item;
	$items_count = $mysqli->query('SELECT SUM(count) count, bi.name, u.login FROM items_users iu INNER JOIN base_items bi ON iu.item_id = bi.id INNER JOIN users u ON iu.user = u.id WHERE iu.item_id = '.$item['id'].' AND u.user_group != 1 ORDER BY count DESC')->fetch_array();
	//echo '<span class="'.$item['type'].'">'.$items_count['name'].' <b>' . number_format($items_count['count']) . ' шт.</b></span>';
  echo '<span class="'.$item['type'].'">'.$items_count['name'].' ('.$item['id'].')</span>';
}
}
