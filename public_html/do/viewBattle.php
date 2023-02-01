<?php
//if(isset(!empty($_POST))){
	$patch_project = $_SERVER['DOCUMENT_ROOT'];
	$patch_global = $patch_project.'/inc/conf/global.php';
	require_once($patch_global);
	$UserQuery = $mysqli->query('SELECT * FROM users WHERE id = '.$_SESSION['id'])->fetch_assoc();
	$battleQuery = $mysqli->query('SELECT * FROM battle WHERE type = "pvp"');
	//$UserQuery2 = $mysqli->query('SELECT * FROM users WHERE id = '.$battleQuery['user_1'].' AND location = '.$UserQuery['location'])->fetch_assoc();

	if($battleQuery->num_rows > 0) {
		while($battle = $battleQuery->fetch_assoc()) {
			$UserQuery2 = $mysqli->query('SELECT * FROM users WHERE id = '.$battle['user_1'].' AND location = '.$UserQuery['location'])->fetch_assoc();
			if($UserQuery2) {
				$UserQuery3 = $mysqli->query('SELECT * FROM users WHERE id = '.$battle['user_1'].'')->fetch_assoc();
				$UserQuery4 = $mysqli->query('SELECT * FROM users WHERE id = '.$battle['user_2'].'')->fetch_assoc();
				$html .= '<div class="Step"><div class="fS"><div class="user-link"><div onclick=showUserTooltip("'.$UserQuery3['id'].'") class="Info-Link sex'.$UserQuery3['sex'].'"><i class="fa fa-info"></i></div> <div class="u-'.$UserQuery3['user_group'].'">'.$UserQuery3['login'].'</div></div> <span onclick="createView('.$battle['id'].');">vs</span> <div class="user-link"><div onclick=showUserTooltip("'.$UserQuery4['id'].'") class="Info-Link sex'.$UserQuery4['sex'].'"><i class="fa fa-info"></i></div> <div class="u-'.$UserQuery4['user_group'].'">'.$UserQuery4['login'].'</div></div></div></div>';
			}
		}
	}


	$response = [
		'count'	=> ($battleQuery->num_rows ? $battleQuery->num_rows : 0),
		'html' => $html
	];
	echo json_encode($response);
?>
