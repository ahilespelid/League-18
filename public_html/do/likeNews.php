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
    if(isset($_SESSION['id'])) {
      $checkLike = $mysqli->query("SELECT * FROM `likenews` WHERE `user` = '".$_SESSION['id']."' AND `news` = '".$_POST['id']."'")->fetch_assoc();
      if($checkLike) {
        if($checkLike['like'] == 0) {
          $like = 1;
        }else{
          $like = 0;
        }
        $mysqli->query("UPDATE `likenews` SET `like`=".$like." WHERE `user` = '".$_SESSION['id']."' AND `news` = '".$_POST['id']."'");
      }else{
        $mysqli->query("INSERT INTO `likenews` (`user`,`like`,`news`) VALUES ('".$_SESSION['id']."','1','".$_POST['id']."')");
      }
    }
    $checkLike = $mysqli->query("SELECT `like` FROM `likenews` WHERE `news` = '".$_POST['id']."'");
    $response['like'] = $checkLike->num_rows;
		echo json_encode($response);
?>
