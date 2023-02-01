<style>
body {background: #f4f4f4;
    text-align: left;}
h2 {
  color: #934d4d;
      font-family: Arial;
      margin-bottom: 0px;
}
.tra{
  background: #fff;
    padding: 10px;
    margin: 10px;
    border-radius: 3px;
    border: 1px solid #d5cdcd;
    line-height: 25px;
}
.tra > span{
  text-align: center;
    display: block;
    font-size: 20px;
    font-family: sans-serif;
    font-weight: bold;
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
if($_SESSION['id'] == 1 || $_SESSION['id'] == 2 || $_SESSION['id'] == 3 || $_SESSION['id'] == 8 || $_SESSION['id'] == 17 || $_SESSION['id'] == 151 || $_SESSION['id'] == 250) {
$trade = $mysqli->query('SELECT * FROM log_game WHERE title = "TRADE_CPL" ORDER BY id DESC');
while($log = $trade->fetch_assoc()){
  $info1 = json_decode($log['info'], TRUE);
  $user1 = $mysqli->query('SELECT login,ip FROM users WHERE id = '.$log['user_id'])->fetch_assoc();
  $user2 = $mysqli->query('SELECT login,ip FROM users WHERE id = '.$info1['user_to'])->fetch_assoc();
    $c .= '<div class="tra"> <span>Обмен #'.$log['id'].'</span>';
    foreach($info1['objects'] as $val){
      $c .= '('.$val['type'].') #'.$val['number'].' '.$val['name'].' ('.$val['count'].' шт.). ID'.$val['id'].' - передал <b>'.$user2['login'].' (ip '.$user2['ip'].') </b> тренеру <b>'.$user1['login'].' (ip '.$user1['ip'].')</b><br>';
    }
    $c .= '</div>';
  }
  echo $c;
}
?>