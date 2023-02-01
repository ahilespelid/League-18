<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
        require_once($patch_global);
    }
}
if(!isset($_SESSION['id']) || !isset($_COOKIE['hash'])){
	header('Location: ./');
}
// if($_SESSION['id'] != 683) {
//   header('Location: ./');
// }
$user = $mysqli->query('SELECT `id`,`login`,`user_group`,`rang`,`hash`,`location`,`sound`,`lang`,`opros` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
if($_COOKIE['hash'] != $user['hash']){
	header('Location: ./');
}
$index = new Index($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>League 18 - Мир</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="/img/tw.png" type="image/x-icon">
	<link rel="icon" href="/img/tw.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/css/world.css?<?=microtime(true);?>">
    <link rel="stylesheet" type="text/css" href="/css/makasimka.css?<?=microtime(true);?>">
    <link rel="stylesheet" type="text/css" href="/css/emoji.css?<?=$versionGame;?>">
	<link rel="stylesheet" type="text/css" href="/font-awesome/css/fontawesome-all.css?<?=microtime(true);?>">
	<link rel="stylesheet" type="text/css" href="/css/tipped/tipped.css?<?=$versionGame;?>"/>
</head>
<body>
 
  <div class="TechWork" style="display: none;"><span>Технические работы в игре!</span></div>
	<div id="locationPreloader">
		<div class="preloader">
			<img src="/img/loader/1.gif">
			<span></span>
		</div>
	</div>
	<audio id="battleAudio"><source src="battleStart.wav" type="audio/wav"></audio>
	<div class="BlockOtherContent" style="display: none;">
		<div class="DivNotifyBlock"></div>
	</div>
	<div class="tooltip" id="mainTooltip" style="display: none;"></div>
	<div class="tooltip-block" style="display: none;"></div>
	<div class="mudol" style="display: none;"></div>
	<div class="mudolmap" style="display: none;"></div>
  <div class="BigModal" style="display: none;"></div>
	<div class="inform" style="display: none;"></div>
	<div class="CraftModal" style="top: 100px; right: 80px; display: none;"></div>
	<div class="DivNotification"></div>
  <div class="TopMenu">
    <div class="Bafs"></div>
		<div class="LeftMenu">
			<div class="Text"></div>
		</div>
		<div class="MidMenu"></div>
		<div class="RightMenu"><sup>В игре: <?=$index->online;?></sup>
			<div class="Buttons">
				<div class="Button" onclick="showNotify(this);"><i class="fas fa-bell"></i><span><div id="countNotif" style="display: none;">0</div></span></div>
			</div>
			<div class="Time" id="map_time">
				00:00
			</div>
			<div class="Logo"></div>
		</div>
		<div align="center">

	</div>
  <div class="loadWorld"></div>
  <div id="window_games" class="DivWorld">
		<div class="DivMap">
			<div class="Left">
				<div class="Name">Локации</div>
			
        <div class="Steps"></div>
			</div>
			<div class="Center">
				<div class="ImageLoc">
					<div class="About">
						<div class="Text"></div>
					</div>
					<div class="Name">
						<div onclick="$('.ImageLoc .About').toggle();"></div>
					</div>
          <div class="Other">
             <div onclick="bigmapworld(12)"><i class="fas fa-map-signs"></i></div>
			 <div onclick="Game.prize.dayPrize('')"><i class="fas fa-gift"></i></div>
					</div>
          <div class="Events">
						<div class="Name" onclick="evenOn()"><i class="fas fa-calendar"></i></div>
            <div class="Steps" style="display: none;">
              <div class="Event" onclick="issetAll(1,'event')">Нападение Карнивайнов <span>Вечер, Сб</span></div>
              <div class="Event" onclick="issetAll(2,'event')">Затопленный корабль <span>День, Вс</span></div>
              <div class="Event" onclick="issetAll(3,'event')">Башня испытаний <span>Ежедневно</span></div>
            </div>
					</div>
				</div>
			</div>
      <div class="Right">
				<div class="Name">Персонажи</div>
			
        <div class="Steps"></div>
			</div>
		</div>
	</div>
  <div class="DivChat">
    <div class="Chat">
      <input class="__chat_scrolls simple-tooltip" title="Чат автоматически вниз" type="checkbox" checked/>
      <div class="Category"></div>
      <div class="Talk">
        <div class="Message-Block Channel_8" data-channel='8'></div>
             <div class="Message-Block Channel_30" data-channel='30'></div>
        <div class="Message-Block Channel_9" data-channel='9'></div>
        <div class="Message-Block Channel_21" data-channel='21'></div>
        <div class="Message-Block Channel_10" data-channel='10'></div>
        <div class="Message-Block Channel_0 active" data-channel='0'></div>
      </div>
    </div>
    <div class="Trainers">
			<div class="Name"></div>
			<div class="TrainerList"></div>
		</div>
    <div class="DivRightButtons">
			<div class="Wrap"></div>
		</div>
  </div>
  <div class="DivBottomGame">
		<div class="Inputs">
        <form onsubmit="ClassChat._send();return false;">
  			<div class="User">
  				<input id="chat_user_to" placeholder="Имя тренера..." type="text">
  				<div class="Button" onclick="$(this).prev().val('');"><i class="fas fa-close"></i></div>
  			</div>
  			<div class="Text" id="messageFieldBox">
  				<input id="chat_send" placeholder="Сообщение..." type="text" autocomplete="off">
  				<div onclick="ClassChat._send();return false;" class="Button"><i class="fas fa-chevron-right"></i></div>
  			</div>
        <input type="submit" style="display: none">
      </form>
		</div>
		<div class="MiniButtons"></div>
	</div>
	<script src="/js/jquery/jquery.js?<?=$versionGame;?>" type="text/javascript"></script>
	<script src="/js/jquery/draggabilly.js?<?=$versionGame;?>" type="text/javascript"></script>
	<script src="/js/emoji.js?<?=$versionGame;?>" type="text/javascript"></script>
	<script src="/js/world.js?<?=microtime(true);?>" type="text/javascript"></script>
	<script src="/js/makasimka.js?<?=microtime(true);?>" type="text/javascript"></script>
	<script src="/js/lang/<?=$user['lang'];?>.js?<?=$versionGame;?>" type="text/javascript"></script>
	<script src="/js/tipped/tipped.js?<?=$versionGame;?>" type="text/javascript"></script>
	<script src="/js/moment/moment.js?<?=$versionGame;?>" type="text/javascript"></script>
	<script>
    var ClassInfo, UserAudio = <?=$user['sound'];?>, ClassChat;
		const VERSION = '<?=$versionGame;?>';
    const GROUP_USER = '<?=$user['user_group'];?>';
    const ID_USER = '<?=$_SESSION['id'];?>';
    const LOGIN = '<?=$_SESSION['login'];?>';
    const REITS = '<?=$reitsGlobal;?>';
    const REITS_TEXT = '<?=$reitsGlobalText;?>';
		$(function(){
			Game.init();
			ClassChat = new GameChat({
				'id': '<?=$_SESSION['id'];?>',
				'login': '<?=$_SESSION['login'];?>',
				'group': '<?=$user['user_group'];?>'
			});
      ClassInfo = new GameInfo({
				'id': '<?=$_SESSION['id'];?>',
				'login': '<?=$_SESSION['login'];?>',
				'group': '<?=$user['user_group'];?>'
			});
		});
		$(document).ready(function() {
			Tipped.create('.simple-tooltip');
		});
	</script>
</body>
</html>
