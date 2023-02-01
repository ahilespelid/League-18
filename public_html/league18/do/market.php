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

$lots = $mysqli->query("SELECT * FROM `lombard` ORDER BY `id` DESC");
$a .= '<div class="Header">Межрегиональный аукцион<div class="Close" onclick=$(".mudol").hide()><i class="fa fa-close"></i></div></div>';
$a .= '<div class="Content">';
$a .= '<div class="Lombard">';
while($lot = $lots->fetch_assoc()) {
  $user = $mysqli->query("SELECT `login`,`user_group`,`sex` FROM `users` WHERE id = ".$lot['userID'])->fetch_assoc();
  if(isset($lot['userBuy'])) {
    $user2 = $mysqli->query("SELECT `login`,`user_group`,`sex` FROM `users` WHERE id = ".$lot['userBuy'])->fetch_assoc();
  }else{
    $user2 = 0;
  }
  if($lot['category'] == 'pok') {
    $pokemon = $mysqli->query("SELECT * FROM `user_pokemons` WHERE id = ".$lot['productID'])->fetch_assoc();
    $color = $pokemon['type'].'-color';
    $itemOpen = 'onclick=Game.pokemonTeamTabs('.$lot['productID'].',"info")';
    $count = '';
    $img = 'style="background-image: url(/img/pokemons/mini/'.$pokemon['type'].'/'.numCheck($lot['productID']).'.png); background-size: 100%;"';
  }elseif($lot['category'] == 'item'){
    $color = '';
    $itemOpen = 'onclick=issetAll('.$lot['productID'].',"item")';
    $count = '('.number_format($lot['count'],0,'.','.').' шт.)';
    $img = 'style="background-image: url(/img/world/items/little/'.$lot['productID'].'.png);"';
  }else{
    $color = '';
    $itemOpen = 'onclick=issetAll(54,"item")';
    $count = '';
    $img = 'style="background-image: url(/img/world/items/little/54.png);"';
  }
  if($lot['priceBuy'] <= 0) {
    $pbuy = '-';
  }else{
    $pbuy = number_format($lot['priceBuy'],0,'.','.');
  }
  if(!empty($lot['str'])) {
    $str = explode(',',$lot['str']);
    $str1 = '['.$str[0].'/'.$str[1].']';
  }else{
    $str1 = '';
  }
  $a .= '
  <div class="StepLomb">
    <div class="BtnsLomb">
    <div onclick=market_go('.$lot['id'].',"stavka")>Сделать ставку</div>
    <div onclick=market_go('.$lot['id'].',"buynow")>Выкупить</div>
    <span>Выкуп составляет:<br>
    '.$pbuy.'</span>
    </div>
    <div class="PriceLomb">
    <div>Начальная цена: '.number_format($lot['priceStart'],0,'.','.').'</div>
    <div>Шаг: '.number_format($lot['priceStep'],0,'.','.').'</div>
    <div>Последняя ставка: '.($lot['priceNow'] >= $lot['priceStart'] ? number_format($lot['priceNow'],0,'.','.') : '-').'</div>
    </div>
    <div class="LotLomb">Лот №'.$lot['id'].'</div>
    <div class="ImageLomb" '.$img.' '.$itemOpen.'></div>
    <div class="NameLomb '.$color.'">'.$lot['name'].' '.$str1.' '.$count.'</div>
    <div class="FromLomb">
      продавец <div class="user-link"><div onclick=showUserTooltip('.$lot['userID'].') class="Info-Link sex'.$user['sex'].'"><i class="fa fa-info"></i></div> <div class="u-'.$user['user_group'].'">'.$user['login'].'</div></div>
      <br>
      '.($user2 == 0 ? 'ставки отсутствуют' : 'последняя ставка от <div class="user-link"><div onclick=showUserTooltip('.$lot['userBuy'].') class="Info-Link sex'.$user2['sex'].'"><i class="fa fa-info"></i></div> <div class="u-'.$user2['user_group'].'">'.$user2['login'].'</div></div>').'
      <br>
      завершение лота после '.date('d.m.Y',$lot['dateEnd']).'г.
    </div>
  </div>
  ';
}
$a .= '</div></div>';
$response['html'] = $a;
echo json_encode($response);
