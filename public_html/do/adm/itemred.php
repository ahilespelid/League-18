<?php
session_start();
$pass = 'NightTime1707';
if(empty($_SESSION['password']) || $_SESSION['password'] != $pass){
	if(!empty($_POST['pass'])){
		if($pass == $_POST['pass']){
			$_SESSION['password'] = $pass;
			header("Location: /do/functions/addEvolution") ;
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
$pokemons = $mysqli->query("SELECT * FROM `base_pokemons`");
if(isset($_POST['pokemon'])){
	$mysqli->query("UPDATE `base_pokemons` SET `nextEvolution` = '".$_POST['evolution']."' WHERE `id` = '".$_POST['pokemon']."'");
	die('Добавлена эволюция покемону');
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
			var pokemon = $("#pokemon").val();
			var evolution = $("textarea[name='evolution']").val();
			$.ajax({
				type: 'POST',
				data: {
					pokemon: pokemon,
					evolution: evolution
				},
				success: function(data) {
					$.notify(data);
				}
			});
		}
</script>
	</head>
	<body style="background-color: rgb(241, 241, 241); text-align: center;">
		<center><h3>Добавление эволюции</h3></center><hr>
		<form role="form" method="POST" id="formx" style="width: 500px; margin: auto;" action="javascript:void(null);" onsubmit="call()">
		 <div class="form-group">
			<label for="name">Покемон</label><br>
			<select id='pokemon'>  
				<? while($pokemon = $pokemons->fetch_assoc()){?>
				<option value='<?=$pokemon['id'];?>'><?=$pokemon['name'];?></option>
				<?}?>
			</select>
		 </div>
		 <div class="form-group">
			<label for="name">Эволюция</label><br>
			<textarea name="evolution" type="text" class="form-control" required></textarea>
		 </div>
		 
		 <div class="form-group">
			<input type="submit" class="btn btn-info" value="Отправить" />
		 </div>
		</form>
		<center><h3><b>Примеры</h3></b>
			Если эволюция через уровень:<br />
			<pre>
				&lt;div class="arrow"&gt;&lt;div&gt;»&lt;/div&gt;&lt;span&gt;32 ур.&lt;/span&gt;&lt;/div&gt;&lt;div class="evol"&gt;&lt;div onclick="openDex(3)" style="background: url(img/pokemons/mini/normal/003.png);"&gt;&lt;/div&gt;&lt;span&gt;#003 Венозавр&lt;/span&gt;&lt;/div&gt;
			</pre>
		</center>
	</body>
</html>