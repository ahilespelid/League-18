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
$user = [];
if(isset($_SESSION['id'])){
    $user = $mysqli->query('SELECT `id`,`login`,`user_group`,`rang`,`hash`,`location`,`sound`,`lang` FROM `users` WHERE `id` = '.$_SESSION['id'])->fetch_assoc();
    if($_COOKIE['hash'] === $user['hash']){
        $autorize = true;
    }else{
        $autorize = false;
        header('Location: ./');
    }
}else{
    $autorize = false;
    header('Location: ./');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>League 18</title>
	<link rel="icon" type="image/png" href="/img/mainLogo.png">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/css/worldMobile.css?<?=microtime(true);?>">
    <link rel="stylesheet" type="text/css" href="/css/makasimka.css?<?=microtime(true);?>">
    <link rel="stylesheet" type="text/css" href="/css/emoji.css?<?=$server_ver;?>">
	<link rel="stylesheet" type="text/css" href="/font-awesome/css/fontawesome-all.css?<?=$server_ver;?>">
	<link rel="stylesheet" type="text/css" href="/css/tipped/tipped.css?<?=$server_ver;?>"/>
    <script>var ClassInfo, UserAudio = <?=$user['sound'];?>;</script>
    <script type="text/JavaScript" src="/js/jquery/jquery.js?<?=$server_ver;?>"></script>
    <script type="text/JavaScript" src="/js/device.js?<?=$server_ver;?>"></script>
	<script type="text/JavaScript" src="/js/jquery/draggabilly.js?<?=$server_ver;?>"></script>
    <script type="text/JavaScript" src="/js/emoji.js?<?=$server_ver;?>"></script>
    <script type="text/JavaScript" src="/js/world.js?<?=microtime(true);?>"></script>
    <script type="text/JavaScript" src="/js/makasimka.js?<?=microtime(true);?>"></script>
	<script type="text/JavaScript" src="/js/lang/<?=$user['lang'];?>.js?<?=$server_ver;?>"></script>
	<script type="text/javascript" src="/js/tipped/tipped.js?<?=$server_ver;?>"></script>
	<script type="text/javascript" src="/js/moment/moment.js?<?=microtime(true);?>"></script>
	<script>
        const LOGIN = '<?=$_SESSION['login'];?>';
		const VERSION = '<?=$versionGame;?>';
        var ClassChat;
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
                'group': '<?=$user['user_group'];?>',
                'ver': '<?=$server_ver;?>'
            });
        });
		$(document).ready(function() {
			Tipped.create('.simple-tooltip');
		});
    </script>
</head>
<body>
  <div id="locationPreloader">
    <div class="preloader">
      <img src="/img/loader/loader.gif">
      <span></span>
    </div>
  </div>
  <audio id="battleAudio">
    <source src="battleStart.wav" type="audio/wav">
  </audio>
  <div class="BlockOtherContent" style="display: none;">
    <div class="DivNotifyBlock"></div>
  </div>
  <div class="tooltip" style="display: none;"></div>
  <div class="tooltip-block" style="display: none;"></div>
  <div class="mudol">
	<div class="title"><div>Тренеркарта игрока</div> <span><i class="fa fa-close"></i></span></div>
	<div class="bigAvatar" style="background: url(/img/avatars/full/model/1.png">
		<span style="background: url(/img/avatars/full/mouth/m/1.png);"></span><span style="z-index:11; background: url(/img/avatars/full/eye/m/1.png);"></span><span style="z-index:13; background: url(/img/avatars/full/hair/m/2.png);"></span><span style="z-index:12; background: url(/img/avatars/full/eyebrow/m/1.png);"></span><span style="z-index:4; background: url(/img/avatars/full/slot1/m/3.png);"></span><span style="z-index:3; background: url(/img/avatars/full/slot2/m/3.png);"></span><span style="z-index:2; background: url(/img/avatars/full/slot3/m/1.png);"></span><span style="background: url(/img/avatars/full/slot4/m/1.png);"></span><span style="z-index:1; background: url(/img/avatars/full/slot5/m/0.png);"></span><span style="z-index:10; background: url(/img/avatars/full/slot6/m/1.png);"></span><span style="background: url(/img/avatars/full/slot7/m/1.png);"></span><span style="background: url(/img/avatars/full/slot8/m/1.png);"></span><span style="background: url(/img/avatars/full/slot9/m/1.png);"></span><span style="background: url(/img/avatars/full/slot10/m/1.png);"></span><div class="left"><div></div><div></div><div></div><div></div><div></div></div><div class="right"><div></div><div></div><div></div><div></div><div></div></div>
	</div>
	<div class="userContent">
		<div class="littleAvatar">
			<img src="/img/avatars/mini/45.png">
			<div class="userInfo">
				<div class="user-link u-1">Lumenion</div>
				<span class="u-1">Администрация League 18</span>
			</div>
			<div class="statusUser">Тут должен быть ваш статус</div>
		</div>
		<div class="statLeft">
			<div><i class="fa fa-paw"></i> 100</div>
			<div class="unik"><i class="fa fa-paw"></i> 100</div>
		</div>
		<div class="buttonRight">
			<div><i class="fa fa-users"></i> 100</div>
			<div><i class="fa fa-bolt"></i> 100</div>
		</div>
		<div class="tabsContent">
			<div class="tabsi">
				<div class="active">Награды</div>
				<div>Подарки</div>
				<div>Достижения</div>
				<div>Друзья</div>
			</div>
			<div class="contentTab">
				
			</div>
		</div>
	</div>
  </div>
  <div class="inform" style="display: none;"></div>
  <div class="CraftModal" style="top: 100px; right: 80px; display: none;"></div>
  <div class="DivNotification"></div>
  <div class="DivTopMenu">
	<div class="DivLeftMenu">
		<div class="el_notify" onclick="showNotify(this);"><i class="fa fa-bell"></i><span><div id="countNotif" style="display: none;">0</div></span></div>
		<div class="el_prize" onclick="Game.prize.dayPrize()"><i class="fa fa-gift"></i></div>
		<div class="el_dex dex" onclick="openDex(1)">dex</div>
	</div>
	<div class="DivMidMenu"></div>
	<div class="DivRightMenu">
		<div class="Text">
			<div class="WeatherName" data="<?=$constDay;?>"></div>
			<div class="TimeWorld" id="map_time"></div>
		</div>
		<div class="Weather"></div>
	</div>
  </div>
  <div id="window_games" class="DivWorld">
    <div class="elka1"></div>
    <div class="DivMap">
      <div class="loadWorld"></div>
      <div id="gameCurrentLocationInfoBlock" class="DivLocationImage">
        <div class="DivLocationStep"></div>
		<div class="LocationSteps">
			<span>Переходы по локациям</span>
			<div></div>
		</div>
		<div class="LocationPersons">
			<span>Персонажи на локации</span>
			<div></div>
		</div>
		<div class="LocationInfo">
			<div class="Name"></div>
			<div class="About"></div>
			<div class="Type"></div>
		</div>
      </div>
    </div>
    <div class="DivChat">
      <div class="Chat">
        <input class="__chat_scrolls simple-tooltip" title="Чат автоматически вниз" type="checkbox" checked/>
        <div class="Talk">
          <div class="Category-Chat"></div>
          <div class="Message-Block Channel_8" data-channel='8'></div>
          <div class="Message-Block Channel_9" data-channel='9'></div>
          <div class="Message-Block Channel_21" data-channel='21'></div>
          <div class="Message-Block Channel_10" data-channel='10'></div>
          <div class="Message-Block Channel_0 active" data-channel='0'></div>
        </div>
      </div>
      <div class="Trainers">
        <div class="Trainers-Block">
          <div class="Trainers-Search">
            <div class="Trainers-Now simple-tooltip" title="Тренеров на локации"></div>
          </div>
          <div class="Trainers-In-Location">
            <div class="Trainer"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="DivBottomGame">
      <div class="Buttons">
        <form onsubmit="ClassChat._send();return false;">
          <div class="User">
            <input type="text" id="chat_user_to" autocomplete="off">
            <div onclick="$(this).prev().val('');" class="Close"><i class="fa fa-close"></i></div>
          </div>
          <div class="Text" id="messageFieldBox">
            <input id="chat_send" type="text" autocomplete="off">
            <div class="Go" onclick="ClassChat._send();return false;"><i class="fa fa-chevron-right"></i></div>
            <div class="Smiles simple-tooltip" title="Смайлы"><i class="fa fa-smile"></i></div>
          </div>
          <input type="submit" style="display: none">
        </form>
      </div>
      <div class="Other-Buttons">
        <div class="Button NoActive simple-tooltip" title="Режим нападения диких покемонов" onclick="setHunt(this);"><i class="fa fa-paw"></i></div>
      </div>
    </div>
  </div>
  </div>
</body>
</html>