<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$patch_func = $patch_project.'/inc/function/Functions.php';
$patch_makasimka = $patch_project.'/makasimka/';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
        require_once($patch_global);
        require_once($patch_func);
    }
}
if(isset($_POST['count']) && (int)$_POST['count'] > 0 && isset($_SESSION['id'])){
	$user = $mysqli->query('SELECT id, email FROM users WHERE id = '.(int)$_SESSION['id'])->fetch_assoc();
	$mysqli->query("INSERT INTO payments (user,count,status,date_add) VALUES(".(int)$user['id'].", ".(int)$_POST['count'].",0,NOW()) ");
	$order_id = $mysqli->insert_id;
	$summ = number_format(1 * (int)$_POST['count'], 2, '.', '');
	$crc = md5("Lumenion:" . $summ . ":" . $order_id . ":k0ax1CnlcZti8Pvu2Dw0:Shp_id=".$user['id']);

	$data = [
		'MerchantLogin'	=> 'Lumenion',
		'OutSum'		=> $summ,
		'InvId'			=> $order_id,
		'SignatureValue'=> $crc,
		'InvDesc'		=> urlencode('Покупка Жемчуга x'.(int)$_POST['count'].' на сумму '.$summ.' руб.'),
		'Email'			=> $user['email'],
		//'IsTest'		=> 1,
		'Shp_id'		=> $user['id']
	];
	$url = 'https://auth.robokassa.ru/Merchant/Index.aspx?'.http_build_query($data);
	header('Location: '.$url);
}
