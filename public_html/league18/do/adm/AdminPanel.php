<?php
session_start();
if ($myrow['user_group'] == 1)
{
  echo "<script>alert('Вход на эту страницу разрешен только Администраторам!'); location.href='..';</script>"; exit;
}
$pass = 'qpmzgh19';
if(empty($_SESSION['password']) || $_SESSION['password'] != $pass){
	if(!empty($_POST['pass'])){
		if($pass == $_POST['pass']){
			$_SESSION['password'] = $pass;
			header("Location: /do/adm/AdminPanel") ;
		}
	}
	$tpl = '<center>Введите пароль
	<form method="POST">
      <input type="text" name="pass"></br>
      <input type="submit" value="Войти">
    </form></center>';
	die($tpl);
}


/* ~ Global Include ~ */
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$patch_func = $patch_project.'/inc/function/Functions.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
		require_once($patch_func);
    }
}
//1 Люма
//2 Системс шок
//3 Маерсище
//8 Маверище
if($_SESSION['id'] == 1 || $_SESSION['id'] == 2 || $_SESSION['id'] == 3 || $_SESSION['id'] == 8 ) {

$items = $mysqli->query("SELECT * FROM `base_items`");
$users = $mysqli->query("SELECT * FROM `users`");
$user = $mysqli->query("SELECT * FROM `users`");
$pokemons = $mysqli->query("SELECT * FROM `base_pokemons`");
if(isset($_POST['count'])){
	$items = $mysqli->query("SELECT * FROM `items_users` WHERE `user`= '".$_POST['user']."' AND `item_id` = '".$_POST['item']."'")->fetch_assoc(); 
	if(!empty($items['count'])){
		$itemsCount = $items['count'] + $_POST['count']; 
		$insert = $mysqli->query("UPDATE `items_users` SET `count` = '".$itemsCount."' WHERE `item_id` = '".$_POST['item']."' AND `user` = '".$_POST['user']."'"); 
	}else{ 
		$insert = $mysqli->query("INSERT INTO `items_users` (`user`,`item_id`,`count`) VALUES ('".$_POST['user']."','".$_POST['item']."','".$_POST['count']."') "); 
	}
	if($insert){
		die('Предмет успешно выдан!');
	}else{
		die('Ошибка');
	}
}
if(isset($_POST['pokemon'])){
	if(newPokemon($_POST['pokemon'],$_POST['user'],1,false,false,false,false,false,500)){
		die('Покемон успешно выдан!');
	}else{
		die('Покемон успешно выдан!');
	}
}
}
?>
<html>
	<head>
		<title>Панель выдачи</title>
		<LINK REL='Stylesheet' HREF='/css/bootstrap.css' TYPE='text/css'>
		<script src="/js/jquery/jquery.js"></script>
		<script src="/js/jquery/notify.js"></script>
		<script type="text/javascript" language="javascript">
		function call() {
			var count = $("input[name='count']").val();
			var item = $("#item").val();
			var user = $("#user").val();
			$.ajax({
				type: 'POST',
				data: {
					count: count,
					user: user,
					item: item
				},
				success: function(data) {
					$.notify(data);
				}
			});
		}
		function addPok() {
			var pokemon = $("#pokemons").val();
			var user = $("#user").val();
			$.ajax({
				type: 'POST',
				data: {
					pokemon: pokemon,
					user: user
				},
				success: function(data) {
					$.notify(data);
				}
			});
		}
</script>
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
	</head>
	<body style="background-color: rgb(241, 241, 241); text-align: center;">
		<center><h3>Выдача предметов</h3></center><hr>
		<form role="form" method="POST" id="formx" style="width: 500px; margin: auto;" action="javascript:void(null);" onsubmit="call()">
		 <div class="form-group">
			<label for="name">Предмет</label><br>
			<select id='item'>  
				<? while($itemsList = $items->fetch_assoc()){?>
				<option value='<?=$itemsList['id'];?>'><?=$itemsList['name'];?></option>
				<?}?>
			</select>
		 </div>
		 <div class="form-group">
			<label for="name">Пользователь</label><br>
			<select id='user'>  
				<? while($usersList = $users->fetch_assoc()){?>
				<option value='<?=$usersList['id'];?>'><?=$usersList['login'];?></option>
				<?}?>
			</select>
		 </div>
		 <div class="form-group">
			<label for="name">Количество</label><br>
			<input name="count" type="text" class="form-control" required/>
		 </div>
		 <div class="form-group">
			<input type="submit" class="btn btn-info" value="Отправить" />
		 </div>
		</form>
		<center><h3>Выдача покемонов</h3></center><hr>
		<form role="form" method="POST" id="formx" style="width: 500px; margin: auto;" action="javascript:void(null);" onsubmit="addPok()">
		 <div class="form-group">
			<label for="name">Покемон</label><br>
			<select id='pokemons'>  
				<? while($pokList = $pokemons->fetch_assoc()){?>
				<option value='<?=$pokList['id'];?>'><?=$pokList['name_rus'];?></option>
				<?}?>
			</select>
		 </div>
		 <div class="form-group">
			<label for="name">Пользователь</label><br>
			<select id='user'>  
				<? while($usersList = $user->fetch_assoc()){?>
				<option value='<?=$usersList['id'];?>'><?=$usersList['login'];?></option>
				<?}?>
			</select>
		 </div>
		 <div class="form-group">
			<input type="submit" class="btn btn-info" value="Отправить" />
		 </div>
		</form><br><br>
		<a href="/do/adm/logtrade.php" class="tra">Логи обмена</a>
		<a href="/do/adm/battle_log.php" class="tra">Логи Битв</a>
		<a href="/do/adm/statistic.php" class="tra">База итемов</a>
		<a href="/do/adm/itemred.php" class="tra">Итемы</a>
		<a href="/do/adm/loc.php" class="tra">Локации</a>
		
			</tbody>
		</table>
	</body>
</html>