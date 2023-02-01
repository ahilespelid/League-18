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
	$allowed_formats = array("image/png");
	if (0 < $_FILES['file']['error']) {
		echo 'Ошибка при загрузке аватарки.';
	}else{
		if (in_array($_FILES['file']['type'], $allowed_formats)) {
			$name = $_SESSION['id'].'.png';
			$uploadFile = dirname(__DIR__).'/img/avatars/mini/'.$name;
			if(is_file($uploadFile)){
				@unlink($uploadfile);
			}
			move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);
		}
	}
?>
