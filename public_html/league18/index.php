<?php
/* ~ Global Include ~ */
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $_SERVER['DOCUMENT_ROOT'].'/inc/conf/global.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
    }
}
if($_GET['route'] === "registration") {
  $lol = 'Создание персонажа';
}elseif($_GET['route'] === "rules") {
  $lol = 'Не нарушай!';
}else{
  $lol = 'Последние новости';
}
if($_GET['route'] === 'exit'){
	unset($_SESSION['id']);
	unset($_SESSION['login']);
	header('Location: /');
}
/* END ~ Global Include ~ */
if(isset($_SESSION['id'])){
	$autorize = true;
	$user = $mysqli->query("SELECT `login`,`user_group`,`rang`,`lang` FROM `users` WHERE `id` = ".$_SESSION['id'])->fetch_assoc();
	if(file_exists($patch_project.'/img/tw.png'.$_SESSION['id'].'.png')){
		$user['avatar'] = '/img/tw.png'.$_SESSION['id'].'.png';
    $lang = $user['lang'];
  }else{
		$user['avatar'] = '/img/tw.png';
	}
}else{
  $lang = 'ru';
	$autorize = false;
}
$index = new Index($mysqli);
$page = (isset($_GET['page']) ? ($_GET['page']) : 1);
$nextPage = $page + 1;
$prevPage = $page - 1;
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
    <script src="https://vk.com/js/api/openapi.js?160" type="text/javascript"></script>
		<title>League-18: Браузерная Онлайн игра по мотивам Покемонов.</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="keywords" content="<?=PAGE_KEY;?>">
        <meta name="description" content="<?=PAGE_DESCRIPTION;?>">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="/img/tw.png" type="image/x-icon">
		<link rel="icon" href="/img/tw.png" type="image/x-icon">
		<link rel="stylesheet" href="/font-awesome/css/fontawesome-all.css?<?=microtime(true)?>">
		<link rel="stylesheet" href="/css/index.new.css?<?=microtime(true)?>">
	</head>
	<body id="body">
    <!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
VK.Widgets.CommunityMessages("vk_community_messages", 164378292, {widgetPosition: "left",disableExpandChatSound: "1",tooltipButtonText: "Есть вопрос по игре? Задай!"});
</script>
    <div class="TopMenu">
      <div class="no_snow"></div>
      <div class="Stats">
        <div class="Online">
          <div><?=$index->online;?> <span>онлайн</span></div>
          <div><?=$index->all;?> <span>за день</span></div>
        </div>
        <div class="Soc"> 
          <a href="https://vk.com/league_18" target="_blank" class="vk"><i class="fab fa-vk"></i></a>
          <a href="https://www.youtube.com/channel/UCNdVH2FegN280ci6ZtCHZ3A?view_as=subscriber" class="youtube"><i class="fab fa-youtube"></i></a>
          <a href="https://volnorez.com/liga-18-radio" class="twitch"><i class="fas fa-podcast"></i></i></a>
        </div>
      </div>
      <div class="InfoProject">
        <img src="/img/logo_index/newlogo/logo.png" style="width: 730px;"></img>
      <!--<p><img src="/img/logo.png" alt="League-18"></p> -->
       <!-- <div class="Name"><h3>League 18</h3></div> -->
        
      </div>
      <div class="Menu">
        <div class="Wrap">
          <a href="..">Главная</a>
          <a href="/?route=registration">Регистрация</a>
          <a href="/?route=rules">Правила</a>
          <a target="_blank" href="http://leagueonline.forum2.net/">Форум</a>
          <a target="_blank" href="Здесь_должна_быть_Покепедия">Педия</a>
          <a href="https://vk.com/im?media=&sel=-164378292" target="_blank">Помощь</a>
        </div>
      </div>
    </div>
    <div class="Auth">
      <div class="Wrap">
        <?=$index->GetInfo1();?>
      </div>
    </div>
    <div class="Content">
      <div class="Wrap">
        <div class="Nav">
          <a href="..">Главная страница</a> <i class="fa fa-long-arrow-alt-right"></i> <span><?=$lol;?></span>
        </div>
        <?=$index->GetInfo();?>
      </div>
    </div>
    <div class="Footer">
      <div class="Wrap">
        <div class="Left">
          <div class="Logo"></div>
          <div class="Text">League-18 © 2019</div>
        </div>
        <div class="Right">
          Покемоны, их имена, картинки, и связанные с ними названия являются торговыми марками: Gamefreak, Nintendo, The Pokémon Company Creatures Inc, а также их соответствующим дочерним компаниям.
        </div>
      </div>
    </div>
		<script src="/js/jquery/jquery.js?<?=$versionGame;?>" type="text/javascript"></script>
		<script src="/js/jquery/notify.js?<?=$versionGame;?>" type="text/javascript"></script>
		<script src="/js/index.js?<?=microtime(true)?>" type="text/javascript"></script>
    <script src="/js/jquery/notify.js?<?=$versionGame;?>" type="text/javascript"></script>
    <script src="/js/underscore.js?<?=$versionGame;?>" type="text/javascript"></script>
    <script src="/js/lang/<?=$lang;?>.js?<?=microtime(true)?>" type="text/javascript"></script>
		<script>
			const DOMAIN = '<?=DOMAIN_HTTP;?>';
      //w3.displayObject("body", Lang);
		</script>
	</body>
</html>
