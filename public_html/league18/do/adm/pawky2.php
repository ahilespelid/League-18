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
$trade = $mysqli->query('SELECT * FROM base_ability');
while($log = $trade->fetch_assoc()){
  $c .= $log['name'].' ('.$log['id'].')<br>';
}
echo $c;
