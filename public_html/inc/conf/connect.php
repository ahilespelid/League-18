<?php
#Функция расчета разницы между двумя датами
function downcounter($date,$date2=false){
    $check_time = $date - time();
    if($check_time <= 0){
        return false;
    }
    $days = floor($check_time/86400);
    $hours = floor(($check_time%86400)/3600);
    $minutes = floor(($check_time%3600)/60);
    $seconds = $check_time%60;
    $str = '';
    if($days > 0) $str .= declension($days,array('день','дня','дней')).' ';
    if($hours > 0) $str .= declension($hours,array('час','часа','часов')).' ';
    if($minutes > 0) $str .= declension($minutes,array('минута','минуты','минут')).' ';
    if($seconds > 0) $str .= declension($seconds,array('секунда','секунды','секунд'));
    return $str;
}
#Функция склонения слов
function declension($digit,$expr,$onlyword=false){
    if(!is_array($expr)) $expr = array_filter(explode(' ', $expr));
    if(empty($expr[2])) $expr[2]=$expr[1];
    $i=preg_replace('/[^0-9]+/s','',$digit)%100;
    if($onlyword) $digit='';
    if($i>=5 && $i<=20) $res=$digit.' '.$expr[2];
    else{
        $i%=10;
        if($i==1) $res=$digit.' '.$expr[0];
        elseif($i>=2 && $i<=4) $res=$digit.' '.$expr[1];
        else $res=$digit.' '.$expr[2];
    }
    return trim($res);
}
#Очищает текст от ненужных символов
function clearStr($text){
	$text = trim($text);
	$text = stripslashes($text);
	$text = htmlspecialchars($text);
	return $text;
}
#Очищает числа от ненужных символов
function clearInt($chs){
	$chs = ceil($chs);
	$chs = abs($chs);
	$chs = stripslashes($chs);
	$chs = htmlspecialchars($chs);
	$chs = trim($chs);
	return $chs;
}
function numbPok($val){
	if($val < 10){$dpl = "00";}else{
		if($val < 100 and $val >= 10){$dpl = "0";}
	else{$dpl = "";}
	}
	return $dpl.$val;
}
try {
    $mysqli = new mysqli(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PASSWORD, MYSQL_DB);
    mysqli_set_charset($mysqli, "utf8");
} catch (Exception $e) {
    die($e->getMessage());
}
date_default_timezone_set("Europe/Moscow");

$dataHour = date("G");
$dataWeek = date("D");
if(date("G") >= 0 and date("G") <= 5){
	$timeday = 1;
	$constDay = 2;
}elseif(date("G") >= 6 and date("G") <= 11){
	$timeday = 2;
	$constDay = 3;
}elseif(date("G") >= 12 and date("G") <= 17){
	$timeday = 3;
	$constDay = 0;
}else{
	$timeday = 4;
	$constDay = 1;
}
if(isset($_SESSION['id']) && isset($_SESSION['login'])){
	$_SESSION['id'] = clearInt($_SESSION['id']);
	$userID = $_SESSION['id'];
	$userName = $_SESSION['login'];
	$timeOnl = time()+300;
	$time = time();
	$mysqli->query('UPDATE `users` SET `online` = '.$timeOnl.' WHERE `id` = '.$_SESSION['id']);
}

error_reporting(0);
