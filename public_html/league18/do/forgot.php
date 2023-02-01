<?php
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
$userFunction = $patch_project.'/inc/function/Users.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
		require_once($userFunction);
    }
}
    $checkMail = $mysqli->query("SELECT * FROM `users` WHERE `email` = '".$_POST['mail']."'")->fetch_assoc();
    if($checkMail){
      $checkPass = $mysqli->query("SELECT * FROM `new_pass` WHERE `user` = '".$checkMail['id']."'")->fetch_assoc();
      $rand = rand(10000,99999);
      if($checkPass){
        $mysqli->query("UPDATE `new_pass` SET `pass`=".$rand." WHERE `user` = ".$checkPass['user']);
      }else{
        $mysqli->query("INSERT INTO `new_pass` (`user`,`pass`) VALUES ('".$checkMail['id']."','".$rand."')");
      }
      mail($_POST['mail'],'Смена пароля - League 18','Здравствуйте, '.$checkMail['login'].'. Для вас сгенерирован новый пароль - '.$rand.'. Используйте его для входа в игру. ОБЯЗАТЕЛЬНО ИЗМЕНИТЕ ЭТОТ ПАРОЛЬ В НАСТРОЙКАХ ИГРЫ, ПОСКОЛЬКУ КАЖДЫЙ ПОНЕДЕЛЬНИК СГЕНЕРИРОВАННЫЕ ПАРОЛИ УДАЛЯЮТСЯ, И ВЫ БОЛЬШЕ НЕ СМОЖЕТЕ ЗАЙТИ НА АККАУНТ ЧЕРЕЗ ЭТОТ ПАРОЛЬ!');
      $response['error'] = 0;
    }else{
      $response['error'] = 1;
      $response['text'] = 'Данная почта не найдена.';
    }
		echo json_encode($response);
?>
