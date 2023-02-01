<?php
function isBot()
{
  $bots = array(
    'googlebot','yandex','mail.ru','rambler','msnbot','bing.com','aport','yahoo','turtle','yetibot','gigabot','snapbot','alexa.com',
    'scoutjet','similarpages','google-sitemaps','appEngine-google','googlealert.com','yaDirectBot','yandexSomething','AdsBot-Google','yandeG'
  );
  foreach($bots as $b) { if( stripos($_SERVER['HTTP_USER_AGENT'], $b) == true ) return $b; }

  return false;
}


$enter=true;
$ip=$_SERVER['REMOTE_ADDR']; // Убедитесь, что переменная $_SERVER['REMOTE_ADDR'] содержит IP пользователя, а не сервера, как иногда бывает при кривых настройках, либо при проксировании домена через сервисы типа Cloudflare

define('DIR', $_SERVER['DOCUMENT_ROOT'].'/antiddos/');
define('BAN', DIR.'ban/'.$ip);
//$ip=rand(1,255).'.'.rand(1,255).'.'.rand(1,255).'.'.rand(1,255); // это для теста


// Настройки
$url=false; // Атакуемая страница. Обычно это главная или страница с авторизацией (POST запросы создают максимальную нагрузку на сервер). Если боты атакуют разные внутряки, оставить false.
$count=1; // Лимит запросов в минуту, при превышении которого IP попадает в черный список. Если установлено false, то нужно будет пройти каптчу для захода на сайт или атакуемую страницу.

// !!! ВАЖНО !!! Для работы скрипта необходимо создать папку antiddos в корне сайта, а в этой папке еще три папки с правами 777: ban, white и count.


function antiddos($ip, $url, $count)
{
    if ($url)
    {
        list(,$url)=explode($_SERVER['HTTP_HOST'], $url);
        if ($_SERVER['REQUEST_URI']!=$url) return true; // Если не целевая страница, то пропускаем. Например, ддосят только главную, а пользователь зашел с поисковой системы на внутреннюю
    }

    // Отсеиваем глупых ботов с пустым юзер-агентом. Если в логах таких нет, можно закомментить.
    if (strlen($_SERVER['HTTP_USER_AGENT'])<3)
    {
        file_put_contents(BAN, '');
        return false;
    }

    // Если пользователь зашел с поисковиков, добавляем в белый список.
    if (strpos($_SERVER['HTTP_REFERER'],'yandex.')!==false || strpos($_SERVER['HTTP_REFERER'],'google.')!==false) return true;

    if (isBot()) // Если ддос-боты подменяют User Agent, то отключить проверку
    {
        file_put_contents(DIR.'white/'.$ip, $_SERVER['HTTP_USER_AGENT']); // Добавляем IP поисковых ботов в белый список
        return true;
    }

    if (!$count) // Если лимит запросов не задан, добавляем все IP в бан. Для удаления из бана пользователь должен будет пройти каптчу
    {
        file_put_contents(BAN, '');

        return false;
    }
    else
    {
        if ($url)
        {
            $cf=date("m-d-h-i.").$ip;  // Метод не точен, так как минута будет не полная. Но даже если бот не израсходует свой лимит на остатке минуте, то срежется на следующей минуте. Делать более сложную проверку - лишняя нагрузка
   
        }
        else $cf=md5($_SERVER['REQUEST_URI'].$_SERVER['HTTP_USER_AGENT'].date("mdhi")).$ip; // Если ддосят разные страницы, то делаем счетчик для каждой страницы. Более ресурсоемкий вариант.
   
        $cf=DIR.'count/'.$cf;

        if (!is_file($cf)) file_put_contents($cf, "1"); // папку antiddos/count рекомендуется переодически очищать через админку
        else
        {
            $c=file_get_contents($cf);
            if ($c>$count) // лимит превышен
            {
                file_put_contents(BAN, $_SERVER['HTTP_USER_AGENT'].PHP_EOL.$_SERVER['REQUEST_URI']); // отправляем в бан

                return false;
            }
            else
            {
                file_put_contents($cf, $c+1);
            }
        }
   
        return true;
    }
}

//
if (isset($_GET['nebot']) )  // Пользователь проходит каптчу
{
    $time=time();

    if ($_GET['nebot']>$time-60 && $_GET['nebot']<$time) // Простая timestamp-каптча. Большинство ддосеров не смогут (не будут пытаться) ее обойти, не смотря на кажущуюся простоту.
    {
        file_put_contents(DIR.'white/'.$ip, ""); // Добавляе IP в белый список.
   
        if (is_file(BAN)) unlink(BAN); // Удаляем IP из черного списка, если он там есть
   
        // Сбрасываем счетчик обращений
        $items = glob(DIR.'count/*'.$ip);
        foreach ($items as $fip) unlink($fip);   

    /*    sleep(1);
   
        header("Location: http://".$_SERVER['HTTP_HOST']);  // Редиректим на главную  */
        exit;
    }

}
elseif (is_file(BAN))
{
    exit; // Если ip в черном списке, прерываем исполнение. Вместо exit можно вывести заглушку (как ниже), если вы опасаетесь что пользователь может попасть в черный список случайно, но тогда увеличится нагрузка на сервер.
}
else
if ( !is_file(DIR.'white/'.$ip) && !antiddos($ip, $url, $count)) // Если нет в белом списке и не прошел проверку, показываем заглушку только первый раз. В дальнейшем IP будет отсеиваться на предыдущем шаге.
{
    echo '<script>window.location="/?nebot='.time().'";</script>';     // Боты обычно не видят редиректов
    echo '<h1>На сайт идет ддос. Нажмите, если вы не бот: <a href="?nebot='.time().'">я не бот</a></h1>'; // Примитивная заглушка-каптча без html-разметки, если по каким то причинам не сработал редирект выше
    exit;
}



if (@empty($_COOKIE))
{
    include($_SERVER['DOCUMENT_ROOT'].'/antiddos/include.php');
}
var_dump($_COOKIE);
exit;



if (!isset($_COOKIE['checkuser']))
{
    setcookie("checkuser", 1, time()+43200); // устанавливаем куку на месяц
    include($_SERVER['DOCUMENT_ROOT'].'/antiddos/include.php');
}
?>