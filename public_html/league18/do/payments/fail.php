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
if($_GET['route'] === 'exit'){
	unset($_SESSION['id']);
	unset($_SESSION['login']);
	header('Location: /');
}
/* END ~ Global Include ~ */
if(isset($_SESSION['id'])){
	$autorize = true;
	$user = $mysqli->query("SELECT `login`,`user_group`,`rang` FROM `users` WHERE `id` = ".$_SESSION['id'])->fetch_assoc();
	if(file_exists($patch_project.'/img/avatars/mini/'.$_SESSION['id'].'.png')){
		$user['avatar'] = '/img/avatars/mini/'.$_SESSION['id'].'.png';
	}else{
		$user['avatar'] = '/img/avatars/mini/no-user-img.png';
	}
}else{
	$autorize = false;
}
$month = [1=>'Январь',2=>'Февраль',3=>'Март',4=>'Апрель',5=>'Май',6=>'Июнь',7=>'Июль',8=>'Август',9=>'Сентябрь',10=>'Октябрь',11 => 'Ноябрь', 12 => 'Декабрь'];
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
		<link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css?<?=microtime(true)?>">
		<link rel="stylesheet" href="/font-awesome/css/fontawesome-all.css?<?=microtime(true)?>">
		<link rel="stylesheet" href="/css/index_v0.0.1.css?<?=microtime(true)?>">
	</head>
	<body>
		<div class="container-fluid head">
			<div class="row justify-content-center align-items-start">
				<div class="col-4 text-center">
					<h1>League 18</h1>
					<img src="/img/logo.png" alt="League 18">
					<span>Онлайн игра про Покемонов</span>
				</div>
			</div>
			<div class="row align-items-end">
				<div class="col pr-0 pl-0">
					<nav class="navbar navbar-expand-lg">
						<div class="container">
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false">
								<i class="navbar-toggler-icon fa fa-bars"></i>
							</button>
							<div class="collapse navbar-collapse" id="mainNav">
								<ul class="navbar-nav mr-auto">
									<li class="nav-item">
										<a href="//<?=DOMAIN;?>" class="nav-link">Главная</a>
									</li>
									<?php if(!$autorize){ ?>
									<li class="nav-item">
										<a href="//<?=DOMAIN;?>?route=registration" class="nav-link reg">Регистрация</a>
									</li>
									<?php } ?>
									<li class="nav-item">
										<a href="//<?=DOMAIN;?>?route=rules" class="nav-link">Правила</a>
									</li>
									<li class="nav-item">
										<a target="_blank" href="http://leagueonline.forum2.net/" class="nav-link">Форум</a>
									</li>
								</ul>
								<?php if(!$autorize){ ?>
									<form action="//<?=DOMAIN;?>/do/sign" method="POST" class="sign form-inline my-2 my-lg-0">
										<input type="text" name="login" class="form-control mr-sm-2" placeholder="Логин" required />
										<input type="password" name="pass" class="form-control mr-sm-2" placeholder="Пароль" required />
										<button type="submit" class="btn btn-primary my-2 my-sm-0">Войти</button>
									</form>
								<?php }else{ ?>
									<ul class="navbar-nav ml-auto">
										<li class="nav-item">
										<?php if($autorize){ ?>
											<span class="navbar-brand">
												<img src="<?=$user['avatar']?>" class="d-inline-block align-top" alt="<?=$user['login'];?>">
												<p class="u-<?=$user['user_group'];?>"><?=$user['login'];?><span><?=$user['rang'];?></span></p>
											</span>
										<?php } ?>
										</li>
										<li class="nav-item">
											<a href="//<?=DOMAIN;?>/world" class="nav-link">В игру</a>
										</li>
										<li class="nav-item">
											<a href="//<?=DOMAIN;?>/?route=exit" class="nav-link">Выход</a>
										</li>
									</ul>
								<?php } ?>
								<span class="online"><?=$index->online;?> чел. онлайн</span>
							</div>
						</div>
					</nav>
				</div>
			</div>
		</div>
		<div class="container payment">
			<div class="row justify-content-center">
				<div class="col-5">
					<div class="card text-white bg-danger mt-5 w-100">
						<div class="card-header">Вы отказались от оплаты</div>
						<div class="card-body">
							<h5 class="card-title">Ничего страшного, попробуйте повторить попытку позднее!</h5>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="/js/jquery/jquery.js" type="text/javascript"></script>
		<script src="/js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
		<script src="/js/jquery/notify.js?<?=microtime(true)?>" type="text/javascript"></script>
		<script src="/js/device.js" type="text/javascript"></script>
		<script src="/js/index.js?<?=microtime(true)?>" type="text/javascript"></script>
		<script>
			const DOMAIN = '<?=DOMAIN_HTTP;?>';
		</script>
	</body>
</html>