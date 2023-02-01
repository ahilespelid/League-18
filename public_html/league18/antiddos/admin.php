<!DOCTYPE html><html><body>
<?PHP

if (!isset($dir)) $dir=$_SERVER['DOCUMENT_ROOT'].'/antiddos/';


$pass='123123123'; // Сменить на свой
if (!isset($_GET['pass']) || $_GET['pass']!=$pass) 
{
     echo 'Введите пароль: <form name="form"  method="get"><input type="text" name="pass"><input type="submit" value="Отправить"></form>';
     echo '<br>'.$_SERVER['REMOTE_ADDR'];
}
else
{
?>
<div style="padding:5px 0 0 5px;">
<a href="?banip&pass=<?=$pass?>">Список забаненных IP</a> | <a href="?clearban&pass=<?=$pass?>">Очистить черный список</a>  | <a href="?clearwhite&pass=<?=$pass?>">Очистить белый список</a> | <a href="?clearcount&pass=<?=$pass?>">Очистить счетчик</a>
</div><br>
<?php

function delfiles($dir)
{
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) 
        { 
            if ($file != "." && $file != "..") unlink($dir.'/'.$file);
        }
        closedir($handle); 
    }
}

if (isset($_GET['banip']))  
{
    $list='';
    $items = glob($dir.'ban/*');
    foreach ($items as $ip)
    {
        $list.=str_replace($dir.'ban/','',$ip).'<br>';
    
    }
    
    echo count($items).'<br><br>';
    echo $list;

    exit;
}
elseif (isset($_GET['clearban']))
{
    delfiles($dir.'ban');
    
    echo 'Операция выполнена.';
}
elseif (isset($_GET['clearwhite']))
{
    delfiles($dir.'white');
    
    echo 'Операция выполнена. ';
}
elseif (isset($_GET['clearcount']))
{
    delfiles($dir.'count');
    
    echo 'Операция выполнена.';
}

}
?>
</body></html>