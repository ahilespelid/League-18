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
	if(file_exists($patch_project.'/img/avatars/mini/'.$_SESSION['id'].'.png')){
		$user['avatar'] = '/img/avatars/mini/'.$_SESSION['id'].'.png';
    $lang = $user['lang'];
  }else{
		$user['avatar'] = '/img/avatars/mini/no-user-img.png';
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
		<title><?=PAGE_TITLE;?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="keywords" content="<?=PAGE_KEY;?>">
        <meta name="description" content="<?=PAGE_DESCRIPTION;?>">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="/img/icon.ico" type="image/x-icon">
		<link rel="icon" href="/img/icon.ico" type="image/x-icon">
		<link rel="stylesheet" href="/font-awesome/css/fontawesome-all.css?<?=microtime(true)?>">
		<link rel="stylesheet" href="/css/index.new.css?<?=microtime(true)?>">
	</head>
	<body id="body">
    <div class="TopMenu">
      <div class="Stats">
        <div class="Online">
          <div>100 <span>онлайн</span></div>
          <div>100 <span>за день</span></div>
        </div>
        <div class="Soc">
          <a href="#" class="vk"><i class="fab fa-vk"></i></a>
          <a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
          <a href="#" class="twitch"><i class="fab fa-twitch"></i></a>
        </div>
      </div>
      <div class="InfoProject">
        <div class="Logo"></div>
        <div class="Name">League 18</div>
        <div class="About">Онлайн игра про покемонов</div>
      </div>
      <div class="Menu">
        <div class="Wrap">
          <a href="#">Главная</a>
          <a href="#">Регистрация</a>
          <a href="#">Правила</a>
          <a href="#">Форум</a>
          <a href="#">Помощь</a>
        </div>
      </div>
    </div>
    <div class="Auth">
      <div class="Wrap">
        <div class="User">
          <div class="TrenBlock">
            <div class="Avatar" style="background-image: url(/img/avatars/mini/5.png);"></div>
            <div class="Text">
              <div class="u-1">AnarHeest</div>
              <span>Новичок</span>
            </div>
          </div>
        </div>
        <div class="Buttons">
          <a href="#">В игру</a>
          <a href="#">Выход</a>
        </div>
      </div>
    </div>
    <div class="Content">
      <div class="Wrap">
        <div class="Nav">
          <a href="..">Главная страница</a> <i class="fa fa-long-arrow-alt-right"></i> <span>Создание нового персонажа</span>
        </div>
        
      </div>
    </div>
    <div class="Footer">
      <div class="Wrap">
        <div class="Left">
          <div class="Logo"></div>
          <div class="Text">League 18 © 2019</div>
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
