<?php
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
	$response['name'] = 'Тест';
	switch($npcStep){
		case 1:
		$response['question'] = 'На';

    // $quest = Work::$sql->query("SELECT * FROM `items_users` WHERE `str` = '5,5'");
		// while($a = $quest->fetch_assoc()) {
		// 	//$b = Work::$sql->query("SELECT * FROM `items_users` WHERE `item_id` = ".$a['id'])->fetch_assoc();
		// 	//if($b) {
		// 		itemAdd($a['item_id'],$a['count'],$a['user']);
		// 		//Work::$sql->query('UPDATE `items_users` SET `str` = "5,5" WHERE `item_id` = '.$a['id']);
    //     Work::$sql->query("DELETE FROM `items_users` WHERE `id` = ".$a['id']."");
		// 	//}
		// }

		// $quest = Work::$sql->query("SELECT * FROM `base_items` WHERE `str` != '0'");
		// while($a = $quest->fetch_assoc()) {
		// 	$b = Work::$sql->query("SELECT * FROM `items_users` WHERE `item_id` = ".$a['id'])->fetch_assoc();
		// 	if($b) {
		// 		itemAdd($b['item_id'],$b['count'],$b['user']);
		// 		Work::$sql->query('UPDATE `items_users` SET `str` = "5,5" WHERE `item_id` = '.$a['id']);
    //     Work::$sql->query("DELETE FROM `items_users` WHERE `id` = ".$b['id']."");
		// 	}
		// }
		// $quest = Work::$sql->query("SELECT * FROM `user_pokemons` WHERE `item_id` != '0'");
		// while($a = $quest->fetch_assoc()) {
		// 	itemAdd($a['item_id'],1,$a['user_id']);
		// 	Work::$sql->query("UPDATE `user_pokemons` SET `item_id` = '0' WHERE `id` = '".$a['id']."'");
		// }
		break;
		default:
				$response['question'] = 'Ку';
				$response['answer'] = [
										1=>'Дай айтем'
									];
		break;
	}
?>
