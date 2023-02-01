<style>
body {background: #f4f4f4;
    text-align: center;}
span {
  display: inline-block;
  background-color: #616161;
  color: #fff000;
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
if($_SESSION['id'] == 1 || $_SESSION['id'] == 2 || $_SESSION['id'] == 3 || $_SESSION['id'] == 8) {
$battle = $mysqli->query('SELECT * FROM battle_end ORDER BY id DESC');
while($log = $battle->fetch_array()){
  $user1 = $mysqli->query('SELECT * FROM users WHERE id = '.$log['user1'])->fetch_assoc();
  $user2 = $mysqli->query('SELECT * FROM users WHERE id = '.$log['user2'])->fetch_assoc();
  echo $user1['login'].' дрался с '.$user2['login'].'. <b>Победил '.$user2['login'].'</b>. Бой №'.$log['battle'].'<br>';
}
}
