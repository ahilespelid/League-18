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
if(isset($_REQUEST['OutSum']) && isset($_REQUEST['InvId']) && isset($_REQUEST['Shp_id']) && isset($_REQUEST['SignatureValue'])){
	$mrh_pass2 = "No9D5fzR39rakO1hKWbL";

	$out_summ = $_REQUEST['OutSum'];
	$inv_id = $_REQUEST['InvId'];
	$shp_id = $_REQUEST['Shp_id'];
	$crc = $_REQUEST['SignatureValue'];

	$crc = strtoupper($crc);
	$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:Shp_id=$shp_id"));

	$user = $mysqli->query('SELECT id, email, login FROM users WHERE id = '.(int)$shp_id)->fetch_assoc();
	$order = $mysqli->query('SELECT * FROM payments WHERE id = '.(int)$inv_id)->fetch_assoc();
	if($my_crc != $crc || !$user || !$order){
		$mysqli->query('UPDATE payments SET status=2 WHERE id='.(int)$inv_id);
		echo "bad sign\n";
		exit();
	}
	echo "OK$inv_id\n";

	$mysqli->query('UPDATE payments SET status=1 WHERE id='.(int)$inv_id);
	itemAdd(43, (int)$order['count'], (int)$order['user']);

	$from = 'fionix9090@gmail.com';
	$subject = 'Новая оплата на сайте league-18.ru';
	$subject = '=?utf-8?b?'. base64_encode($subject) .'?=';
	$headers = "Content-type: text/html; charset=\"utf-8\"\r\n";
	$headers .= "From: <". $from .">\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Date: ". date('D, d M Y h:i:s O') ."\r\n";
	$message = "<h1>Новая покупка акваритов!</h1>\n
				<h4>Тренер: ".$user['login']."</h4>\n
				<h4>Сумма: ". (int)$order['count'] * 1 ." р.</h4>\n
				<h4>Акваритов: ". (int)$order['count'] ."</h4>\n";
	//mail('kirichyn.93@mail.ru, rxurmatov@bk.ru', $subject, $message, $headers, '-f'.$from);
}
